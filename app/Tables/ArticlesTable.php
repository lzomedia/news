<?php

namespace App\Tables;


use App\Models\Article;

use Yajra\DataTables\DataTables;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\QueryDataTable;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class ArticlesTable extends DataTables
{

    /**
     * @throws Exception
     */
    public function dataTable($query): EloquentDataTable
    {
        return datatables()->eloquent($query);
    }

    /**
     * @throws Exception
     */
    public function query(Article|Builder $builder): QueryDataTable
    {
        return $builder->newQuery();
    }


    public function html()
    {
        return $this->builder()
            ->setTableId('users-table')
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
            Column::computed('action')
                ->width(60)
                ->addClass('text-center'),
            Column::make('id'),
            Column::make('title'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

}
