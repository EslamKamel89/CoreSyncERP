<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Core\Enums\CoreTag;
use Modules\Core\Models\Company;
use Modules\Core\Models\Tag;

class LocalAdminSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $user =   User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
        ]);
        $user->assignRole('Admin');
    }
}
