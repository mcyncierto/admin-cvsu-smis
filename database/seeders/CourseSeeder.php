<?php

namespace Database\Seeders;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::insert([
            [
                'course_name' => 'BSBM (Bachelor of Science in Business Management)',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'course_name' => 'BSE (Bachelor of Secondary Education)',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'course_name' => 'BSP (Bachelor of Science in Psychology)',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'course_name' => 'BSCS (Bachelor of Science in Computer Science)',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'course_name' => 'BSIT (Bachelor of Science in Information Technology)',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'course_name' => 'BSC (Bachelor of Science in Criminology)',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'course_name' => 'BSHM (Bachelor of Science in Hospitality Management)',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
        ]);
    }
}
