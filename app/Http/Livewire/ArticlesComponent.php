<?php
namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\Author;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Zofe\Rapyd\Http\Livewire\AbstractDataTable;

class ArticlesComponent extends AbstractDataTable
{
    public $search;
    public $sortField = 'id';

    public $perPage = 50;

    public function getDataSet(): \Illuminate\Database\Eloquent\Builder|\Illuminate\Support\Collection
    {
        return Article::with('feed', 'category')->where('title', 'like', '%'.$this->search.'%');
    }

    public function render(): View|Factory|string|Application
    {
        $items = $this->getDataSet()->orderBy(
            $this->sortField, $this->sortAsc ? 'asc' : 'desc'
        )->paginate($this->perPage);

        return view('dashboard.articles.index', compact('items'))->slot('table');
    }
}
