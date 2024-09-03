@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-9">
                        <h1>State Wise Report</h1>
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
                                    <label for="period">Date Range</label>
                                    <input type="text" name="period" id="period" class="form-control"
                                        placeholder="Select Date Range" readonly>
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
                            <table id="state-report-table" class="table table-bordered table-striped">

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

        });
    </script>
@endsection
