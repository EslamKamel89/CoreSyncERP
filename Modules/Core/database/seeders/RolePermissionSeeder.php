<?php

namespace Modules\Core\database\seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $permissions = [
            'core.manage_settings',
            'hr.access',
            'inventory.access',
            'accounting.access',
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        /** @var Role $admin */
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $hr = Role::firstOrCreate(['name' => 'HR Manager']);
        $inventory = Role::firstOrCreate(['name' => 'Inventory Manager']);
        $accountant = Role::firstOrCreate(['name' => 'Accountant']);
        $admin->givePermissionTo(Permission::all());
        $hr->givePermissionTo([$permissions[1]]);
        $inventory->givePermissionTo([$permissions[2]]);
        $accountant->givePermissionTo([$permissions[3]]);
        $user = User::where('name', 'admin')->firstOrFail();
        $user->assignRole($admin);
    }
}
