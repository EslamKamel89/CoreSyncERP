<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\HR\Models\Department;
use Modules\HR\Models\Position;

class HRDemoDataSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        if (!app()->isLocal() && config('app.debug') !== true) {
            return;
        }
        $departments = [
            'hr' => [
                'en' => 'Human Resources',
                'ar' => 'الموارد البشرية',
            ],
            'finance' => [
                'en' => 'Finance',
                'ar' => 'المالية',
            ],
            'engineering' => [
                'en' => 'Engineering',
                'ar' => 'الهندسة',
            ],
            'sales' => [
                'en' => 'Sales',
                'ar' => 'المبيعات',
            ],
            'operations' => [
                'en' => 'Operations',
                'ar' => 'العمليات',
            ],
        ];
        $departmentModels = [];
        foreach ($departments as $key => $name) {
            $departmentModels[$key] = Department::firstOrCreate(
                ['name->en' => $name['en']],
                [
                    'name' => [
                        'en' => $name['en'],
                        'ar' => $name['ar'],
                    ],
                    'is_active' => true,
                ]
            );
        }
        $positions = [
            'hr' => [
                [
                    'en' => 'HR Manager',
                    'ar' => 'مدير الموارد البشرية',
                ],
                [
                    'en' => 'HR Specialist',
                    'ar' => 'أخصائي موارد بشرية',
                ],
            ],
            'finance' => [
                [
                    'en' => 'Accountant',
                    'ar' => 'محاسب',
                ],
                [
                    'en' => 'Financial Controller',
                    'ar' => 'مراقب مالي',
                ],
            ],
            'engineering' => [
                [
                    'en' => 'Backend Engineer',
                    'ar' => 'مهندس نظم خلفية',
                ],
                [
                    'en' => 'Frontend Engineer',
                    'ar' => 'مهندس واجهات',
                ],
            ],
            'sales' => [
                [
                    'en' => 'Sales Executive',
                    'ar' => 'مندوب مبيعات',
                ],
            ],
            'operations' => [
                [
                    'en' => 'Operations Supervisor',
                    'ar' => 'مشرف عمليات',
                ],
            ],
        ];
        foreach ($positions as $departmentKey => $items) {
            foreach ($items as $position) {
                Position::firstOrCreate(
                    [
                        'department_id' => $departmentModels[$departmentKey]->id,
                        'name->en' => $position['en'],
                    ],
                    [
                        'department_id' => $departmentModels[$departmentKey]->id,
                        'name' => [
                            'en' => $position['en'],
                            'ar' => $position['ar'],
                        ],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
