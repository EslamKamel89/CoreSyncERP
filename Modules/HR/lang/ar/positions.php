<?php

return [
    'create' => [
        'title' => 'إنشاء منصب',
        'description' => 'تعريف منصب وظيفي جديد داخل قسم معين.',
    ],
    'edit' => [
        'title' => 'تعديل منصب',
        'description' => 'تعديل بيانات المنصب الوظيفي.',
    ],

    'actions' => [
        'save' => 'حفظ المنصب',
    ],

    'fields' => [
        'name' => 'اسم المنصب',
        'department' => 'القسم',
        'grade' => 'الدرجة الوظيفية',
        'is_active' => 'نشط',
    ],
    'placeholders' => [
        'department' => 'اختر القسم',
        'grade' => 'بدون درجة',
    ],
];
