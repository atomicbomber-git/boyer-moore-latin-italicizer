<?php


namespace App\Http\Controllers;


use App\Models\Dokumen;
use App\Models\Kata;
use App\Support\DocumentProcessor;
use App\Support\FileConverter;
use App\Support\MessageState;
use App\Support\SessionHelper;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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

    public function create()
    {
        return $this->responseFactory->view("dokumen.create");
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "nama" => ["required", "string", Rule::unique(Dokumen::class)],
            "document" => ["required", "file", "mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document"],
        ], [
            "document.mimetypes" => "Berkas harus dalam format .docx",
        ]);

        DB::beginTransaction();

        /** @var Dokumen $dokumen */
        $dokumen = Dokumen::query()->create([
            "nama" => $data["nama"],
        ]);

        $dokumen
            ->addMediaFromString(
                (new DocumentProcessor)->markWords(
                    FileConverter::wordToHTML($request->file("document")->getRealPath()),
                    Kata::query()->get(["isi"])->pluck("isi")->toArray(),
                )
            )
            ->usingFileName(Str::snake($dokumen->nama) . ".html")
            ->toMediaCollection(Dokumen::COLLECTION_HTML);

        $dokumen
            ->addMediaFromRequest("document")
            ->toMediaCollection(Dokumen::COLLECTION_WORD);

        DB::commit();

        SessionHelper::flashMessage(
            __("messages.create.success"),
            MessageState::STATE_SUCCESS,
        );

        return $this->responseFactory->redirectToRoute("dokumen.index");
    }

    public function edit(Dokumen $dokumen)
    {
        return $this->responseFactory->view("dokumen.edit", [
            "dokumen" => $dokumen,
        ]);
    }

    public function update(Request $request, Dokumen $dokumen)
    {
        $data = $request->validate([
            "nama" => ["required", "string", Rule::unique(Dokumen::class)->ignoreModel($dokumen)],
            "document" => ["required", "file", "mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document"],
        ], [
            "document.mimetypes" => "Berkas harus dalam format .docx",
        ]);

        DB::beginTransaction();

        $dokumen
            ->addMediaFromString(
                (new DocumentProcessor)->markWords(
                    FileConverter::wordToHTML($request->file("document")->getRealPath()),
                    Kata::query()->get(["isi"])->pluck("isi")->toArray(),
                )
            )
            ->usingFileName(Str::snake($dokumen->nama) . ".html")
            ->toMediaCollection(Dokumen::COLLECTION_HTML);

        $dokumen
            ->addMediaFromRequest("document")
            ->toMediaCollection(Dokumen::COLLECTION_WORD);


        $dokumen->update([
            "nama" => $data["nama"],
        ]);

        DB::commit();

        SessionHelper::flashMessage(
            __("messages.update.success"),
            MessageState::STATE_SUCCESS,
        );

        return $this->responseFactory->redirectToRoute("dokumen.edit", $dokumen);
    }

    public function show(Dokumen $dokumen)
    {
        return $this->responseFactory->view("dokumen.show", [
            "dokumen" => $dokumen,
        ]);
    }
}