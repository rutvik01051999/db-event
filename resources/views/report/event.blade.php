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
                                    <label for="department">Department</label>
                                    <select name="department" id="department" class="form-control">

                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="event">Event</label>
                                    <select name="event" id="event" class="form-control">

                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="period">Date Range</label>
                                    <input type="text" name="period" id="period" class="form-control" placeholder="Select Date Range" readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Apply --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-warning" id="apply">Apply</button>
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
        // Document on ready
        $(document).ready(function() {

            // Date range picker
            $('#period').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                },
            }, function(start, end, label) {
                $('#period').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            });

            // On cancel clear date range
            $('#period').on('cancel.daterangepicker', function(ev, picker) {
                $('#period').val('');
            });

            $('#department').select2({
                placeholder: "Select Department",
                allowClear: true,
                theme: 'bootstrap4',
                width: '100%',
                ajax: {
                    url: "{{ route('select2.departments') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            show_all: 0
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.departments,
                        };
                    },
                    cache: true,
                }
            })

            // On change departments reset events
            $('#department').on('change', function() {
                $('#event').val('').trigger('change');
            });

            $('#event').select2({
                placeholder: "Select Event",
                theme: 'bootstrap4',
                width: '100%',
                allowClear: true,
                ajax: {
                    url: "{{ route('select2.events') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            department_id: $('#department').val(),
                            show_all: 0
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

            // Apply
            $('#apply').on('click', function() {
                let eventId = $('#event').val();
                let period = $('#period').val();

                $.ajax({
                    url: "{{ route('report.event.fetch') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        event_id: eventId,
                        per_page: 10,
                        period: period
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        let columns = response.columns;
                        let columnData = response.data;
                        let total = response.total;
                        let perPage = response.perPage;

                        // If datatable already initialized
                        if ($.fn.dataTable.isDataTable('#report-table')) {
                            $('#report-table').DataTable().clear().destroy();
                        }

                        $('#report-table').empty();
                        $('#report-table tbody').empty();

                        var table = $('#report-table').DataTable({
                            destroy: true,
                            dom: 'Bfrtip',
                            retrieve: true,
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
                                extend: 'excel',
                                text: 'Export Excel',
                                className: 'btn btn-dark',
                                exportOptions: {
                                    columns: columns
                                },
                                action: function(e, dt, button, config) {
                                    let url =
                                        "{{ route('report.event.export') }}";
                                    let method = 'POST';

                                    $.ajax({
                                        url: url,
                                        type: method,
                                        data: {
                                            _token: "{{ csrf_token() }}",
                                            event_id: $('#event')
                                                .val(),
                                            type: 'excel'
                                        },
                                        xhrFields: {
                                            responseType: 'blob'
                                        },
                                        success: function(
                                            response) {
                                            let blob = new Blob(
                                                [
                                                    response
                                                ], {
                                                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                                                });

                                            let link = document
                                                .createElement(
                                                    'a');
                                            link.href = window
                                                .URL
                                                .createObjectURL(
                                                    blob);
                                            link.download =
                                                'event-report.xlsx';
                                            link.click();
                                        }
                                    })
                                }
                            }],
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
            });
        })
    </script>
@endsection
