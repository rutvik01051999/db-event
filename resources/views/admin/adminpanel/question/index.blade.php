@extends('layouts.admin')
@section('content')
    <style>

    </style>
    <br>

    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-9">
                        <h1>{{ $data->name }}</h1>
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

                @if (Session::has('success'))
                    <div class="alert alert-success">
                        <span>{!! \Session::get('success') !!}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- <button type="button" class="btn btn-success add_button2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus " viewBox="0 0 16 16">
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4">
                        </path>
                    </svg>
                    Add Personal information
                </button> -->
            
                <p class="datacount"></p>

                <img src="{{ asset('storage/' . '1721644554.jpeg') }}" width="120px" hight="120px" alt="">

                <form action="/question/update" method="post" id="questionform">
                    <input type="hidden" name="event_id" value="{{ $data->id }}">
                    @csrf

                    @foreach ($data->personalinfo as $val)
                        <div class="row row{{ $val->id }}">
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label></label>
                                    <input type="text" name="p_quation[]" class="form-control quation"
                                        placeholder="Enter ..." value="{{ $val->name }}" data-translatable="true"
                                        id="p_quation_{{ $val->id }}">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label></label>
                                        <select class="form-control" name="p_required[]">
                                            <option value="1" {{ $val->required == 1 ? 'selected' : '' }}>yes
                                            </option>
                                            <option value="0" {{ $val->required == 0 ? 'selected' : '' }}>no</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label></label>
                                    <input type="text" name="p_option[]" class="form-control" placeholder="Enter ..."
                                        value="{{ $val->option_name }}" data-translatable="true"
                                        id="p_option_{{ $val->id }}">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label></label>
                                    <select class="form-control" name="p_option_type[]">
                                        @foreach (config('per_option') as $key => $option)
                                            <option value="{{ $key }}"
                                                {{ $val->option_types == $key ? 'selected' : '' }}>{{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-sm-1">
                                <div class="form-group">
                                    <label></label><br>
                                    <svg data-id="{{ $val->id }}" xmlns="http://www.w3.org/2000/svg" width="32"
                                        height="32" fill="red" class="bi bi-trash-fill delete_button2"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                        <path
                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                    </svg>
                                </div>
                            </div> -->
                        </div>
                    @endforeach

                    <div class="field_wrapper2"></div>
                    <br>
                    <button type="button" class="btn btn-success add_button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus " viewBox="0 0 16 16">
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4">
                            </path>
                        </svg>
                        Add Questions
                    </button><br><br>

                    @foreach ($data->questions as $val)
                        <div class="row row{{ $val->id }}">
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label></label>
                                    <input type="text" name="quation[]" class="form-control quation"
                                        placeholder="Enter ..." value="{{ $val->name }}" data-translatable="true"
                                        id="q_quation_{{ $val->id }}">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label></label>
                                        <select class="form-control" name="required[]">
                                            <option value="1" {{ $val->required == 1 ? 'selected' : '' }}>yes
                                            </option>
                                            <option value="0" {{ $val->required == 0 ? 'selected' : '' }}>no
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label></label>
                                    <input type="text" name="option[]" class="form-control" placeholder="Enter ..."
                                        value="{{ $val->option_name }}" data-translatable="true"
                                        id="q_option_{{ $val->id }}">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label></label>
                                    <select class="form-control" name="option_type[]">

                                        @foreach (config('question_option') as $key => $option)
                                            <option value="{{ $key }}"
                                                {{ $val->option_types == $key ? 'selected' : '' }}>{{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="form-group">
                                    <label></label><br>
                                    <svg data-id="{{ $val->id }}" xmlns="http://www.w3.org/2000/svg" width="32"
                                        height="32" fill="red" class="bi bi-trash-fill delete_button"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                        <path
                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="field_wrapper"></div>
                    <button type="submit" class="btn btn-primary">Update</button>

                </form>

            </div>
        </section>
    </div><br>
@section('content-js')
    <script>
        $(document).ready(function() {
            var array_count = $('input[name="quation[]"]').length;
            if (array_count == 0) {
                $('.btn-primary').hide()
                // $('.datacount').html('No data found')

            }
            setTimeout(function() {
                $('.alert-danger').remove()
                $('.alert-success').remove()
            }, 4000);

            $(function() {
                $(".datepicker").datepicker({
                    minDate: 0,
                    dateFormat: 'yy-mm-dd',
                    onSelect: function(date) {
                        console.log(date)
                    }
                });

            });


            var maxField = 100; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var addButton2 = $('.add_button2'); //Add button selector
            var wrapper2 = $('.field_wrapper2'); //Input field wrapper
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var x = 1; //Initial field counter is 1
            var y = 1; //Initial field counter is 1


            // Once add button is clicked
            $(addButton).click(function() {
                $('.btn-primary').show()
                $('.datacount').html('')
                //Check maximum number of input fields
                if (x < maxField) {
                    var fieldHTML = '<div id="removecls' + x +
                        '">  <div class="row "> <div class="col-sm-4"> <!-- text input --> <div class="form-group"> <label></label> <input type="text" name="quation[]" class="form-control quation" placeholder="Enter ..." data-translatable="true" id="q_quation_' +
                        (x + 1) +
                        '"> </div> </div> <div class="col-sm-2"> <div class="form-group"> <div class="form-group"> <label></label> <select class="form-control" name="required[]"> <option value="1">yes</option> <option value="0">no</option> </select> </div> </div> </div> <div class="col-sm-3"> <div class="form-group"> <label></label> <input type="text" name="option[]" class="form-control" placeholder="Enter ..."  data-translatable="true" id="q_option_' +
                        x +
                        '"> </div> </div> <div class="col-sm-2"> <div class="form-group"> <label></label> <select class="form-control question_option' +
                        x +
                        '" name="option_type[]"> </select> </div> </div> <div class="col-sm-1"> <div class="form-group"> <br> <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="red" class="bi bi-x-circle-fill remove_button" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/></svg></div> </div> </div></div>'; //New input field html 
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
                $('.btn-primary').show()
                $('.datacount').html('')
                //Check maximum number of input fields
                if (y < maxField) {
                    var fieldHTML = '<div id="removecls2' + y +
                        '">  <div class="row "> <div class="col-sm-4"> <!-- text input --> <div class="form-group"> <label></label> <input type="text" name="p_quation[]" class="form-control quation" placeholder="Enter ..." data-translatable="true" id="p_quation_' +
                        (y + 1) +
                        '">  </div> </div> <div class="col-sm-2"> <div class="form-group"> <div class="form-group"> <label></label> <select class="form-control" name="p_required[]"> <option value="1">yes</option> <option value="0">no</option> </select> </div> </div> </div> <div class="col-sm-3"> <div class="form-group"> <label></label> <input type="text" name="p_option[]" class="form-control" placeholder="Enter ..." data-translatable="true" id="p_option_' +
                        y +
                        '"> </div> </div> <div class="col-sm-2"> <div class="form-group"> <label></label> <select class="form-control per_option' +
                        y +
                        '" name="p_option_type[]"> </select> </div> </div> <div class="col-sm-1"> <div class="form-group"> <br> <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="red" class="bi bi-x-circle-fill remove_button" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/></svg></div> </div> </div></div>'; //New input field html 
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
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                console.log(x)
                x--;
                $('#removecls' + x).remove();
                var array_count = $('input[name="quation[]"]').length;
                if (array_count == 0) {
                    $('.btn-primary').hide()
                    // $('.datacount').html('No data found')
                }
            });


            $(document).on('click', '.delete_button', function() {
                var id = $(this).attr("data-id");
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ url('question/delete') }}",
                            data: {
                                'id': id,
                                "_token": "{{ csrf_token() }}",
                            },

                            type: 'POST',
                            dataType: 'json',
                            success: function(result) {
                                $('.row' + id).remove()
                                var array_count = $('input[name="quation[]"]').length;
                                console.log('array count' + array_count)
                                if (array_count == 0) {
                                    $('.btn-primary').hide()
                                    // $('.datacount').html('No data found')
                                }
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your record has been deleted.",
                                    icon: "success"
                                });
                            }
                        });
                    }
                });

            });


            $(document).on('click', '.delete_button2', function() {
                var id = $(this).attr("data-id");
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ url('personal/info/delete') }}",
                            data: {
                                'id': id,
                                "_token": "{{ csrf_token() }}",
                            },

                            type: 'POST',
                            dataType: 'json',
                            success: function(result) {
                                $('.row' + id).remove()
                                var array_count = $('input[name="quation[]"]').length;
                                console.log('array count' + array_count)
                                if (array_count == 0) {
                                    $('.btn-primary').hide()
                                    // $('.datacount').html('No data found')
                                }
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your record has been deleted.",
                                    icon: "success"
                                });
                            }
                        });
                    }
                });
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
        var formformValidaor = $("form#questionform").validate({
            rules: {
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
    </script>
@endsection
@endsection
