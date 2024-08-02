<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OptionTypes;
use App\Models\Category;
use App\Models\Departmen;
use App\Models\Event;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Requests\QuetionInfoUpdateRequest;
use DB;
use App\Models\Question;
use App\Models\PersonalInformation;
use App\Models\Option;
use DataTables;

class EventContoller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        if (request()->ajax()) {
            $data = Event::where('status', 1)->orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.adminpanel.event.index');
    }

    public function create()
    {
        $option_type = OptionTypes::all();
        $category = Category::all();
        $departmen = Departmen::all();
        return view('admin.adminpanel.event.create', compact('option_type', 'category', 'departmen'));
    }

    public function store(EventStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $url = env('APP_URL') . '/' . str()->random(25);
            if ($request->hasFile('logo')) {
                $imageName = time() . '.' . $request->logo->getClientOriginalExtension();
                // $path = $request->logo->store('images', 'public');
                $request->logo->storeAs('public/images', $imageName);
            }else{
                $imageName =null;
            }

            $event = Event::create([
                'name' => $request->event_title,
                'description' => $request->event_desc,
                'start_date' => $request->event_start,
                'close_date' => $request->event_end,
                'image' => $imageName,
                'category_id' => $request->category_name,
                'department_id' => $request->departmen_name,
                'event_url' => $url
            ]);

            //for Personal information
            foreach ($request->p_option_type as $key => $type) {
                if ($type == 'input' || $type == 'textarea') {
                    $question = PersonalInformation::create([
                        'event_id' => $event->id,
                        'name' => $request->p_quation[$key],
                        'description' => $request->p_description,
                        'required' => $request->p_required[$key],
                        'option_types' => $type,
                    ]);

                    Option::create([
                        'personal_information_id' => $question->id,
                    ]);

                } else if ($type == 'radio' || $type == 'dropdown' || $type == 'checkbox' || $type == 'file' || $type == 'rating' || $type == 'date' || $type == 'number'|| $type == 'mobile') {
                    $options = explode("~", $request->p_option[$key]);

                    $question = PersonalInformation::create([
                        'event_id' => $event->id,
                        'name' => $request->p_quation[$key],
                        'description' => $request->p_description,
                        'required' => $request->p_required[$key],
                        'option_types' => $type,
                        'option_name' => $request->p_option[$key]

                    ]);



                    if (count($options) > 1) {
                        foreach ($options as $val) {
                            Option::create([
                                'personal_information_id' => $question->id,
                                'name' => $val
                            ]);
                        }
                    } else {
                        Option::create([
                            'personal_information_id' => $question->id,
                            'name' => $request->p_option[$key]
                        ]);
                    }
                } else {

                }
            }

            //for question 
            foreach ($request->option_type as $key => $type) {
                // dd($request->all());
                if ($type == 'input' || $type == 'textarea') {
                    $question = Question::create([
                        'event_id' => $event->id,
                        'name' => $request->quation[$key],
                        'description' => $request->description,
                        'required' => $request->required[$key],
                        'option_types' => $type,
                    ]);

                    Option::create([
                        'question_id' => $question->id,
                    ]);

                } else if ($type == 'radio' || $type == 'dropdown' || $type == 'checkbox' || $type == 'file' || $type == 'rating' || $type == 'date' || $type == 'number'|| $type == 'mobile') {
                    $options = explode("~", $request->option[$key]);
                    $question = Question::create([
                        'event_id' => $event->id,
                        'name' => $request->quation[$key],
                        'description' => $request->description,
                        'required' => $request->required[$key],
                        'option_types' => $type,
                        'option_name' => $request->option[$key]

                    ]);

                    if (count($options) > 1) {
                        foreach ($options as $val) {
                            Option::create([
                                'question_id' => $question->id,
                                'name' => $val
                            ]);
                        }
                    } else {
                        Option::create([
                            'question_id' => $question->id,
                            'name' => $request->option[$key]
                        ]);
                    }
                } else {

                }
            }
            
            DB::commit();
            return redirect()->back()->with('success', config('const.success_message'));

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

    }

    public function edit(Request $request)
    {
        try {
            $event = Event::findOrFail($request->id);
            $category = Category::all();
            $departmen = Departmen::all();
            $html = view('admin.adminpanel.event.edit', compact('event', 'category', 'departmen'))->render();
            return response()->json(['html' => $html]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function update(EventUpdateRequest $request)
    {
        try {
            $event = Event::findOrFail($request->event_id);
            $event->category_id = $request->category_name;
            $event->department_id = $request->departmen_name;
            $event->name = $request->event_title;
            $event->description = $request->category_name;
            $event->start_date = $request->start_date;
            $event->close_date = $request->end_date;

            if ($request->hasFile('logo')) {
                $imageName = time() . '.' . $request->logo->getClientOriginalExtension();
                // $path = $request->logo->store('images', 'public');
                $request->logo->storeAs('public/images', $imageName);
                $event->image = $imageName;
            }
            $event->save();
            return response()->json(['data' => $event]);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete(Request $request)
    {
        try {
            $event = Event::findOrFail($request->id);
            $event->delete();
            return response()->json(['data' => $event]);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function questionList($id)
    {

        try {

            $data = Event::with('questions','personalinfo')->where('status', 1)->where('id', $id)->first();
            return view('admin.adminpanel.question.index', compact('data'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function questionUpdate(QuetionInfoUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            Question::where('event_id', $request->event_id)->delete();
            PersonalInformation::where('event_id', $request->event_id)->delete();
            //for personal info
            foreach ($request->p_option_type as $key => $type) {
                if ($type == 'input' || $type == 'textarea') {
                    $question = PersonalInformation::create([
                        'event_id' => $request->event_id,
                        'name' => $request->p_quation[$key],
                        'description' => $request->p_description,
                        'required' => $request->p_required[$key],
                        'option_types' => $type,
                    ]);


                    Option::create([
                        'personal_information_id' => $question->id,
                    ]);

                } else if ($type == 'radio' || $type == 'dropdown' || $type == 'checkbox' || $type == 'file' || $type == 'rating' || $type == 'date' || $type == 'number'|| $type == 'mobile') {
                    $options = explode("~", $request->p_option[$key]);
                    $question = PersonalInformation::create([
                        'event_id' => $request->event_id,
                        'name' => $request->p_quation[$key],
                        'description' => $request->p_description,
                        'required' => $request->p_required[$key],
                        'option_types' => $type,
                        'option_name' => $request->p_option[$key]

                    ]);

                    if (count($options) > 1) {
                        foreach ($options as $val) {
                            Option::create([
                                'personal_information_id' => $question->id,
                                'name' => $val
                            ]);
                        }
                    } else {
                        Option::create([
                            'personal_information_id' => $question->id,
                            'name' => $request->p_option[$key]
                        ]);
                    }
                } else {

                }
            }

            //for questions 
            foreach ($request->option_type as $key => $type) {
                if ($type == 'input' || $type == 'textarea') {
                    $question = Question::create([
                        'event_id' => $request->event_id,
                        'name' => $request->quation[$key],
                        'description' => $request->description,
                        'required' => $request->required[$key],
                        'option_types' => $type,
                    ]);

                    Option::create([
                        'question_id' => $question->id,
                    ]);

                } else if ($type == 'radio' || $type == 'dropdown' || $type == 'checkbox' || $type == 'file' || $type == 'rating' || $type == 'date' || $type == 'number'|| $type == 'mobile') {
                    $options = explode("~", $request->option[$key]);
                    $question = Question::create([
                        'event_id' => $request->event_id,
                        'name' => $request->quation[$key],
                        'description' => $request->description,
                        'required' => $request->required[$key],
                        'option_types' => $type,
                        'option_name' => $request->option[$key]

                    ]);

                    if (count($options) > 1) {
                        foreach ($options as $val) {
                            Option::create([
                                'question_id' => $question->id,
                                'name' => $val
                            ]);
                        }
                    } else {
                        Option::create([
                            'question_id' => $question->id,
                            'name' => $request->option[$key]
                        ]);
                    }
                } else {
                }
            }
            DB::commit();
            return redirect()->back()->with('success', config('const.success_message'));

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function questionDelete(Request $request){
      Question::where('id', $request->id)->delete();
      return response()->json(['data' => $request->id]);
    }
    public function PersonalInfodelete(Request $request){
        PersonalInformation::where('id', $request->id)->delete();
        return response()->json(['data' => $request->id]);
    }
}
