<?php

namespace Database\Seeders;

use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Semester::insert([
            [
                'semester_name' => 'First Semester',
                'is_current' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'semester_name' => 'Second Semester',
                'is_current' => 0,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
        ]);
    }
}
