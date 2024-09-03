<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\EventDataTable;
use App\DataTables\EventUserListDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Event;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Requests\QuetionInfoUpdateRequest;
use App\Models\Department;
use DB;
use App\Models\Question;
use App\Models\PersonalInformation;
use App\Models\Option;
use App\Services\QrCodeService;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Storage;

class EventContoller extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function index(EventDataTable $dataTable)
    {
        return $dataTable->render('admin.adminpanel.event.index');
    }

    public function create()
    {
        $category = Category::all();
        $department = Department::all();
        return view('admin.adminpanel.event.create', compact('category', 'department'));
    }

    public function store(EventStoreRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $url = env('APP_URL') . '/' . str()->random(25);
            $imagePath = '';
            if ($request->hasFile('logo')) {
                $imageName = time() . '.' . $request->logo->getClientOriginalExtension();
                $imagePath = Storage::putFileAs('images', $request->logo, $imageName);
            }

            $event = Event::create([
                'name' => $request->event_title,
                'description' => $request->event_desc,
                'start_date' => $request->event_start,
                'close_date' => $request->event_end,
                'image' => $imagePath,
                'category_id' => $request->category_name,
                'department_id' => $request->department_name,
                'event_url' => $url,
                'response' => $request->event_response ?? '',
                'status' => false,
            ]);

            //for Personal information
            foreach ($request->p_option_type as $key => $type) {
                if ($key == 0) {
                    $input_type = 'full_name';
                } elseif ($key == 1) {
                    $input_type = 'gender';
                } elseif ($key == 2) {
                    $input_type = 'age';
                } elseif ($key == 3) {
                    $input_type = 'address';
                } elseif ($key == 4) {
                    $input_type = 'pincode';
                } elseif ($key == 5) {
                    $input_type = 'area';
                } elseif ($key == 6) {
                    $input_type = 'state';
                } elseif ($key == 7) {
                    $input_type = 'city';
                } elseif ($key == 8) {
                    $input_type = 'mobile_number';
                } elseif ($key == 9) {
                    $input_type = 'dob';
                } else {
                }
                if ($type == 'input' || $type == 'textarea' || $type == 'pincode') {
                    $question = PersonalInformation::create([
                        'event_id' => $event->id,
                        'name' => $request->p_quation[$key],
                        'description' => $request->p_description,
                        'required' => $request->p_required[$key],
                        'option_types' => $type,
                        'index_no' => $key,
                        'input_name' => $input_type,
                    ]);

                    Option::create([
                        'personal_information_id' => $question->id,
                    ]);
                } elseif ($type == 'radio' || $type == 'dropdown' || $type == 'checkbox' || $type == 'file' || $type == 'multiple_file' || $type == 'rating' || $type == 'date' || $type == 'number' || $type == 'mobile' || $type == 'mobile_otp') {
                    $options = explode('~', $request->p_option[$key]);

                    $question = PersonalInformation::create([
                        'event_id' => $event->id,
                        'name' => $request->p_quation[$key],
                        'description' => $request->p_description,
                        'required' => $request->p_required[$key],
                        'option_types' => $type,
                        'option_name' => $request->p_option[$key],
                        'index_no' => $key,
                        'input_name' => $input_type,
                    ]);

                    if (count($options) > 1) {
                        foreach ($options as $key2 => $val) {
                            Option::create([
                                'personal_information_id' => $question->id,
                                'name' => $val,
                                'index_no' => $key2,
                            ]);
                        }
                    } else {
                        Option::create([
                            'personal_information_id' => $question->id,
                            'name' => $request->p_option[$key],
                            'index_no' => $key,
                        ]);
                    }
                } else {
                }
            }

            //for question
            foreach ($request->option_type as $key => $type) {
                if ($type == 'input' || $type == 'textarea') {
                    $question = Question::create([
                        'event_id' => $event->id,
                        'name' => $request->quation[$key],
                        'description' => $request->description,
                        'required' => $request->required[$key],
                        'option_types' => $type,
                        'index_no' => $key,
                    ]);

                    Option::create([
                        'question_id' => $question->id,
                    ]);
                } elseif ($type == 'radio' || $type == 'dropdown' || $type == 'checkbox' || $type == 'file' || $type == 'multiple_file' || $type == 'rating' || $type == 'date' || $type == 'number' || $type == 'mobile' || $type == 'pdf' || $type == 'video' || $type == 'audio' || $type == 'image' || $type == 'pdf_multiple' || $type == 'image_multiple' || $type == 'video_multiple' || $type == 'audio_multiple') {
                    $options = explode('~', $request->option[$key]);
                    $question = Question::create([
                        'event_id' => $event->id,
                        'name' => $request->quation[$key],
                        'description' => $request->description,
                        'required' => $request->required[$key],
                        'option_types' => $type,
                        'option_name' => $request->option[$key],
                        'index_no' => $key,
                    ]);

                    if (count($options) > 1) {
                        foreach ($options as $key2 => $val) {
                            Option::create([
                                'question_id' => $question->id,
                                'name' => $val,
                                'index_no' => $key2,
                            ]);
                        }
                    } else {
                        Option::create([
                            'question_id' => $question->id,
                            'name' => $request->option[$key],
                            'index_no' => $key,
                        ]);
                    }
                } else {
                }
            }

            // Save QR Code
            QrCodeService::generateAndSave($event);

            DB::commit();

            if ($event->category && strtolower($event->category->name) == 'quiz') {
                return redirect()->route('event.set-correct-answer', $event->id);
            }

            return redirect()->route('event.index')->with('success', config('const.success_message'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $event = Event::findOrFail($id);
            $categories = Category::all();
            $departments = Department::all();
            return view('admin.adminpanel.event.edit', compact('event', 'categories', 'departments'));
        } catch (\Exception $e) {
            return redirect()->route('event.index')->withErrors($e->getMessage());
        }
    }
    public function update(EventUpdateRequest $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return redirect()->route('event.index')->with('error', 'Event not found');
        }

        $imagePath = $event->image ?? '';
        if ($request->hasFile('logo')) {
            $imageName = time() . '.' . $request->logo->getClientOriginalExtension();
            $imagePath = Storage::putFileAs('images', $request->logo, $imageName);
        }

        $event->update([
            'category_id' => $request->category_name,
            'department_id' => $request->department_name,
            'name' => $request->event_title,
            'description' => $request->event_desc ?? '',
            'start_date' => $request->event_start,
            'close_date' => $request->event_end,
            'image' => $imagePath,
            'response' => $request->event_response ?? '',
        ]);

        return redirect()->route('event.index')->with('success', 'Event updated successfully');
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
            $data = Event::with('questions', 'personalinfo')->where('status', 1)->where('id', $id)->first();
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
                if ($key == 0) {
                    $input_type = 'full_name';
                } elseif ($key == 1) {
                    $input_type = 'gender';
                } elseif ($key == 2) {
                    $input_type = 'age';
                } elseif ($key == 3) {
                    $input_type = 'address';
                } elseif ($key == 4) {
                    $input_type = 'pincode';
                } elseif ($key == 5) {
                    $input_type = 'area';
                } elseif ($key == 6) {
                    $input_type = 'state';
                } elseif ($key == 7) {
                    $input_type = 'city';
                } elseif ($key == 8) {
                    $input_type = 'mobile_number';
                } elseif ($key == 9) {
                    $input_type = 'dob';
                } else {
                }
                if ($type == 'input' || $type == 'textarea' || $type == 'pincode') {
                    $question = PersonalInformation::create([
                        'event_id' => $request->event_id,
                        'name' => $request->p_quation[$key],
                        'description' => $request->p_description ?? null,
                        'required' => $request->p_required[$key],
                        'option_types' => $type,
                        'index_no' => $key,
                        'input_name' => $input_type,
                    ]);

                    Option::create([
                        'personal_information_id' => $question->id,
                    ]);
                } elseif ($type == 'radio' || $type == 'dropdown' || $type == 'checkbox' || $type == 'file' || $type == 'multiple_file' || $type == 'rating' || $type == 'date' || $type == 'number' || $type == 'mobile' || $type == 'mobile_otp') {
                    $options = explode('~', $request->p_option[$key]);
                    $question = PersonalInformation::create([
                        'event_id' => $request->event_id,
                        'name' => $request->p_quation[$key],
                        'description' => $request->p_description,
                        'required' => $request->p_required[$key],
                        'option_types' => $type,
                        'option_name' => $request->p_option[$key],
                        'index_no' => $key,
                        'input_name' => $input_type,
                    ]);

                    if (count($options) > 1) {
                        foreach ($options as $key2 => $val) {
                            Option::create([
                                'personal_information_id' => $question->id,
                                'name' => $val,
                                'index_no' => $key2,
                            ]);
                        }
                    } else {
                        Option::create([
                            'personal_information_id' => $question->id,
                            'name' => $request->p_option[$key],
                            'index_no' => $key,
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
                        'index_no' => $key,
                    ]);

                    Option::create([
                        'question_id' => $question->id,
                    ]);
                } elseif ($type == 'radio' || $type == 'dropdown' || $type == 'checkbox' || $type == 'file' || $type == 'multiple_file' || $type == 'rating' || $type == 'date' || $type == 'number' || $type == 'mobile' || $type == 'pdf' || $type == 'video' || $type == 'audio' || $type == 'image' || $type == 'pdf_multiple' || $type == 'image_multiple' || $type == 'video_multiple' || $type == 'audio_multiple') {
                    $options = explode('~', $request->option[$key]);
                    $question = Question::create([
                        'event_id' => $request->event_id,
                        'name' => $request->quation[$key],
                        'description' => $request->description,
                        'required' => $request->required[$key],
                        'option_types' => $type,
                        'option_name' => $request->option[$key],
                        'index_no' => $key,
                    ]);

                    if (count($options) > 1) {
                        foreach ($options as $key2 => $val) {
                            Option::create([
                                'question_id' => $question->id,
                                'name' => $val,
                                'index_no' => $key2,
                            ]);
                        }
                    } else {
                        Option::create([
                            'question_id' => $question->id,
                            'name' => $request->option[$key],
                            'index_no' => $key,
                        ]);
                    }
                } else {
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Event updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function questionDelete(Request $request)
    {
        Question::where('id', $request->id)->delete();
        return response()->json(['data' => $request->id]);
    }
    public function PersonalInfodelete(Request $request)
    {
        PersonalInformation::where('id', $request->id)->delete();
        return response()->json(['data' => $request->id]);
    }

    public function setCorrectAnswer($id)
    {
        $event = Event::where('id', $id)
            ->withWhereHas('questions', function ($q) {
                return $q->whereIn('option_types', ['checkbox', 'dropdown', 'radio']);
            })
            ->first();

        if (!$event) {
            abort(404, 'Event not found');
        }

        return view('admin.event.set_correct_answer', compact('event'));
    }

    public function saveCorrectAnswer(Request $request, $id)
    {
        $correctAnswerIds = $request->option_id ?? [];

        if ($correctAnswerIds) {
            $options = Event::where('id', $id)->with('questions.options')->get()->first()->questions->pluck('options')->flatten();
            foreach ($options as $option) {
                $option->update(['is_correct' => false]);
            }
            Option::whereIn('id', $correctAnswerIds)->update(['is_correct' => true]);

            Event::where('id', $id)->update(['status' => true]);
        }

        return redirect()->route('event.index')->with('success', 'Correct answer updated successfully');
    }

    public function changeStatus(Request $request, $id)
    {
        $status = $request->status;
        $event = Event::find($id);
        $approved = $request->approved;

        $isSetCorrectAnswers = Event::where('id', $id)
            ->whereHas('questions.options', function ($q) {
                return $q->where('is_correct', true);
            })
            ->exists();

        if (!$isSetCorrectAnswers && $event->category && strtolower($event->category->name) == 'quiz') {
            return response()->json(
                [
                    'title' => 'Warning',
                    'message' => 'Please set correct answers first',
                    'need_correct_answers' => true,
                ],
                200,
            );
        }

        $today = Carbon::now();
        // If the event is already started then it cannot be changed
        if ($event->start_date < $today && $event->status == 1 && $approved == 'no') {
            return response()->json(
                [
                    'title' => 'Are you sure?',
                    'message' => 'Event already started cannot be changed',
                    'is_started' => true,
                ],
                200,
            );
        }

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $event->update([
            'status' => !$event->status,
        ]);

        return response()->json(['message' => 'Event status updated successfully'], 200);
    }

    public function downloadQrCode($id) {
        $event = Event::where('id', $id)->first();

        if (!$event) {
            abort(404, 'Event not found');
        }

        $filePath = $event->qr_code_path;
        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        }

        abort(404, 'QR code not found');
    }
}
