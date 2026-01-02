<?php

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Modules\Core\Livewire\Settings\CompanyProfile;
use Tests\Support\PestHelper;


uses(RefreshDatabase::class);
it('allows admin to update company profile and dispatches success toast', function () {
    $admin = PestHelper::adminUser();
    Livewire::actingAs($admin)
        ->test(CompanyProfile::class)
        ->set('form.name', 'new company name')
        ->call('save')
        ->assertHasNoErrors();
    $company = PestHelper::company();
    $this->assertEquals($company->name, 'new company name');
});
