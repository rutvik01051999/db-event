@extends('layouts.user')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
<style>
    /* Import Google font - Poppins */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
body {
  /* height: 100vh; */
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(45deg, #ffd195, #ffb283);
}
.rating-box {
  position: relative;
  background: #fff;
  padding: 25px 50px 35px;
  border-radius: 25px;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
}
.rating-box header {
  font-size: 22px;
  color: #dadada;
  font-weight: 500;
  margin-bottom: 20px;
  text-align: center;
}
.rating-box .stars {
  display: flex;
  align-items: center;
  gap: 25px;
}
.stars i {
  color: #e6e6e6;
  font-size: 35px;
  cursor: pointer;
  transition: color 0.2s ease;
}
.stars i.active {
  color: #ff9c1a;
}

.otp-field {
  flex-direction: row;
  column-gap: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.otp-field input {
  height: 45px;
  width: 42px;
  border-radius: 6px;
  outline: none;
  font-size: 1.125rem;
  text-align: center;
  border: 1px solid #ddd;
}
.otp-field input:focus {
  box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
}
.otp-field input::-webkit-inner-spin-button,
.otp-field input::-webkit-outer-spin-button {
  display: none;
}

.resend {
  font-size: 12px;
}

.footer {
  position: absolute;
  bottom: 10px;
  right: 10px;
  color: black;
  font-size: 12px;
  text-align: right;
  font-family: monospace;
}

.footer a {
  color: black;
  text-decoration: none;
}
</style>




<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
      <section class="container-fluid bg-body-tertiary d-block">
  <div class="row justify-content-center">
      <div class="col-12 col-md-6 col-lg-4" style="min-width: 500px;">
        <div class="card">
          <div class="card-body p-5 text-center">
            <h4>Verify</h4>
            <p>Your code was sent to you via email</p>

            <div class="otp-field mb-4">
              <input type="number" />
              <input type="number" disabled />
              <input type="number" disabled />
              <input type="number" disabled />
              <input type="number" disabled />
              <input type="number" disabled />
            </div>

            <button class="btn btn-primary mb-3">
              Verify
            </button>

            <p class="resend text-muted mb-0">
              Didn't receive code? <a href="">Request again</a>
            </p>
          </div>
        </div>
      </div>
    </div>
</section>
      </div>
    </div>
  </div>
</div>


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
            
                @elseif($perinfo->option_types == "rating")
                <input type="hidden" name="perinfo_rating_{{$perinfo->index_no}}" id="perinfo_rating_{{$perinfo->index_no}}" value="">
            <div class="rating-box">
      <header>{{$perinfo->name}}</header>
      <div class="stars" data-id="1">
        @for($i=0;$i<5;$i++ )
        <i class="fa-solid fa-star perstar prstar{{$i+1}}{{$perinfo->index_no}}" data-id="{{$i+1}}_{{$perinfo->index_no}}"></i>
        @endfor
      </div>
       </div>
        <br>


            @elseif($perinfo->option_types == "mobile_otp")
            <div class="form-group">
            <div class="row">
                <div class="col">
                <label for="name">{{$perinfo->name}}</label>
                <input type="text" class="form-control" id="mobile_otp" name="per_mobile_otp_{{$perinfo->index_no}}">
                </div>
                <div class="col">
                <label for="name"></label>
                <br>
                <button type="button" class="btn btn-primary get_otp">get otp</button>
                </div>
            </div>
            </div>
            <br>


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

            @elseif($perinfo->option_types == "rating")
            <input type="hidden" name="que_rating_{{$perinfo->index_no}}" id="que_rating_{{$perinfo->index_no}}" value="">
            <div class="rating-box">
      <header>{{$perinfo->name}}</header>
      <div class="stars" data-id="1">
        @for($i=0;$i<5;$i++ )
        <i class="fa-solid fa-star questar qrstar{{$i+1}}{{$perinfo->index_no}}" data-id="{{$i+1}}_{{$perinfo->index_no}}"></i>
        @endfor
      </div>
    </div>
            <br>
            
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
                    id="datepicker2" readonly>
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
                            <input class="form-check-input" type="radio"  name="que_radio_{{$perinfo->index_no}}" id="exampleRadios1{{$key}}" value="{{$option->index_no}}" {{$perinfo->required == 1 ? 'required': ''}}>
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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>

<script>
const inputs = document.querySelectorAll(".otp-field > input");
const button = document.querySelector(".btn");

window.addEventListener("load", () => inputs[0].focus());
button.setAttribute("disabled", "disabled");

inputs[0].addEventListener("paste", function (event) {
  event.preventDefault();

  const pastedValue = (event.clipboardData || window.clipboardData).getData(
    "text"
  );
  const otpLength = inputs.length;

  for (let i = 0; i < otpLength; i++) {
    if (i < pastedValue.length) {
      inputs[i].value = pastedValue[i];
      inputs[i].removeAttribute("disabled");
      inputs[i].focus;
    } else {
      inputs[i].value = ""; // Clear any remaining inputs
      inputs[i].focus;
    }
  }
});

inputs.forEach((input, index1) => {
  input.addEventListener("keyup", (e) => {
    const currentInput = input;
    const nextInput = input.nextElementSibling;
    const prevInput = input.previousElementSibling;

    if (currentInput.value.length > 1) {
      currentInput.value = "";
      return;
    }

    if (
      nextInput &&
      nextInput.hasAttribute("disabled") &&
      currentInput.value !== ""
    ) {
      nextInput.removeAttribute("disabled");
      nextInput.focus();
    }

    if (e.key === "Backspace") {
      inputs.forEach((input, index2) => {
        if (index1 <= index2 && prevInput) {
          input.setAttribute("disabled", true);
          input.value = "";
          prevInput.focus();
        }
      });
    }

    button.classList.remove("active");
    button.setAttribute("disabled", "disabled");

    const inputsNo = inputs.length;
    if (!inputs[inputsNo - 1].disabled && inputs[inputsNo - 1].value !== "") {
      button.classList.add("active");
      button.removeAttribute("disabled");

      return;
    }
  });
});
     $('#myModal').modal('show'); 
     
      $(".datepicker").datepicker({
        minDate: 0,
        dateFormat: 'yy-mm-dd',
        onSelect: function (date) {
          console.log(date)
        }
      });
      

$('.perstar').click(function () {
    let countstart=$(this).data("id") // will return the number 123
    let text = "How are you doing today?";
    const myArray = countstart.split("_");
    var index_star =myArray[0]
    var question_no =myArray[1]
    console.log(index_star,question_no,myArray)
    $('#perinfo_rating_'+question_no).val(index_star)
    //remove star

    for(var j = 0; j<5; j++){
      var jcount = j+1 
       $('.prstar'+jcount+question_no).removeClass('active')       
    }

    console.log('index',index_star)


    for(var i = 0; i<index_star; i++){
      var icount = i+1 
       console.log('.prstart'+icount+question_no)
       $('.prstar'+icount+question_no).addClass('active')       
    }
});


$('.get_otp').click(function () {
    var mobile_num = $('#mobile_otp').val()
    $.ajax({
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                url: "{{ url('api/send/number') }}",
                data: {
                    'mobile_num': mobile_num,
                    "_token": "{{ csrf_token() }}",
                },

                type: 'POST',
                dataType: 'json',
                success: function (result) {
                 console.log(result.number)
            

                 $('#myModal').modal('show'); 

                 if(result.number == 'invalid'){

                 }else{

                 }
                }
            });
});



$('.get_otp_check').click(function () {
    var mobile_num = $('#mobile_otp').val()
    var otp = $('#mobile_get_otp').val()
    if(!mobile_num){
       alert('please enter mobile number')
    }
    if(!otp){
        alert('please enter valid otp')
    }
    $.ajax({
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                url: "{{ url('api/check/otp') }}",
                data: {
                    'mobile_num': mobile_num,
                    "otp":otp,
                    "_token": "{{ csrf_token() }}",
                },

                type: 'POST',
                dataType: 'json',
                success: function (result) {
                    console.log(result.number)
                    if(result.number == 'valid'){
                        $("#mobile_otp").prop('disabled', true);
                        $("#mobile_get_otp").prop('disabled', true);
                    }
                   
                }
            });
});


$('.questar').click(function () {
    let countstart=$(this).data("id") // will return the number 123
    const myArray = countstart.split("_");
    var index_star =myArray[0]
    var question_no =myArray[1]
    console.log(index_star,question_no,myArray)
    $('#que_rating_'+question_no).val(index_star)
    //remove star

    for(var j = 0; j<5; j++){
      var jcount = j+1 
    //    console.log('.remove_rstar'+jcount+question_no)
       $('.qrstar'+jcount+question_no).removeClass('active')       
    }

    console.log('index',index_star)


    for(var i = 0; i<index_star; i++){
      var icount = i+1 
       console.log('.qrstart'+icount+question_no)
       $('.qrstar'+icount+question_no).addClass('active')       
    }
});

</script>
@endsection
@endsection
