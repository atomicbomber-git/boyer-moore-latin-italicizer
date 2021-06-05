<x-layouts.app>
    <x-feature-title>
        <a href="{{ route("mahasiswa.index") }}">
            @lang("application.mahasiswa")
        </a>

        /

        @lang("application.edit")
    </x-feature-title>

    <x-messages></x-messages>

    <div class="card {{ $errors->isNotEmpty() ? 'border-danger' : '' }}">
        <div class="card-body">
            <form
                    id="form"
                    action="{{ route("mahasiswa.update", $mahasiswa) }}"
                    method="POST"
            >
                @csrf
                @method("PATCH")

                <div class="mb-3">
                    <label for="name"> @lang("application.name") </label>
                    <input
                            id="name"
                            type="text"
                            placeholder="@lang("application.name")"
                            class="form-control @error("name") is-invalid @enderror"
                            name="name"
                            value="{{ old("name", $mahasiswa->name) }}"
                    />
                    @error("name")
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="username"> @lang("application.username") </label>
                    <input
                            id="username"
                            type="text"
                            placeholder="@lang("application.username")"
                            class="form-control @error("username") is-invalid @enderror"
                            name="username"
                            value="{{ old("username", $mahasiswa->username) }}"
                    />
                    @error("username")
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="alert alert-warning">
                    Kosongkan kolom di bawah jika Anda tidak ingin mengubah password.
                </div>

                <div class="mb-3">
                    <label for="password"> @lang("application.password") </label>
                    <input
                            id="password"
                            type="password"
                            placeholder="@lang("application.password")"
                            class="form-control @error("password") is-invalid @enderror"
                            name="password"
                            value="{{ old("password") }}"
                    />
                    @error("password")
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </form>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <button class="btn btn-primary" form="form">
                @lang("application.edit")
            </button>
        </div>
    </div>
</x-layouts.app>