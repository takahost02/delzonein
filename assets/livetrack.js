var map, infoWindow, markersArray = [];

window.onload = function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.cookie = "latitude=" + position.coords.latitude;
            document.cookie = "longitude=" + position.coords.longitude;
        });
    }

    map = new google.maps.Map(document.getElementById("map_canvas"), {
        center: new google.maps.LatLng(52.696361078274485, -111.4453125),
        zoom: 3,
        mapTypeId: 'roadmap',
        gestureHandling: 'greedy'
    });

    infoWindow = new google.maps.InfoWindow;
    livetracking(); // Initial tracking
    setInterval(livetracking, 15000); // Update every 15 seconds
};

// Live tracking function to fetch vehicle data and place markers
function livetracking() {
  var path = $("#group").attr("data-name") != 0 
      ? $('#base').val() + "/api/currentpositions?gr=" + $("#group").attr("data-name") 
      : $('#base').val() + "/api/currentpositions";

  $.ajax({
      type: "GET",
      url: path,
      dataType: 'json',
      cache: false,
      success: function(result) {
          if (result.status === 1) {
              var markers = result.in_trip.concat(result.idle); // Combine both in_trip and idle data
              var bounds = new google.maps.LatLngBounds();
              resetMarkers(markersArray); // Clear existing markers

              markers.forEach(function(markerData) {
                  var v_type = getVehicleIcon(markerData.v_type); // Get correct icon based on vehicle type
                  var point = new google.maps.LatLng(parseFloat(markerData.latitude), parseFloat(markerData.longitude));
                  var html = "<div><b>Name: </b>" + markerData.v_name + "<br><b>Status: </b>" + markerData.vehicle_status + "<br><b>Speed: </b>" + Math.round(markerData.speed) + " Km/h<br><b>Last Update: </b>" + markerData.last_update_time_ago + "</div>";

                  var marker = new google.maps.Marker({
                      map: map,
                      position: point,
                      icon: {
                          path: v_type,
                          scale: 0.4,
                          strokeWeight: 0.2,
                          strokeColor: 'black',
                          strokeOpacity: 2,
                          fillColor: markerData.v_color,
                          fillOpacity: 1.5
                      }
                  });

                  markersArray.push(marker);
                  bindInfoWindow(marker, map, infoWindow, html);
                  bounds.extend(point); // Extend map bounds to include this marker
              });

              map.fitBounds(bounds); // Adjust the map to fit all markers
          } else {
              alertmessage(result.message, 2); // Show error message
          }
      },
      error: function() {
          console.log('Unexpected error.');
      }
  });
}

// Function to get the correct vehicle icon path based on vehicle type
function getVehicleIcon(vType) {
    switch (vType) {
        case 'MOTORCYCLE': return fontawesome.markers.MOTORCYCLE;
        case 'BICYCLE': return fontawesome.markers.BICYCLE;
        case 'CAR': return fontawesome.markers.CAR;
        case 'TRUCK': return fontawesome.markers.TRUCK;
        case 'BUS': return fontawesome.markers.BUS;
        case 'TAXI': return fontawesome.markers.TAXI;
        default: return fontawesome.markers.TRUCK; // Default to TRUCK if no match
    }
}

// Function to reset markers array and remove markers from the map
function resetMarkers(arr) {
    for (var i = 0; i < arr.length; i++) {
        arr[i].setMap(null); // Remove the marker from the map
    }
    arr.length = 0; // Clear the array
}

// Function to bind an info window to a marker
function bindInfoWindow(marker, map, infoWindow, html) {
    google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
    });
}

// Function to display success or error message using toast notifications
function alertmessage(msg, type) {
    if (type === 1) {
        $.toast({
            heading: 'Success',
            text: msg,
            icon: 'info',
            loader: true,
            position: 'top-center',
            loaderBg: '#2196f3',
            afterHidden: function() {
                location.reload();
            }
        });
    } else if (type === 2) {
        $.toast({
            heading: 'Error',
            text: msg,
            icon: 'error',
            loader: true,
            position: 'top-center',
            loaderBg: '#f44336',
        });
    }
}
