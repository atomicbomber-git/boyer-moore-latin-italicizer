<?php


namespace App\Support;

use DOMDocument;
use DOMNode;

class DocumentProcessor
{
    public function __construct(
        public string $markerCssClass = "marked"
    ){}

    public function markWords(string $htmlString, array $words): string
    {
        $htmlDocument = new DOMDocument();
        $htmlDocument->loadHTML($htmlString);

        $pendingNodeReplacements = [];
        $indexCounter = 0;

        DomTreeWalker::traverse($htmlDocument, function (DOMNode $node) use ($words, &$pendingNodeReplacements, &$indexCounter) {
            if ($node->nodeType === XML_TEXT_NODE) {
                $originalText = trim($node->wholeText);
                $text = strtolower($originalText);
                if (strlen($originalText) === 0) return;

                $matches = [];
                foreach ($words as $word) {
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

                    $markedWordElement = $node->ownerDocument->createElement('span');

                    $classAttribute = $node->ownerDocument->createAttribute("class");
                    $classAttribute->value = $this->markerCssClass;

                    $idAttribute = $node->ownerDocument->createAttribute("id");
                    $idAttribute->value = sprintf("%s-%s", $this->markerCssClass, $indexCounter++);
                    dump($idAttribute->value);

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

                $pendingNodeReplacements[] = [
                    "old" => $node,
                    "new" => $documentFragment,
                ];
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