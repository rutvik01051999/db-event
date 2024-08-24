<?php

namespace App\DataTables;

use App\Models\Event;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EventDataTable extends BaseDataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('url', function ($event) {
                $url = $event->event_url;
                $parseUrl = parse_url($url);
                $path = $parseUrl['path'] ?? '';
                $id = str_replace(['/', '.php'], ['', ''], $path);

                return '<a class="text-decoration-none" href="' . route('user.event.form', ['id' => $id]) . '" target="_blank">' . route('user.event.form', ['id' => $id]) . '</a>';
            })
            ->addColumn('action', function ($event) {
                return view('admin.adminpanel.event.action', compact('event'));
            })
            ->editColumn('status', function ($event) {
                return '<span class="badge badge-' . ($event->status == 1 ? 'success' : 'danger') . '">' . ($event->status == 1 ? 'Active' : 'Inactive') . '</span>';
            })
            ->addColumn('category', function ($event) {
                return optional($event->category)->name ?? 'N/A';
            })
            ->addColumn('department', function ($event) {
                return optional($event->department)->name ?? 'N/A';
            })
            ->setRowId('id')
            ->rawColumns(['url', 'action', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Event $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('event-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters($this->parameters)
            //->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle()
            ->buttons([]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->visible(false)->searchable(false),
            Column::make('name'),
            Column::make('url')->sortable(false)->searchable(false),
            Column::make('start_date'),
            Column::make('close_date'),
            Column::make('status')->addClass('text-center'),
            Column::make('category')->addClass('text-center'),
            Column::make('department')->addClass('text-center'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Event_' . date('YmdHis');
    }
}
