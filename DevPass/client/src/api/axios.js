import axios from 'axios';

const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
    timeout: 30000, // 30 second timeout to prevent hanging requests
});

// Store in-flight GET requests to prevent duplicates
const pendingRequests = new Map();

// Add token to every request if it exists
api.interceptors.request.use(
    (config) => {
        // Only deduplicate GET requests
        if (config.method === 'get') {
            const requestKey = `${config.url}${config.params ? JSON.stringify(config.params) : ''}`;
            
            if (pendingRequests.has(requestKey)) {
                // Return the existing promise
                return Promise.reject({
                    isDuplicate: true,
                    requestKey
                });
            }
            
            // Mark as pending
            pendingRequests.set(requestKey, true);
            config.requestKey = requestKey;
        }

        // Check both localStorage (remember me) and sessionStorage (no remember me)
        const token = localStorage.getItem('token') || sessionStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Handle 401 errors globally - clear storage and redirect to login
// But only redirect if not already handling it in component
let redirecting = false;
let redirectTimeout = null;
let redirectHandledByComponent = false;

// Allow components to mark that they're handling the redirect
export const setRedirectHandledByComponent = (handled) => {
    redirectHandledByComponent = handled;
};

api.interceptors.response.use(
    (response) => {
        // Clear from pending requests map
        if (response.config.requestKey) {
            pendingRequests.delete(response.config.requestKey);
        }
        
        // Reset flag on successful response
        redirectHandledByComponent = false;
        return response;
    },
    (error) => {
        // If it's a duplicate request we blocked, we can ignore the error
        if (error.isDuplicate) {
            // We return a never-resolving promise or just a quiet reject
            // Depending on how components handle it. 
            // Better: return a promise that resolves when the first one does? 
            // Simplified for now: just clear the key after a timeout and reject.
            setTimeout(() => pendingRequests.delete(error.requestKey), 500);
            return new Promise(() => {}); // Wait forever (effectively cancelling this duplicate)
        }

        // Clear from pending requests map on error too
        if (error.config?.requestKey) {
            pendingRequests.delete(error.config.requestKey);
        }

        if (error.response?.status === 401) {
            // Clear all authentication data FIRST to prevent Landing page from redirecting back
            localStorage.removeItem('token');
            localStorage.removeItem('student');
            localStorage.removeItem('user_type');
            localStorage.removeItem('rememberMe');
            sessionStorage.removeItem('token');
            sessionStorage.removeItem('student');
            sessionStorage.removeItem('user_type');
            
            // Only redirect if component hasn't already handled it
            // Also check if we're on a protected route (dashboard pages)
            const currentPath = window.location.pathname;
            const isProtectedRoute = currentPath.includes('/dashboard') || 
                                     currentPath.includes('/personnel') || 
                                     currentPath.includes('/admin') || 
                                     currentPath.includes('/student');
            
            // Don't redirect if component is handling it, or if we're already redirecting
            if (!redirectHandledByComponent && !redirecting && isProtectedRoute && currentPath !== '/' && !currentPath.includes('/login')) {
                redirecting = true;
                // Clear any existing timeout
                if (redirectTimeout) {
                    clearTimeout(redirectTimeout);
                }
                // Use a longer delay to allow the component to handle it first
                redirectTimeout = setTimeout(() => {
                    if (redirecting && window.location.pathname !== '/' && !redirectHandledByComponent) {
                        // Use replace to prevent back button issues
                        window.location.replace('/');
                    }
                    redirecting = false;
                }, 2000);
            }
        }
        return Promise.reject(error);
    }
);

export default api;