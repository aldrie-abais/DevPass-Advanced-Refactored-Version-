<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            DROP PROCEDURE IF EXISTS PRC_APPROVE_DEVICE;
            
            CREATE PROCEDURE PRC_APPROVE_DEVICE(
                IN p_laptop_id BIGINT, 
                IN p_admin_id BIGINT,
                IN p_qr_hash VARCHAR(255),
                IN p_expires_at DATETIME
            )
            BEGIN
                -- 1. Update the device status
                UPDATE devices 
                SET registration_status = 'active', 
                    approved_by = p_admin_id, 
                    approved_at = NOW(),
                    updated_at = NOW()
                WHERE laptop_id = p_laptop_id;
                
                -- 2. Deactivate any old QR codes for this device just to be safe
                UPDATE qr_codes 
                SET is_active = 0 
                WHERE laptop_id = p_laptop_id;

                -- 3. Insert the brand new active QR code
                INSERT INTO qr_codes (
                    laptop_id, 
                    qr_code_hash, 
                    expires_at, 
                    is_active, 
                    created_at, 
                    updated_at
                ) 
                VALUES (
                    p_laptop_id, 
                    p_qr_hash, 
                    p_expires_at, 
                    1, 
                    NOW(), 
                    NOW()
                );
            END;
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS PRC_APPROVE_DEVICE");
    }
};