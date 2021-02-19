<x-layouts.app>
    <div class="card {{ $errors->isNotEmpty() ? "border-danger" : "" }}"
         style="max-width: 480px; margin: auto"
    >
        <h1 class="h3 card-header">

            @lang("application.log_in")
        </h1>

        <div class="card-body">
            <form
                    id="login-form"
                    action="{{ route("login") }}"
                    method="POST"
            >
                @csrf
                @method("POST")

                <div class="mb-3">
                    <label for="username" class="form-label"> @lang("application.username") </label>
                    <input
                            id="username"
                            type="text"
                            placeholder="@lang("application.username")"
                            class="form-control @error("username") is-invalid @enderror"
                            name="username"
                            value="{{ old("username") }}"
                    />
                    @error("username")
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label"> @lang("application.password") </label>
                    <input
                            id="password"
                            type="text"
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
            <button type="submit" class="btn btn-primary" form="login-form">
                @lang("application.log_in")
            </button>
        </div>
    </div>
</x-layouts.app>