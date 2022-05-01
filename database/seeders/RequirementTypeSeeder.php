<?php

namespace Database\Seeders;

use App\Models\RequirementType;
use App\Models\ScholarshipType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RequirementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scholarshipType = ScholarshipType::all();
        $fullAcademicId = $scholarshipType[array_search('Full Academic', array_column($scholarshipType->toArray(), 'scholarship_type_name'))]['id'];
        $partialAcademicId = $scholarshipType[array_search('Partial Academic', array_column($scholarshipType->toArray(), 'scholarship_type_name'))]['id'];
        $serviceId = $scholarshipType[array_search('Service', array_column($scholarshipType->toArray(), 'scholarship_type_name'))]['id'];
        $pldtId = $scholarshipType[array_search('PLDT Gabay Guro', array_column($scholarshipType->toArray(), 'scholarship_type_name'))]['id'];
        $tesId = $scholarshipType[array_search('TES', array_column($scholarshipType->toArray(), 'scholarship_type_name'))]['id'];
        $tdpId = $scholarshipType[array_search('TDP', array_column($scholarshipType->toArray(), 'scholarship_type_name'))]['id'];

        RequirementType::insert([
            // Full Academic
            [
                'scholarship_type_id' => $fullAcademicId,
                'requirement_name' => 'Certificate of Grades',
                'description' => null,
                'input_type' => 'attachment',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'scholarship_type_id' => $fullAcademicId,
                'requirement_name' => 'Certificate of Registration',
                'description' => null,
                'input_type' => 'attachment',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            // Partial Academic
            [
                'scholarship_type_id' => $partialAcademicId,
                'requirement_name' => 'Certificate of Grades',
                'description' => null,
                'input_type' => 'attachment',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'scholarship_type_id' => $partialAcademicId,
                'requirement_name' => 'Certificate of Registration',
                'description' => null,
                'input_type' => 'attachment',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            // Service
            [
                'scholarship_type_id' => $serviceId,
                'requirement_name' => 'Certificate of Grades',
                'description' => null,
                'input_type' => 'attachment',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'scholarship_type_id' => $serviceId,
                'requirement_name' => 'Certificate of Registration',
                'description' => null,
                'input_type' => 'attachment',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'scholarship_type_id' => $serviceId,
                'requirement_name' => 'Organization',
                'description' => null,
                'input_type' => 'textbox',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            // PLDT Gabay Guro
            [
                'scholarship_type_id' => $pldtId,
                'requirement_name' => 'Form 138',
                'description' => null,
                'input_type' => 'attachment',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'scholarship_type_id' => $pldtId,
                'requirement_name' => 'Form 137',
                'description' => null,
                'input_type' => 'attachment',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'scholarship_type_id' => $pldtId,
                'requirement_name' => 'Application Form  from the Scholarship Coordinator',
                'description' => null,
                'input_type' => 'attachment',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'scholarship_type_id' => $pldtId,
                'requirement_name' => 'Waiver from PLDT',
                'description' => null,
                'input_type' => 'attachment',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'scholarship_type_id' => $tesId,
                'requirement_name' => 'Certificate of Registration',
                'description' => null,
                'input_type' => 'attachment',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
            [
                'scholarship_type_id' => $tdpId,
                'requirement_name' => 'Certificate of Registration',
                'description' => null,
                'input_type' => 'attachment',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ],
        ]);
    }
}
