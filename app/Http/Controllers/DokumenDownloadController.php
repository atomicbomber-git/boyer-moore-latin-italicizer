<?php


namespace App\Http\Controllers;


use App\Models\Dokumen;
use Illuminate\Routing\ResponseFactory;

class DokumenDownloadController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(Dokumen $dokumen)
    {
        return $this->responseFactory->download(
            $dokumen->getFirstMediaPath(Dokumen::COLLECTION_WORD)
        );
    }
}