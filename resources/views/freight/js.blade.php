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
    let exitOldAddress = null;
    let destinationOldAddress = null;

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
            // 7301 John Galt Way, Arbuckle
            // 7950 S Bliss Road, Chowchilla
            let exit = null;
            let destination = null;

            if ($("input[name=exit]").val()) {
                exit = $("input[name=exit]").val();
            } else {
                exit = document.getElementById("exit").value;
            }

            if ($("input[name=destination]").val()) {
                destination = $("input[name=destination]").val();
            } else {
                destination = document.getElementById("destination").value;
            }

            $('#error').addClass('d-none');
            toggleModel('show');
            calculateAndDisplayRoute(directionsService, directionsRenderer, exit, destination);
        };

        $('#exit').on('change', function() {
            $('#exitAddress').val('');
            $("input[name=exit]").val('');
            if (validateInputs()) onChangeHandler();
        })
        $('#destination').on('change', function() {
            $('#destinationAddress').val('');
            $("input[name=destination]").val('');
            if (validateInputs()) onChangeHandler();
        })

        function validateInputs() {
            let exit = document.getElementById("exit").value;
            let destination = document.getElementById("destination").value;
            let exitAddress = document.getElementById("exitAddress").value;
            let destinationAddress = document.getElementById("destinationAddress").value;

            return (exit || exitAddress) && (destination || destinationAddress) ? true : false;
        }

        // autocomplete start here
        $('#geoForm').on('keyup keypress', function(e) {
            let keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        const locationInputs = document.getElementsByClassName("map-input");

        const autocompletes = [];
        const geocoder = new google.maps.Geocoder;

        for (let i = 0; i < locationInputs.length; i++) {
            const input = locationInputs[i];
            const fieldKey = input.id.replace("-input", "");

            const autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.key = fieldKey;
            autocompletes.push({
                input: input,
                autocomplete: autocomplete
            });
        }

        for (let i = 0; i < autocompletes.length; i++) {
            const input = autocompletes[i].input;
            const autocomplete = autocompletes[i].autocomplete;

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                const place = autocomplete.getPlace();
                const address = place.formatted_address;
                exitOldAddress = $('#exitAddress').val();
                destinationOldAddress = $('#destinationAddress').val();

                if (input.id === 'exitAddress') {
                    $('#exit').val('').trigger('change');
                    $('#exitAddress').val(exitOldAddress)
                    $("input[name=exit]").val(address);
                }

                if (input.id === 'destinationAddress') {
                    $('#destination').val('').trigger('change');
                    $('#destinationAddress').val(destinationOldAddress)
                    $("input[name=destination]").val(address);
                }

                if (validateInputs()) onChangeHandler();
            });
        }

    }

    function calculateAndDisplayRoute(directionsService, directionsRenderer, origin, destination) {
        directionsService
            .route({
                origin: {
                    query: origin,
                },
                destination: {
                    query: destination,
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
                            toggleModel('hide');
                        },
                        error: function(error) {
                            toggleModel('hide');
                            $('#error').text('Something went wrong').removeClass('d-none');
                        }
                    });

                    // display route path on map
                    directionsRenderer.setDirections(response);
                } else {
                    toggleModel('hide');
                    $('#error').text('Something went wrong').removeClass('d-none');
                }
            })
            .catch(function(e) {
                toggleModel('hide');
                $('#mileage').text(0);
                $('#suggestedRate').text('$' + 0);
                $('#shellRate').text('$' + 0);
                $('#longDistanceRate').text('$' + 0);
                $('#error').text(e.message).removeClass('d-none');
                directionsRenderer.setMap(null);
            });

    }

    function toggleModel(type) {
        if (type === 'show') {
            $('#loadingBackdrop').removeClass('d-none').addClass('show d-block');
            $('#loadingModal').addClass('show d-block');

        } else {
            $('#loadingBackdrop').removeClass('show d-block').addClass('d-none');
            $('#loadingModal').removeClass('show d-block');

        }
    }

    window.initMap = initMap;
</script>

<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map_key') }}&callback=initMap&libraries=places&v=weekly"
    defer></script>
