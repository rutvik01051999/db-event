<?php

namespace App\DataTables;

use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Contracts\Support\Renderable;

class BaseDataTable extends DataTable
{
    /**
     * @var array
     */
    protected array $parameters = [
        'dom' => '<"row"<"col-12"B>><"row mt-3"<"col-md-6"l><"col-md-6"f>>r<"col-12 table-responsive"t><"row"<"col-md-6"i><"col-md-6"p>>',        
    ];

    /**
     * Display printable view of datatables.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function printPreview(): Renderable
    {
        $data = $this->getDataForPrint();
        $pageTitle = $this->pageTitle ?? '';
        $wantPrint = request()->get('action') === 'print' ? true : false;

        return view($this->printPreview, compact('data', 'pageTitle', 'wantPrint'));
    }
}
