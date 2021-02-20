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
        $this->responseFactory = $responseFactory;
    }

    public function index()
    {
        return $this->responseFactory->view("kata.index");
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
            "isi" => ["string", "not_regex:/[^\w]/", Rule::unique(Kata::class)->ignoreModel($kata)]
        ], [
            "isi.not_regex" => "Format isi hanya boleh mengandung huruf"
        ]);

        $kata->update($data);

        SessionHelper::flashMessage(
            __("messages.update.success"),
            MessageState::STATE_SUCCESS,
        );

        return $this->responseFactory->redirectToRoute("kata.edit", $kata);
    }
}
