<?php

use App\Support\DocumentProcessor;

test("Can mark words as editable", function () {
    $words = [
        "delenda",
        "omni",
        "est",
        "quid",
        "pro",
        "quo",
        "penatus",
        "nunquam",
    ];

    $htmlString = /** @lang HTML */
        <<<HERE
<p>
Bahwa sesungguhnya <em> nunquam </em> Kemerdekaan itu ialah hak segala bangsa dan oleh sebab itu, maka penjajahan di atas <strong>delenda</strong> dunia harus dihapuskan, karena tidak sesuai dengan perikemanusiaan dan perikeadilan.
</p>
HERE;


    $documentProcessor = new DocumentProcessor();
    dump(
        $documentProcessor->markWords(
            $htmlString,
            $words,
        )
    );
});