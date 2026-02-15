<?php

use Tests\Support\PestHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\HR\Livewire\Grades\Form as GradeForm;
use Modules\HR\Livewire\Grades\Index as GradeIndex;
use Modules\HR\Models\Grade;

uses(RefreshDatabase::class);

it('localized input saves all locales', function () {
    $user = PestHelper::hrManagerUser();

    Livewire::actingAs($user)
        ->test(GradeForm::class)
        ->set('name', [
            'en' => 'Localized Grade',
            'ar' => 'درجة مترجمة',
        ])
        ->set('base_salary', 8000)
        ->call('save')
        ->assertHasNoErrors();

    PestHelper::assertDatabaseHasLocalized(
        table: 'grades',
        column: 'name',
        locale: 'en',
        value: 'Localized Grade'
    );

    PestHelper::assertDatabaseHasLocalized(
        table: 'grades',
        column: 'name',
        locale: 'ar',
        value: 'درجة مترجمة'
    );
});

it('localized input respects current locale display', function () {
    $user = PestHelper::hrManagerUser();

    PestHelper::grade([
        'name' => [
            'en' => 'English Name',
            'ar' => 'الاسم العربي',
        ],
    ]);

    app()->setLocale('ar');

    Livewire::actingAs($user)
        ->test(GradeIndex::class)
        ->assertSee('الاسم العربي')
        ->assertDontSee('English Name');
});

it('active toggle updates is_active flag', function () {
    $user = PestHelper::hrManagerUser();

    $grade = PestHelper::grade([
        'name' => ['en' => 'Toggle Grade'],
        'is_active' => true,
    ]);

    Livewire::actingAs($user)
        ->test(GradeForm::class, ['grade' => $grade])
        ->set('is_active', false)
        ->call('save')
        ->assertHasNoErrors();

    $this->assertTrue(
        Grade::where('id', $grade->id)
            ->where('is_active', false)
            ->exists()
    );
});
