<?php

namespace App\Http\Livewire;

use App\Models\Kata;
use App\Support\MessageState;
use App\Support\SessionHelper;
use Livewire\Component;
use Livewire\WithPagination;

class KataIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        "destroy" => "destroy"
    ];

    public function destroy(string $isi)
    {
        try {
            SessionHelper::flashMessage(
                __("messages.delete.success"),
                MessageState::STATE_SUCCESS,
            );

            Kata::query()
                ->whereKey($isi)
                ->delete();

        } catch (\Throwable $throwable) {
            SessionHelper::flashMessage(
                __("messages.delete.failure"),
                MessageState::STATE_DANGER,
            );
        }
    }

    public function render()
    {
        return view('livewire.kata-index', [
            "katas" => Kata::query()
                ->select("isi")
                ->paginate()
        ]);
    }
}
