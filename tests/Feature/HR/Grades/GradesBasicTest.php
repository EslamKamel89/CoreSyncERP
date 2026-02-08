<?php

use Tests\Support\PestHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\HR\Livewire\Grades\Index;
use Modules\HR\Livewire\Grades\Form;
use Modules\HR\Models\Grade;

uses(RefreshDatabase::class);
it('renders grades index page successfully', function () {
    $user = PestHelper::hrManagerUser();
    $this->actingAs($user)
        ->get(route('hr.grades.index'))
        ->assertOk();
});

it('allows creating a grade with localized name and base salary', function () {
    $user = PestHelper::hrManagerUser();
    Livewire::actingAs($user)
        ->test(Form::class)
        ->set('name', [
            'en' => 'Senior',
            'ar' => 'خبير',
        ])->set('is_active', true)
        ->set('base_salary', 9000)
        ->call('save')
        ->assertHasNoErrors();
    PestHelper::assertDatabaseHasLocalized(
        'grades',
        'name',
        'en',
        'Senior'
    );
    $this->assertTrue(
        Grade::where('is_active', true)
            ->where('base_salary', 9000)->exists()
    );
});

it('shows english localized grade name in grades list', function () {
    $user = PestHelper::hrManagerUser();
    PestHelper::grade([
        'name' => [
            'en' => 'Mid Level',
            'ar' => 'متوسط',
        ],
    ]);
    Livewire::actingAs($user)
        ->test(Index::class)
        ->assertSee('Mid Level');
});
it('shows arabic localized grade name in grades list', function () {
    $user = PestHelper::hrManagerUser();
    PestHelper::grade([
        'name' => [
            'en' => 'Mid Level',
            'ar' => 'متوسط',
        ],
    ]);
    app()->setLocale('ar');
    Livewire::actingAs($user)
        ->test(Index::class)
        ->assertSee('متوسط');
});
