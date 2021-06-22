<nav class="nav col-md-2 flex-column">
    <div class="h4 fw-bolder">
        @lang("application.menu")
    </div>

    @can(\App\Providers\AuthServiceProvider::CAN_ACT_AS_ADMIN)
        <a class="text-dark nav-link {{ \Illuminate\Support\Facades\Route::is("mahasiswa.*") ? "active fw-bold" : "" }}"
           aria-current="page"
           href="{{ route("mahasiswa.index") }}"
        >
            @lang("application.mahasiswa")
        </a>

        <a class="text-dark nav-link {{ \Illuminate\Support\Facades\Route::is("kata.*") ? "active fw-bold" : "" }}"
           aria-current="page"
           href="{{ route("kata.index") }}"
        >
            @lang("application.word")
        </a>
    @endcan

    @canany([
        \App\Providers\AuthServiceProvider::CAN_ACT_AS_MAHASISWA,
    ])
        <a class="text-dark nav-link {{ \Illuminate\Support\Facades\Route::is("dokumen.*") ? "active fw-bold" : "" }}"
           aria-current="page"
           href="{{ route("dokumen.index") }}"
        >
            @lang("application.document")
        </a>
    @endcanany
</nav>