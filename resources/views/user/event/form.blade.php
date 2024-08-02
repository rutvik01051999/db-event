@extends('layouts.user')
@section('content')
<div class="container">
    <div class="event-name">
        <h3>{{$data->name}}</h3>
    </div><br>
    <form method="post" action="user/event/store">
        @csrf

        @foreach ($data->personalinfo as $perinfo)
            @if($perinfo->option_types == "input")
                <div class="form-group">
                    <label for="formGroupExampleInput2">{{$perinfo->name}}</label>
                    <input type="text" class="form-control" id="formGroupExampleInput2" name="input_name{{$perinfo->id}}"  {{$perinfo->required == 1 ? 'required': ''}}>
                </div><br>

            @elseif($perinfo->option_types == "number")
                <div class="form-group">
                <label for="formGroupExampleNumber2">{{$perinfo->name}}</label>
                <input type="number" class="form-control" id="formGroupExampleNumber2" name="input_name{{$perinfo->id}}"  {{$perinfo->required == 1 ? 'required': ''}}>
                </div><br>

                @elseif($perinfo->option_types == "dropdown")
                <div class="form-group">
                    <label for="inputState">{{$perinfo->name}}</label>
                    <select id="inputState" class="form-control" {{$perinfo->required == 1 ? 'required': ''}}>
                    @foreach ($perinfo->options as $option)
                        <option selected>{{$option->name}}</option>
                    @endforeach
                    </select>
                </div><br>

            @elseif($perinfo->option_types == "checkbox")
                <div class="form-group">
                    <label for="inputState">{{$perinfo->name}}</label>

                    @foreach ($perinfo->options as $option)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" {{$perinfo->required == 1 ? 'required': ''}}>
                            <label class="custom-control-label" for="customCheck1">{{$option->name}}</label>
                        </div>
                    @endforeach

                </div><br>

            @elseif($perinfo->option_types == "radio")
                <div class="form-group">
                    <label for="inputState">{{$perinfo->name}}</label>

                    @foreach ($perinfo->options as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" {{$perinfo->required == 1 ? 'required': ''}}>
                            <label class="form-check-label" for="exampleRadios1">
                                {{$option->name}}
                            </label>
                        </div>
                    @endforeach
                </div><br>
            @endif

        @endforeach


        @foreach ($data->questions as $perinfo)
            @if($perinfo->option_types == "input")
                <div class="form-group">
                    <label for="formGroupExampleInput2">{{$perinfo->name}}</label>
                    <input type="text" class="form-control" id="formGroupExampleInput2"  {{$perinfo->required == 1 ? 'required': ''}}>
                </div><br>
            
                @elseif($perinfo->option_types == "number")
                <div class="form-group">
                <label for="formGroupExampleNumber2">{{$perinfo->name}}</label>
                <input type="number" class="form-control" id="formGroupExampleNumber2" name="input_name{{$perinfo->id}}"  {{$perinfo->required == 1 ? 'required': ''}}>
                </div><br>
                

            @elseif($perinfo->option_types == "dropdown")
                <div class="form-group">
                    <label for="inputState">{{$perinfo->name}}</label>
                    <select id="inputState" class="form-control" {{$perinfo->required == 1 ? 'required': ''}}>
                    @foreach ($perinfo->options as $option)
                        <option selected>{{$option->name}}</option>
                    @endforeach
                    </select>
                </div><br>
            
            @elseif($perinfo->option_types == "date")
                <div class="form-group">
                    <label for="inputState">{{$perinfo->name}}</label>
                    <input type="text" name="event_end" class="form-control datepicker" placeholder="Enter ..."
                    id="datepicker2">
            </div><br>

            @elseif($perinfo->option_types == "checkbox")
                <div class="form-group">
                    <label for="inputState">{{$perinfo->name}}</label>

                    @foreach ($perinfo->options as $option)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" {{$perinfo->required == 1 ? 'required': ''}}>
                            <label class="custom-control-label" for="customCheck1">{{$option->name}}</label>
                        </div>
                    @endforeach

                </div><br>

            @elseif($perinfo->option_types == "radio")
                <div class="form-group">
                    <label for="inputState">{{$perinfo->name}}</label>
                    @foreach ($perinfo->options as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" {{$perinfo->required == 1 ? 'required': ''}}>
                            <label class="form-check-label" for="exampleRadios1">
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
  });
</script>
@endsection
@endsection