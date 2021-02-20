<x-layouts.app>
    <x-feature-title>
        <a href="{{ route("kata.index") }}">
            @lang("application.word")
        </a>

        /

        @lang("application.edit")
    </x-feature-title>

    <x-messages></x-messages>

    <div class="card {{ $errors->isNotEmpty() ? 'border-danger' : '' }}">
        <div class="card-body">
            <form
                    id="form"
                    action="{{ route("kata.update", $kata->isi) }}"
                    method="POST"
            >
                @csrf
                @method("PATCH")

                <div class="mb-3">
                    <label for="isi"
                           class="form-label"
                    > @lang("application.content") </label>
                    <input
                            id="isi"
                            type="text"
                            placeholder="@lang("application.content")"
                            class="form-control @error("isi") is-invalid @enderror"
                            name="isi"
                            value="{{ old("isi", $kata->isi) }}"
                    />
                    @error("isi")
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </form>

        </div>
        <div class="card-footer d-flex justify-content-end">
            <button class="btn btn-primary" form="form">
                @lang("application.update")
            </button>
        </div>
    </div>
</x-layouts.app>