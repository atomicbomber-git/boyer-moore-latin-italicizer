<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\MessageState;
use App\Support\SessionHelper;
use Hash;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class MahasiswaController extends Controller
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->middleware("auth");
        $this->responseFactory = $responseFactory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->responseFactory->view("mahasiswa.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->responseFactory->view("mahasiswa.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => ["required", "string"],
            "username" => ["required", "string", Rule::unique(User::class)],
            "password" => ["required", Password::min(8)],
        ]);

        User::create([
            "name" => $data["name"],
            "username" => $data["username"],
            "level" => User::LEVEL_MAHASISWA,
            "password" => Hash::make("password"),
        ]);

        SessionHelper::flashMessage(
            __("messages.create.success"),
            MessageState::STATE_SUCCESS,
        );

        return $this->responseFactory->redirectToRoute("mahasiswa.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(User $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(User $mahasiswa)
    {
        return $this->responseFactory->view("mahasiswa.edit", [
            "mahasiswa" => $mahasiswa,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $mahasiswa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $mahasiswa): RedirectResponse
    {
        $data = $request->validate([
            "name" => ["required", "string"],
            "username" => ["required", "string", Rule::unique(User::class)->ignore($mahasiswa)],
            "password" => ["nullable", Password::min(8)],
        ]);

        if (isset($data["password"])) {
            $data["password"] = Hash::make($data["password"]);
        } else {
            unset($data["password"]);
        }

        $mahasiswa->forceFill($data)->save();

        SessionHelper::flashMessage(
            __("messages.update.success"),
            MessageState::STATE_SUCCESS,
        );

        return $this->responseFactory->redirectToRoute("mahasiswa.edit", $mahasiswa->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $mahasiswa)
    {
        //
    }
}
