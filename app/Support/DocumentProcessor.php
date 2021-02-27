<?php


namespace App\Support;

use DOMDocument;
use DOMNode;

class DocumentProcessor
{
    public function __construct(
        public string $markerLatinUnitalicized = "marked",
        public string $markerLatinItalicized = "marked-done"
    ){}

    public function markWords(string $htmlString, array $words): string
    {
        $htmlDocument = new DOMDocument();
        $htmlDocument->loadHTML($htmlString);

        $pendingNodeReplacements = [];
        $indexCounter = 0;

        DomTreeWalker::traverse($htmlDocument, function (DOMNode $node) use ($words, &$pendingNodeReplacements, &$indexCounter) {
            if ($node->nodeType === XML_TEXT_NODE) {
                $markerClass = $node->parentNode->nodeName === "em" ?
                    $this->markerLatinItalicized :
                    $this->markerLatinUnitalicized;

                $originalText = $node->wholeText;
                $text = strtolower($originalText);
                if (strlen($originalText) === 0) return;

                $matches = [];
                foreach ($words as $word) {
                    $tempText = $text;
                    $matchPosition = StringUtil::boyerMooreSearch(
                        $tempText,
                        $word
                    );

                    $offset = 0;

                    while ($matchPosition !== -1) {
                        $matches[] = [
                            "word" => $word,
                            "index" => $offset + $matchPosition,
                        ];

                        $offset += $matchPosition + strlen($word);
                        $tempText = substr($tempText, $matchPosition + strlen($word));

                        $matchPosition = StringUtil::boyerMooreSearch(
                            $tempText,
                            $word
                        );
                    }
                }

                $matches = array_filter($matches, function ($match) use ($text) {
                    return StringUtil::isWordIn(
                        $text,
                        $match["index"],
                        strlen($match["word"])
                    );
                });

                usort($matches, fn ($matchA, $matchB) => $matchA["index"] - $matchB["index"]);
                $documentFragment = $node->ownerDocument->createDocumentFragment();
                $currentTextStartIndex = 0;

                foreach ($matches as $match) {
                    $word = $match["word"];
                    $matchIndex = $match["index"];

                    $precedingText = substr($originalText, $currentTextStartIndex, $matchIndex - $currentTextStartIndex);

                    $documentFragment->appendChild(
                        $node->ownerDocument->createTextNode($precedingText)
                    );

                    $markedWordElement = $node->ownerDocument->createElement('span');

                    $classAttribute = $node->ownerDocument->createAttribute("class");
                    $classAttribute->value = $markerClass;

                    $idAttribute = $node->ownerDocument->createAttribute("id");
                    $idAttribute->value = sprintf("%s-%s", "index", $indexCounter++);

                    $markedWordElement->appendChild($classAttribute);
                    $markedWordElement->appendChild($idAttribute);


                    $markedWordElement->appendChild(
                        $node->ownerDocument->createTextNode(
                            substr($originalText, $matchIndex, strlen($word)),
                        )
                    );

                    $documentFragment->appendChild($markedWordElement);
                    $currentTextStartIndex = $matchIndex + strlen($word);
                }

                $documentFragment->appendChild(
                    $node->ownerDocument->createTextNode(substr($originalText, $currentTextStartIndex))
                );

                if ($matches !== []) {
                    $pendingNodeReplacements[] = [
                        "old" => $node,
                        "new" => $documentFragment,
                    ];
                }
            }
        });

        foreach ($pendingNodeReplacements as $pendingNodeReplacement) {
            $pendingNodeReplacement["old"]->parentNode->replaceChild(
                $pendingNodeReplacement["new"],
                $pendingNodeReplacement["old"],
            );
        }

        return $htmlDocument->saveHTML();
    }
}