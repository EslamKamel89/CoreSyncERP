<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Models\Department;
use Modules\HR\Models\Position;
use Modules\HR\Models\Employee;
use Carbon\Carbon;

class HRDemoDataSeeder extends Seeder {
    public function run(): void {
        if (!app()->isLocal() && config('app.debug') !== true) {
            return;
        }

        // -----------------------------
        // Departments
        // -----------------------------
        $departments = [
            'hr' => ['en' => 'Human Resources', 'ar' => 'الموارد البشرية'],
            'finance' => ['en' => 'Finance', 'ar' => 'المالية'],
            'engineering' => ['en' => 'Engineering', 'ar' => 'الهندسة'],
            'sales' => ['en' => 'Sales', 'ar' => 'المبيعات'],
            'operations' => ['en' => 'Operations', 'ar' => 'العمليات'],
        ];

        $departmentModels = [];

        foreach ($departments as $key => $name) {
            $departmentModels[$key] = Department::firstOrCreate(
                ['name->en' => $name['en']],
                [
                    'name' => $name,
                    'is_active' => true,
                ]
            );
        }

        // -----------------------------
        // Positions
        // -----------------------------
        $positions = [
            'hr' => [
                ['en' => 'HR Manager', 'ar' => 'مدير الموارد البشرية'],
                ['en' => 'HR Specialist', 'ar' => 'أخصائي موارد بشرية'],
            ],
            'finance' => [
                ['en' => 'Accountant', 'ar' => 'محاسب'],
                ['en' => 'Financial Controller', 'ar' => 'مراقب مالي'],
            ],
            'engineering' => [
                ['en' => 'Backend Engineer', 'ar' => 'مهندس نظم خلفية'],
                ['en' => 'Frontend Engineer', 'ar' => 'مهندس واجهات'],
            ],
            'sales' => [
                ['en' => 'Sales Executive', 'ar' => 'مندوب مبيعات'],
            ],
            'operations' => [
                ['en' => 'Operations Supervisor', 'ar' => 'مشرف عمليات'],
            ],
        ];

        $positionModels = [];

        foreach ($positions as $departmentKey => $items) {
            foreach ($items as $position) {
                $model = Position::firstOrCreate(
                    [
                        'department_id' => $departmentModels[$departmentKey]->id,
                        'name->en' => $position['en'],
                    ],
                    [
                        'department_id' => $departmentModels[$departmentKey]->id,
                        'name' => $position,
                        'is_active' => true,
                    ]
                );

                $positionModels[] = $model;
            }
        }

        // -----------------------------
        // Employees (Demo Data)
        // -----------------------------
        $employees = [
            [
                'name' => 'Ahmed Hassan',
                'display_name' => ['en' => 'Ahmed Hassan', 'ar' => 'أحمد حسن'],
                'department' => 'hr',
                'position_en' => 'HR Manager',
                'hire_date' => '2019-03-15',
                'base_salary' => 8500,
            ],
            [
                'name' => 'Sara Ali',
                'display_name' => ['en' => 'Sara Ali', 'ar' => 'سارة علي'],
                'department' => 'finance',
                'position_en' => 'Accountant',
                'hire_date' => '2020-07-01',
                'base_salary' => 6500,
            ],
            [
                'name' => 'Omar Khaled',
                'display_name' => ['en' => 'Omar Khaled', 'ar' => 'عمر خالد'],
                'department' => 'engineering',
                'position_en' => 'Backend Engineer',
                'hire_date' => '2021-01-10',
                'base_salary' => 9000,
            ],
            [
                'name' => 'Lina Youssef',
                'display_name' => ['en' => 'Lina Youssef', 'ar' => 'لينا يوسف'],
                'department' => 'engineering',
                'position_en' => 'Frontend Engineer',
                'hire_date' => '2022-06-20',
                'base_salary' => 7800,
            ],
            [
                'name' => 'Mohamed Samir',
                'display_name' => ['en' => 'Mohamed Samir', 'ar' => 'محمد سمير'],
                'department' => 'sales',
                'position_en' => 'Sales Executive',
                'hire_date' => '2023-02-01',
                'base_salary' => 6000,
            ],
        ];

        foreach ($employees as $data) {
            $department = $departmentModels[$data['department']];
            $position = Position::where('department_id', $department->id)
                ->where('name->en', $data['position_en'])
                ->first();

            Employee::firstOrCreate(
                ['name' => $data['name']],
                [
                    'name' => $data['name'],
                    'display_name' => $data['display_name'],
                    'department_id' => $department->id,
                    'position_id' => $position?->id,
                    'hire_date' => Carbon::parse($data['hire_date']),
                    'base_salary' => $data['base_salary'],
                    'is_active' => true,
                ]
            );
        }
    }
}
