var map = infoWindow = latitude = null;
var markersArray = [];

function initMap() {
  if ($('#t_trip_status').val() != 'ongoing') return;

  map = new google.maps.Map(document.getElementById("map_canvas"), {
    center: new google.maps.LatLng(52.696361078274485, -111.4453125),
    zoom: 3,
    mapTypeId: 'roadmap',
    gestureHandling: 'greedy'
  });

  infoWindow = new google.maps.InfoWindow;
  var v_id = $('#v_id').val();
  livetracking(v_id);
}


$(document).ready(function () {
  console.log("Document ready triggered.");

  t_trip_status = $('#t_trip_status').val();
  console.log("Trip Status:", t_trip_status);

  if (t_trip_status != 'ongoing') {
    if (t_trip_status == 'yettostart') {
      $('#msg').html('Trip is yet to start, so tracking not available at this moment..');
    } else if (t_trip_status == 'completed') {
      $('#msg').html('Trip completed, so live tracking not available..');
    } else {
      $('#msg').html('Tracking not available at this moment..');
    }
    $('#myModal').modal('show');
  } else {
    if (navigator.geolocation) {
      console.log("Geolocation supported. Attempting to get current position.");
      navigator.geolocation.getCurrentPosition(function (position) {
        document.cookie = "maplatitude=" + position.coords.latitude;
        document.cookie = "maplongitude=" + position.coords.longitude;
        console.log("Geo coords saved in cookies:", position.coords.latitude, position.coords.longitude);
      });
    } else {
      console.warn("Geolocation is not supported by this browser.");
    }

    map = new google.maps.Map(document.getElementById("map_canvas"), {
      center: new google.maps.LatLng(52.696361078274485, -111.4453125),
      zoom: 3,
      mapTypeId: 'roadmap',
      gestureHandling: 'greedy'
    });
    console.log("Google Map initialized.");

    console.log("Cookies (maplatitude):", ("; " + document.cookie).split("; maplatitude=").pop().split(";").shift());

    infoWindow = new google.maps.InfoWindow;
    var v_id = $('#v_id').val();
    console.log("Vehicle ID for tracking:", v_id);
    livetracking(v_id);
  }
});

function livetracking(id) {
  console.log("Live tracking initiated with ID:", id);

  if (id != '') {
    var path = $('#base').val() + "/api/currentpositions?v_id=" + id;
    console.log("API Path:", path);
  }

  $.ajax({
    type: "GET",
    url: path,
    dataType: 'json',
    cache: false,
    success: function (result) {
      console.log("AJAX Success - Data Received:", result);

      if (result.status == 1) {
        var markers = result.data;
        var bounds = new google.maps.LatLngBounds();
        resetMarkers(markersArray);

        for (let i = 0; i < markers.length; i++) {
          var lastupdate = markers[i].time;
          var v_type;

          switch (markers[i].v_type) {
            case 'MOTORCYCLE':
              v_type = fontawesome.markers.MOTORCYCLE;
              break;
            case 'BICYCLE':
              v_type = fontawesome.markers.BICYCLE;
              break;
            case 'CAR':
              v_type = fontawesome.markers.CAR;
              break;
            case 'TRUCK':
              v_type = fontawesome.markers.TRUCK;
              break;
            case 'BUS':
              v_type = fontawesome.markers.BUS;
              break;
            case 'TAXI':
              v_type = fontawesome.markers.TAXI;
              break;
            default:
              v_type = fontawesome.markers.TRUCK;
          }

          var lat = parseFloat(markers[i].latitude);
          var lng = parseFloat(markers[i].longitude);
          var point = new google.maps.LatLng(lat, lng);
          bounds.extend(point);

          var html = "<div><b>Name:</b> " + markers[i].v_name +
            "<br><b>Speed:</b> " + Math.round(markers[i].speed) + " Km/h" +
            "<br><b>Updated On:</b> " + lastupdate + "</div>";

          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: {
              path: v_type,
              scale: 0.4,
              strokeWeight: 0.2,
              strokeColor: 'black',
              strokeOpacity: 2,
              fillColor: markers[i].v_color,
              fillOpacity: 1.5
            }
          });

          console.log("Marker added:", {
            name: markers[i].v_name,
            lat: lat,
            lng: lng,
            type: markers[i].v_type
          });

          markersArray.push(marker);
          bindInfoWindow(marker, map, infoWindow, html);
        }

        map.fitBounds(bounds);

      } else {
        console.warn("Tracking failed with message:", result.message);
        alertmessage(result.message, 2);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("AJAX Error:", textStatus, errorThrown);
      alertmessage('Unexpected error.', 2);
    }
  });
}

function resetMarkers(arr) {
  console.log("Resetting existing markers.");
  for (var i = 0; i < arr.length; i++) {
    arr[i].setMap(null);
  }
  arr = [];
}

function bindInfoWindow(marker, map, infoWindow, html) {
  google.maps.event.addListener(marker, 'click', function () {
    infoWindow.setContent(html);
    infoWindow.open(map, marker);
    console.log("InfoWindow opened for marker.");
  });
}

function alertmessage(msg, type) {
  console.log("Alert Message - Type:", type, "Message:", msg);

  const Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 5000
  });

  if (type == 1) {
    Toast.fire({
      icon: 'success',
      title: msg
    });
  }
  if (type == 2) {
    Toast.fire({
      icon: 'error',
      title: msg
    });
  }
}
