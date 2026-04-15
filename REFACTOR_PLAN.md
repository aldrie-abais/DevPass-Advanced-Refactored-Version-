# DevPass: Advanced MySQL Refactoring Plan
**Author:** Aldrie Abais
**Objective:** Refactor the DevPass backend to utilize Advanced MySQL concepts (Views, Triggers, Stored Procedures) to optimize database interactions, reduce PHP processing load, and fulfill final project requirements.

---

## Module A: Updatable Views (Dashboard Statistics)
**Concept Applied:** Complex JOIN operations and Views (Chapter 8).
**Goal:** Offload the relational mapping of Devices, Students, and QR Codes from the Laravel Controller to the MySQL database. 

### Implementation Steps:
1. Create a Laravel migration to execute `DB::statement('CREATE VIEW vw_device_dashboard AS ...')`.
2. Write raw SQL to `LEFT JOIN` the `devices`, `students`, and `qr_codes` tables.
3. Create a new Laravel Eloquent model `DashboardStat` mapped to the `vw_device_dashboard` view.
4. Refactor `DeviceController@index` to query the view instead of looping through relationships in PHP.

### Verification & Presentation Script:
* **Show:** Open the database client (phpMyAdmin/DBeaver) and demonstrate the `vw_device_dashboard` view. Show the code inside the Laravel Migration.
* **Action:** Load the React Admin Dashboard.
* **Pitch:** *"Instead of the PHP server executing multiple queries and looping through data to build the dashboard, MySQL pre-compiles the JOINs into a View. Laravel simply selects from this View, resulting in a cleaner controller and faster API response times."*

---

## Module B: Database Triggers (Automated Scan Counting)
**Concept Applied:** Procedural SQL / Triggers (Chapter 8).
**Goal:** Automatically track total device scans at the database level without requiring additional PHP queries during the scanning process.

### Implementation Steps:
1. Add a `total_scans` integer column to the `devices` table.
2. Create a Laravel migration using `DB::unprepared()` to write an `AFTER INSERT` trigger on the `entry_log` table.
3. The trigger logic: `UPDATE devices SET total_scans = total_scans + 1 WHERE laptop_id = NEW.laptop_id`.

### Verification & Presentation Script:
* **Show:** Open the database client and show the `total_scans` column for a specific device is at `0`.
* **Action:** Use the frontend (or API) to simulate a successful QR code scan for that device.
* **Pitch:** *"I did not write any PHP code to update the scan count. When the new scan log was inserted, the MySQL Trigger intercepted the action and automatically incremented the device's total scan count in the background."*

---

## Module C: Stored Procedures (Device Approval Logic)
**Concept Applied:** Stored Procedures (Chapter 8).
**Goal:** Encapsulate the multi-step business logic of approving a device into a single database routine to reduce network traffic and ensure transaction integrity.

### Implementation Steps:
1. Create a migration using `DB::unprepared()` to build `CREATE PROCEDURE PRC_APPROVE_DEVICE(IN deviceId INT, IN adminId INT)`.
2. The procedure will: Update the device status to 'active', set the `approved_by` ID, and insert the initial active QR code record.
3. Refactor `DeviceController@approve` to replace the PHP logic with `DB::statement('CALL PRC_APPROVE_DEVICE(?, ?)', [$id, $adminId])`.

### Verification & Presentation Script:
* **Show:** Display the Stored Procedure in the database client under "Routines".
* **Action:** Click "Approve" on a pending device in the React dashboard.
* **Pitch:** *"By moving the approval logic into a Stored Procedure, we reduce multiple database trips into a single call. This isolates the business logic at the database layer, improving performance and ensuring the status update and QR code generation happen together."*