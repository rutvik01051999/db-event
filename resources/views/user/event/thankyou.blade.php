@extends('layouts.user')
@section('content')
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 text-center">
            <div class="checkmark-container mb-4">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px" y="0px" viewBox="0 0 161.2 161.2" enable-background="new 0 0 161.2 161.2" xml:space="preserve"
                    class="checkmark">
                    <path class="path" fill="none" stroke="#0acf97" stroke-miterlimit="10"
                        d="M425.9,52.1L425.9,52.1c-2.2-2.6-6-2.6-8.3-0.1l-42.7,46.2l-14.3-16.4
                                                            c-2.3-2.7-6.2-2.7-8.6-0.1c-1.9,2.1-2,5.6-0.1,7.7l17.6,20.3c0.2,0.3,0.4,0.6,0.6,0.9c1.8,2,4.4,2.5,6.6,1.4c0.7-0.3,1.4-0.8,2-1.5
                                                            c0.3-0.3,0.5-0.6,0.7-0.9l46.3-50.1C427.7,57.5,427.7,54.2,425.9,52.1z" />
                    <circle class="path" fill="none" stroke="#0acf97" stroke-width="4" stroke-miterlimit="10"
                        cx="80.6" cy="80.6" r="62.1" />
                    <polyline class="path" fill="none" stroke="#0acf97" stroke-width="6" stroke-linecap="round"
                        stroke-miterlimit="10" points="113,52.8 74.1,108.4 48.2,86.4 " />
                </svg>
            </div>

            <h5 class="response-text">
                {{ $data->response }}
            </h5>
        </div>
    </div>

    <style>
        .checkmark-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            width: 100px;
            margin: 0 auto;
        }

        .checkmark {
            width: 100px;
            height: 100px;
        }

        .response-text {
            font-size: 1.25rem;
            color: #333;
            margin-top: 20px;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .checkmark {
                width: 80px;
                height: 80px;
            }

            .response-text {
                font-size: 1rem;
            }
        }

        body {
            background-color: #f9f9f9;
        }
    </style>
@endsection
