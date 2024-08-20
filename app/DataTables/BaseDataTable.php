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
        'initComplete' => 'function(settings, json) {$(this).removeClass("table-striped");}',
        'select' => [
            'style' => 'multi',
            'selector' => 'td:first-child',
            'info' => false
        ],
        // Disable action buttons if no record available
        'drawCallback' => 'function(settings) {
            var rowsData = this.api().rows({ filter: "applied" }).data();
            var hasRows = rowsData.length > 0;
            var buttonsCsv = $(".buttons-csv");
            var buttonsExcel = $(".buttons-excel");
            var buttonsPdf = $(".buttons-pdf");
            var buttonsPrint = $(".buttons-print");

            if (hasRows) {
                buttonsCsv.removeClass("disabled");
                buttonsExcel.removeClass("disabled");
                buttonsPdf.removeClass("disabled");
                buttonsPrint.removeClass("disabled");
            } else {
                buttonsCsv.addClass("disabled");
                buttonsExcel.addClass("disabled");
                buttonsPdf.addClass("disabled");
                buttonsPrint.addClass("disabled");
            }
        }',
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
