<?php


namespace App\Http\Controllers;


use App\Models\Dokumen;
use Illuminate\Routing\ResponseFactory;

class DokumenHtmlController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(Dokumen $dokumen)
    {
        return $dokumen->getFirstMedia(Dokumen::COLLECTION_WORD)
            ->file_name;
    }
}