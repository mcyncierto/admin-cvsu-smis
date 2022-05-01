<?php

namespace Database\Seeders;

use App\Models\ScholarshipType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScholarshipTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScholarshipType::insert([
            [
                'scholarship_type_name' => 'Full Academic',
                'max_scholars_allowed' => '45',
                'lowest_gpa_allowed' => '1.45',
                'highest_gpa_allowed' => '1.00',
                'restrictions' => null,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'scholarship_type_name' => 'Partial Academic',
                'max_scholars_allowed' => '300',
                'lowest_gpa_allowed' => '1.75',
                'highest_gpa_allowed' => '1.46',
                'restrictions' => null,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'scholarship_type_name' => 'Service',
                'max_scholars_allowed' => '200',
                'lowest_gpa_allowed' => null,
                'highest_gpa_allowed' => null,
                'restrictions' => 'INC,Dropped',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'scholarship_type_name' => 'PLDT Gabay Guro',
                'max_scholars_allowed' => null,
                'lowest_gpa_allowed' => '2.00',
                'highest_gpa_allowed' => '1.00',
                'restrictions' => 'INC,Dropped',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'scholarship_type_name' => 'TES',
                'max_scholars_allowed' => null,
                'lowest_gpa_allowed' => null,
                'highest_gpa_allowed' => null,
                'restrictions' => 'INC,Dropped',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'scholarship_type_name' => 'TDP',
                'max_scholars_allowed' => null,
                'lowest_gpa_allowed' => null,
                'highest_gpa_allowed' => null,
                'restrictions' => 'INC,Dropped',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
        ]);
    }
}
