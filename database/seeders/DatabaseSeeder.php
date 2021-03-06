<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminUserSeeder::class);
        $this->call(MahasiswaUserSeeder::class);
        $this->call(KataSeeder::class);
        $this->call(ScientificNamesSeeder::class);
    }
}
