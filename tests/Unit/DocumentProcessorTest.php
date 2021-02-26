<?php

use App\Support\DocumentProcessor;

test("Can mark words as editable", function () {
    $words = [
        "di",
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
<p>maka penjajahan di atas xxx xxx xxx <strong><em>delenda</em></strong> dunia harus dihapuskan</p>
HERE;

    $documentProcessor = new DocumentProcessor();
    dump(
        $documentProcessor->markWords(
            $htmlString,
            $words,
        )
    );
});