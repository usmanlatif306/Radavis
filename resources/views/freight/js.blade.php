<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#destination').select2({
            placeholder: "Select Destination",
        });
        $('#exit').select2({
            placeholder: "Select Exit",
        });

    });
</script>

<script type="text/javascript">
    // lat: 30.8798008,
    // lng: 72.3312289

    function initMap() {
        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer();
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 7,
            center: {
                lat: 36.55876578016731,
                lng: -119.71697281592843
            },
        });

        directionsRenderer.setMap(map);

        const onChangeHandler = function() {
            $('#error').addClass('d-none');
            let exit = document.getElementById("exit").value;
            let destination = document.getElementById("destination").value;

            if (exit && destination) {
                $('#info').removeClass('d-none').text('Please Wait...');
                // $("#loadingModal").modal('show');
                calculateAndDisplayRoute(directionsService, directionsRenderer);
            }
        };

        $('#exit').on('change', function() {
            onChangeHandler();
        })
        $('#destination').on('change', function() {
            onChangeHandler();
        })
    }

    function calculateAndDisplayRoute(directionsService, directionsRenderer) {
        directionsService
            .route({
                origin: {
                    query: document.getElementById("exit").value,
                },
                destination: {
                    query: document.getElementById("destination").value,
                },
                travelMode: google.maps.TravelMode.DRIVING,
            })
            .then(function(response) {
                let distance = response?.routes[0]?.legs[0]?.distance;
                if (distance) {
                    let miles = distance.text.replace(' mi', '');
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('freight.calculator') }}",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            miles: miles
                        },
                        success: function(res) {
                            $('#mileage').text(res.miles);
                            $('#suggestedRate').text('$' + res.local_rate);
                            $('#shellRate').text('$' + res.shel_rate);
                            $('#longDistanceRate').text('$' + res.long_rate);
                            // $("#loadingModal").modal('hide');
                        },
                        error: function(error) {
                            // console.log(error);
                            $('#error').text('Something went wrong').removeClass('d-none');
                        }
                    });

                    // display route path on map
                    directionsRenderer.setDirections(response);
                    $('#info').addClass('d-none');
                } else {
                    $('#error').text('Something went wrong').removeClass('d-none');
                }
            })
            .catch(function(e) {
                $('#info').addClass('d-none');
                // $("#loadingModal").modal('hide');
                $('#mileage').text(0);
                $('#suggestedRate').text('$' + 0);
                $('#shellRate').text('$' + 0);
                $('#longDistanceRate').text('$' + 0);
                $('#error').text(e.message).removeClass('d-none');
                directionsRenderer.setMap(null);
            });

    }

    window.initMap = initMap;
</script>

<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map_key') }}&callback=initMap&v=weekly"
    defer></script>
