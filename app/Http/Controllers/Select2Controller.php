<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Select2Controller extends Controller
{
    public function events(Request $request)
    {
        $search = $request->q;
        $showAll = $request->show_all;
        $departmentId = $request->department_id;

        if (is_null($departmentId) || $departmentId == 0 || $departmentId == '') {
            return response()->json([]);
        }

        $events = Event::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->when($showAll == 0, function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })
            ->select(DB::raw('name as text'), 'id')
            ->latest()
            ->get();

        return response()->json([
            'events' => $events,
        ]);
    }

    public function departments(Request $request)
    {
        $search = $request->q;
        $showAll = $request->show_all;
        $user = Auth::user();
        $userDepartments = $user->departments->pluck('id')->toArray();

        $departments = Department::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->when($showAll == 0, function ($query) use ($userDepartments) {
                $query->whereIn('id', $userDepartments);
            })
            ->select(DB::raw('name as text'), 'id')
            ->latest()
            ->get();

        return response()->json([
            'departments' => $departments,
        ]);
    }
}
