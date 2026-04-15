# DevPass - QR-Based Device Registration System

## Project Overview
DevPass is a full-stack application designed to manage and track electronic devices (primarily laptops) within an organization or educational institution. It provides a streamlined workflow for students to register their devices, admins to approve them, and security personnel to verify them at entry/exit points using QR codes.

### Architecture
- **Backend:** Laravel 12 (PHP 8.2+) providing a RESTful API.
- **Frontend:** React 19 (Vite) as a Single Page Application (SPA).
- **Database:** MySQL/MariaDB with a relational schema managing students, devices, specifications, QR codes, and entry logs.
- **Authentication:** Laravel Sanctum for token-based API authentication, supporting multiple roles (Student, Admin, Security Personnel).
- **Styling:** Tailwind CSS 4.0 for a modern, responsive UI.

### Key Features
- **Student Dashboard:** Register devices, view approval status, generate/renew QR codes, and track personal entry/exit history.
- **Admin Dashboard:** Manage device approval requests, view system-wide statistics, manage security personnel and gates.
- **Security Interface:** Scan QR codes at specific gates to verify device ownership and validity, logging every entry/exit attempt.
- **Automated Logging:** Real-time logging of all scans (Success/Denied) with timestamps and guard associations.
- **Device Specifications:** Deep tracking of device hardware (Brand, Model, Serial Number) with optional advanced specifications.

---

## Building and Running

### Backend Setup (Laravel)
1.  **Navigate to directory:** `cd DevPass/server`
2.  **Install dependencies:** `composer install`
3.  **Environment Setup:** Copy `.env.example` to `.env` and configure your database.
4.  **Key Generation:** `php artisan key:generate`
5.  **Database Migration:** `php artisan migrate` (Optionally `php artisan db:seed` for sample data).
6.  **Run Server:** `php artisan serve` (Runs on `http://localhost:8000`).

### Frontend Setup (React + Vite)
1.  **Navigate to directory:** `cd DevPass/client`
2.  **Install dependencies:** `npm install`
3.  **Environment Setup:** Ensure `VITE_API_URL` in `.env` points to your backend (default: `http://localhost:8000/api`).
4.  **Run Dev Server:** `npm run dev` (Runs on `http://localhost:5173`).

---

## Development Conventions

### Backend (Laravel)
- **Service Layer:** Business logic is encapsulated in `app/Services/` (e.g., `QRCodeService`, `EntryLogService`).
- **Controllers:** Controllers handle request validation and response formatting, delegating logic to services.
- **API Versioning:** Routes are defined in `routes/api.php`.
- **Models:** Eloquent models use relationships (e.g., `belongsTo`, `hasMany`) and soft deletes for devices to maintain history.
- **Auth:** Custom logic in `AuthController` handles different user types, mapping them to a consistent 'student' object structure for frontend compatibility.

### Frontend (React)
- **API Services:** Centralized API calls in `src/services/` (e.g., `authService.js`, `securityService.js`).
- **Axios Configuration:** A central axios instance in `src/api/axios.js` handles base URLs, headers, and global error interceptors (including 401 redirect logic).
- **State Management:** Uses React hooks (useState, useEffect) and custom hooks in `src/hooks/`.
- **Routing:** Managed via `react-router-dom` in `App.jsx`.
- **Components:** Modular structure in `src/components/` and `src/pages/`.

### Database Schema Notes
- **Primary Keys:** Some tables use non-standard PK names (e.g., `laptop_id`, `qr_id`, `guard_id`).
- **Unique Constraints:** Serial numbers for devices must be globally unique.
- **Soft Deletes:** Devices use soft deletes to ensure historical scan logs remain valid even if a device is removed.

---

## Key Directories
- `DevPass/server/app/Http/Controllers/`: Backend API endpoints.
- `DevPass/server/app/Services/`: Core business logic.
- `DevPass/client/src/pages/`: Main UI views (Student, Admin, Personnel).
- `DevPass/client/src/services/`: Frontend API interaction layer.
- `DevPass/server/database/migrations/`: Database schema definitions.
