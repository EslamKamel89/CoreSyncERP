<?php

namespace Modules\HR\Observers;

use Modules\HR\Models\Employee;
use Str;

class EmployeeObserver {
    public function creating(Employee $employee) {
        if ($employee->employee_number) return;
        $datePart = now()->format('Ymd');
        $randomPart = strtoupper(Str::random(4));
        $employee->employee_number = "EMP-{$datePart}-{$randomPart}";
    }
}
