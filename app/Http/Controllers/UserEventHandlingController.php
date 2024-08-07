<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\UserEventData;

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
      // dd(count($request->all()));
      try {
        $data = Event::with('questions','personalinfo')->where('id',$request->event_id)->first();
        foreach ($data->personalinfo as $key => $val) {

            if($val->option_types == 'input'){
              //  dd('per_input_'.$key,$request['event_id']);
               if(isset($request['per_input_'.$val->index_no])){
                  UserEventData::create([
                     'event_id'=>$request->event_id,
                     'personal_index'=>$val->index_no,
                     'option_val'=>$request['per_input_'.$val->index_no],
                     'option_types'=>'input'
                  ]);
               }else{

               }
            }else if($val->option_types == 'checkbox'){

            }else{

            }
        }

        foreach ($data->questions as $key => $val) {
          if($val->option_types == 'input'){
            // dd($request['que_input_'.$val->index_no]);
             if(isset($request['que_input_'.$val->index_no])){
                UserEventData::create([
                   'event_id'=>$request->event_id,
                   'question_index'=>$val->index_no,
                   'option_val'=>$request['que_input_'.$val->index_no],
                   'option_types'=>'input'
                ]);
             }else{

             }
          }else if($val->option_types == 'checkbox'){

          }else{

          }
        }
        return view('user.event.thankyou');
      }
      catch(\Exception $e){  
        dd($e);
       }
    }
}
