<?php

namespace App\Imports;

use App\Models\StudentRecord;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentRecordsImport implements ToModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $request = Request();

        if ($row[0] != 'Student Number' && !empty($row[0])) { // Execute if header and cell is not empty
            return new StudentRecord([
                'semester_id' => $request->semester,
                'school_year' => $request->school_year,
                'student_number' => $row[0],
                'course' => $row[2],
                'gpa' => $row[3],
                'has_inc' => ($row[4] == 'Yes') ? true : false,
                'has_dropped' => ($row[5] == 'Yes') ? true : false,
                'is_enrolled' => ($row[6] == 'Yes') ? true : false,
            ]);
        }
    }
}
