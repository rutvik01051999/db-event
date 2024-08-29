@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-9">
                        <h1>Event Report</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="event">Event</label>
                                    <select name="event" id="event" class="form-control">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="report-table" class="table table-bordered table-striped">
    
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('content-js')
    <script>
        $('#event').select2({
            placeholder: "Select Event",
            theme: 'bootstrap4',
            ajax: {
                url: "{{ route('select2.events') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.events,
                    };
                },
                cache: true,
            },
        });

        $('#event').on('change', function() {
            let eventId = $(this).val();

            $.ajax({
                url: "{{ route('report.event.fetch') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    event_id: eventId,
                    per_page: 10
                },
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    let columns = response.columns;
                    let columnData = response.data;
                    let total = response.total;
                    let perPage = response.perPage;

                    $('#report-table').DataTable({
                        destroy: true,
                        serverSide: true, // Enable server-side processing
                        processing: true, // Show processing indicator
                        ajax: {
                            url: "{{ route('report.event.fetch') }}",
                            type: 'POST',
                            data: function(d) {
                                d._token = '{{ csrf_token() }}';
                                d.event_id = $('#event').val();
                            },
                            dataSrc: function(response) {
                                return response.data;
                            }
                        },
                        buttons: [{
                            extend: 'csv',
                            text: 'CSV',
                            className: 'btn btn-success',
                            action: function(e, dt, button, config) {
                                let eventId = $('#event')
                            .val(); // Get the selected event ID

                                $.ajax({
                                    url: "{{ route('report.event.export') }}",
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        event_id: eventId,
                                        type: 'csv'
                                    },
                                    xhrFields: {
                                        responseType: 'blob' // Important for file downloads
                                    },
                                    success: function(response) {
                                        let blob = new Blob([
                                        response], {
                                            type: 'text/csv'
                                        });
                                        let url = window.URL
                                            .createObjectURL(blob);
                                        let a = document.createElement(
                                            'a');
                                        a.href = url;
                                        a.download = 'event.csv';
                                        document.body.appendChild(a);
                                        a.click();
                                        window.URL.revokeObjectURL(url);
                                    }
                                });
                            }
                        }, ],
                        layout: {
                            topStart: 'buttons'
                        },
                        columns: response.columns,
                        pageLength: perPage,
                        paging: true, // Enable pagination
                        lengthChange: false, // Disable changing page length
                        searching: false, // Disable search
                        ordering: false, // Disable ordering
                    });

                }
            });

        })
    </script>
@endsection
