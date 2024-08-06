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
    public function eventDataStore(Request $request){
      dd(count($request->all()));
      try {
        $data = Event::with('questions','personalinfo')->where('id',$request->event_id)->first();
        foreach ($data->personalinfo as $key => $val) {
            if($val->option_types == 'input'){
               dd('per_input_'.$key);
            }else if($val->option_types == 'radio'){

            }else{

            }
        }

        foreach ($data->questions as $key => $val) {

        }
      }
      catch(\Exception $e){  
        dd($e);
       }
    }
}
