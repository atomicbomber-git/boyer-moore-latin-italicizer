<?php


namespace App\Http\Controllers;


use Illuminate\Routing\ResponseFactory;

class DokumenController extends Controller
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->middleware("auth");
        $this->responseFactory = $responseFactory;
    }

    public function index()
    {
        return $this->responseFactory->view("dokumen.index");
    }
}