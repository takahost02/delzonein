$(document).ready(function() {
    // Initialize the map variable (we'll load it later)
    var map;
    var markers = []; // Store markers
    var polylines = []; // Store polylines
  
    if (!map) {
      map = L.map('map').setView([12.9341123, 80.1938214], 10); // Initial coordinates
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    }
  
    // Attach the submit event to the form
    $("#track").on("submit", function(e) {
      e.preventDefault(); // Prevent the default form submission
  
      // Clear existing markers and polylines from the map
      clearMap();
  
      // Ensure the vehicle field is not empty
      if ($('#t_vechicle').val() === '') {
        alert("Please enter a vehicle ID.");
        return;
      }
  
      var path = $('#base').val();
  
      // Perform the AJAX request
      $.ajax({
        type: "POST", // Use GET method to fetch the trip data
        url: path + "/api/positions", // Your API URL (make sure to replace `path` with the correct path)
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
      var tripColors = generateTripColors(1000);
      var colorIndex = 0;
  
      let startingPoint = null; // Variable to store the starting point
  
      if (data.trips) {
          Object.keys(data.trips).forEach(function(tripKey, tripIndex) {
              var tripData = data.trips[tripKey];
              var latLngs = [];
  
              tripData.positions.forEach(function(point, i) {
                  var latLng = [parseFloat(point.latitude), parseFloat(point.longitude)];
                  latLngs.push(latLng);
  
                  if (i === 0 && !startingPoint) {
                      startingPoint = latLng;  // Store the first starting point
                  }
  
                  var marker;
                  if (i === 0) {
                      marker = L.marker(latLng, {
                          icon: L.icon({
                              iconUrl: $('#s_mapstarting_marker').val(),
                              iconSize: [30, 50],
                              iconAnchor: [15, 50]
                          })
                      });
                  } else if (i === tripData.positions.length - 1) {
                      marker = L.marker(latLng, {
                          icon: L.icon({
                              iconUrl: $('#s_mapending_marker').val(),
                              iconSize: [30, 50],
                              iconAnchor: [15, 50]
                          })
                      });
                  } else {
                      marker = L.marker(latLng, {
                          icon: L.divIcon({
                              className: 'numbered-icon',
                              html: `<div style="background-color: white; width: 24px; height: 24px; border: 2px solid grey; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                  <div style="width: 12px; height: 12px; background-color: ${tripColors[colorIndex % tripColors.length]}; border-radius: 50%;"></div>
                              </div>`,
                              iconSize: [15, 15],
                              iconAnchor: [12, 12]
                          })
                      });
                  }
  
                  marker.addTo(map).bindPopup(`
                      <b>Trip ID:</b> ${point.t_id || 'N/A'}<br>
                      <b>Time:</b> ${point.time}<br>
                      <b>Speed:</b> ${point.speed} km/h<br>
                      <b>Address:</b> ${point.address || 'N/A'}<br>
                      <b>Battery:</b> ${point.battery_level}<br>
                      <b>Comment:</b> ${point.comment || 'No Comment'}
                  `);
  
                  markers.push(marker);
              });
  
              var polyline = L.polyline(latLngs, {
                  color: tripColors[colorIndex % tripColors.length],
                  weight: 4
              }).addTo(map);
  
              polylines.push(polyline);
              colorIndex++;
          });
  
          addLegend(map, tripColors, data.trips);
  
          // Zoom to the starting point if available
          if (startingPoint) {
              map.setView(startingPoint, 15); // Zoom level set to 15 for better focus
          }
      }
  }
  
  
    function clearMap() {
      // Remove all markers and polylines from the map
      markers.forEach(function(marker) {
        map.removeLayer(marker);
      });
      polylines.forEach(function(polyline) {
        map.removeLayer(polyline);
      });
  
      // Clear the stored arrays
      markers = [];
      polylines = [];
    }
  
  });
  


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
function addLegend(map, tripColors, tripData) {
  if (map._legendControl) {
      map.removeControl(map._legendControl);
  }

  var legend = L.control({ position: 'bottomright' });

  legend.onAdd = function (map) {
      var div = L.DomUtil.create('div', 'info legend');
      div.style.backgroundColor = 'white';
      div.style.padding = '8px';
      div.style.borderRadius = '5px';
      div.style.boxShadow = '0px 2px 4px rgba(0,0,0,0.2)';
      div.style.maxHeight = '300px';
      div.style.overflowY = 'auto';
      div.style.fontSize = '9px';
      div.style.width = '350px';

      // Minimize/Maximize button
      div.innerHTML = `
          <div id="legend-header" style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
              <span style="font-weight: bold;">Trip Details</span>
              <i id="toggle-legend" class="fas fa-minus"></i>
          </div>
          <div id="legend-content" style="display: block;"> 
      `;

      // Add details for each trip
      Object.keys(tripData).forEach(function (tripKey, index) {
          var trip = tripData[tripKey];
          var tripStops = trip.trip_stops ? JSON.parse(trip.trip_stops) : [];

          div.innerHTML += `
              <div style="margin-bottom: 5px; padding-bottom: 5px; border-bottom: 1px solid #ccc;">
                  <div style="display: flex; align-items: center; margin-bottom: 3px;">
                      <div style="width: 15px; height: 15px; background-color: ${tripColors[index]}; margin-right: 5px;"></div>
                      <span><b>Trip ${index + 1}</b></span>
                  </div>
                  <p style="margin: 2px 0;"><b>Date:</b> ${trip.start_time || 'N/A'} to ${trip.end_time || 'N/A'}</p>
                  <p style="margin: 2px 0;"><b>Location:</b> ${trip.fromlocation || 'N/A'} to ${trip.tolocation || 'N/A'}</p>
                  <p style="margin: 2px 0;"><b>Stops:</b> ${tripStops.length > 0 ? tripStops.join('<br> → ') : 'N/A'}</p>
                  <p style="margin: 2px 0;"><b>Total Distance:</b> ${trip.total_distance ? trip.total_distance + ' km' : 'N/A'}</p>
                  <p style="margin: 2px 0;"><b>Total Time:</b> ${trip.total_time_hours ? trip.total_time_hours.toFixed(2) + ' hours' : 'N/A'}</p>
                  <p style="margin: 2px 0;"><b>Average Speed:</b> ${trip.average_speed || 'N/A'}</p>
              </div>
          `;
      });

      div.innerHTML += `
              <div style="margin-top: 10px;">
                  <div style="display: flex; align-items: center; margin-bottom: 5px;">
                      <div style="width: 12px; height: 2px; background-color: red; border-top: 2px dotted red; margin-right: 8px;"></div>
                      <span style="font-size: 9px;">Idle Time Without Trip</span>
                  </div>
              </div>
          </div> <!-- End of #legend-content -->
      `;

      return div;
  };

  map._legendControl = legend;
  legend.addTo(map);

  // Add Minimize/Maximize functionality using Leaflet's recommended `L.DomEvent` handling
  setTimeout(() => {
      const legendHeader = document.getElementById('legend-header');
      const legendContent = document.getElementById('legend-content');
      const toggleIcon = document.getElementById('toggle-legend');

      L.DomEvent.on(legendHeader, 'click', function () {
          if (legendContent.style.display === 'none') {
              legendContent.style.display = 'block';
              toggleIcon.className = 'fas fa-minus'; // Show minus icon
          } else {
              legendContent.style.display = 'none';
              toggleIcon.className = 'fas fa-plus'; // Show plus icon
          }
      });
  }, 100);
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