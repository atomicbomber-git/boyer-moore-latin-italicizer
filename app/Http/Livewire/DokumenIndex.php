<?php

namespace App\Http\Livewire;

use App\Models\Dokumen;
use Livewire\Component;

class DokumenIndex extends Component
{
    public function render()
    {
        return view('livewire.dokumen-index', [
            "dokumens" => Dokumen::query()
                ->paginate()
        ]);
    }
}
