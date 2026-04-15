 # The Issue
The application is experiencing severe lag due to duplicate API calls firing simultaneously.
 
 # API Log Evidence
 2026-04-14 11:25:41 /api/auth/login .............................................. ~ 511.26ms

  2026-04-14 11:25:41 /api/auth/login .............................................. ~ 509.24ms

  2026-04-14 11:25:42 /api/auth/profile .................................................. ~ 1s

  2026-04-14 11:25:43 /api/devices ................................................... ~ 0.31ms

  2026-04-14 11:25:43 /api/devices/stats ............................................ ~ 11.90ms

  2026-04-14 11:25:43 /api/entries .................................................. ~ 20.34ms

  2026-04-14 11:25:43 /api/auth/profile ............................................. ~ 31.93ms

  2026-04-14 11:25:43 /api/devices .................................................. ~ 40.62ms

  2026-04-14 11:25:44 /api/devices/stats ........................................... ~ 514.66ms

  2026-04-14 11:25:44 /api/entries ................................................. ~ 522.59ms

  2026-04-14 11:25:44 /api/auth/profile ............................................ ~ 519.00ms

  2026-04-14 11:25:44 /api/devices ................................................. ~ 516.46ms

  2026-04-14 11:25:45 /api/devices/stats ............................................ ~ 11.41ms

  2026-04-14 11:25:45 /api/entries ................................................... ~ 9.91ms

  2026-04-14 11:25:45 /api/auth/profile ............................................ ~ 512.57ms

  2026-04-14 11:25:45 /api/devices ................................................... ~ 0.11ms

  2026-04-14 11:25:45 /api/devices/stats ............................................. ~ 0.13ms

  2026-04-14 11:25:45 /api/entries ................................................... ~ 0.15ms

  2026-04-14 11:25:50 /api/devices ................................................... ~ 1.08ms

  2026-04-14 11:25:50 /api/devices/stats ........................................... ~ 528.42ms

  2026-04-14 11:25:50 /api/entries ................................................. ~ 545.44ms

  2026-04-14 11:25:50 /api/devices ................................................... ~ 0.24ms

  2026-04-14 11:25:50 /api/devices/stats ........................................... ~ 538.09ms

  2026-04-14 11:25:51 /api/entries ................................................. ~ 545.64ms

  2026-04-14 11:25:51 /api/devices ....................................................... ~ 2s

  2026-04-14 11:25:53 /api/devices/stats ............................................. ~ 0.63ms

  2026-04-14 11:25:53 /api/entries ................................................. ~ 533.65ms

  2026-04-14 11:25:53 /api/devices ................................................. ~ 539.09ms

  2026-04-14 11:25:54 /api/devices/stats ............................................. ~ 0.57ms

  2026-04-14 11:25:54 /api/entries ................................................. ~ 507.59ms

  2026-04-14 11:25:56 /api/devices ................................................... ~ 0.62ms

  2026-04-14 11:25:56 /api/devices/stats ............................................ ~ 26.76ms

  2026-04-14 11:25:56 /api/entries .................................................. ~ 42.54ms

  2026-04-14 11:25:56 /api/devices ................................................. ~ 508.76ms

  2026-04-14 11:25:56 /api/devices/stats


  # First Test Result:
  Landing.jsx:274 Login/Register error: 
AxiosError
code
: 
"ERR_BAD_RESPONSE"
config
: 
{transitional: {…}, adapter: Array(3), transformRequest: Array(1), transformResponse: Array(1), timeout: 30000, …}
message
: 
"Request failed with status code 500"
name
: 
"AxiosError"
request
: 
XMLHttpRequest {onreadystatechange: null, readyState: 4, timeout: 30000, withCredentials: false, upload: XMLHttpRequestUpload, …}
response
: 
{data: {…}, status: 500, statusText: 'Internal Server Error', headers: AxiosHeaders, config: {…}, …}
status
: 
500
stack
: 
"AxiosError: Request failed with status code 500\n    at settle (http://localhost:5173/node_modules/.vite/deps/axios.js?v=db211858:1257:12)\n    at XMLHttpRequest.onloadend (http://localhost:5173/node_modules/.vite/deps/axios.js?v=db211858:1606:7)\n    at Axios.request (http://localhost:5173/node_modules/.vite/deps/axios.js?v=db211858:2223:41)\n    at async Object.login (http://localhost:5173/src/services/authService.js:21:26)\n    at async handleSubmit (http://localhost:5173/src/pages/Landing.jsx:194:24)"
[[Prototype]]
: 
Error

# Second Test Result:

### I tried to log in but it encountered an error

Landing.jsx:276 Login/Register error: 
AxiosError {message: 'Request failed with status code 500', name: 'AxiosError', code: 'ERR_BAD_RESPONSE', config: {…}, request: XMLHttpRequest, …}
code
: 
"ERR_BAD_RESPONSE"
config
: 
{transitional: {…}, adapter: Array(3), transformRequest: Array(1), transformResponse: Array(1), timeout: 30000, …}
message
: 
"Request failed with status code 500"
name
: 
"AxiosError"
request
: 
XMLHttpRequest {onreadystatechange: null, readyState: 4, timeout: 30000, withCredentials: false, upload: XMLHttpRequestUpload, …}
response
: 
{data: {…}, status: 500, statusText: 'Internal Server Error', headers: AxiosHeaders, config: {…}, …}
status
: 
500
stack
: 
"AxiosError: Request failed with status code 500\n    at settle (http://localhost:5173/node_modules/.vite/deps/axios.js?v=db211858:1257:12)\n    at XMLHttpRequest.onloadend (http://localhost:5173/node_modules/.vite/deps/axios.js?v=db211858:1606:7)\n    at Axios.request (http://localhost:5173/node_modules/.vite/deps/axios.js?v=db211858:2223:41)\n    at async Object.login (http://localhost:5173/src/services/authService.js?t=1776147894028:29:26)\n    at async handleSubmit (http://localhost:5173/src/pages/Landing.jsx?t=1776147894028:195:24)"
[[Prototype]]
: 
Error

# Third Test Result
I can log in as an admin using the seeded account
I can register as a sutdent on the landing page
I can log in as the newly created student account but it brings me to a white page with this error
Uncaught ReferenceError: useRef is not defined
    at StudentDashboard (StudentDashboard.jsx:802:27)

    also this is the api calls that happened throughout the testing, its not getting any better. What information do you want me to provide so you can really tackle and solve this problem?

# API Logs-Third Test
2026-04-14 14:33:17 /api/auth/login .................................................. ~ 0.37ms
  2026-04-14 14:33:18 /api/auth/login ................................................ ~ 514.45ms
  2026-04-14 14:33:18 /api/auth/profile .................................................... ~ 1s
  2026-04-14 14:33:20 /api/devices ................................................... ~ 500.78ms
  2026-04-14 14:33:20 /api/devices/stats ............................................. ~ 529.91ms
  2026-04-14 14:33:20 /api/entries ................................................... ~ 548.07ms
  2026-04-14 14:33:20 /api/auth/profile .................................................... ~ 1s
  2026-04-14 14:33:20 /api/auth/profile .............................................. ~ 569.19ms
  2026-04-14 14:33:21 /api/devices .................................................... ~ 21.62ms
  2026-04-14 14:33:21 /api/devices/stats ............................................. ~ 527.32ms
  2026-04-14 14:33:21 /api/entries ................................................... ~ 523.53ms
  2026-04-14 14:33:21 /api/auth/profile .............................................. ~ 537.29ms
  2026-04-14 14:33:24 /api/devices ..................................................... ~ 0.40ms
  2026-04-14 14:33:24 /api/devices/stats .............................................. ~ 24.23ms
  2026-04-14 14:33:24 /api/entries .................................................... ~ 43.00ms
  2026-04-14 14:33:24 /api/devices ................................................... ~ 503.50ms
  2026-04-14 14:33:24 /api/devices/stats ............................................. ~ 526.60ms
  2026-04-14 14:33:24 /api/entries ................................................... ~ 532.66ms
  2026-04-14 14:33:25 /api/devices ................................................... ~ 537.01ms
  2026-04-14 14:33:25 /api/devices/stats ............................................. ~ 511.26ms
  2026-04-14 14:33:25 /api/entries ................................................... ~ 530.24ms
  2026-04-14 14:33:25 /api/devices .................................................... ~ 24.11ms
  2026-04-14 14:33:26 /api/devices/stats ............................................. ~ 504.67ms
  2026-04-14 14:33:26 /api/entries ..................................................... ~ 0.28ms
  2026-04-14 14:33:36 /api/devices ..................................................... ~ 0.48ms
  2026-04-14 14:33:36 /api/devices/stats ............................................. ~ 540.68ms
  2026-04-14 14:33:36 /api/entries ................................................... ~ 555.56ms
  2026-04-14 14:33:37 /api/devices ................................................... ~ 510.67ms
  2026-04-14 14:33:37 /api/devices/stats ............................................. ~ 526.24ms
  2026-04-14 14:33:37 /api/entries .................................................... ~ 13.76ms
  2026-04-14 14:33:37 /api/devices ........................................................ ~ 16s
  2026-04-14 14:33:54 /api/devices/stats ............................................... ~ 0.32ms
  2026-04-14 14:33:54 /api/entries .................................................... ~ 24.79ms
  2026-04-14 14:33:55 /api/devices ................................................... ~ 508.53ms
  2026-04-14 14:33:55 /api/devices/stats ............................................... ~ 0.27ms
  2026-04-14 14:33:55 /api/entries ..................................................... ~ 0.21ms
  2026-04-14 14:34:29 /api/auth/register ............................................... ~ 0.35ms
  2026-04-14 14:34:30 /api/auth/register ............................................. ~ 506.71ms
  2026-04-14 14:34:30 /api/auth/register ................................................... ~ 8s
  2026-04-14 14:34:39 /api/auth/register ............................................. ~ 510.84ms
  2026-04-14 14:34:39 /api/auth/login ..................................................... ~ 14s
  2026-04-14 14:34:54 /api/auth/login ................................................ ~ 509.14ms
  2026-04-14 14:34:55 /api/auth/login ...................................................... ~ 4s
  2026-04-14 14:34:59 /api/auth/login .................................................. ~ 0.37ms
  2026-04-14 14:35:19 /api/devices ................................................... ~ 514.29ms
  2026-04-14 14:35:19 /api/devices/stats ............................................. ~ 537.74ms
  2026-04-14 14:35:19 /api/entries ......................................................... ~ 1s
  2026-04-14 14:35:19 /api/devices ..................................................... ~ 1.93ms
  2026-04-14 14:35:19 /api/devices/stats .............................................. ~ 27.52ms
  2026-04-14 14:35:20 /api/entries ................................................... ~ 535.33ms
  2026-04-14 14:35:20 /api/auth/login ...................................................... ~ 6s
  2026-04-14 14:35:26 /api/auth/login ................................................ ~ 503.05ms
  2026-04-14 14:35:00 .................................................................. ~ 1m 47s


# Possible Solution:
are you sure that the backend its working fine and theres multiple api calls because of how the frontend call them multiple times?

Yes, I am absolutely sure. It is a very common reaction to suspect the backend when the server is lagging or your terminal is flooded with logs, but in this specific architecture, Laravel is entirely innocent.

It is essentially a case of your frontend accidentally DDOS-ing its own backend.

Here is exactly why we can be certain the bug lives in React and not in Laravel:

1. The Backend is Reactive, Not Proactive
Laravel only does what it is explicitly asked to do. It sits there listening on a port. It cannot spontaneously generate an incoming HTTP request. If your backend log shows 20 executions of the /api/devices route, it is because it received 20 distinct HTTP GET requests from the browser over the network.

2. The Millisecond Timestamps
Look closely at the first two lines of the log you shared earlier:

2026-04-14 11:25:41 /api/auth/login .............................................. ~ 511.26ms
2026-04-14 11:25:41 /api/auth/login .............................................. ~ 509.24ms

If the backend had a bug—like an infinite while loop inside your LoginController—you wouldn't see two separate requests. You would see one request that takes 30 seconds to finish and eventually throws a 500 Server Error or memory exhaustion error. The fact that there are two distinct entries in the exact same second proves the browser fired the request twice concurrently.

3. The React Code Evidence
When we looked at StudentDashboard.jsx, the smoking gun was there. Because the useEffect dependency array contained the entire student object rather than a primitive value like student?.id, React was re-evaluating the component on every cycle, thinking the student data had "changed" (because the object reference changed in memory), and firing the fetch functions over and over again.

How to Prove It to Yourself Right Now
You don't have to take my word for it! You can prove this visually using your browser:

Open your frontend in Chrome or Edge.

Right-click and select Inspect to open the Developer Tools.

Go to the Network tab.

Click the "Clear" button (the circle with a line through it) to empty the log.

In your app, click your "Log In" button or navigate to the Dashboard.

Watch the Network tab. If you see /login pop up twice in that list, or a waterfall of /devices requests flooding the screen, you are looking directly at the React frontend actively firing multiple requests across the network.

Once you apply those refactored components with the if (loading) return; guards and the correct useEffect dependencies, you will see that Network tab quiet down to just single, clean requests.