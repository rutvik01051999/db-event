<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\UserEventPersonalData;

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
        $users = UserEventPersonalData::selectRaw('count(*) as total_users')->first()->toArray();
        return response()->json([
            'total_events' => $events['total_events'] ?? 0,
            'active_events' => $events['active_events'] ?? 0,
            'inactive_events' => $events['inactive_events'] ?? 0,
            'total_users' => $users['total_users'] ?? 0
        ]);
    }
}
