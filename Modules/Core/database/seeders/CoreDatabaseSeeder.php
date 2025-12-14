<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Core\Enums\CoreTag;
use Modules\Core\Models\Company;
use Modules\Core\Models\Tag;

class CoreDatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $company = Company::factory()->create([
            'name' => 'IslamDev',
            'base_currency' => 'USD',
            'timezone' => 'Africa/Cairo',
            'locale' => 'en',
        ]);

        foreach (CoreTag::cases() as $tag) {
            Tag::create([
                'company_id' => $company->id,
                'name'       => $tag->value,
                'slug'       => $tag->slug(),
                'meta'       => [
                    'system' => true,
                    'seeded' => true,
                ],
            ]);
        }
    }
}
