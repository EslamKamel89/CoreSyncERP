<?php

namespace Tests\Support;

use App\Models\User;
use Modules\Core\Models\Company;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Modules\HR\Models\Department;
use Modules\HR\Models\Grade;
use Modules\HR\Models\Position;
use Modules\HR\Models\Employee;

class PestHelper {
    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */

    public static function manageSettingsPermission(): Permission {
        return Permission::where('name', 'core.manage_settings')->firstOrFail();
    }

    public static function hrAccessPermission(): Permission {
        return Permission::where('name', 'hr.access')->firstOrFail();
    }

    public static function hrManageStructurePermission(): Permission {
        return Permission::where('name', 'hr.manage_structure')->firstOrFail();
    }


    public static function inventoryAccessPermission(): Permission {
        return Permission::where('name', 'inventory.access')->firstOrFail();
    }

    public static function accountingAccessPermission(): Permission {
        return Permission::where('name', 'accounting.access')->firstOrFail();
    }

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */

    public static function adminRole(): Role {
        return Role::where('name', 'Admin')->firstOrFail();
    }

    public static function hrRole(): Role {
        return Role::where('name', 'HR Manager')->firstOrFail();
    }


    public static function inventoryRole(): Role {
        return Role::where('name', 'Inventory Manager')->firstOrFail();
    }

    public static function accountantRole(): Role {
        return Role::where('name', 'Accountant')->firstOrFail();
    }

    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

    public static function adminUser(array $attributes = []): User {
        $user = User::factory()->create($attributes);

        $user->assignRole(self::adminRole());

        return $user;
    }
    public static function hrUser(array $attributes = []): User {
        $user = User::factory()->create($attributes);

        $user->assignRole(self::hrRole());

        return $user;
    }

    public static function normalUser(array $attributes = []): User {
        return User::factory()->create($attributes);
    }

    public static function hrManagerUser(array $attributes = []): User {
        $user = User::factory()->create($attributes);
        $user->assignRole(self::hrRole());
        return $user;
    }

    /*
    |--------------------------------------------------------------------------
    | company
    |--------------------------------------------------------------------------
    */
    public static function company(): Company {
        return Company::all()->firstOrFail();
    }
    /*
    |--------------------------------------------------------------------------
    | HR Resources
    |--------------------------------------------------------------------------
    */
    public static function department(array $overrides = []): Department {
        return Department::create(array_merge([
            'name' => self::localizedName('Department'),
            'is_active' => true,
        ], $overrides));
    }

    public static function grade(array $overrides = []): Grade {
        return Grade::create(array_merge([
            'name' => self::localizedName('Grade'),
            'base_salary' => 5000,
            'is_active' => true,
        ], $overrides));
    }

    public static function position(
        Department $department,
        ?Grade $grade = null,
        array $overrides = []
    ): Position {
        return Position::create(array_merge([
            'department_id' => $department->id,
            'grade_id' => $grade?->id,
            'name' => self::localizedName('Position'),
            'is_active' => true,
        ], $overrides));
    }

    public static function employee(
        Department $department,
        Position $position,
        ?Grade $grade = null,
        array $overrides = []
    ): Employee {
        return Employee::create(array_merge([
            'name' => 'Test Employee',
            'display_name' => self::localizedName('Test Employee'),
            'department_id' => $department->id,
            'position_id' => $position->id,
            'grade_id' => $grade?->id,
            'hire_date' => now()->subYear(),
            'base_salary' => 6000,
            'is_active' => true,
        ], $overrides));
    }
    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    public static function localizedName(string $en, ?string $ar = null): array {
        return [
            'en' => $en,
            'ar' => $ar ?? $en,
        ];
    }

    public static function assertDatabaseHasLocalized(
        string $table,
        string $column,
        string $locale,
        string $value
    ): void {
        \PHPUnit\Framework\Assert::assertTrue(
            \DB::table($table)->where("$column->$locale", $value)->exists(),
            "Failed asserting that {$table}.{$column}->{$locale} has value [{$value}]"
        );
    }
}
