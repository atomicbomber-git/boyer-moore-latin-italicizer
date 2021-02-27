<?php


namespace App\Http\Controllers;


use App\Models\Dokumen;
use App\Support\FileConverter;
use App\Support\MessageState;
use App\Support\SessionHelper;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Str;

class DokumenRevisiController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(Request $request, Dokumen $dokumen)
    {
        $data = $request->validate([
            "corrections" => ["required", "array"],
            "corrections.*.id" => ["required", "string"],
            "corrections.*.applies" => ["required", "boolean"],
        ]);

        $htmlFile = file_get_contents(
            $dokumen->getFirstMediaPath(Dokumen::COLLECTION_HTML)
        );

        $htmlDomDocument = new \DOMDocument();
        $htmlDomDocument->loadHTML($htmlFile);

        foreach ($data["corrections"] as $correction) {
            $node = $htmlDomDocument->getElementById($correction["id"]);

            if ($correction["applies"]) {
                if ($node->parentNode?->nodeName !== "em") {
                    $node->setAttribute("class", "marked-done");
                    $emNode = $node->ownerDocument->createElement("em");
                    $node->parentNode->replaceChild($emNode, $node);
                    $emNode->appendChild($node);
                }
            } else {
                if ($node->parentNode->nodeName === "em") {
                    $node->setAttribute("class", "marked");

                    $previousSiblings = [];
                    $tempNode = $node->previousSibling;
                    while ($tempNode !== null) {
                        $previousSiblings[] = $tempNode;
                        $tempNode = $tempNode->previousSibling;
                    }
                    $previousSiblings = array_reverse($previousSiblings);
                    $previousSiblings = array_filter($previousSiblings, fn($previousSibling) => $previousSibling->textContent !== "");

                    $nextSiblings = [];
                    $tempNode = $node->nextSibling;
                    while ($tempNode !== null) {
                        $nextSiblings[] = $tempNode;
                        $tempNode = $tempNode->nextSibling;
                    }
                    $nextSiblings = array_filter($nextSiblings, fn($nextSibling) => $nextSibling->textContent !== "" );

                    $replacementPrecedingEmNode = $node->ownerDocument->createElement("em");
                    foreach ($previousSiblings as $previousSibling) {
                        $replacementPrecedingEmNode->appendChild($previousSibling);
                    }

                    $replacementFollowingEmNode = $node->ownerDocument->createElement("em");
                    foreach ($nextSiblings as $nextSibling) {
                        $replacementFollowingEmNode->appendChild($nextSibling);
                    }

                    $oldParent = $node->parentNode;
                    $oldGrandparent = $node->parentNode->parentNode;

                    $documentFragment = $node->ownerDocument->createDocumentFragment();
                    $documentFragment->appendChild($replacementPrecedingEmNode);
                    $documentFragment->appendChild($node);
                    $documentFragment->appendChild($replacementFollowingEmNode);


                    $oldGrandparent->replaceChild(
                        $documentFragment,
                        $oldParent,
                    );
                }
            }
        }

        $oldWordMedia = $dokumen->getFirstMedia(Dokumen::COLLECTION_WORD);

        dump($htmlDomDocument->saveHTML());

        $dokumen->addMediaFromString(
            $htmlDomDocument->saveHTML(),
        )->usingFileName(
            $oldWordMedia->name  . ".html"
        )->toMediaCollection(Dokumen::COLLECTION_HTML);

        $dokumen->addMediaFromString(
            FileConverter::HTMLToWord(
                $htmlDomDocument->saveHTML()
            )
        )->usingFileName(
            $oldWordMedia->file_name
        )->toMediaCollection(Dokumen::COLLECTION_WORD);

        SessionHelper::flashMessage(
            __("messages.update.success"),
            MessageState::STATE_SUCCESS,
        );
    }
}