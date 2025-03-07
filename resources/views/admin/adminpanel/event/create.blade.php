@extends('layouts.admin')
@section('content')
<style>
  .error {
    color: red;
  }
</style>

<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid">
      @if (\Session::has('success'))
      <div class="alert alert-success">

      <span>{!! \Session::get('success') !!}</span>

      </div>
      @endif
     <!-- #region -->
      <br>
      <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title">Event Create</h3>
        </div>

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
          <img src="{{ asset('storage/' . '1721644554.jpeg') }}" width="120px" hight="120px" alt="">

          <form id="event-details" method="post" action="store" enctype="multipart/form-data">
            @csrf
            <h3 class="">Event Master</h3><br>
            <div class="row">
              <div class="col-sm-4">
                <!-- text input -->
                <div class="form-group">
                  <label>Title</label>
                  <input type="text" class="form-control" name="event_title" placeholder="Enter ...">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Description</label>
                  <input type="text" name="event_desc" class="form-control" placeholder="Enter ...">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Logo</label>
                  <input type="file" name="logo" class="form-control" placeholder="Enter ...">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Start event</label>
                  <input type="text" name="event_start" class="form-control datepicker" placeholder="Enter ..."
                    id="datepicker">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>End event</label>
                  <input type="text" name="event_end" class="form-control datepicker" placeholder="Enter ..."
                    id="datepicker2">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Response</label>
                  <input type="text" name="event_response" class="form-control" placeholder="Enter ...">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="category_name">
                    @foreach ($category as $item)
            <option value="{{$item->id}}">{{$item->name}}</option>
          @endforeach
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Departmen</label>
                  <select class="form-control" name="departmen_name">
                    @foreach ($departmen as $item)
            <option value="{{$item->id}}">{{$item->name}}</option>
          @endforeach
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">

                </div>
              </div>
            </div>
            <h3 class="">Personal Info.
            </h3><br>

            <div class="row ">
              <div class="col-sm-4">
                <!-- text input -->
                <div class="form-group">
                  <label>question</label>
                  <input type="text" name="p_quation[]" class="form-control quation" placeholder="Enter ..."
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
                  <input type="text" name="p_option[]" class="form-control" placeholder="Enter ...">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label>Select option type</label>
                  <select class="form-control" name="p_option_type[]">
                  @foreach (config('per_option') as $key => $val)
                  <option value="{{$key}}">{{$val}}</option>
                  @endforeach                  
                  </select>
                </div>
              </div>
              <div class="col-sm-1">
                <div class="form-group">
                  <label>Action</label><br>
                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="green"
                    class="bi bi-plus-circle-fill add_button2" viewBox="0 0 16 16">
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
                  <input type="text" name="p_quation[]" class="form-control quation" placeholder="Enter ..."
                    value="Gender">
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
                  <input type="text" name="p_option[]" class="form-control" placeholder="Enter ...">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label></label>
                  <select class="form-control" name="p_option_type[]">
                  @foreach (config('per_option') as $key => $val)
                  <option value="{{$key}}">{{$val}}</option>
                  @endforeach       
                  </select>
                </div>
              </div>
              <div class="col-sm-1">
                <div class="form-group">
                  <label></label><br>
                  <svg xmlns="http://www.w3.org/2000/svg" data-id=1 width="32" height="32" fill="red"
                    class="bi bi-x-circle-fill remove_button2" viewBox="0 0 16 16">
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
                  <input type="text" name="p_quation[]" class="form-control quation" placeholder="Enter ..."
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
                  <input type="text" name="p_option[]" class="form-control" placeholder="Enter ...">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label></label>
                  <select class="form-control" name="p_option_type[]">
                  @foreach (config('per_option') as $key => $val)
                  <option value="{{$key}}">{{$val}}</option>
                  @endforeach       
                  </select>
                </div>
              </div>
              <div class="col-sm-1">
                <div class="form-group">
                  <label></label><br>
                  <svg xmlns="http://www.w3.org/2000/svg" data-id=2 width="32" height="32" fill="red"
                    class="bi bi-x-circle-fill remove_button2" viewBox="0 0 16 16">
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
                  <input type="text" name="p_quation[]" class="form-control quation" placeholder="Enter ..."
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
                  <input type="text" name="p_option[]" class="form-control" placeholder="Enter ...">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label></label>
                  <select class="form-control" name="p_option_type[]">
                  @foreach (config('per_option') as $key => $val)
                  <option value="{{$key}}">{{$val}}</option>
                  @endforeach       
                  </select>
                </div>
              </div>
              <div class="col-sm-1">
                <div class="form-group">
                  <label></label><br>
                  <svg xmlns="http://www.w3.org/2000/svg" data-id=3 width="32" height="32" fill="red"
                    class="bi bi-x-circle-fill remove_button2" viewBox="0 0 16 16">
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
                  <input type="text" name="p_quation[]" class="form-control quation" placeholder="Enter ..."
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
                  <input type="text" name="p_option[]" class="form-control" placeholder="Enter ...">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label></label>
                  <select class="form-control" name="p_option_type[]">
                  @foreach (config('per_option') as $key => $val)
                  <option value="{{$key}}">{{$val}}</option>
                  @endforeach       
                  </select>
                </div>
              </div>
              <div class="col-sm-1">
                <div class="form-group">
                  <label></label><br>
                  <svg xmlns="http://www.w3.org/2000/svg" data-id=4 width="32" height="32" fill="red"
                    class="bi bi-x-circle-fill remove_button2" viewBox="0 0 16 16">
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
                  <input type="text" name="p_quation[]" class="form-control quation" placeholder="Enter ..."
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
                  <input type="text" name="p_option[]" class="form-control" placeholder="Enter ...">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label></label>
                  <select class="form-control" name="p_option_type[]">
                  @foreach (config('per_option') as $key => $val)
                  <option value="{{$key}}">{{$val}}</option>
                  @endforeach       
                  </select>
                </div>
              </div>
              <div class="col-sm-1">
                <div class="form-group">
                  <label></label><br>
                  <svg xmlns="http://www.w3.org/2000/svg" data-id=5 width="32" height="32" fill="red"
                    class="bi bi-x-circle-fill remove_button2" viewBox="0 0 16 16">
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
                  <input type="text" name="p_quation[]" class="form-control quation" placeholder="Enter ..."
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
                  <input type="text" name="p_option[]" class="form-control" placeholder="Enter ...">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label></label>
                  <select class="form-control" name="p_option_type[]">
                  @foreach (config('per_option') as $key => $val)
                  <option value="{{$key}}">{{$val}}</option>
                  @endforeach       
                  </select>
                </div>
              </div>
              <div class="col-sm-1">
                <div class="form-group">
                  <label></label><br>
                  <svg xmlns="http://www.w3.org/2000/svg" data-id=6 width="32" height="32" fill="red"
                    class="bi bi-x-circle-fill remove_button2" viewBox="0 0 16 16">
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
                  <input type="text" name="p_quation[]" class="form-control quation" placeholder="Enter ..."
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
                  <input type="text" name="p_option[]" class="form-control" placeholder="Enter ...">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label></label>
                  <select class="form-control" name="p_option_type[]">
                  @foreach (config('per_option') as $key => $val)
                  <option value="{{$key}}">{{$val}}</option>
                  @endforeach       
                  </select>
                </div>
              </div>
              <div class="col-sm-1">
                <div class="form-group">
                  <label></label><br>
                  <svg xmlns="http://www.w3.org/2000/svg" data-id=7 width="32" height="32" fill="red"
                    class="bi bi-x-circle-fill remove_button2" viewBox="0 0 16 16">
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
                  <input type="text" name="p_quation[]" class="form-control quation" placeholder="Enter ..."
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
                  <input type="text" name="p_option[]" class="form-control" placeholder="Enter ...">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label></label>
                  <select class="form-control" name="p_option_type[]">
                  @foreach (config('per_option') as $key => $val)
                  <option value="{{$key}}">{{$val}}</option>
                  @endforeach       
                  </select>
                </div>
              </div>
              <div class="col-sm-1">
                <div class="form-group">
                  <label></label><br>
                  <svg xmlns="http://www.w3.org/2000/svg" data-id=8 width="32" height="32" fill="red"
                    class="bi bi-x-circle-fill remove_button2" viewBox="0 0 16 16">
                    <path
                      d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z">
                    </path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="field_wrapper2"></div>

            <h3 class="">Questions</h3><br>
            <div class="row ">
              <div class="col-sm-4">
                <!-- text input -->
                <div class="form-group">
                  <label>quation</label>
                  <input type="text" name="quation[]" class="form-control quation" placeholder="Enter ...">
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
                  <input type="text" name="option[]" class="form-control" placeholder="Enter ...">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label>Select option type</label>
                  <select class="form-control" name="option_type[]">
                  @foreach (config('question_option') as $key => $val)
                  <option value="{{$key}}">{{$val}}</option>
                  @endforeach       
                  </select>
                </div>
              </div>
              <div class="col-sm-1">
                <div class="form-group">
                  <label>Action</label><br>
                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="green"
                    class="bi bi-plus-circle-fill add_button" viewBox="0 0 16 16">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
  $(document).ready(function () {
    setTimeout(function () {
      $('.alert-danger').remove()
      $('.alert-success').remove()
    }, 4000);

    $(function () {
      $(".datepicker").datepicker({
        minDate: 0,
        dateFormat: 'yy-mm-dd',
        onSelect: function (date) {
          console.log(date)
        }
      });

    });

    var maxField = 100; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var addButton2 = $('.add_button2'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var wrapper2 = $('.field_wrapper2'); //Input field wrapper
    var x = 1; //Initial field counter is 1
    var y = 9; //Initial field counter is 9


    // Once add button is clicked
    $(addButton).click(function () {
      //Check maximum number of input fields
      if (x < maxField) {
        var fieldHTML = '<div id="removecls' + x + '">  <div class="row "> <div class="col-sm-4"> <!-- text input --> <div class="form-group"> <label></label> <input type="text" name="quation[]" class="form-control quation" placeholder="Enter ..."> </div> </div> <div class="col-sm-2"> <div class="form-group"> <div class="form-group"> <label></label> <select class="form-control" name="required[]"> <option value="1">yes</option> <option value="0">no</option> </select> </div> </div> </div> <div class="col-sm-3"> <div class="form-group"> <label></label> <input type="text" name="option[]" class="form-control" placeholder="Enter ..." > </div> </div> <div class="col-sm-2"> <div class="form-group"> <label></label> <select class="form-control" name="option_type[]"> <option value="input">input</option> <option value="textarea">text area</option> <option value="checkbox">check box</option> <option value="dropdown">dropdown</option> <option value="radio">radio</option> <option value="file">file</option> </select> </div> </div> <div class="col-sm-1"> <div class="form-group"> <br> <svg xmlns="http://www.w3.org/2000/svg" data-id =" ' + x  +'" width="32" height="32" fill="red" class="bi bi-x-circle-fill remove_button" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/></svg></div> </div> </div></div>'; //New input field html 
        x++; //Increase field counter
        $(wrapper).append(fieldHTML); //Add field html
      } else {
        alert('A maximum of ' + maxField + ' fields are allowed to be added. ');
      }
    });

    $(addButton2).click(function () {
      //Check maximum number of input fields
      if (y < maxField) {
        var fieldHTML = '<div id="removecls' + y + '">  <div class="row "> <div class="col-sm-4"> <!-- text input --> <div class="form-group"> <label></label> <input type="text" name="p_quation[]" class="form-control quation" placeholder="Enter ..."> </div> </div> <div class="col-sm-2"> <div class="form-group"> <div class="form-group"> <label></label> <select class="form-control" name="p_required[]"> <option value="1">yes</option> <option value="0">no</option> </select> </div> </div> </div> <div class="col-sm-3"> <div class="form-group"> <label></label> <input type="text" name="p_option[]" class="form-control" placeholder="Enter ..." > </div> </div> <div class="col-sm-2"> <div class="form-group"> <label></label> <select class="form-control" name="p_option_type[]"> <option value="input">input</option> <option value="textarea">text area</option> <option value="checkbox">check box</option> <option value="dropdown">dropdown</option> <option value="radio">radio</option> <option value="file">file</option> </select> </div> </div> <div class="col-sm-1"> <div class="form-group"> <br> <svg xmlns="http://www.w3.org/2000/svg" data-id ="' + y + '" width="32" height="32" fill="red" class="bi bi-x-circle-fill remove_button" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/></svg></div> </div> </div></div>'; //New input field html 
        y++; //Increase field counter
        $(wrapper2).append(fieldHTML); //Add field html
      } else {
        alert('A maximum of ' + maxField + ' fields are allowed to be added. ');
      }
    });

    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function (e) {
      e.preventDefault();
      var id = $(this).attr("data-id");
      x--;
      $('#removecls' + id).remove();
    });

    $(document).on('click', '.remove_button2', function (e) {
      var id = $(this).attr("data-id");
      e.preventDefault();
      y--;
      $('.removecls2' + id).remove();
    });
  });
</script>
@endsection
@endsection