<?php


namespace App\Http\Livewire\Support;


use Livewire\WithPagination;

trait WithCustomPagination
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';
}