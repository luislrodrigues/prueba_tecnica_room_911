<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeesImport implements ToModel, WithHeadingRow, WithBatchInserts,WithChunkReading, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        return new Employee([
            'department_id'     => $row['department_id'],
            'first_name'        => $row['first_name'],
            'last_name'         => $row['last_name'],
            'email'             => $row['email'],
            'document_number'   => $row['document_number']

        ]);
    }

    public function rules() :array
    {
        return [
            'department_id'   => ['bail','required','exists:departments,id'],
            'first_name'      => ['bail','required','string'],
            'last_name'       => ['bail','required','string'],
            'email'           => ['bail','required','email',Rule::unique('employees')->whereNull('deleted_at')],
            'document_number' => ['bail','required','numeric','digits_between:7,12',Rule::unique('employees')->whereNull('deleted_at')]
        ];
    }
    public function batchSize(): int
    {
        return 50;
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
