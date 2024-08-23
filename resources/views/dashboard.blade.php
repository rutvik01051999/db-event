@extends('layouts.admin')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary elevation-1">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Events</span>
                                <span class="info-box-number" id="total_events">
                                    0
                                </span>
                            </div>

                        </div>

                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1">
                                <i class="fa fa-regular fa-calendar-check"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Active Eevents</span>
                                <span class="info-box-number" id="active_events">0</span>
                            </div>

                        </div>

                    </div>


                    <div class="clearfix hidden-md-up"></div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1">
                                <i class="fa fa-regular fa-calendar-times"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Inactive Events</span>
                                <span class="info-box-number" id="inactive_events">0</span>
                            </div>

                        </div>

                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Users</span>
                                <span class="info-box-number" id="total_users">0</span>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


@section('content-js')
    <script type="text/javascript">
        // Use ajax to find dashboard counts
        $.ajax({
            url: "{{ route('dashboard.counts') }}",
            success: function (counts) {
                $('#total_events').text(counts.total_events);
                $('#active_events').text(counts.active_events);
                $('#inactive_events').text(counts.inactive_events);
                $('#total_users').text(counts.total_users);
            }
        });
    
    </script>
@endsection
