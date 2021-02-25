<?php


namespace App\Http\Controllers;


use App\Models\Dokumen;
use Illuminate\Routing\ResponseFactory;

class DokumenDataController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(Dokumen $dokumen)
    {
        return $this->responseFactory->json([
            "nama" => $dokumen->nama,
            "html" => file_get_contents(
                $dokumen->getFirstMediaPath(Dokumen::COLLECTION_HTML)
            )
        ]);
    }
}