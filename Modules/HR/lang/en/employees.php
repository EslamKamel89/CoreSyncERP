<?php

return [
    'create' => [
        'title' => 'Create Employee',
        'description' => 'Add a new employee and assign them to the organization structure.',
        "select_department_first" => 'Please select a department first'
    ],

    'edit' => [
        'title' => 'Edit Employee',
        'description' => 'Update employee information and organizational assignment.',
    ],

    'actions' => [
        'save' => 'Save Employee',
    ],

    'fields' => [
        'employee_number' => 'Employee number',
        'name' => 'Full name',
        'display_name' => 'Display name',
        'department' => 'Department',
        'position' => 'Position',
        'grade' => 'Grade',
        'hire_date' => 'Hire date',
        'base_salary' => 'Base salary',
        'is_active' => 'Active',
        'status' => 'Status'
    ],

    'placeholders' => [
        'department' => 'Select department',
        'position' => 'Select position',
        'grade' => 'No grade',
        'display_name' => 'Optional display name',
    ],
];
