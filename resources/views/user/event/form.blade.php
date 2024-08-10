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
</style>
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
                <input type="hidden" name="perinfo_rating_{{$perinfo->index_no}}" value="">
            <div class="rating-box">
      <header>{{$perinfo->name}}</header>
      <div class="stars" data-id="1">
        @for($i=0;$i<5;$i++ )
        <i class="fa-solid fa-star rstar{{$i+1}}{{$perinfo->index_no}}" data-id="{{$i+1}}_{{$perinfo->index_no}}"></i>
        @endfor
        
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
            <input type="hidden" name="que_rating_{{$perinfo->index_no}}" value="">
            <div class="rating-box">
      <header>{{$perinfo->name}}</header>
      <div class="stars" data-id="1">
        @for($i=0;$i<5;$i++ )
        <i class="fa-solid fa-star rstar{{$i+1}}{{$perinfo->index_no}}" data-id="{{$i+1}}_{{$perinfo->index_no}}"></i>
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

 // Select all elements with the "i" tag and store them in a NodeList called "stars"
//  const stars = document.querySelectorAll(".stars i");

// // Loop through the "stars" NodeList
// stars.forEach((star, index1) => {

//   // Add an event listener that runs a function when the "click" event is triggered
//   star.addEventListener("click", () => {
//     console.log('1',star)
   
//     // Loop through the "stars" NodeList Again
//     stars.forEach((star, index2) => {
//         console.log('2',star)

      
//       // Add the "active" class to the clicked star and any stars with a lower index
//       // and remove the "active" class from any stars with a higher index
//       index1 >= index2 ? star.classList.add("active") : star.classList.remove("active");
//     });
//   });
// });

$('.fa-star').click(function () {
    let countstart=$(this).data("id") // will return the number 123
    let text = "How are you doing today?";
    const myArray = countstart.split("_");
    var index_star =myArray[0]
    var question_no =myArray[1]
    console.log(index_star,question_no,myArray)
    //remove star

    for(var j = 0; j<5; j++){
      var jcount = j+1 
       console.log('.remove_rstar'+jcount+question_no)
       $('.rstar'+jcount+question_no).removeClass('active')       
    }


    for(var i = 0; i<index_star; i++){
      var icount = i+1 
       console.log('.rstart'+icount+question_no)
       $('.rstar'+icount+question_no).addClass('active')       
    }

});
  });
</script>
@endsection
@endsection
