<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\MahasiswaFactory;
use Illuminate\Database\Seeder;

class MahasiswaUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MahasiswaFactory::new()
            ->count(100)
            ->create([
                "level" => User::LEVEL_MAHASISWA,
            ]);
    }
}
