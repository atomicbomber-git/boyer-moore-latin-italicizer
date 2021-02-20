<x-layouts.app>
    <x-feature-title>
        <a href="{{ route("dokumen.index") }}">
            @lang("application.document")
        </a>

        /

        @lang("application.create")
    </x-feature-title>

    <x-messages></x-messages>

    <div class="card {{ $errors->isNotEmpty() ? 'border-danger' : '' }}">
        <div class="card-body">
            <form
                    enctype="multipart/form-data"
                    id="form"
                    action="{{ route("dokumen.store") }}"
                    method="POST"
            >
                @csrf
                @method("POST")

                <div class="mb-3">
                    <label for="nama"
                           class="form-label"
                    > @lang("application.name") </label>
                    <input
                            id="nama"
                            type="text"
                            placeholder="@lang("application.name")"
                            class="form-control @error("nama") is-invalid @enderror"
                            name="nama"
                            value="{{ old("nama") }}"
                    />
                    @error("nama")
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="document"
                           class="form-label"
                    >
                        @lang("application.document")
                    </label>

                    <input
                            name="document"
                            class="form-control @error("document") is-invalid @enderror"
                            type="file"
                            id="document"
                    >
                    @error("document")
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </form>

        </div>
        <div class="card-footer d-flex justify-content-end">
            <button class="btn btn-primary"
                    form="form"
            >
                @lang("application.create")
            </button>
        </div>
    </div>
</x-layouts.app>