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
                            <div class="row justify-content-around">
                                <div class="col-md-3 col-sm-12">
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
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <select class="form-select" id="department" name="departments[]" multiple
                                            data-placeholder="Select a department" style="width: 100%;">
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">
                                            Select departments the user can access.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-lg permission-card d-none">
                        <div class="card-body">
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
        // Document on load
        $(document).ready(function() {
            // Select Department
            $('#department').select2({
                placeholder: "Select Department",
                allowClear: true,
                theme: 'bootstrap4',
                width: '100%'
            });
        });

        // Search on click
        $(document).on('click', '#searchBtn', function() {
            var id = $('#search').val();
            if (id == "") {
                toastr.error('Please enter employee id');
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ route('permission.search-by-employee-id') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        var userDepartments = response.userDepartments;

                        $(document).find('#department').val(userDepartments).trigger('change');

                        if (response.view == "") {
                            $('.permissions').html(
                                '<p class="text-danger">No permissions found</p>'
                            )
                        }
                        $('.permission-card').removeClass('d-none');
                        $('.submit-btn').show();
                        $('#name').val(response.fullName);
                        $('#username').val(response.username);
                        $('.permissions').html(response.view);
                    },
                    error: function(response) {
                        $('.permission-card').addClass('d-none');
                        $('.permissions').html(
                            '<p class="text-danger">No permissions found</p>'
                        )
                    }
                });
            }
        });

        // Submit
        $('#assignForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            var departments = $('#department').val();
            var username = $('#username').val();
            var permissions = $('input[name="permissions[]"]:checked').map(function() {
                return this.value;
            }).get();

            if (permissions.length == 0) {
                toastr.error('Please select atleast one permission');
                return false;
            }

            if (departments.length == 0) {
                toastr.error('Please select atleast one department');
                return false;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('permission.store') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    departments: departments,
                    username: username,
                    permissions: permissions
                },
                success: function(response) {
                    if (response.status == "success") {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(response) {
                    toastr.error(response.responseJSON.message);
                }
            });
        })
    </script>
@endsection
@endsection
