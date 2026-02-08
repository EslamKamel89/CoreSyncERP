<?php

use Tests\Support\PestHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\HR\Livewire\Grades\Index;
use Modules\HR\Livewire\Grades\Form;
use Modules\HR\Models\Grade;

uses(RefreshDatabase::class);
it('allows updating an existing grade', function () {
    $user = PestHelper::hrManagerUser();
    $grade = PestHelper::grade([
        'name' => [
            'en' => 'Senior',
            'ar' => 'خبير',
        ],
        'base_salary' => 9000,
    ]);
    Livewire::actingAs($user)
        ->test(Form::class, ['grade' => $grade])
        ->set('name.en', 'Senior Updated')
        ->set('base_salary', 9500)
        ->call('save')
        ->assertHasNoErrors();
    PestHelper::assertDatabaseHasLocalized(
        table: 'grades',
        column: 'name',
        locale: 'en',
        value: 'Senior Updated'
    );
    $this->assertTrue(
        Grade::where('id', $grade->id)
            ->where('base_salary', 9500)
            ->exists()
    );
});

it('allows deactivating a grade', function () {
    $user = PestHelper::hrManagerUser();
    $grade = PestHelper::grade(['is_active' => true]);
    Livewire::actingAs($user)
        ->test(Form::class, ['grade' => $grade])
        ->set('is_active', false)
        ->call('save')
        ->assertHasNoErrors();
    $this->assertTrue(
        Grade::where('id', $grade->id)
            ->where('is_active', false)
            ->exists()
    );
});

it('filters grades by active status', function () {
    $user = PestHelper::hrManagerUser();
    PestHelper::grade(['name' => ['en' => 'Active Grade'], 'is_active' => true]);
    PestHelper::grade(['name' => ['en' => 'Inactive Grade'], 'is_active' => false]);
    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('filters.status', 'active')
        ->assertSee('Active Grade')
        ->assertDontSee('Inactive Grade');
});
it('sorts grades by is_active', function () {
    $user = PestHelper::hrManagerUser();
    PestHelper::grade(['name' => ['en' => 'Junior'], 'is_active' => false]);
    PestHelper::grade(['name' => ['en' => 'Lead'], 'is_active' => true]);
    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('sortColumn', 'is_active')
        ->set('sortDirection', 'desc')
        ->assertSeeInOrder(['Lead', 'Junior']);
});
it('respects per-page selection on grades list', function () {
    $user = PestHelper::hrManagerUser();

    foreach (range(1, 15) as $i) {
        PestHelper::grade([
            'name' => ['en' => "Grade {$i}"],
        ]);
    }

    Livewire::actingAs($user)
        ->test(Index::class)
        ->set('perPage', 5)
        ->assertCount('grades.list.rows', 5);
});
