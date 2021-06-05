<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Support\WithCustomPagination;
use App\Http\Livewire\Support\WithDestroy;
use App\Http\Livewire\Support\WithFilter;
use App\Http\Livewire\Support\WithSort;
use App\Models\Kata;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class KataIndex extends Component
{
    use WithFilter, WithCustomPagination, WithSort, WithDestroy;

    public function render(): Factory|View|Application
    {
        return view('livewire.kata-index', [
            "katas" => Kata::query()
                ->when($this->filter, function (Builder $builder, string $filter) {
                    $builder->where("isi", "LIKE", "%{$filter}%");
                })
                ->select("isi")
                ->paginate()
        ]);
    }
}
