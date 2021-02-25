<?php


namespace App\Http\Controllers;


use App\Models\Dokumen;
use Illuminate\Routing\ResponseFactory;

class DokumenRevisiController
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(Dokumen $dokumen)
    {
    }
}