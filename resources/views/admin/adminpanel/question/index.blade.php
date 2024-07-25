@extends('layouts.admin')
@section('content')
<style>

</style>
<br>
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid">
      <form action="/question/update" method="post">
        <input type="hidden" name="event_id" value="{{$data->id}}">
        @csrf

      @foreach($data->questions as $val)
      <div class="row row{{$val->id}}">
        <div class="col-sm-4">
        <!-- text input -->
        <div class="form-group">
          <label></label>
          <input type="text" name="quation[]" class="form-control quation" placeholder="Enter ..."
          value="{{$val->name}}">
        </div>
        </div>
        <div class="col-sm-2">
        <div class="form-group">
          <div class="form-group">
          <label></label>
          <select class="form-control" name="required[]">
            <option value="1" {{ ($val->required == 1) ? 'selected' : '' }}>yes</option>
            <option value="0" {{ ($val->required == 0) ? 'selected' : '' }}>no</option>
          </select>
          </div>
        </div>
        </div>
        <div class="col-sm-3">
        <div class="form-group">
          <label></label>
          <input type="text" name="option[]" class="form-control" placeholder="Enter ..."
          value="{{$val->option_name}}">
        </div>
        </div>
        <div class="col-sm-2">
        <div class="form-group">
          <label></label>
          <select class="form-control" name="option_type[]">
          <option value="input" {{ ($val->option_types == 'input') ? 'selected' : '' }}>input</option>
          <option value="textarea" {{ ($val->option_types == 'textarea') ? 'selected' : '' }}>text area</option>
          <option value="checkbox" {{ ($val->option_types == 'checkbox') ? 'selected' : '' }}>check box</option>
          <option value="dropdown" {{ ($val->option_types == 'dropdown') ? 'selected' : '' }}>dropdown</option>
          <option value="radio" {{ ($val->option_types == 'radio') ? 'selected' : '' }}>radio</option>
          <option value="file" {{ ($val->option_types == 'file') ? 'selected' : '' }}>file</option>
          </select>
        </div>
        </div>
        <div class="col-sm-1">
        <div class="form-group">
          <label></label><br>
          <!-- <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="red"
          class="bi bi-x-circle-fill remove_button" viewBox="0 0 16 16">
          <path
            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
          </svg> -->

          <svg data-id="{{$val->id}}" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="red" class="bi bi-trash-fill delete_button" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
</svg>
        </div>
        </div>
      </div>
        @endforeach

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
                <option value="input">input</option>
                <option value="textarea">text area</option>
                <option value="checkbox">check box</option>
                <option value="dropdown">dropdown</option>
                <option value="radio">radio</option>
                <option value="file">file</option>
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

        <div class="field_wrapper"></div>
        <button type="submit" class="btn btn-primary">Update</button>

      </form>

    </div>
  </section>
</div>
@section('content-js')
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
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var x = 1; //Initial field counter is 1


    // Once add button is clicked
    $(addButton).click(function () {
      console.log('enter 45')
      //Check maximum number of input fields
      if (x < maxField) {
        var fieldHTML = '<div id="removecls' + x + '">  <div class="row "> <div class="col-sm-4"> <!-- text input --> <div class="form-group"> <label></label> <input type="text" name="quation[]" class="form-control quation" placeholder="Enter ..."> </div> </div> <div class="col-sm-2"> <div class="form-group"> <div class="form-group"> <label></label> <select class="form-control" name="required[]"> <option value="1">yes</option> <option value="0">no</option> </select> </div> </div> </div> <div class="col-sm-3"> <div class="form-group"> <label></label> <input type="text" name="option[]" class="form-control" placeholder="Enter ..." > </div> </div> <div class="col-sm-2"> <div class="form-group"> <label></label> <select class="form-control" name="option_type[]"> <option value="input">input</option> <option value="textarea">text area</option> <option value="checkbox">check box</option> <option value="dropdown">dropdown</option> <option value="radio">radio</option> <option value="file">file</option> </select> </div> </div> <div class="col-sm-1"> <div class="form-group"> <br> <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="red" class="bi bi-x-circle-fill remove_button" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/></svg></div> </div> </div></div>'; //New input field html 
        x++; //Increase field counter
        $(wrapper).append(fieldHTML); //Add field html
      } else {
        alert('A maximum of ' + maxField + ' fields are allowed to be added. ');
      }
    });

    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function (e) {
      e.preventDefault();
      console.log(x)
      x--;
      $('#removecls' + x).remove();
    });


$(document).on( 'click', '.delete_button', function () { 
  var id = $(this).attr("data-id");
  $.ajax({
        url : "{{ url('question/delete') }}",
        data : {
            'id' : id,
            "_token": "{{ csrf_token() }}",
        },
        
        type : 'POST',
        dataType : 'json',
        success : function(result){
          $('.row'+id).remove()
        }
    });

});

});
</script>
@endsection
@endsection