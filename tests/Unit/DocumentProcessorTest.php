<?php

use App\Support\DocumentProcessor;
use App\Support\DomTreeWalker;
use App\Support\StringUtil;

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

    $htmlString = /** @lang HTML */ <<<HERE
<div>
    <p> Pronunquam nunquam </p>
</div>
HERE;

    $documentProcessor = new DocumentProcessor();
    dump(
        $documentProcessor->markWords(
            $htmlString,
            $words,
        )
    );
});