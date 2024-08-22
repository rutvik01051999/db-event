@extends('layouts.user')


<style>
    .registration_close {
        width: 300px;
        margin: 0 auto;
        display: block;
        margin-top: 100px;
        margin-bottom: 100px;
        height: 300px;
    }
</style>

@section('content')
    <section class="content">
        <img src="{{ asset('dist/img/registration_close.jpg') }}" alt="Registration Closed" class="registration_close" />
    </section>
@endsection
@section('content-js')
    <script>
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        } else {
            console.log("Geolocation is not supported by this browser.");
        }

        function successCallback(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            // Fetch location information from latitude and longitude
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`)
                .then(response => response.json())
                .then(data => {
                    // Save location information by ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ route('user.event.save-location') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            event_id: "{{ $data->id }}",
                            latitude: data.lat,
                            longitude: data.lon,
                            suburb: data.address.suburb,
                            town: data.address.town,
                            county: data.address.county,
                            state_district: data.address.state_district,
                            state: data.address.state,
                            postcode: data.address.postcode,
                            country: data.address.country,
                        },
                        success: function(response) {
                            console.log(response);
                        }
                    })
                })
                .catch(error => {
                    console.error("Error:", error);
                });

        }

        function errorCallback(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    console.log("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    console.log("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    console.log("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    console.log("An unknown error occurred.");
                    break;
            }
        }
    </script>
@endsection
