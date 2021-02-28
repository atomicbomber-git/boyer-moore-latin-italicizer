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
<em></em>
HERE;

        $domDocument = new DOMDocument();
        $domDocument->loadHTML($htmlString);

        $selectedChild = ($domDocument->getElementsByTagName("body")->item(0))->childNodes->item(0);

        dump($selectedChild->textContent === "");
});