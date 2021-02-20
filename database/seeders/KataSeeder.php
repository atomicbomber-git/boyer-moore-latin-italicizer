<?php

namespace Database\Seeders;

use App\Models\Kata;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KataSeeder extends Seeder
{
    const FILENAME = "most-common-latin-words.txt";

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dictionary = [];

        $fileHandle = fopen(database_path("seeders/data/" . self::FILENAME), "r");

        while (($line = fgets($fileHandle)) !== false) {
            [$word, $frequency] = explode("\t", $line);
            $dictionary[strtolower(trim($word))] = trim($frequency);
        }

        fclose($fileHandle);

        $this->command->info(sprintf(
            "Menemukan %d kata dalam file %s.",
            count($dictionary),
            self::FILENAME,
        ));

        $words = collect(array_keys($dictionary))
            ->unique(function ($word) {
                return preg_replace("/[^\w]/", '', $word);
            })->filter(function ($word) {
                return strlen(
                    preg_replace("/[^\w]/", '', $word)
                ) > 0;
            })->toArray();


        $this->command->info(sprintf(
            "Dari ke %d kata tersebut, terdapat %d kata unik.",
            count($dictionary),
            count($words),
        ));

        DB::beginTransaction();
        Kata::query()->delete();
        Kata::query()->insert(array_map(fn($word) => ["isi" => $word], $words));
        DB::commit();
    }
}
