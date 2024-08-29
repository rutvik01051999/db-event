<?php

namespace App\Http\Controllers;

use App\DataTables\UserEventReportDataTable;
use App\Exports\UserEventExport;
use App\Models\Event;
use App\Models\Option;
use App\Models\Question;
use App\Models\UserEventPersonalData;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
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

        $event = Event::find($eventId);
        $eventQuestions = $event->questions;

        $query = UserEventPersonalData::withWhereHas('events', function ($query) use ($eventId) {
            $query->where('event_id', $eventId);
        });

        $total = $query->count();

        $users = $query->offset($start)->limit($length)->get();

        $data = [];
        
        $columns[] = [
            'title' => 'Full Name', 'data' => 'full_name'
        ];

        foreach ($eventQuestions as $key => $question) {
            $columns[$key] = [
                'title' => $question->name,
                'data' => "question_$question->index_no",
            ];
        }

        foreach ($users as $k => $user) {
            $data[$k]['full_name'] = $user->full_name;
            $eventResponses = $user->events;
            foreach ($eventResponses as $eventResponse) {
                // dd($eventResponse);
                $answer = '';
                switch ($eventResponse->option_types) {
                    case 'input':
                    case 'textarea':
                    case 'date':
                    case 'rating':
                    case 'number':
                        $answer =  $eventResponse->option_val;
                        break;
                    
                    case 'checkbox':
                    case 'dropdown':
                    case 'radio':
                        $answer =  $eventResponse->option_val;
                        $answer = explode(',', $answer);
                        $answer = Option::whereIn('index_no', $answer)->pluck('name')->implode(', ');
                        break;
                    
                    case 'file':
                    case 'multiple_file':
                        $html = '';
                        $answer =  $eventResponse->option_val;
                        $answer = json_decode($answer);
                        $html = '<ul class="list-group">';
                        foreach ($answer as $key => $value) {
                            $html .= '<li class="list-group-item">'.Storage::url($value).'</li>';
                        }
                        $html .= '</ul>';
                        $answer = $html;
                        break;
                    
                        $answer =  $eventResponse->option_val;
                        break;
                    
                    default:
                        $answer =  '';
                        break;
                }

                $data[$k]["question_$eventResponse->question_index"] = $answer;
            }
        }

        // dd($data, $columns, $total);

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
                    if ($kk === 0) {
                        $data[$k]['event_id'] = $eventResponse->event_id;
                    }

                    if ($k == 0) {
                        $columns[] = $eventResponse->question->name;
                    }

                    $data[$k][] = $eventResponse->question->name;
                }
            }

            return Excel::download(new UserEventExport($data, $columns), 'event.csv');
        }
    }
}
