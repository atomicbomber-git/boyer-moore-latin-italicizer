<?php

use App\Support\DomTreeWalker;
use App\Support\StringUtil;

test("Can mark words as editable", function () {
    $wordList = [
        "delenda",
        "omni",
        "est",
        "quid",
        "pro",
        "quo",
        "penatus",
        "nunquam",
    ];

    $htmlDocument = new DOMDocument();
    $htmlDocument->loadHTML(/** @lang HTML */ <<<HERE
<div>
    <p> Mary had a quid pro quo </p>
    <div>
        <p> John told penatus not to nunquam </p>
    </div>
    <div>
        <div> Omni gratia est. Carthago delenda est. </div>
    </div>
</div>
HERE);


    $replacementList = [];


    DomTreeWalker::traverse($htmlDocument, function (DOMNode $node) use ($wordList, &$replacementList) {
        if ($node->nodeType === XML_TEXT_NODE) {

            $originalText = trim($node->wholeText);
            $text = strtolower($originalText);

            if (strlen($text) === 0) return;

            $matches = [];
            foreach ($wordList as $word) {
                $matches[$word] = StringUtil::boyerMooreSearch(
                    $text,
                    $word
                );
            }

            $matches = array_filter($matches, fn ($position) => $position !== -1);
            uksort($matches, fn ($wordA, $wordB) => $matches[$wordA] - $matches[$wordB]);


            $documentFragment = $node->ownerDocument->createDocumentFragment();
            $currentTextStartIndex = 0;

            foreach ($matches as $word => $matchIndex) {
                $precedingText = substr($originalText, $currentTextStartIndex, $matchIndex - $currentTextStartIndex);

                $documentFragment->appendChild(
                    $node->ownerDocument->createTextNode($precedingText)
                );

                $markedWord = $node->ownerDocument->createElement('em');
                $markedWord->appendChild(
                    $node->ownerDocument->createTextNode(
                        substr($originalText, $matchIndex, strlen($word)),
                    )
                );
                $documentFragment->appendChild($markedWord);

                $currentTextStartIndex = $matchIndex + strlen($word);
            }

            dump($node->ownerDocument->saveHTML($documentFragment));





        }
    });

//    dump($positions);
















});