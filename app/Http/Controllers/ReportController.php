<?php

namespace App\Http\Controllers;

use App\DataTables\UserEventReportDataTable;
use App\Exports\UserEventExport;
use App\Models\Question;
use App\Models\UserEventPersonalData;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function eventReport()
    {
        return view('report.event');
    }

    public function fetch(Request $request)
    {
        $eventId = $request->get('event_id');
        $start = $request->get('start') ?? 0;
        $length = $request->get('length') ?? 10;

        $query = UserEventPersonalData::withWhereHas('events', function ($query) use ($eventId) {
            $query->where('event_id', $eventId);
        });

        $total = $query->count();

        $users = $query->offset($start)->limit($length)->get();

        $columns = [];
        $data = [];

        foreach ($users as $k => $user) {
            if ($k === 0) {
                $columns[] = ['title' => 'Full Name', 'data' => 'full_name'];
                $columns[] = ['title' => 'Event ID', 'data' => 'event_id'];
            }

            $data[$k] = ['full_name' => $user->full_name];

            $eventResponses = $user->events;

            foreach ($eventResponses as $kk => $eventResponse) {
                if ($eventResponse->option_types == 'input') {
                    if ($kk === 0) {
                        $data[$k]['event_id'] = $eventResponse->event_id;
                    }

                    if ($k == 0) {
                        $columns[] = [
                            'title' => $eventResponse->option_val,
                            'data' => "question_$eventResponse->question_index",
                        ];
                    }

                    $data[$k]["question_$eventResponse->question_index"] = $eventResponse->option_val;
                }
            }
        }

        return response()->json([
            'draw' => intval($request->get('draw')), // DataTables draw parameter
            'recordsTotal' => $total, // Total records before filtering
            'recordsFiltered' => $total, // Total records after filtering
            'data' => $data, // Data for the current page
            'columns' => $columns,
        ]);
    }

    public function export(Request $request)
    {
        $eventId = $request->get('event_id');
        $type = $request->get('type');

        if ($type == 'csv') {
            $users = UserEventPersonalData::withWhereHas('events', function ($query) use ($eventId) {
                $query->where('event_id', $eventId);
            })->get();

            $columns = [];
            $data = [];

            foreach ($users as $k => $user) {
                if ($k === 0) {
                    $columns[] = 'Full Name';
                    $columns[] = 'Event ID';
                }

                $data[$k] = [$user->full_name];

                $eventResponses = $user->events;

                foreach ($eventResponses as $kk => $eventResponse) {
                    if ($eventResponse->option_types == 'input') {
                        if ($kk === 0) {
                            $data[$k]['event_id'] = $eventResponse->event_id;
                        }

                        if ($k == 0) {
                            $columns[] = $eventResponse->option_val;
                        }

                        $data[$k][] = $eventResponse->option_val;
                    }
                }
            }

            return Excel::download(new UserEventExport($data, $columns), 'event.csv');
        }
    }
}
