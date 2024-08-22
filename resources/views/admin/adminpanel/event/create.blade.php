@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-9">
                        <h1>Create Event</h1>
                    </div>
                    <div class="col-sm-3 float-sm-right">
                        <label for="language-editor">Select Language:</label>
                        <select name="languages" id="languageDropDown" onchange="javascript:languageChangeHandler()"
                            class="form-control">
                            <option value="en">English</option>
                            <option value="hi">Hindi</option>
                            <option value="gu">Gujarati</option>
                            <option value="mr">Marathi</option>
                        </select>
                    </div>
                </div>
            </div>
        </section>


        <section class="content">
            <div class="container-fluid">
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <span>{!! \Session::get('success') !!}</span>
                    </div>
                @endif
                <div class="card shadow-lg">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="event-details" method="post" action="store" enctype="multipart/form-data">
                            @csrf
                            <h3 class="mt-3">Event Master</h3>
                            <div class="row">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Title
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="event_title" id="eventTitle"
                                            placeholder="Title" data-translatable="true">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Description <span class="text-danger">*</span></label>
                                        <input type="text" name="event_desc" class="form-control" id="eventDesc"
                                            placeholder="Description" data-translatable="true">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Logo <span class="text-danger">*</span></label>
                                        <input type="file" name="logo" class="form-control" placeholder="Logo">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Start event<span class="text-danger">*</span></label>
                                        <input type="text" name="event_start" class="form-control datepicker"
                                            placeholder="Start event" id="event_start" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>End event<span class="text-danger">*</span></label>
                                        <input type="text" name="event_end" class="form-control datepicker"
                                            placeholder="End event" id="event_end" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Response<span class="text-danger">*</span></label>
                                        <input type="text" name="event_response" class="form-control"
                                            placeholder="Response" id="eventResponse" data-translatable="true"
                                            id="eventResponse">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Category<span class="text-danger">*</span></label>
                                        <select class="form-control" name="category_name">
                                            @foreach ($category as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Department <span class="text-danger">*</span></label>
                                        <select class="form-control" name="departmen_name">
                                            @foreach ($departmen as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">

                                    </div>
                                </div>
                            </div>

                            <h3 class="mt-3">Personal Information</h3>
                            <div class="row ">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Question</label>
                                        <input type="text" name="p_quation[]" class="form-control quation"
                                            placeholder="Question" data-translatable="true" id="p_quation_1"
                                            value="Full Name">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Required</label>
                                            <select class="form-control" name="p_required[]">
                                                <option value="1">yes</option>
                                                <option value="0">no</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Option</label>
                                        <input type="text" name="p_option[]" class="form-control"
                                            placeholder="Value (Add multiple value with ~ separated)"
                                            data-translatable="true" id="p_option_1">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Select option type</label>
                                        <select class="form-control" name="p_option_type[]">
                                            @foreach (config('per_option') as $key => $option)
                                                <option value="{{ $key }}">
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label>Action</label><br>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            fill="green" class="bi bi-plus-circle-fill add_button2"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="row removecls21">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_quation[]" class="form-control quation"
                                            placeholder="Question" data-translatable="true" data-translatable="true"
                                            id="p_quation_2" value="Gender">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label></label>
                                            <select class="form-control" name="p_required[]">
                                                <option value="1">yes</option>
                                                <option value="0">no</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_option[]" class="form-control"
                                            placeholder="Value (Add multiple value with ~ separated)"
                                            data-translatable="true" id="p_option_2" value="Male ~ Female ~ Others">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label></label>
                                        <select class="form-control" name="p_option_type[]">
                                            @foreach (config('per_option') as $key => $option)
                                                <option value="{{ $key }}"
                                                    @if ('radio' == $key) selected @endif>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label></label><br>
                                        <svg xmlns="http://www.w3.org/2000/svg" data-id=1 width="32" height="32"
                                            fill="red" class="bi bi-x-circle-fill remove_button2"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="row removecls22">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_quation[]" class="form-control quation"
                                            placeholder="Question" data-translatable="true" id="p_quation_3"
                                            value="Age">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label></label>
                                            <select class="form-control" name="p_required[]">
                                                <option value="1">yes</option>
                                                <option value="0">no</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_option[]" class="form-control"
                                            placeholder="Value (Add multiple value with ~ separated)"
                                            data-translatable="true" id="p_option_3">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label></label>
                                        <select class="form-control" name="p_option_type[]">
                                            @foreach (config('per_option') as $key => $option)
                                                <option value="{{ $key }}">
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label></label><br>
                                        <svg xmlns="http://www.w3.org/2000/svg" data-id=2 width="32" height="32"
                                            fill="red" class="bi bi-x-circle-fill remove_button2"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="row removecls23">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_quation[]" class="form-control quation"
                                            placeholder="Question" data-translatable="true" id="p_quation_4"
                                            value="Address">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label></label>
                                            <select class="form-control" name="p_required[]">
                                                <option value="1">yes</option>
                                                <option value="0">no</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_option[]" class="form-control"
                                            placeholder="Value (Add multiple value with ~ separated)"
                                            data-translatable="true" id="p_option_4">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label></label>
                                        <select class="form-control" name="p_option_type[]">
                                            @foreach (config('per_option') as $key => $option)
                                                <option value="{{ $key }}"
                                                    @if ('textarea' == $key) selected @endif>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label></label><br>
                                        <svg xmlns="http://www.w3.org/2000/svg" data-id=3 width="32" height="32"
                                            fill="red" class="bi bi-x-circle-fill remove_button2"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="row removecls24">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_quation[]" class="form-control quation"
                                            placeholder="Question" data-translatable="true" id="p_quation_5"
                                            value="Pincode">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label></label>
                                            <select class="form-control" name="p_required[]">
                                                <option value="1">yes</option>
                                                <option value="0">no</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_option[]" class="form-control"
                                            placeholder="Value (Add multiple value with ~ separated)"
                                            data-translatable="true" id="p_option_5">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label></label>
                                        <select class="form-control" name="p_option_type[]">
                                            @foreach (config('per_option') as $key => $option)
                                                <option value="{{ $key }}"
                                                    @if ('pincode' == $key) selected @endif>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label></label><br>
                                        <svg xmlns="http://www.w3.org/2000/svg" data-id=4 width="32" height="32"
                                            fill="red" class="bi bi-x-circle-fill remove_button2"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="row removecls25">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_quation[]" class="form-control quation"
                                            placeholder="Question" data-translatable="true" id="p_quation_6"
                                            value="Area">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label></label>
                                            <select class="form-control" name="p_required[]">
                                                <option value="1">yes</option>
                                                <option value="0">no</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_option[]" class="form-control"
                                            placeholder="Value (Add multiple value with ~ separated)"
                                            data-translatable="true" id="p_option_6">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label></label>
                                        <select class="form-control" name="p_option_type[]">
                                            @foreach (config('per_option') as $key => $option)
                                                <option value="{{ $key }}">
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label></label><br>
                                        <svg xmlns="http://www.w3.org/2000/svg" data-id=5 width="32" height="32"
                                            fill="red" class="bi bi-x-circle-fill remove_button2"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="row removecls26">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_quation[]" class="form-control quation"
                                            placeholder="Question" data-translatable="true" id="p_quation_7"
                                            value="State">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label></label>
                                            <select class="form-control" name="p_required[]">
                                                <option value="1">yes</option>
                                                <option value="0">no</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_option[]" class="form-control"
                                            placeholder="Value (Add multiple value with ~ separated)"
                                            data-translatable="true" id="p_option_7">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label></label>
                                        <select class="form-control" name="p_option_type[]">
                                            @foreach (config('per_option') as $key => $option)
                                                <option value="{{ $key }}">
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label></label><br>
                                        <svg xmlns="http://www.w3.org/2000/svg" data-id=6 width="32" height="32"
                                            fill="red" class="bi bi-x-circle-fill remove_button2"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="row removecls27">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_quation[]" class="form-control quation"
                                            placeholder="Question" data-translatable="true" id="p_quation_8"
                                            value="City">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label></label>
                                            <select class="form-control" name="p_required[]">
                                                <option value="1">yes</option>
                                                <option value="0">no</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_option[]" class="form-control"
                                            placeholder="Value (Add multiple value with ~ separated)"
                                            data-translatable="true" id="p_option_8">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label></label>
                                        <select class="form-control" name="p_option_type[]">
                                            @foreach (config('per_option') as $key => $option)
                                                <option value="{{ $key }}">
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label></label><br>
                                        <svg xmlns="http://www.w3.org/2000/svg" data-id=7 width="32" height="32"
                                            fill="red" class="bi bi-x-circle-fill remove_button2"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="row removecls28">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_quation[]" class="form-control quation"
                                            placeholder="Question" data-translatable="true" id="p_quation_9"
                                            value="Mobile No">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label></label>
                                            <select class="form-control" name="p_required[]">
                                                <option value="1">yes</option>
                                                <option value="0">no</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label></label>
                                        <input type="text" name="p_option[]" class="form-control"
                                            placeholder="Value (Add multiple value with ~ separated)"
                                            data-translatable="true" id="p_option_9">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label></label>
                                        <select class="form-control" name="p_option_type[]">
                                            @foreach (config('per_option') as $key => $option)
                                                <option value="{{ $key }}">
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label></label><br>
                                        <svg xmlns="http://www.w3.org/2000/svg" data-id=8 width="32" height="32"
                                            fill="red" class="bi bi-x-circle-fill remove_button2"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="field_wrapper2"></div>

                            <h3 class="mt-3">Questions</h3>
                            <div class="row ">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Question</label>
                                        <input type="text" name="quation[]" class="form-control quation"
                                            placeholder="Question" data-translatable="true" id="q_quation_1">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Required</label>
                                            <select class="form-control" name="required[]">
                                                <option value="1">yes</option>
                                                <option value="0">no</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Option</label>
                                        <input type="text" name="option[]" class="form-control" placeholder="Option"
                                            data-translatable="true" id="q_option_1">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Select option type</label>
                                        <select class="form-control" name="option_type[]">
                                            @foreach (config('question_option') as $key => $option)
                                                <option value="{{ $key }}">
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label>Action</label><br>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            fill="green" class="bi bi-plus-circle-fill add_button" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="field_wrapper">

                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </section>
    </div>
@section('content-js')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert-danger').remove()
                $('.alert-success').remove()
            }, 4000);

            var maxField = 100; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var addButton2 = $('.add_button2'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var wrapper2 = $('.field_wrapper2'); //Input field wrapper
            var x = 1; //Initial field counter is 1
            var y = 9; //Initial field counter is 9


            // Once add button is clicked
            $(addButton).click(function() {
                //Check maximum number of input fields
                if (x < maxField) {
                    var fieldHTML = '<div id="removecls' + x +
                        '">  <div class="row "> <div class="col-sm-4"> <!-- text input --> <div class="form-group"> <label></label> <input type="text" name="quation[]" class="form-control quation" placeholder="Enter ..." data-translatable="true" id="q_quation_' +
                        (x + 1) +
                        '"> </div> </div> <div class="col-sm-2"> <div class="form-group"> <div class="form-group"> <label></label> <select class="form-control" name="required[]"> <option value="1">yes</option> <option value="0">no</option> </select> </div> </div> </div> <div class="col-sm-3"> <div class="form-group"> <label></label> <input type="text" name="option[]" class="form-control" placeholder="Enter ..."  data-translatable="true" id="q_option_' +
                        (x + 1) +
                        '"> </div> </div> <div class="col-sm-2"> <div class="form-group"> <label></label> <select class="form-control question_option' +
                        x +
                        '"" name="option_type[]"></select> </div> </div> <div class="col-sm-1"> <div class="form-group"> <br> <svg xmlns="http://www.w3.org/2000/svg" data-id ="' +
                        x +
                        '" width="32" height="32" fill="red" class="bi bi-x-circle-fill remove_button" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/></svg></div> </div> </div></div>'; //New input field html 
                    $(wrapper).append(fieldHTML); //Add field html
                    @foreach (config('question_option') as $key => $option)
                        var per_option = "{{ $option }}";
                        var key = "{{ $key }}";
                        $(".question_option" + x)
                            .append($("<option></option>")
                                .attr("value", key)
                                .text(per_option));
                    @endforeach

                    // Add newly added input fields to translatable fields
                    onLoad();
                    x++; //Increase field counter
                } else {
                    alert('A maximum of ' + maxField + ' fields are allowed to be added. ');
                }
            });

            $(addButton2).click(function() {
                //Check maximum number of input fields
                if (y < maxField) {
                    var fieldHTML = '<div class="removecls2' + y +
                        '">  <div class="row "> <div class="col-sm-4"> <!-- text input --> <div class="form-group"> <label></label> <input type="text" name="p_quation[]" class="form-control quation" placeholder="Enter ..." data-translatable="true" id="p_quation_' +
                        (y + 1) +
                        '"></div> </div> <div class="col-sm-2"> <div class="form-group"> <div class="form-group"> <label></label> <select class="form-control" name="p_required[]"> <option value="1">yes</option> <option value="0">no</option> </select> </div> </div> </div> <div class="col-sm-3"> <div class="form-group"> <label></label> <input type="text" name="p_option[]" class="form-control" placeholder="Enter ..."  data-translatable="true" id="p_option_' +
                        (y + 1) +
                        '" > </div> </div> <div class="col-sm-2"> <div class="form-group"> <label></label> <select class="form-control per_option' +
                        y +
                        '" name="p_option_type[]"></select> </div> </div> <div class="col-sm-1"> <div class="form-group"> <br> <svg xmlns="http://www.w3.org/2000/svg" data-id ="' +
                        y +
                        '" width="32" height="32" fill="red" class="bi bi-x-circle-fill remove_button2" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/></svg></div> </div> </div></div>'; //New input field html 

                    $(wrapper2).append(fieldHTML); //Add field html

                    @foreach (config('per_option') as $key => $option)
                        var per_option = "{{ $option }}";
                        var key = "{{ $key }}";
                        $(".per_option" + y)
                            .append($("<option></option>")
                                .attr("value", key)
                                .text(per_option));
                        console.log(".per_option" + y)
                    @endforeach

                    // Add newly added input fields to translatable fields
                    onLoad();

                    y++; //Increase field counter
                } else {
                    alert('A maximum of ' + maxField + ' fields are allowed to be added. ');
                }
            });

            // Once remove button is clicked
            $(document).on('click', '.remove_button', function(e) {
                e.preventDefault();
                console.log('enter')
                var id = $(this).attr("data-id");
                x--;
                $('#removecls' + id).remove();
            });

            $(document).on('click', '.remove_button2', function(e) {
                var id = $(this).attr("data-id");
                console.log(id)

                e.preventDefault();
                y--;
                $('.removecls2' + id).remove();
            });
        });

        // Multiple languages
        google.load("elements", "1", {
            packages: "transliteration",
        });
        var control;

        function onLoad() {
            var options = {
                sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
                destinationLanguage: ["hi", "gu", "mr"],
                shortcutKey: "ctrl+g",
                transliterationEnabled: false,
            };
            control = new google.elements.transliteration.TransliterationControl(
                options
            );

            // Add input with data-translatable="true" to translatable fields
            let translatableFields = document.querySelectorAll('[data-translatable="true"]');
            let translatableFieldIds = [];

            translatableFields.forEach((field) => {
                translatableFieldIds.push(field.id);
            });

            console.log(translatableFieldIds);

            control.makeTransliteratable(translatableFieldIds);
        }

        function languageChangeHandler() {
            var dropdown = document.getElementById("languageDropDown");
            if (dropdown.options[dropdown.selectedIndex].value == "en") {
                control.disableTransliteration();
            } else {
                control.enableTransliteration();

                control.setLanguagePair(
                    google.elements.transliteration.LanguageCode.ENGLISH,
                    dropdown.options[dropdown.selectedIndex].value
                );
            }
        }
        google.setOnLoadCallback(onLoad);

        function needtranslator() {
            jQuery("#editortypewriter").css("display", "block");
        }

        function closeeditor() {
            jQuery("#editortypewriter").css("display", "none");
        }

        $.extend($.validator.prototype, {
            checkForm: function() {
                this.prepareForm();
                for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
                    if (this.findByName(elements[i].name).length != undefined && this.findByName(elements[i]
                            .name).length > 1) {
                        for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                            this.check(this.findByName(elements[i].name)[cnt]);
                        }
                    } else {
                        this.check(elements[i]);
                    }
                }
                return this.valid();
            }
        });

        // Validation
        var formformValidaor = $("form#event-details").validate({
            rules: {
                event_title: {
                    required: true,
                    minlength: 2
                },
                event_desc: {
                    required: true
                },
                event_start: {
                    required: true,
                    date: true
                },
                event_end: {
                    required: true,
                    date: true,
                    greaterThan: "#event_start" // Custom rule to ensure end date is after start date
                },
                event_response: {
                    required: true
                },
                category_name: {
                    required: true
                },
                departmen_name: {
                    required: true
                },
                logo: {
                    required: true,
                    extension: "jpg|jpeg|png|gif" // Adjust based on allowed file types
                },
                'p_quation[]': {
                    required: true
                },
                'p_required[]': {
                    required: true
                },
                'p_option[]': {
                    required: false
                },
                'p_option_type[]': {
                    required: true
                },
                'quation[]': {
                    required: true
                },
                'required[]': {
                    required: true
                },
                'option[]': {
                    required: false
                },
                'option_type[]': {
                    required: true
                }
            },
            messages: {
                event_title: {
                    required: "Please enter the event title",
                    minlength: "Event title must be at least 2 characters long"
                },
                event_desc: "Please enter the event description",
                event_start: {
                    required: "Please select the start date",
                    date: "Please enter a valid date"
                },
                event_end: {
                    required: "Please select the end date",
                    date: "Please enter a valid date",
                    greaterThan: "End date must be after the start date"
                },
                event_response: "Please enter the event response",
                category_name: "Please select a category",
                departmen_name: "Please select a department",
                logo: {
                    required: "Please upload a logo",
                    extension: "Please upload a valid image file (jpg, jpeg, png, gif)"
                },
                'p_quation[]': {
                    required: "Please enter the quation"
                },
                'p_required[]': {
                    required: "Please enter the required"
                },
                'p_option[]': {
                    required: "Please enter the option"
                },
                'p_option_type[]': {
                    required: "Please enter the option type"
                },
                'quation[]': {
                    required: "Please enter the quation"
                },
                'required[]': {
                    required: "Please enter the required"
                },
                'option[]': {
                    required: "Please enter the option"
                },
                'option_type[]': {
                    required: "Please enter the option type"
                }
            },
        });

        // DatePicker for end date & start date
        let endDatePickr = $('#event_end').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            minDate: 0,
            autoClose: true,
        });

        $('#event_start').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            minDate: 0,
            autoClose: true,
            onSelect: function(selected) {
                endDatePickr.datepicker("option", "minDate", selected);
            }
        });
    </script>
@endsection
@endsection