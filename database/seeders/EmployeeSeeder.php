<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //random employers with random email, phone, address, department_id

        $data = [
            [
                'name'          => 'John Doe',
                'email'         => 'email1@example.com',
                'phone'         => '11111111',
                'address'       => 'Kyiv',
                'department_id' => 2,
            ],
            [
                'name'          => 'Jane Doe',
                'email'         => 'email2@example.com',
                'phone'         => '22222222',
                'address'       => 'Kyiv',
                'department_id' => 2,
            ],
            [
                'name'          => 'John Smith',
                'email'         => 'email3@example',
                'phone'         => '33333333',
                'address'       => 'Kyiv',
                'department_id' => 2,
            ]
        ];

        Employee::insert($data);
    }
}
