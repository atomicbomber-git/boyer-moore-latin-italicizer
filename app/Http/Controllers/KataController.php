<?php

namespace App\Http\Controllers;

use App\Models\Kata;
use App\Support\MessageState;
use App\Support\SessionHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Validation\Rule;

class KataController extends Controller
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->middleware("auth");
        $this->responseFactory = $responseFactory;
    }

    public function index()
    {
        return $this->responseFactory->view("kata.index");
    }

    public function create()
    {
        return $this->responseFactory->view("kata.create");
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "isi" => ["string", "not_regex:/[^\w ]/", Rule::unique(Kata::class)]
        ], [
            "isi.not_regex" => __("application.word_content_not_regex")
        ]);

        Kata::query()->create($data);

        SessionHelper::flashMessage(
            __("messages.create.success"),
            MessageState::STATE_SUCCESS,
        );

        return $this->responseFactory->redirectToRoute("kata.index");
    }
    
    public function edit(Kata $kata): Response
    {
        return $this->responseFactory->view("kata.edit", [
            "kata" => $kata,
        ]);
    }

    public function update(Request $request, Kata $kata)
    {
        $data = $request->validate([
            "isi" => ["string", "not_regex:/[^\w ]/", Rule::unique(Kata::class)->ignoreModel($kata)]
        ], [
            "isi.not_regex" => __("application.word_content_not_regex")
        ]);

        $kata->update($data);

        SessionHelper::flashMessage(
            __("messages.update.success"),
            MessageState::STATE_SUCCESS,
        );

        return $this->responseFactory->redirectToRoute("kata.edit", $kata);
    }
}
