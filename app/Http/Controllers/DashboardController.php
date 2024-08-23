<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        return view('dashboard');
    }

    public function counts() {
        $events = Event::selectRaw('count(*) as total_events, count(case when status = 1 then 1 end) as active_events, count(case when status = 0 then 1 end) as inactive_events')->first()->toArray();
        sleep(1);
        return response()->json([
            'total_events' => $events['total_events'] ?? 0,
            'active_events' => $events['active_events'] ?? 0,
            'inactive_events' => $events['inactive_events'] ?? 0,
            'total_users' => 0
        ]);
    }
}
