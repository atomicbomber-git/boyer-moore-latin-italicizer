<?php


namespace App\Support;


class StringUtil
{
    public static function isWordIn(string $haystack, int $begin, int $length): bool
    {
        $finish = $begin + $length - 1;

        if (
            ($begin < 0) ||
            ($finish > (strlen($haystack) - 1)) ||
            ($finish <= $begin)
        ) {
            return false;
        }

        $beginsAtBoundary = ($begin === 0) || preg_match("/[^\w]/", $haystack[$begin - 1]);
        $endsAtBoundary = ($finish === (strlen($haystack) - 1)) || preg_match("/[^\w]/", $haystack[$finish + 1]);

        return $beginsAtBoundary && $endsAtBoundary;
    }

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