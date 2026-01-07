<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Core\Database\Seeders\CoreDatabaseSeeder;
use Modules\HR\Database\Seeders\HRDatabaseSeeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {


        $this->call([
            CoreDatabaseSeeder::class,
            LocalAdminSeeder::class,
            HRDatabaseSeeder::class
        ]);
    }
}
