<?php

namespace Modules\Core\database\seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     */


    public function run(): void {
        $permissions = [
            'system.manage_roles',
            'core.manage_settings',
            'hr.access',
            'hr.manage_structure',
            'inventory.access',
            'accounting.access',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        /** @var Role $admin */
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        /** @var Role $hr */
        $hr = Role::firstOrCreate(['name' => 'HR Manager']);
        /** @var Role $inventory */
        $inventory = Role::firstOrCreate(['name' => 'Inventory Manager']);
        /** @var Role $accountant */
        $accountant = Role::firstOrCreate(['name' => 'Accountant']);

        $admin->givePermissionTo(Permission::all());

        $hr->givePermissionTo([
            'hr.access',
            'hr.manage_structure',
        ]);

        $inventory->givePermissionTo(['inventory.access']);
        $accountant->givePermissionTo(['accounting.access']);
    }
}
