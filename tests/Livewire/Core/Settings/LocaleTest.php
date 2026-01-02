<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\Support\PestHelper;

uses(RefreshDatabase::class);
it('applies user locale and direction correctly', function () {
    $user = PestHelper::normalUser(['locale' => 'ar']);
    $this->actingAs($user)->get(route('dashboard'));
    $this->assertEquals(app()->getLocale(), $user->locale);
});
