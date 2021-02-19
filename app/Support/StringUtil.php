<?php


namespace App\Support;


class StringUtil
{
    public static function boyerMooreSearch(string $text, string $pattern): int {
        $patlen = strlen($pattern);
        $textlen = strlen($text);
        $table = self::boyerMooreCharTable($pattern);

        for ($i=$patlen-1; $i < $textlen;) {
            $t = $i;
            for ($j=$patlen-1; $pattern[$j]==$text[$i]; $j--,$i--) {
                if($j == 0) return $i;
            }
            $i = $t;
            if(array_key_exists($text[$i], $table))
                $i = $i + max($table[$text[$i]], 1);
            else
                $i += $patlen;
        }
        return -1;
    }

    public static function boyerMooreCharTable(string $string): array
    {
        $len = strlen($string);
        $table = array();
        for ($i=0; $i < $len; $i++) {
            $table[$string[$i]] = $len - $i - 1;
        }
        return $table;
    }
}