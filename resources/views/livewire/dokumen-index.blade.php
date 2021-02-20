<div>
    <x-feature-title>
        @lang("application.document")
    </x-feature-title>

    <x-messages/>

    <div class="card">
        <div class="card-body">
            <div class="my-3 d-flex justify-content-end">
                <a href="{{ route("dokumen.create") }}" class="btn btn-primary">
                    @lang("application.create")
                </a>
            </div>

            @if($dokumens->isNotEmpty())
                <x-table>
                    <x-thead>
                        <tr>
                            <th> @lang("application.number_symbol") </th>
                            <th> @lang("application.content") </th>
                            <x-th-control> @lang("application.controls") </x-th-control>
                        </tr>
                    </x-thead>

                    <tbody>
                    @foreach ($dokumens as $dokumen)
                        <tr>
                            <td> {{ $dokumens->firstItem() + $loop->index }} </td>
                            <td> {{ $dokumen->nama }} </td>
                            <x-td-control>
                                <a href="{{ route("dokumen.edit", $dokumen) }}" class="btn btn-primary btn-sm">
                                    @lang("application.edit")
                                </a>

                                <button
                                        x-data="{}"
                                        x-on:click="confirmDialog().then(res => res.isConfirmed && Livewire.emit('destroy', '{{ $dokumen->id }}'))"
                                        type="button"
                                        class="btn btn-danger btn-sm">
                                    @lang("application.destroy")
                                </button>
                            </x-td-control>
                        </tr>
                    @endforeach
                    </tbody>
                </x-table>

                <div class="d-flex justify-content-center">
                    {{ $dokumens->links() }}
                </div>

            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ __("messages.errors.no_data") }}
                </div>
            @endif
        </div>
    </div>
</div>
