$(document).ready(function() {
  var map;

  // Initialize Google Map
  if (!map) {
    map = new google.maps.Map(document.getElementById('map'), {
      center: { lat: 12.9341123, lng: 80.1938214 }, // Initial coordinates
      zoom: 10
    });
  }

  // Attach the submit event to the form
  $("#track").on("submit", function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Ensure the vehicle field is not empty
    if ($('#t_vechicle').val() === '') {
      alert("Please enter a vehicle ID.");
      return;
    }
    var path = $('#base').val();

    // Perform the AJAX request
    $.ajax({
      type: "POST", // Use GET method to fetch the trip data
      url: path + "/api/positions", // Your API URL
      data: $("#track").serialize(), // Serialize form data
      dataType: 'json', // Expect JSON response from the server

      success: function(response) {
        // Check if the response is successful
        if (response.status === 1) {
          renderMap(response.data); // Call function to render map with fetched data
          updateTripSummary(response.data);
        } else {
          alert("No trip data found or an error occurred.");
        }
      },

      error: function(xhr, status, error) {
        // Handle errors during the AJAX request
        console.error('Error fetching trip data:', error);
        alert("An error occurred while fetching trip data.");
      }
    });
  });


  function renderMap(data) {
    // Initialize the map if it hasn't been initialized
    if (!map) {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 12.9341123, lng: 80.1938214 }, // Initial coordinates
            zoom: 10
        });
    }

    // Define colors for trips
    var tripColors = generateTripColors(1000);
    var colorIndex = 0;

    // Clear previous legend content
    $('#trip-legend').empty();

    // Loop through trips and render them
    if (data.trips) {
        Object.keys(data.trips).forEach(function(tripKey, tripIndex) {
            var tripData = data.trips[tripKey];
            var pathCoordinates = [];

            // Add the trip's fromlocation to tolocation in the legend
            var fromLocation = tripData.fromlocation || 'N/A';
            var toLocation = tripData.tolocation || 'N/A';

            tripData['positions'].forEach(function(point, i) {
                var latLng = new google.maps.LatLng(parseFloat(point.latitude), parseFloat(point.longitude));
                pathCoordinates.push(latLng);

                // Marker logic based on position in the trip
                var marker;

                if (i === 0) {
                    // Start marker (green flag)
                    marker = new google.maps.Marker({
                        position: latLng,
                        icon: {
                            url: $('#s_mapstarting_marker').val(),
                        },
                        map: map
                    });
                } else if (i === (tripData['positions'].length - 1)) {
                    // End marker (red flag)
                    marker = new google.maps.Marker({
                        position: latLng,
                        icon: {
                            url: $('#s_mapending_marker').val(),
                        },
                        map: map
                    });
                } else {
                    marker = new google.maps.Marker({
                        position: latLng,
                        label: {
                            text: (i + 1).toString(),
                            fontSize: "12px",
                            color: tripColors[colorIndex % tripColors.length]
                        },
                        map: map
                    });
                }

                // Add the marker's info window
                var contentString = `
                    <b>Trip ID:</b> ${point.t_id || 'N/A'}<br>
                    <b>Time:</b> ${point.time}<br>
                    <b>Speed:</b> ${point.speed} km/h<br>
                    <b>Address:</b> ${point.address || 'N/A'}<br>
                    <b>Battery:</b> ${point.battery_level}<br>
                    <b>Comment:</b> ${point.comment || 'No Comment'}
                `;
                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map, marker);
                });
            });

            // Add the polyline for the trip with a unique color
            var polyline = new google.maps.Polyline({
                path: pathCoordinates,
                strokeColor: tripColors[colorIndex % tripColors.length],
                strokeOpacity: 1.0,
                strokeWeight: 4
            });
            polyline.setMap(map);

            // Add the trip to the legend
            var legendItem = $('<div class="legend-item"></div>');
            var colorBox = $('<div class="legend-color-box"></div>');
            colorBox.css('background-color', tripColors[colorIndex % tripColors.length]);

            // Add trip number and locations to the legend
            legendItem.append(colorBox);
            legendItem.append('<span><b>Trip ' + (tripIndex + 1) + '</b></span>');
            legendItem.append('<span class="legend-location"><b>[</b> ' + fromLocation + '</span>');
            legendItem.append('<span class="legend-location"><b>To</b> ' + toLocation + '</span>]');
            $('#trip-legend').append(legendItem);

            colorIndex++;
        });
    }
}



  function generateTripColors(numTrips) {
    var colors = [];
    for (var i = 0; i < numTrips; i++) {
      // Generate random RGB values
      var r = Math.floor(Math.random() * 256);
      var g = Math.floor(Math.random() * 256);
      var b = Math.floor(Math.random() * 256);
      colors.push(`rgb(${r}, ${g}, ${b})`);
    }
    return colors;
  }

  function updateTripSummary(data) {
    // Clear the existing trip summaries
    $('#trip-summary').empty();

    if (data.trips) {
      // Loop through each trip and generate a summary
      Object.keys(data.trips).forEach(function(tripKey, index) {
        var trip = data.trips[tripKey];

        // Parse the trip stops if they are in JSON string format
        var tripStops = trip.trip_stops ? JSON.parse(trip.trip_stops) : [];

        // Create a collapsible panel for each trip
        var tripPanel = `
          <div class="trip-panel">
            <h4>Trip ${index + 1}</h4>
            <p><b>From Location:</b> ${trip.fromlocation || 'N/A'}</p>
            <p><b>To Location:</b> ${trip.tolocation || 'N/A'}</p>
            <p><b>Trip Stops:</b> ${tripStops.length > 0 ? tripStops.join(' → ') : 'N/A'}</p>
            <p><b>Start Time:</b> ${trip.start_time || 'N/A'}</p>
            <p><b>End Time:</b> ${trip.end_time || 'N/A'}</p>
            <p><b>Total Distance:</b> ${trip.total_distance ? trip.total_distance.toFixed(2) + ' km' : 'N/A'}</p>
            <p><b>Total Time:</b> ${trip.total_time_hours ? trip.total_time_hours.toFixed(2) + ' hours' : 'N/A'}</p>
            <p><b>Average Speed:</b> ${trip.average_speed || 'N/A'}</p>
          </div>
        `;

        // Append the trip panel to the summary container
        $('#trip-summary').append(tripPanel);
      });

      // Show the "Show Trip Summary" button
      $('#show-summary').show();
    } else {
      $('#trip-summary').append('<p>No trip data available.</p>');

      // Hide the "Show Trip Summary" button if no data is available
      $('#show-summary').hide();
    }
  }

  $(document).ready(function() {
    $('#show-summary').hide(); // Hide the button on page load
    $('#show-summary').on('click', function() {
      $('#trip-summary-modal').modal('show');
    });
  });
});
