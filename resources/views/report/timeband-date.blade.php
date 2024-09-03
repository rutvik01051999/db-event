@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-9">
                        <h1>Time Band - Date Wise Report</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-lg">
                    <div class="card-body">

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
@endsection
