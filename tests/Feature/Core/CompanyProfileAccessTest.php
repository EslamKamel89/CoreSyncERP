<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\PestHelper;

uses(RefreshDatabase::class);

it("check normal user can't visit the company page ", function () {
    $user = PestHelper::normalUser();
    $res = $this->actingAs($user)->get(route('core.settings.company'));
    $res->assertForbidden();
});

it('allows admin users to access company profile', function () {
    $user = PestHelper::adminUser();
    $res = $this->actingAs($user)->get(route('core.settings.company'));
    $res->assertOk();
});
