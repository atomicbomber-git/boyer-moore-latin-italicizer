<?php

namespace App\Http\Livewire;

use App\Models\Dokumen;
use App\Support\MessageState;
use App\Support\SessionHelper;
use Livewire\Component;

class DokumenIndex extends Component
{
    protected $listeners = [
        "destroy" => "destroy",
    ];

    public function destroy(int $dokumenId)
    {
        try {
            Dokumen::query()
                ->whereKey($dokumenId)
                ->delete();

            SessionHelper::flashMessage(
                __("messages.delete.success"),
                MessageState::STATE_SUCCESS,
            );
        } catch (\Throwable $throwable) {
            SessionHelper::flashMessage(
                __("messages.delete.failure"),
                MessageState::STATE_DANGER,
            );
        }
    }

    public function render()
    {
        return view('livewire.dokumen-index', [
            "dokumens" => Dokumen::query()
                ->paginate()
        ]);
    }
}
