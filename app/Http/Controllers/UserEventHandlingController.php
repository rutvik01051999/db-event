<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\UserEventData;
use App\Models\UserEventLocation;
use App\Services\AttachmentService;
use Carbon\Carbon;
use DB;
use App\Models\UserEventPersonalData;

class UserEventHandlingController extends Controller
{
  public function index($id)
  {
    try {
      $data = Event::with('questions', 'personalinfo')->where('event_url', env('APP_URL') . '/' . $id)->first();

      // if the start date is greater than current date OR end date is less than current date OR event status is 0
      if ($data->status == 0 || Carbon::parse($data->start_date)->format('Y-m-d') > Carbon::now()->format('Y-m-d') || Carbon::parse($data->close_date) < Carbon::now()->format('Y-m-d')) {
        return view('user.event.closed', compact('data'));
      }

      return view('user.event.form', compact('data'));
    } catch (\Exception $e) {
      logger($e);
    }
  }
  public function eventDataStore(Request $request)
  {
    // dd($request->all());
    DB::beginTransaction();
    try {
      $data = Event::with('questions', 'personalinfo')->where('id', $request->event_id)->first();

      // foreach ($data->personalinfo as $key => $val) {

      //   if ($val->option_types == 'input') {
      //     if (isset($request['per_input_' . $val->index_no])) {
      //       UserEventData::create([
      //         'event_id' => $request->event_id,
      //         'personal_index' => $val->index_no,
      //         'option_val' => $request['per_input_' . $val->index_no],
      //         'option_types' => 'input'
      //       ]);
      //     }
      //   } else if ($val->option_types == 'checkbox') {
      //     $checkbox = array();
      //     foreach ($val->options as $key2 => $val2) {
      //       if (isset($request['per_checkbox_' . $val2->index_no . '_' . $val->index_no])) {
      //         $checkbox[] = $request['per_checkbox_' . $val2->index_no . '_' . $val->index_no];
      //       }
      //     }
      //     $string_version = implode(',', $checkbox);
      //     //$destination_array = explode(',', $string_version);
      //     UserEventData::create([
      //       'event_id' => $request->event_id,
      //       'personal_index' => $val->index_no,
      //       'option_val' => $string_version,
      //       'option_types' => 'checkbox'
      //     ]);
      //   } else if ($val->option_types == 'number') {
      //     if (isset($request['per_num_' . $val->index_no])) {
      //       UserEventData::create([
      //         'event_id' => $request->event_id,
      //         'question_index' => $val->index_no,
      //         'option_val' => $request['per_num_' . $val->index_no],
      //         'option_types' => 'number'
      //       ]);
      //     }
      //   } else if ($val->option_types == 'textarea') {
      //     if (isset($request['per_textarea_' . $val->index_no])) {
      //       UserEventData::create([
      //         'event_id' => $request->event_id,
      //         'question_index' => $val->index_no,
      //         'option_val' => $request['per_textarea_' . $val->index_no],
      //         'option_types' => 'textarea'
      //       ]);
      //     }
      //   } else if ($val->option_types == 'rating') {
      //     if (isset($request['perinfo_rating_' . $val->index_no])) {
      //       UserEventData::create([
      //         'event_id' => $request->event_id,
      //         'personal_index' => $val->index_no,
      //         'option_val' => $request['perinfo_rating_' . $val->index_no],
      //         'option_types' => 'rating'
      //       ]);
      //     }
      //   } else if ($val->option_types == 'radio') {
      //     if (isset($request['per_radio_' . $val->index_no])) {
      //       UserEventData::create([
      //         'event_id' => $request->event_id,
      //         'personal_index' => $val->index_no,
      //         'option_val' => $request['per_radio_' . $val->index_no],
      //         'option_types' => 'radio'
      //       ]);
      //     }
      //   } else if ($val->option_types == 'dropdown') {
      //     if (isset($request['per_dropdown_' . $val->index_no])) {
      //       UserEventData::create([
      //         'event_id' => $request->event_id,
      //         'personal_index' => $val->index_no,
      //         'option_val' => $request['per_dropdown_' . $val->index_no],
      //         'option_types' => 'dropdown'
      //       ]);
      //     }
      //   } else if ($val->option_types == 'mobile_otp') {
      //     if (isset($request['per_mobile_otp_' . $val->index_no])) {
      //       UserEventData::create([
      //         'event_id' => $request->event_id,
      //         'personal_index' => $val->index_no,
      //         'option_val' => $request['per_mobile_otp_' . $val->index_no],
      //         'option_types' => 'mobile_otp'
      //       ]);
      //     }
      //   } else if ($val->option_types == 'file' || $val->option_types == 'multiple_file') {
      //     if (isset($request['per_file_' . $val->index_no])) {
      //       $files = $request['per_file_' . $val->index_no] ?? [];

      //       $userEvent = UserEventData::create([
      //         'event_id' => $request->event_id,
      //         'personal_index' => $val->index_no,
      //         'option_val' => '',
      //         'option_types' => $val->option_types
      //       ]);
      //       $filePaths = [];
      //       foreach ($files as $key => $file) {
      //         $attachment = AttachmentService::save($file, 'user-uploaded-file', 'users/uploaded-files', $userEvent);

      //         if ($attachment) {
      //           $filePaths[] = $attachment->file_path;
      //         }
      //       }

      //       $userEvent->update([
      //         'option_val' => json_encode($filePaths)
      //       ]);
      //     }
      //   }
      // }

      //store personal info of user
      $user_per_data = UserEventPersonalData::where('mobile_number', $request->otp_mobile);
      $user_data = [
        'full_name' => $request->full_name,
        'gender' => $request->gender,
        'age' => $request->age,
        'mobile_number' => $request->otp_mobile,
        'pincode' => $request->pincode,
        'area' => $request->area,
        'state' => $request->state,
        'city' => $request->city,
        'dob'=>$request->dob,
        'address'=>$request->address
      ];

      if ($user_per_data->count()) {
        // $user_per_data->delete();
        $user_per_info = $user_per_data->first();
        UserEventPersonalData::where('mobile_number',$request->otp_mobile)->update($user_data);
      } else {
        $user_per_info = UserEventPersonalData::create($user_data);
      }
      // $user_per_info = UserEventPersonalData::create([
      //   'full_name' => $request->full_name,
      //   'gender' => $request->gender,
      //   'age' => $request->age,
      //   'mobile_number' => $request->otp_mobile,
      //   'pincode' => $request->pincode,
      //   'area' => $request->area,
      //   'state' => $request->state,
      //   'city' => $request->city,
      //   'dob'=>$request->dob,
      //   'address'=>$request->address
      // ]);
      
      //end here

      foreach ($data->questions as $key => $val) {
        if ($val->option_types == 'input') {
          if (isset($request['que_input_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'question_index' => $val->index_no,
              'option_val' => $request['que_input_' . $val->index_no],
              'option_types' => 'input',
              'personal_id'=>$user_per_info->id
            ]);
          }
        } else if ($val->option_types == 'checkbox') {
          $checkbox = array();
          foreach ($val->options as $key2 => $val2) {
            // dd($request->all());
            if (isset($request['que_checkbox_' . $val2->index_no . '_' . $val->index_no])) {
              $checkbox[] = $request['que_checkbox_' . $val2->index_no . '_' . $val->index_no];
            }
          }
          $string_version = implode(',', $checkbox);
          // dd($request->all(),$request['que_checkbox_2_2'],$val->index_no,$val2->index_no);
          //$destination_array = explode(',', $string_version);
          UserEventData::create([
            'event_id' => $request->event_id,
            'question_index' => $val->index_no,
            'option_val' => $string_version,
            'option_types' => 'checkbox',
            'personal_id'=>$user_per_info->id

          ]);
        } else if ($val->option_types == 'number') {
          if (isset($request['que_num_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'question_index' => $val->index_no,
              'option_val' => $request['que_num_' . $val->index_no],
              'option_types' => 'number',
              'personal_id'=>$user_per_info->id

            ]);
          }
        } else if ($val->option_types == 'textarea') {
          if (isset($request['que_textarea_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'question_index' => $val->index_no,
              'option_val' => $request['que_textarea_' . $val->index_no],
              'option_types' => 'textarea',
              'personal_id'=>$user_per_info->id

            ]);
          }
        } else if ($val->option_types == 'rating') {
          if (isset($request['que_rating_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'question_index' => $val->index_no,
              'option_val' => $request['que_rating_' . $val->index_no],
              'option_types' => 'rating',
              'personal_id'=>$user_per_info->id

            ]);
          }
        }else if ($val->option_types == 'date') {
          if (isset($request['que_date_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'question_index' => $val->index_no,
              'option_val' => $request['que_date_' . $val->index_no],
              'option_types' => 'date',
              'personal_id'=>$user_per_info->id

            ]);
          }
        } else if ($val->option_types == 'radio') {
          if (isset($request['que_radio_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'question_index' => $val->index_no,
              'option_val' => $request['que_radio_' . $val->index_no],
              'option_types' => 'radio',
              'personal_id'=>$user_per_info->id

            ]);
          }
        } else if ($val->option_types == 'dropdown') {
          if (isset($request['que_dropdown_' . $val->index_no])) {
            UserEventData::create([
              'event_id' => $request->event_id,
              'question_index' => $val->index_no,
              'option_val' => $request['que_dropdown_' . $val->index_no],
              'option_types' => 'dropdown',
              'personal_id'=>$user_per_info->id

            ]);
          }
        } else if ($val->option_types == 'file' || $val->option_types == 'multiple_file') {
              if (isset($request['files'])) {
                $files = $request['files'] ?? [];
    
                $userEvent = UserEventData::create([
                  'event_id' => $request->event_id,
                  'option_val' => '',
                  'option_types' => $val->option_types,
                  'question_index' => $val->index_no,
                ]);
                $filePaths = [];
                foreach ($files as $key => $file) {
                  $attachment = AttachmentService::save($file, 'user-uploaded-file', 'users/uploaded-files', $userEvent);
    
                  if ($attachment) {
                    $filePaths[] = $attachment->file_path;
                  }
                }
    
                $userEvent->update([
                  'option_val' => json_encode($filePaths)
                ]);
              }
            }
      }
      DB::commit();
      return view('user.event.thankyou', compact('data'));
    } catch (\Exception $e) {
      dd($e);
      DB::rollback();
    }
  }

  public function saveLocation(Request $request)
  {
    $data = $request->all();
    UserEventLocation::create($data);

    return response()->json(['status' => 'success'], 200);
  }
}
