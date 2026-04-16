<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // We use DB::unprepared() because Triggers contain multiple SQL statements
        DB::unprepared("
            CREATE TRIGGER trg_increment_scan_count
            AFTER INSERT ON entry_log
            FOR EACH ROW
            BEGIN
                -- Only count successful scans!
                IF NEW.status = 'success' THEN
                    UPDATE devices 
                    SET total_scans = total_scans + 1 
                    WHERE laptop_id = (
                        SELECT laptop_id FROM qr_codes 
                        WHERE qr_code_hash = NEW.qr_code_hash 
                        LIMIT 1
                    );
                END IF;
            END;
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS trg_increment_scan_count");
    }
};