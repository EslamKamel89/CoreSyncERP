<?php

return [
    'create' => [
        'title' => 'إضافة موظف',
        'description' => 'إضافة موظف جديد وربطه بالهيكل التنظيمي.',
        "select_department_first" => 'يرجى اختيار القسم أولاً'
    ],

    'edit' => [
        'title' => 'تعديل بيانات الموظف',
        'description' => 'تحديث بيانات الموظف وتعيينه الوظيفي.',
    ],

    'actions' => [
        'save' => 'حفظ الموظف',
    ],

    'fields' => [
        'employee_number' => 'الرقم الوظيفي',
        'name' => 'الاسم الكامل',
        'display_name' => 'اسم العرض',
        'department' => 'القسم',
        'position' => 'المنصب',
        'grade' => 'الدرجة الوظيفية',
        'hire_date' => 'تاريخ التعيين',
        'base_salary' => 'الراتب الأساسي',
        'is_active' => 'نشط',
        'status' => 'مفعل'
    ],

    'placeholders' => [
        'department' => 'اختر القسم',
        'position' => 'اختر المنصب',
        'grade' => 'بدون درجة',
        'display_name' => 'اسم عرض اختياري',
    ],
];
