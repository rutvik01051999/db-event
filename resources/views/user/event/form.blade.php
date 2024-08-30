@extends('layouts.app')

@section('content')
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
                                        <p>Your code was sent to you via Mobile</p>
                                        <div class="error_otp" style="color:red"></div>

                                        <div class="otp-field mb-4">
                                            <input type="number" id="otp_1" />
                                            <input type="number" id="otp_2" disabled />
                                            <input type="number" id="otp_3" disabled />
                                            <input type="number" id="otp_4" disabled />
                                            <input type="number" id="otp_5" disabled />
                                            <input type="number" id="otp_6" disabled />
                                        </div>

                                        <button class="btn btn-primary mb-3 get_otp_check">
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

    <div class="row">
        <div class="col-12">
            <div class="mb-3 p-3">
                <div class="row align-items-center">
                    <div class="col-sm-12 col-md-4 text-center">
                        <img src="{{ Storage::url($data->image) }}" alt="event logo" class="img-fluid rounded"
                            style="max-height: 500px;">
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <h2 class="text-primary font-weight-bold">{{ $data->name }}</h2>
                        <p class="text-muted">{{ $data->description }}</p>
                    </div>
                </div>
            </div>

            <form method="post" action="{{ route('user.event.submit') }}" enctype="multipart/form-data" id="userform">
                @csrf
                <input type="hidden" value="{{ $data->id }}" name="event_id">
                <input type="hidden" value="" id="otp_mobile" name="otp_mobile">
                <input type="hidden" value="" name="otp_verify" id="otp_verify">

                <div class="card shadow-lg">
                    <div class="card-header text-center">
                        <h4 class="m-0 font-weight-bold text-primary">Personal Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($data->personalinfo as $key => $perinfo)
                                @if ($perinfo->option_types == 'input')
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="name">
                                                {{ $perinfo->name }}
                                                @if ($perinfo->required)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <input type="text" name="{{ $perinfo->input_name }}"
                                                class="form-control {{ strtolower($perinfo->name) }}"
                                                id="{{ $perinfo->input_name }}"
                                                {{ $perinfo->required == 1 ? 'required' : '' }}
                                                @if ('area' == strtolower($perinfo->name)) readonly @endif
                                                placeholder="{{ $perinfo->name }}">
                                        </div>
                                    </div>
                                @elseif($perinfo->option_types == 'rating')
                                    <div class="col-md-6 col-sm-12">
                                        <label for="name">
                                            {{ $perinfo->name }}
                                            @if ($perinfo->required)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input type="hidden" name="{{ $perinfo->input_name }}"
                                            id="perinfo_rating_{{ $perinfo->index_no }}" value="">
                                        <div class="rating-box">
                                            <div class="stars" data-id="1">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="fa fa-star perstar prstar{{ $i + 1 }}{{ $perinfo->index_no }}"
                                                        data-id="{{ $i + 1 }}_{{ $perinfo->index_no }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                @elseif($perinfo->option_types == 'mobile_otp')
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="name">
                                                {{ $perinfo->name }}
                                                @if ($perinfo->required)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="mobile_otp"
                                                    name="{{ $perinfo->input_name }}"
                                                    {{ $perinfo->required == 1 ? 'required' : '' }}
                                                    placeholder="{{ $perinfo->name }}">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary get_otp">Get OTP</button>
                                                </div>
                                            </div>
                                            <div class="mobile_otp_error" style="color: red;"></div>
                                        </div>
                                    </div>
                                @elseif($perinfo->option_types == 'textarea')
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="file">
                                                {{ $perinfo->name }}
                                                @if ($perinfo->required)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <textarea placeholder="{{ $perinfo->name }}" id="{{ $perinfo->input_name }}" class="form-control"
                                                name="{{ $perinfo->input_name }}" rows="1" {{ $perinfo->required == 1 ? 'required' : '' }}></textarea>
                                        </div>
                                    </div>
                                @elseif($perinfo->option_types == 'number')
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="number">
                                                {{ $perinfo->name }}
                                                @if ($perinfo->required)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <input type="number" class="form-control" id="{{ $perinfo->input_name }}"
                                                name="{{ $perinfo->input_name }}"
                                                {{ $perinfo->required == 1 ? 'required' : '' }}
                                                placeholder="{{ $perinfo->name }}">
                                        </div>
                                    </div>
                                @elseif($perinfo->option_types == 'mobile')
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="mobile">
                                                {{ $perinfo->name }}
                                                @if ($perinfo->required)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <input type="number" class="form-control" id="{{ $perinfo->input_name }}"
                                                name="{{ $perinfo->input_name }}"
                                                {{ $perinfo->required == 1 ? 'required' : '' }}
                                                placeholder="{{ $perinfo->name }}">
                                        </div>
                                    </div>
                                @elseif($perinfo->option_types == 'dropdown')
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="{{ $perinfo->input_name }}">
                                                {{ $perinfo->name }}
                                                @if ($perinfo->required)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <select id="{{ $perinfo->input_name }}" name="{{ $perinfo->input_name }}"
                                                class="form-select" {{ $perinfo->required == 1 ? 'required' : '' }}>
                                                <option value="" selected>select option</option>
                                                @foreach ($perinfo->options as $option)
                                                    <option>{{ $option->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @elseif($perinfo->option_types == 'checkbox')
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="inputState">
                                                {{ $perinfo->name }}
                                                @if ($perinfo->required)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            @foreach ($perinfo->options as $index => $option)
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="{{ $perinfo->input_name }}"
                                                        class="custom-control-input" value="{{ $option->index_no }}"
                                                        id="checkbox-{{ $option->id }}">
                                                    <label class="custom-control-label"
                                                        for="checkbox-{{ $option->id }}">{{ $option->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif($perinfo->option_types == 'radio')
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="col-sm-2">
                                                {{ $perinfo->name }}
                                                @if ($perinfo->required)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <div class="col-sm-10">
                                                @foreach ($perinfo->options as $option)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input radio{{ $option->index_no }}"
                                                            type="radio" name="{{ $perinfo->input_name }}"
                                                            id="radio-{{ $option->id }}"
                                                            value="{{ $option->name }}"
                                                            {{ $perinfo->required == 1 ? 'required' : '' }}>
                                                        <label class="form-check-label" for="radio-{{ $option->id }}">
                                                            {{ $option->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @elseif ($perinfo->option_types == 'pincode')
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="pincode">
                                                {{ $perinfo->name }}
                                                @if ($perinfo->required)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <span class="pincode-loader" style="display:none;"><i
                                                    class="fas fa-spinner fa-pulse"></i></span>
                                            <input type="text" class="form-control pincode"
                                                id="{{ $perinfo->input_name }}" name="{{ $perinfo->input_name }}"
                                                {{ $perinfo->required == 1 ? 'required' : '' }}
                                                placeholder="{{ $perinfo->name }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12 addresses-div" style="display:none">
                                        <div class="form-group">
                                            <label for="addresses">
                                                Select Area
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select addresses" name="addresses">
                                            </select>
                                        </div>
                                    </div>
                                @elseif($perinfo->option_types == 'date')
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="inputState">
                                                {{ $perinfo->name }}
                                                @if ($perinfo->required)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <input type="text" name="{{ $perinfo->input_name }}"
                                                class="form-control datepicker" placeholder="{{ $perinfo->name }}"
                                                id="{{ $perinfo->input_name }}" readonly
                                                {{ $perinfo->required == 1 ? 'required' : '' }}
                                                placeholder="{{ $perinfo->name }}">
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="card-header text-center">
                        <h4 class="m-0 font-weight-bold text-primary">Questions</h4>
                    </div>

                    <div class="card-body">
                        @foreach ($data->questions as $key => $perinfo)
                            @if ($perinfo->option_types == 'input')
                                <div class="form-group mb-3">
                                    <label for="formGroupExampleInput2">
                                        {{ $perinfo->name }}
                                        @if ($perinfo->required)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <input type="text" class="form-control" id="formGroupExampleInput2"
                                        name="que_input_{{ $perinfo->index_no }}"
                                        {{ $perinfo->required == 1 ? 'required' : '' }}
                                        placeholder="{{ $perinfo->name }}">
                                </div>
                            @elseif($perinfo->option_types == 'textarea')
                                <div class="form-group mb-3">
                                    <label for="file">
                                        {{ $perinfo->name }}
                                        @if ($perinfo->required)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <textarea id="w3review" class="form-control" name="que_textarea_{{ $perinfo->index_no }}"
                                        {{ $perinfo->required == 1 ? 'required' : '' }} placeholder="{{ $perinfo->name }}"></textarea>
                                </div>
                            @elseif($perinfo->option_types == 'rating')
                                <label for="name">
                                    {{ $perinfo->name }}
                                    @if ($perinfo->required)
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>
                                <input type="hidden" name="que_rating_{{ $perinfo->index_no }}"
                                    id="que_rating_{{ $perinfo->index_no }}" value="">
                                <div class="rating-box">
                                    <div class="stars" data-id="1">
                                        @for ($i = 0; $i < 5; $i++)
                                            <i class="fa fa-star questar qrstar{{ $i + 1 }}{{ $perinfo->index_no }}"
                                                data-id="{{ $i + 1 }}_{{ $perinfo->index_no }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            @elseif($perinfo->option_types == 'number')
                                <div class="form-group mb-3">
                                    <label for="formGroupExampleNumber2">
                                        {{ $perinfo->name }}
                                        @if ($perinfo->required)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <input type="number" class="form-control" id="formGroupExampleNumber2"
                                        name="que_num_{{ $perinfo->index_no }}"
                                        {{ $perinfo->required == 1 ? 'required' : '' }}
                                        placeholder="{{ $perinfo->name }}">
                                </div>
                            @elseif($perinfo->option_types == 'dropdown')
                                <div class="form-group mb-3">
                                    <label for="inputState">
                                        {{ $perinfo->name }}
                                        @if ($perinfo->required)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <select id="inputState" class="form-select"
                                        {{ $perinfo->required == 1 ? 'required' : '' }}
                                        name="que_dropdown_{{ $perinfo->index_no }}">
                                        @foreach ($perinfo->options as $option)
                                            <option selected value="{{ $option->index_no }}">{{ $option->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif($perinfo->option_types == 'date')
                                <div class="form-group mb-3">
                                    <label for="inputState">
                                        {{ $perinfo->name }}
                                        @if ($perinfo->required)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <input type="text" class="form-control datepicker"
                                        {{ $perinfo->required == 1 ? 'required' : '' }}
                                        name="que_date_{{ $perinfo->index_no }}" placeholder="{{ $perinfo->name }}"
                                        id="datepicker2" readonly>
                                </div>
                            @elseif($perinfo->option_types == 'checkbox')
                                <div class="form-group mb-3">
                                    <label for="inputState">
                                        {{ $perinfo->name }}
                                        @if ($perinfo->required)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    @foreach ($perinfo->options as $option)
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                id="checkbox-{{ $option->id }}"
                                                name="que_checkbox_{{ $option->index_no }}_{{ $perinfo->index_no }}"
                                                value="{{ $option->index_no }}">
                                            <label class="custom-control-label"
                                                for="checkbox-{{ $option->id }}">{{ $option->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif($perinfo->option_types == 'radio')
                                <div class="form-group mb-3">
                                    <label for="inputState">
                                        {{ $perinfo->name }}
                                        @if ($perinfo->required)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    @foreach ($perinfo->options as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="que_radio_{{ $perinfo->index_no }}"
                                                id="radio-{{ $option->id }}" value="{{ $option->index_no }}"
                                                {{ $perinfo->required == 1 ? 'required' : '' }}>
                                            <label class="form-check-label" for="radio-{{ $option->id }}">
                                                {{ $option->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif($perinfo->option_types == 'file' || $perinfo->option_types == 'multiple_file')
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group mb-3">
                                        <label for="file">
                                            {{ $perinfo->name }}
                                            @if ($perinfo->required)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input type="file" class="form-control"
                                            name="{{ $perinfo->option_types }}s[]"
                                            {{ $perinfo->required == 1 ? 'required' : '' }}
                                            @if ($perinfo->option_types == 'multiple_file') multiple @endif>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="text-center mb-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
            </form>
        </div>
    </div>
@endsection

@section('content-js')
    <script>
        $('form').submit(function() {
            let check_otp = $('#otp_verify').val()
            console.log(check_otp)
            if (check_otp == 1) {
                return true
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Please verify OTP",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                console.log('enter 25')
                return false
            }
        });

        const inputs = document.querySelectorAll(".otp-field > input");
        const button = document.querySelector(".btn");

        window.addEventListener("load", () => inputs[0].focus());
        button.setAttribute("disabled", "disabled");

        inputs[0].addEventListener("paste", function(event) {
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

        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            onSelect: function(date) {
                console.log(date)
            },
            changeMonth: true,
            changeYear: true,
            autoClose: true,
            yearRange: "1900:2050"
        });


        $('.perstar').click(function() {
            let countstart = $(this).data("id") // will return the number 123
            let text = "How are you doing today?";
            const myArray = countstart.split("_");
            var index_star = myArray[0]
            var question_no = myArray[1]
            console.log(index_star, question_no, myArray)
            $('#perinfo_rating_' + question_no).val(index_star)
            //remove star

            for (var j = 0; j < 5; j++) {
                var jcount = j + 1
                $('.prstar' + jcount + question_no).removeClass('active')
            }

            console.log('index', index_star)


            for (var i = 0; i < index_star; i++) {
                var icount = i + 1
                console.log('.prstart' + icount + question_no)
                $('.prstar' + icount + question_no).addClass('active')
            }
        });

        $('.get_otp_check').click(function() {
            var mobile_num = $('#mobile_otp').val()
            var otp = $('#otp_1').val() + $('#otp_2').val() + $('#otp_3').val() + $('#otp_4').val() + $('#otp_5')
                .val() + $('#otp_6').val()
            if (!mobile_num) {
                alert('please enter mobile number')
            }
            if (!otp) {
                alert('please enter valid otp')
            }
            $.ajax({
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                url: "{{ url('api/check/otp') }}",
                data: {
                    'mobile_num': mobile_num,
                    "otp": otp,
                    "_token": "{{ csrf_token() }}",
                },
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    if (result.number == 'valid') {
                        $("#mobile_otp").prop('disabled', true);
                        $(".get_otp").prop('disabled', true);
                        $('#myModal').modal('hide');
                        $("#otp_mobile").val(mobile_num);
                        $('#otp_verify').val(1)
                        console.log(result)
                        if (result.userdata) {
                            $('#full_name').val(result.userdata.full_name)
                            $('#age').val(result.userdata.age)
                            // $('#gender').val(result.userdata.gender)
                            $('#pincode').val(result.userdata.pincode)
                            $('#city').val(result.userdata.city)
                            $('#state').val(result.userdata.state)
                            $('#area').val(result.userdata.area)
                            $('#dob').val(result.userdata.dob)
                            $('#address').val(result.userdata.address)
                            $(".radio" + result.userdata.gender).attr('checked', 'checked');
                        }

                        Swal.fire({
                            title: "Good job!",
                            text: "You clicked the button!",
                            icon: "success"
                        });

                    } else {
                        $('.error_otp').html('Please enter valid otp');
                        setTimeout(function() {
                            $('.error_otp').html('');
                        }, 3000);
                    }

                }
            });
        });

        $('.questar').click(function() {
            let countstart = $(this).data("id") // will return the number 123
            const myArray = countstart.split("_");
            var index_star = myArray[0]
            var question_no = myArray[1]
            console.log(index_star, question_no, myArray)
            $('#que_rating_' + question_no).val(index_star)
            //remove star

            for (var j = 0; j < 5; j++) {
                var jcount = j + 1
                //    console.log('.remove_rstar'+jcount+question_no)
                $('.qrstar' + jcount + question_no).removeClass('active')
            }

            console.log('index', index_star)


            for (var i = 0; i < index_star; i++) {
                var icount = i + 1
                console.log('.qrstart' + icount + question_no)
                $('.qrstar' + icount + question_no).addClass('active')
            }
        });

        // on pincode change .pincode
        $('.pincode').on('input', function() {
            var pincode = $(this).val();

            // If pincode is 6 digits then call api else return
            if (pincode.length != 6) {
                return;
            }

            let url = "https://api.postalpincode.in/pincode/" + pincode;

            $.ajax({
                type: "GET",
                url: url,
                beforeSend: function() {
                    // Show loader while waiting for response
                    $('.pincode-loader').show();
                },
                success: function(response) {
                    // Hide loader
                    $('.pincode-loader').hide();

                    response = response[0];
                    if (response.Status == 'Success') {
                        let addresses = response.PostOffice;

                        // Show addresses in dropdown
                        $('.addresses-div').show();

                        let addressDropdownEle = $('.addresses');

                        // Create the select dropdown for addresses
                        let select = '<option value="" data-state="">Select Area</option>';

                        for (let i = 0; i < addresses.length; i++) {
                            select += '<option value="' + addresses[i].Name + '" data-state="' +
                                addresses[i].State + '">' + addresses[i].Name +
                                '</option>';
                        }

                        addressDropdownEle.html(select);
                    }
                },
                error: function(xhr, status, error) {
                    // Hide loader
                    $('.pincode-loader').hide();
                }
            });
        });

        // On change addresses .addresses set value to area field
        $(document).on('change', '.addresses', function() {
            $('.area').val($(this).val());
            let selectedEle = $(this).find('option:selected');
            $('.state').val(selectedEle.data('state'));
        });

        $('.get_otp').click(function() {
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
                success: function(result) {
                    if (result.number == 'invalid') {
                        $('.mobile_otp_error').html('Please enter valid mobile number');
                        setTimeout(function() {
                            $('.mobile_otp_error').html('');

                        }, 3000);
                    } else {
                        $('#myModal').modal('show');
                    }
                }
            });
        });

        // If session has success

        @if (Session::has('success'))
            Swal.fire({
                text: "{{ Session::get('success') }}",
                icon: "success"
            });
        @endif
    </script>
@endsection
