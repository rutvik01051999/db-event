@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-9">
                        <h1>Events</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                @if (session()->has('success'))
                    <div class="alert alert-success">
                        <span>{{ session()->get('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card shadow-lg">
                    <div class="card-body">
                        {{ $dataTable->table([
                            'class' => 'table table-bordered table-striped table-condensed table-hover dataTable dtr-inline',
                        ]) }}
                    </div>
                    <!-- /.card-body -->

                    <div class="model-append">

                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush

@section('content-js')
    <script>
        var url = '{{ env('APP_URL') }}';

        //edit event
        $(document).ready(function() {

            window.showTable = function() {
                window.LaravelDataTables["event-table"].draw();
            }

            $(document).on('click', '.editor-edit', function() {
                var id = $(this).attr("data-id");
                $.ajax({
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    url: "{{ url('event/edit') }}",
                    data: {
                        'id': id,
                        "_token": "{{ csrf_token() }}",
                    },

                    type: 'POST',
                    dataType: 'json',
                    success: function(result) {

                        $('.model-append').html(result.html)
                        $('#eventeditmodel').modal('show');

                        onLoad();
                    }
                });
            });
        });

        //datepicker
        $(function() {
            $("body").delegate(".datepicker", "focusin", function() {
                // $(this).datepicker();
                $(".datepicker").datepicker({
                    minDate: 0,
                    dateFormat: 'yy-mm-dd',
                    onSelect: function(date) {
                        console.log(date)
                    }
                });
            });
        });

        $(document).on('click', '.editor-delete', function() {
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
                        url: "{{ url('event/delete') }}",
                        data: {
                            'id': id,
                            "_token": "{{ csrf_token() }}",
                        },
                        type: 'POST',
                        dataType: 'json',
                        success: function(result) {
                            // Reload table
                            window.showTable();

                            Swal.fire({
                                title: "Deleted!",
                                text: "Event has been deleted.",
                                icon: "success"
                            });
                        }
                    });
                }
            });
        });

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

        function changeStatus(id, status) {
            let url = "{{ route('event.change-status', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response, status, xhr) {
                    if (xhr.status === 200) {
                        Swal.fire({
                            title: response.title,
                            text: response.message,
                            icon: 'success'
                        });
                        window.showTable();
                        return;
                    }
                    window.showTable();
                },
                error: function(response) {
                    Swal.fire({
                        title: response.responseJSON.title,
                        text: response.responseJSON.message,
                        icon: 'error'
                    });
                }
            });
        }
    </script>
@endsection
@endsection
