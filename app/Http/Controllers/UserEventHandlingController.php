<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\UserEventData;
use DB;

class UserEventHandlingController extends Controller
{
  public function index($id)
  {
    try {
      $data = Event::with('questions', 'personalinfo')->where('event_url', env('APP_URL') . '/' . $id)->first();
      return view('user.event.form', compact('data'));
    } catch (\Exception $e) {
      dd($e);
    }
  }
  public function eventDataStore(Request $request)
  {
    // dd($request->all());
    DB::beginTransaction();
    try {
      $data = Event::with('questions', 'personalinfo')->where('id', $request->event_id)->first();
      foreach ($data->personalinfo as $key => $val) {

        if ($val->option_types == 'input') {
          //  dd('per_input_'.$key,$request['event_id']);
          if (isset($request['per_input_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'personal_index' => $val->index_no,
              'option_val' => $request['per_input_' . $val->index_no],
              'option_types' => 'input'
            ]);
          } else {

          }
        }else if ($val->option_types == 'checkbox') {
          $checkbox = array();
          foreach ($val->options as $key2 => $val2) {
            if (isset($request['per_checkbox_' . $val2->index_no . '_' . $val->index_no])) {
              // dd($request['per_checkbox_' . $val2->index_no . '_' . $val->index_no]);
              $checkbox[] = $request['per_checkbox_' . $val2->index_no . '_' . $val->index_no];
            }
          }
          $string_version = implode(',', $checkbox);
          //$destination_array = explode(',', $string_version);
          UserEventData::create([
            'event_id' => $request->event_id,
            'personal_index' => $val->index_no,
            'option_val' => $string_version,
            'option_types' => 'checkbox'
          ]);

        }else if ($val->option_types == 'number') {
          if (isset($request['per_num_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'question_index' => $val->index_no,
              'option_val' => $request['per_num_' . $val->index_no],
              'option_types' => 'number'
            ]);
          } else {

          }
        }else if ($val->option_types == 'textarea') {
          if (isset($request['per_textarea_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'question_index' => $val->index_no,
              'option_val' => $request['per_textarea_' . $val->index_no],
              'option_types' => 'textarea'
            ]);
          } else {

          }
        }else if($val->option_types == 'rating'){
          if (isset($request['perinfo_rating_' . $val->index_no])) {
            // dd($request['perinfo_rating_' . $val->index_no]);
            UserEventData::create([
              'event_id' => $request->event_id,
              'personal_index' => $val->index_no,
              'option_val' => $request['perinfo_rating_' . $val->index_no],
              'option_types' => 'rating'
            ]);
          } else {

          }
        }else if($val->option_types == 'radio'){
          if (isset($request['per_radio_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'personal_index' => $val->index_no,
              'option_val' => $request['per_radio_' . $val->index_no],
              'option_types' => 'radio'
            ]);
          } else {

          }
        }else if($val->option_types == 'dropdown'){
          if (isset($request['per_dropdown_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'personal_index' => $val->index_no,
              'option_val' => $request['per_dropdown_' . $val->index_no],
              'option_types' => 'dropdown'
            ]);
          } else {

          }
        }
        else {

        }
      }

      foreach ($data->questions as $key => $val) {
        if ($val->option_types == 'input') {
          // dd($request['que_input_'.$val->index_no]);
          if (isset($request['que_input_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'question_index' => $val->index_no,
              'option_val' => $request['que_input_' . $val->index_no],
              'option_types' => 'input'
            ]);
          } else {

          }
        }else if ($val->option_types == 'checkbox') {
          $checkbox = array();
          foreach ($val->options as $key2 => $val2) {
            if (isset($request['per_checkbox_' . $val2->index_no . '_' . $val->index_no])) {
              // dd($request['per_checkbox_' . $val2->index_no . '_' . $val->index_no]);
              $checkbox[] = $request['per_checkbox_' . $val2->index_no . '_' . $val->index_no];
            }
          }
          $string_version = implode(',', $checkbox);
          //$destination_array = explode(',', $string_version);
          UserEventData::create([
            'event_id' => $request->event_id,
            'personal_index' => $val->index_no,
            'option_val' => $string_version,
            'option_types' => 'checkbox'
          ]);
        }else if ($val->option_types == 'number') {
          if (isset($request['que_num_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'question_index' => $val->index_no,
              'option_val' => $request['que_num_' . $val->index_no],
              'option_types' => 'number'
            ]);
          } else {

          }

        }else if ($val->option_types == 'textarea') {
          if (isset($request['que_textarea_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'question_index' => $val->index_no,
              'option_val' => $request['que_textarea_' . $val->index_no],
              'option_types' => 'textarea'
            ]);
          } else {

          }
        }else if($val->option_types == 'rating'){
          if (isset($request['que_rating_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'question_index' => $val->index_no,
              'option_val' => $request['que_rating_' . $val->index_no],
              'option_types' => 'rating'
            ]);
          } else {

          }
        }else if($val->option_types == 'radio'){
          if (isset($request['que_radio_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'question_index' => $val->index_no,
              'option_val' => $request['que_radio_' . $val->index_no],
              'option_types' => 'radio'
            ]);
          } else {

          }
        }else if($val->option_types == 'dropdown'){
          if (isset($request['que_dropdown_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'question_index' => $val->index_no,
              'option_val' => $request['que_dropdown_' . $val->index_no],
              'option_types' => 'dropdown'
            ]);
          } else {

          }
        }
        else {

        }
      }
      DB::commit();
      return view('user.event.thankyou');
    } catch (\Exception $e) {
      DB::rollback();
      dd($e);
    }
  }
}
