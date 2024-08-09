@extends('layouts.user')
@section('content')
    <div class="container">
        <div class="event-name">
            <h2>{{ $data->name }}</h2>
        </div><br>
        <h4>Personal Information:</h4><br>
        <form method="post" action="user/event/store" enctype = "multipart/form-data" id="userform">
            @csrf

        <input type="hidden" value="{{$data->id}}" name="event_id">

        @foreach ($data->personalinfo as $key=>$perinfo)
            @if($perinfo->option_types == "input")
                <div class="form-group">
                    <label for="name">{{$perinfo->name}}</label>
                    <input type="text" class="form-control" id="name" name="per_input_{{$perinfo->index_no}}"  {{$perinfo->required == 1 ? 'required': ''}}>
                </div><br>

            @elseif($perinfo->option_types == "file")
            
                <div class="form-group">
                    <label for="file">{{$perinfo->name}}</label>
                    <input type="file" class="form-control" id="file" name="per_file_{{$perinfo->index_no}}"  {{$perinfo->required == 1 ? 'required': ''}}>
                </div><br>

            @elseif($perinfo->option_types == "textarea")
            
            <div class="form-group">
                <label for="file">{{$perinfo->name}}</label>
                <textarea id="w3review" class="form-control"  name="per_textarea_{{$perinfo->index_no}}" {{$perinfo->required == 1 ? 'required': ''}}></textarea>
            </div><br>

            @elseif($perinfo->option_types == "number")
                <div class="form-group">
                <label for="number">{{$perinfo->name}}</label>
                <input type="number" class="form-control" id="number" name="per_num_{{$perinfo->index_no}}"  {{$perinfo->required == 1 ? 'required': ''}}>
                </div><br>

            @elseif($perinfo->option_types == "mobile")
                <div class="form-group">
                <label for="mobile">{{$perinfo->name}}</label>
                <input type="number" class="form-control" id="mobile" name="per_mobile_{{$perinfo->index_no}}"  {{$perinfo->required == 1 ? 'required': ''}}>
                </div><br>

            @elseif($perinfo->option_types == "dropdown")
                <div class="form-group">
                    <label for="inputState">{{$perinfo->name}}</label>
                    <select id="inputState" name="per_dropdown_{{$perinfo->index_no}}" class="form-control" {{$perinfo->required == 1 ? 'required': ''}}>
                    @foreach ($perinfo->options as $option)
                       <option value="" selected>select option</option>
                        <option value="{{$option->index_no}}">{{$option->name}}</option>
                    @endforeach
                    </select>
                </div><br>

            @elseif($perinfo->option_types == "checkbox")
                <div class="form-group">
                    <label for="inputState">{{$perinfo->name}}</label>

                    @foreach ($perinfo->options as $index=>$option)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="per_checkbox_{{$option->index_no}}_{{$perinfo->index_no}}" class="custom-control-input" value="{{$option->index_no}}" id="customCheck1" >
                            <label class="custom-control-label" for="customCheck1">{{$option->name}}</label>
                        </div>
                    @endforeach

                    </div><br>
                @elseif($perinfo->option_types == 'radio')
                    <div class="form-group">
                        <label for="inputState">{{ $perinfo->name }}</label>

                        @foreach ($perinfo->options as $option)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="per_radio_{{$perinfo->index_no}}" id="exampleRadios1{{$key}}"
                                    value="{{$option->index_no}}" {{ $perinfo->required == 1 ? 'required' : '' }}>
                                <label class="form-check-label" for="exampleRadios1{{$key}}">
                                    {{ $option->name }}
                                </label>
                            </div>
                        @endforeach
                    </div><br>
                @endif
            @endforeach

        <h4>Question:</h4>
        <br>


        @foreach ($data->questions as $key=> $perinfo)
            @if($perinfo->option_types == "input")
                <div class="form-group">
                    <label for="formGroupExampleInput2">{{$perinfo->name}}</label>
                    <input type="text" class="form-control" id="formGroupExampleInput2" name="que_input_{{$perinfo->index_no}}"  {{$perinfo->required == 1 ? 'required': ''}}>
                </div><br>
            
            @elseif($perinfo->option_types == "textarea")
            
            <div class="form-group">
                <label for="file">{{$perinfo->name}}</label>
                <textarea id="w3review" class="form-control" name="que_textarea_{{$perinfo->index_no}}"   {{$perinfo->required == 1 ? 'required': ''}}></textarea>
            </div><br>
            
            @elseif($perinfo->option_types == "number")
                <div class="form-group">
                <label for="formGroupExampleNumber2">{{$perinfo->name}}</label>
                <input type="number" class="form-control" id="formGroupExampleNumber2" name="que_num_{{$perinfo->index_no}}"  {{$perinfo->required == 1 ? 'required': ''}}>
                </div><br>
                

            @elseif($perinfo->option_types == "dropdown")
                <div class="form-group">
                    <label for="inputState">{{$perinfo->name}}</label>
                    <select id="inputState" class="form-control" {{$perinfo->required == 1 ? 'required': ''}} name="que_dropdown_{{$perinfo->index_no}}">
                    @foreach ($perinfo->options as $option)
                        <option selected>{{$option->name}}</option>
                    @endforeach
                    </select>
                </div><br>
            
            @elseif($perinfo->option_types == "date")
                <div class="form-group">
                    <label for="inputState">{{$perinfo->name}}</label>
                    <input type="text" name="event_end" class="form-control datepicker" name="que_date_{{$perinfo->index_no}}" placeholder="Enter ..."
                    id="datepicker2">
            </div><br>

            @elseif($perinfo->option_types == "checkbox")
                <div class="form-group">
                    <label for="inputState">{{$perinfo->name}}</label>

                        @foreach ($perinfo->options as $option)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1"
                                     name="que_checkbox_{{$option->index}}_{{$perinfo->index_no}}">
                                <label class="custom-control-label" for="customCheck1">{{ $option->name }}</label>
                            </div>
                        @endforeach

                </div><br>

            @elseif($perinfo->option_types == "radio")
                <div class="form-group">
                    <label for="inputState">{{$perinfo->name}}</label>
                    @foreach ($perinfo->options as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  name="que_{{$perinfo->index_no}}" id="exampleRadios1{{$key}}" value="{{$option->index_no}}" {{$perinfo->required == 1 ? 'required': ''}}>
                            <label class="form-check-label" for="exampleRadios1{{$key}}">
                                {{$option->name}}
                            </label>
                        </div>
                    @endforeach

                    </div><br>
                @endif
            @endforeach

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@section('content-js')
<script>
  $(document).ready(function () {
   
    $(function () {
      $(".datepicker").datepicker({
        minDate: 0,
        dateFormat: 'yy-mm-dd',
        onSelect: function (date) {
          console.log(date)
        }
      });

    });

//form submit
//     $("#userform").on("submit", function(event) {
//     event.preventDefault();

//     // Validate form, returning on failure.
//     checked = $("input[type=checkbox]:checked").length;

// if(!checked) {
//     alert("You must check at least one checkbox.");
//     return false;
// }
// this.submit();
// });
  });
</script>
@endsection
@endsection
