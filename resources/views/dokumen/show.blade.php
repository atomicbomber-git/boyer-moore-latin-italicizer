<x-layouts.app>
    <x-feature-title>
        <a href="{{ route("dokumen.index") }}">
            @lang("application.document")
        </a>

        /

        @lang("application.show")
    </x-feature-title>

    <x-messages></x-messages>

    <div id="app">
        <document-show></document-show>
    </div>
</x-layouts.app>