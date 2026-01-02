<?php

namespace Tests\Support;

use App\Models\User;
use Modules\Core\Models\Company;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
    public static function normalUser(array $attributes = []): User {
        return User::factory()->create($attributes);
    }
    /*
    |--------------------------------------------------------------------------
    | company
    |--------------------------------------------------------------------------
    */
    public static function company(): Company {
        return Company::all()->firstOrFail();
    }
}
