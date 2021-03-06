<?php

namespace App\Tables;

use App\Models\Feed;
use Yajra\DataTables\Services\DataTable;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Contracts\Database\Query\Builder;

class FeedsTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function (Feed $feed) {
                return  '<a href="'.route('feeds.sync-single', $feed->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-clock"></i> Sync</a>';
            });
    }


    public function query(Feed $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('feeds-table')
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
