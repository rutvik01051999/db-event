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
