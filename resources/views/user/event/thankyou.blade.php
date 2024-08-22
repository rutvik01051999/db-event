@extends('layouts.user')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5>
                    {{ $data->response }}
                </h5>
            </div>
        </div>
    </div>
</div>
@endsection
