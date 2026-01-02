<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->beforeEach(function () {
        \Modules\Core\Models\Company::factory()->create();
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
    })
    ->in('Feature', 'Livewire');

class PestHelper {
    static function adminRole() {
        return Role::where('name', 'admin')->firstOrFail();
    }
}

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something() {
    // ..
}
