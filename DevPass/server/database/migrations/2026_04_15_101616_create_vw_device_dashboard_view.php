<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Using raw Advanced MySQL to build the View
        DB::statement("
            CREATE OR REPLACE VIEW vw_device_dashboard AS
            SELECT 
                d.laptop_id AS id,
                s.name AS studentName,
                s.student_id AS studentId,
                c.course_code AS course,
                d.brand,
                d.model,
                d.serial_number AS serialNumber,
                d.registration_status AS status,
                DATE_FORMAT(d.registration_date, '%Y-%m-%d') AS registrationDate,
                DATE_FORMAT(q.expires_at, '%Y-%m-%d') AS qrExpiry,
                q.qr_code_hash AS qrCodeHash,
                -- Correlated subquery to get the absolute latest scan timestamp
                (SELECT DATE_FORMAT(MAX(scan_timestamp), '%b %d, %Y %h:%i %p') 
                 FROM entry_log e 
                 WHERE e.qr_code_hash = q.qr_code_hash AND e.status = 'success'
                ) AS lastScanned
            FROM devices d
            LEFT JOIN students s ON d.student_id = s.student_id
            LEFT JOIN course c ON s.course_id = c.course_id
            LEFT JOIN qr_codes q ON d.laptop_id = q.laptop_id AND q.is_active = 1
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_device_dashboard");
    }
};