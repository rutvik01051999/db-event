<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Select2Controller extends Controller
{
    public function events(Request $request) {
        $search = $request->q;
        
        $events = Event ::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%');
        })->select(DB::raw('name as text'), 'id')->latest()->get();
        
        return response()->json([
            'events' => $events
        ]);
    }
}
