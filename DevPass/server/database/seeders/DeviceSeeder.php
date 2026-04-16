<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Admin;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // 1. Fetch valid data from the database to satisfy constraints
        $studentIds = Student::pluck('student_id')->toArray();
        $adminId = Admin::value('admin_id'); 
        
        // NEW: Fetch actual, valid models from your laptop_specifications table
        $validModels = DB::table('laptop_specifications')->pluck('model')->toArray();

        // 2. Safety Checks
        if (empty($studentIds)) {
            $this->command->error('No students found! Please seed the students table first.');
            return;
        }

        if (empty($validModels)) {
            $this->command->error('No laptop specifications found! Please add or seed at least one laptop_specification first so we have a valid model to link to.');
            return;
        }

        $devices = [];
        $brands = ['Dell', 'HP', 'Lenovo', 'Apple', 'Asus', 'Acer'];

        // 3. Generate 15 dummy devices
        for ($i = 0; $i < 15; $i++) {
            
            $status = $faker->randomElement(['pending', 'active', 'rejected']);
            $brand = $faker->randomElement($brands);
            $registrationDate = $faker->dateTimeBetween('-2 months', 'now');
            
            $approvedBy = null;
            $approvedAt = null;
            
            if ($status === 'active' && $adminId) {
                $approvedBy = $adminId;
                $approvedAt = Carbon::instance($registrationDate)->addDays(rand(1, 5));
            }

            $devices[] = [
                'student_id' => $faker->randomElement($studentIds),
                // FIXED: Now we randomly select a REAL model from your database!
                'model' => $faker->randomElement($validModels), 
                'serial_number' => strtoupper($faker->bothify('SN-####-????-####')),
                'brand' => $brand,
                'registration_date' => $registrationDate,
                'registration_status' => $status,
                'approved_by' => $approvedBy,
                'approved_at' => $approvedAt,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // 4. Insert into the database
        DB::table('devices')->insert($devices);
        
        $this->command->info('15 Mock devices seeded successfully!');
    }
}