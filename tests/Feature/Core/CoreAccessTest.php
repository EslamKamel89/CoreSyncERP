<?php

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\Company;
use Spatie\Permission\Models\Permission;
use Tests\Support\PestHelper;

uses(RefreshDatabase::class);
it('redirect guests away from core pages', function () {
    $response = $this->get(route('core.settings.company'));
    $response->assertRedirectToRoute('login');
});

it('allow user with permission to visit the company page', function () {
    $permission = PestHelper::manageSettingsPermission();
    $user = PestHelper::normalUser();
    $user->givePermissionTo($permission);
    $res = $this->actingAs($user)->get(route('core.settings.company'));
    $res->assertOk();
});
