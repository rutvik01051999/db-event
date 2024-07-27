<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class UserEventHandlingController extends Controller
{
    public function index($id){
        try {
          $data = Event::with('questions','personalinfo')->where('event_url',env('APP_URL') . '/' . $id)->first();
          return view('user.event.form', compact('data'));
        }
        catch(\Exception $e){  
          dd($e);
         }
    }
}
