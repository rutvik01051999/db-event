@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-9">
                        <h1>Edit Event</h1>
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
                <div class="card">
                    <div class="card-body">
                        <form method="post" id="eventeditform" enctype="multipart/form-data"
                            action="{{ route('event.update', ['id' => $event->id]) }}">
                            @csrf
                            <input type="hidden" value="{{ $event->id }}" id="event_id">
                            <div class="row">
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="event_title" placeholder="Title"
                                            value="{{ $event->name }}" id="event_title" data-translatable="true">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" name="event_desc" class="form-control"
                                            placeholder="Description" value="{{ $event->description }}"
                                            data-translatable="true" id="event_desc">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Uploaded image</label><br>
                                        <img width="80px" src="{{ Storage::url($event->image) }}" alt="event logo">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Start event</label>
                                        <input type="text" name="event_start" class="form-control datepicker"
                                            id="event_start" value="{{ $event->start_date }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>End event</label>
                                        <input type="text" name="event_end" class="form-control datepicker"
                                            id="event_end" value="{{ $event->close_date }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Response</label>
                                        <input type="text" name="event_response" class="form-control"
                                            placeholder="Event Response" id="event_response" data-translatable="true" value="{{ $event->response }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control" name="category_name" id="category_name">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $event->category_id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <select class="form-control" name="departmen_name" id="departmen_name">
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ $department->id == $event->department_id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Upload new image</label>
                                        <input type="file" name="logo" class="form-control" placeholder="Logo"
                                            id="logo">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer bg-white">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

@section('content-js')
    <script type="text/javascript">
        // Multiple languages
        var control;

        google.load("elements", "1", {
            packages: "transliteration",
        });

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

            // Fetch all modal input which have data-translatable attribute true and add transliteration
            let translatableFields = $(document).find('[data-translatable="true"]');
            let translatableFieldIds = [];

            translatableFields.each(function() {
                translatableFieldIds.push(this.id);
            });
            control.makeTransliteratable(translatableFieldIds);
        }

        // On select language inside modal
        $(document).on("change", "#languageDropDown", languageChangeHandler);

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

        // Validation
        var formformValidaor = $("form#eventeditform").validate({
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
                    extension: "jpg|jpeg|png|gif" // Adjust based on allowed file types
                },
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
                },
                event_response: "Please enter the event response",
                category_name: "Please select a category",
                departmen_name: "Please select a department",
                logo: {
                    extension: "Please upload a valid image file (jpg, jpeg, png, gif)"
                },
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
