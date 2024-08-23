@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 col-md-3">
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

                    <div class="col-sm-6 col-md-3">
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

                    <div class="col-sm-6 col-md-3">
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

                    <div class="col-sm-6 col-md-3">
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
        </div>
    </div>
@endsection


@section('content-js')
    <script type="text/javascript">
        // Use ajax to find dashboard counts
        $.ajax({
            url: "{{ route('dashboard.counts') }}",
            beforeSend: function() {
                // Show loader while waiting for response
                $('#total_events').html('<i class="fas fa-spinner fa-pulse"></i>');
                $('#active_events').html('<i class="fas fa-spinner fa-pulse"></i>');
                $('#inactive_events').html('<i class="fas fa-spinner fa-pulse"></i>');
                $('#total_users').html('<i class="fas fa-spinner fa-pulse"></i>');
            },
            success: function(counts) {
                // Show counts with animation
                animateNumberCount('#total_events', 0, counts.total_events, 2000);
                animateNumberCount('#active_events', 0, counts.active_events, 2000);
                animateNumberCount('#inactive_events', 0, counts.inactive_events, 2000);
                animateNumberCount('#total_users', 0, counts.total_users, 2000);
            }
        });

        // animate number count
        function animateNumberCount(selector, start, end, duration) {

            if (start == end) {
                $(selector).text(end);
                return;
            }

            let range = end - start;
            let current = start;
            let increment = end > start ? 1 : -1;
            let stepTime = Math.abs(Math.floor(duration / range));
            let timer = setInterval(function() {
                current += increment;
                $(selector).text(current);
                if (current == end) {
                    clearInterval(timer);
                }
            }, stepTime);
        }
    </script>
@endsection
