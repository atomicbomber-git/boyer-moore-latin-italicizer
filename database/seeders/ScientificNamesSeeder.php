<?php

namespace Database\Seeders;

use App\Models\Kata;
use Doctrine\Inflector\Rules\Word;
use Illuminate\Database\Seeder;

class ScientificNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scientificNames = [];
        $fileHandle = fopen(database_path("seeders/data/speclist.txt"), "r");

        while (($line = fgets($fileHandle)) !== false) {
            $matches = [];
            preg_match("/N=(.*)/",$line, $matches);

            $scientificName = $matches[1] ?? null;

            if ($scientificName === null) {
                continue;
            }

            $beginningOfParenthesis = strpos($scientificName, "(");
            if ($beginningOfParenthesis) {
                $scientificName = substr($scientificName, 0, $beginningOfParenthesis);
            }

            $scientificNames[] = strtolower(
                trim($scientificName)
            );
        }

        fclose($fileHandle);

        $scientificNames = array_unique($scientificNames);

        $existingWordsInDict = Kata::query()->get(["isi"])->pluck("isi")->toArray();
        $intersectionList = array_intersect($scientificNames, $existingWordsInDict);

        foreach ($intersectionList as $key => $intersection) {
            unset($scientificNames[$key]);
        }

        $namesParts = [];
        foreach ($scientificNames as $scientificName) {
            $scientificName = trim($scientificName, "\t\n\r\0\x0B.");
            foreach (explode(' ', $scientificName) as $namePart) {
                $nonNumericCount = preg_match_all("/[^\p{L}]/ui", $namePart);

                if ($nonNumericCount === 0) {
                    $namesParts[] = $namePart;
                }
            }
        }

        Kata::query()->insertOrIgnore(
            array_map(fn($name) => ["isi" => $name], $namesParts)
        );
    }
}
