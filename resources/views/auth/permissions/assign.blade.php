@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-9">
                        <h4>Assign Permissions</h4>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-md-4 col-sm-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="search" name="search"
                                            placeholder="Search by employee id">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-dark" id="searchBtn">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" placeholder="Name"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            {{-- Assign Permissions --}}
                            <form id="assignForm" class="form-horizontal" action="{{ route('permission.store') }}"
                                method="POST">
                                @csrf

                                <input type="username" id="username" name="username" hidden>

                                <div class="row">
                                    <div class="permissions">

                                    </div>
                                </div>

                                <div class="row submit-btn" style="display: none;">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@section('content-js')
    <script>
        // Search on click
        $(document).on('click', '#searchBtn', function() {
            var id = $('#search').val();
            if (id == "") {

                $.toast({
                    text: "Please enter employee id",
                    heading: 'Error',
                    icon: 'error',
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 3000,
                    stack: 5,
                    position: 'top-right',
                    textAlign: 'left',
                    loader: true,
                    loaderBg: '#9EC600',
                });

            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ route('permission.search-by-employee-id') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        if (response.view == "") {
                            $('.permissions').html(
                                '<p class="text-danger">No permissions found</p>'
                            )
                        }
                        $('.submit-btn').show();
                        $('#name').val(response.fullName);
                        $('#username').val(response.username);
                        $('.permissions').html(response.view);
                    }
                });
            }
        })
    </script>
@endsection
@endsection
