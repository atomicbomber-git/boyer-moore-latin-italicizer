<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Support\WithCustomPagination;
use App\Http\Livewire\Support\WithDestroy;
use App\Http\Livewire\Support\WithFilter;
use App\Http\Livewire\Support\WithSort;
use App\Models\User;
use App\Support\MessageState;
use App\Support\SessionHelper;
use Exception;
use Livewire\Component;

class MahasiswaIndex extends Component
{
    use WithFilter, WithCustomPagination, WithSort, WithDestroy;

    public function destroy(mixed $modelKey)
    {
        try {
            User::query()
                ->whereKey($modelKey)
                ->delete();

            $this->resetPage();

            SessionHelper::flashMessage(
                __("messages.delete.success"),
                MessageState::STATE_SUCCESS,
            );
        } catch (Exception $exception) {
            SessionHelper::flashMessage(
                $this->deleteFailureMessage($exception),
                MessageState::STATE_DANGER,
            );
        }
    }

    public function render()
    {
        return view("livewire.mahasiswa-index", [
            "mahasiswas" => User::query()
                ->orderBy("name")
                ->whereNotIn("level", [User::LEVEL_ADMIN])
                ->paginate()
        ]);
    }
}
