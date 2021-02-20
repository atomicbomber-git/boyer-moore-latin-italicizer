<div>
    <x-feature-title>
        @lang("application.word")
    </x-feature-title>

    <x-messages/>

    @if($katas->isNotEmpty())
        <div class="table-responsive">
            <x-table>
                <x-thead>
                    <tr>
                        <th> @lang("application.number_symbol") </th>
                        <th> @lang("application.content") </th>
                        <x-th-control> @lang("application.controls") </x-th-control>
                    </tr>
                </x-thead>

                <tbody>
                @foreach ($katas as $kata)
                    <tr>
                        <td> {{ $katas->firstItem() + $loop->index }} </td>
                        <td> {{ $kata->isi }} </td>
                        <x-td-control>
                            <a href="{{ route("kata.edit", $kata) }}" class="btn btn-primary btn-sm">
                                @lang("application.edit")
                            </a>

                            <button
                                    x-data="{}"
                                    x-on:click="confirmDialog().then(res => res.isConfirmed && Livewire.emit('destroy', '{{ $kata->isi }}'))"
                                    type="button"
                                    class="btn btn-danger btn-sm">
                                @lang("application.destroy")
                            </button>
                        </x-td-control>
                    </tr>
                @endforeach
                </tbody>
            </x-table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $katas->links() }}
        </div>

    @else
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            {{ __("messages.errors.no_data") }}
        </div>
    @endif
</div>
