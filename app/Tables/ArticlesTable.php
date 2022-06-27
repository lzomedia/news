<?php

namespace App\Tables;

use App\Models\Article;

use Yajra\DataTables\Services\DataTable;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Contracts\Database\Query\Builder;

class ArticlesTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function (Article $article) {
                return  '<a href="'.route('video.generate', $article->id).'" class="btn btn-xs btn-primary"> Generate</a>';
            });
    }

    public function query(Article $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return HtmlBuilder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('articles-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
            );
    }


    protected function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('title'),
            Column::computed('action')
        ];
    }
}
