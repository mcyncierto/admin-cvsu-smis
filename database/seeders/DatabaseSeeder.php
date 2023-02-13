<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*
         * For users table
         */
        DB::table('users')->insert([
            [
                'student_number' => '00-00-0000',
                'first_name' => 'CvSU',
                'middle_name' => '',
                'last_name' => 'Admin',
                'birthdate' => null,
                'gender' => 'N/A',
                'contact_number' => 'N/A',
                'address' => 'N/A',
                'email' => 'default@mail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'type' => 'Admin',
            ],
            [
                'student_number' => '00-00-0001',
                'first_name' => 'CvSU',
                'middle_name' => '',
                'last_name' => 'Cashier',
                'birthdate' => null,
                'gender' => 'N/A',
                'contact_number' => 'N/A',
                'address' => 'N/A',
                'email' => 'default-cashier@mail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'type' => 'Cashier',
            ],
        ]);
        // \App\Models\User::factory(50)->create();
        // \App\Models\Announcement::factory(50)->create();
        $this->call([
            ScholarshipTypeSeeder::class,
            SemesterSeeder::class,
            RequirementTypeSeeder::class,
           CourseSeeder::class,
        ]);
    }
}
