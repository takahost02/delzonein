<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Live Tracking</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/toast/toast.min.css" />
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition">

<!-- Navbar Info -->
<div class="col-12 col-md-12">
  <nav class="navbar navbar-expand navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item"><span class="nav-link"><b>From :</b> <?= $tripdetails['t_trip_fromlocation'] ?></span></li>
      <li class="nav-item"><span class="nav-link"><b>To :</b> <?= $tripdetails['t_trip_tolocation'] ?></span></li>
      <li class="nav-item"><span class="nav-link"><b>Vehicle No :</b> <?= $tripdetails['t_vechicle_details']->v_registration_no ?></span></li>
      <li class="nav-item"><span class="nav-link"><b>Driver :</b> <?= isset($tripdetails['t_driver_details']->d_name) ? $tripdetails['t_driver_details']->d_name : '<span class="badge badge-danger">Yet to Assign</span>'; ?></span></li>
    </ul>
  </nav>
</div>

<!-- Hidden Fields -->
<input type="hidden" value="<?= $tripdetails['t_vechicle_details']->v_id ?>" id="v_id">
<input type="hidden" value="<?= $tripdetails['t_trip_status'] ?>" id="t_trip_status">
<input type="hidden" id="base" value="<?= base_url(); ?>">

<!-- Map -->
<div class="col-lg-12 col-md-12" id="map_canvas" style="width: 100%; height: 530px;"></div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h4 class="modal-title">Information</h4></div>
      <div class="modal-body"><p id="msg"></p></div>
      <div class="modal-footer"><button type="button" class="btn btn-primary" data-dismiss="modal">Close</button></div>
    </div>
  </div>
</div>

<!-- JS -->
<script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/toast/toast.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome-markers.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
var map, infoWindow, latitude = null, markersArray = [];

function initMap() {
  console.log("initMap called.");
  const t_trip_status = $('#t_trip_status').val();
  const v_id = $('#v_id').val();

  if (t_trip_status !== 'ongoing') {
    let msg = 'Tracking not available at this moment..';
    if (t_trip_status === 'yettostart') msg = 'Trip is yet to start, so tracking not available.';
    else if (t_trip_status === 'completed') msg = 'Trip completed, so live tracking not available..';
    $('#msg').html(msg);
    $('#myModal').modal('show');
    return;
  }

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(position => {
      document.cookie = "maplatitude=" + position.coords.latitude;
      document.cookie = "maplongitude=" + position.coords.longitude;
      console.log("Geo coords saved:", position.coords.latitude, position.coords.longitude);
    });
  }

  map = new google.maps.Map(document.getElementById("map_canvas"), {
    center: { lat: 22.6239, lng: 88.4112 },
    zoom: 8,
    mapTypeId: 'roadmap',
    gestureHandling: 'greedy'
  });

  infoWindow = new google.maps.InfoWindow;
  livetracking(v_id);
}

function livetracking(id) {
  if (!id) return;

  const path = $('#base').val() + "api/currentpositions?v_id=" + id;

  $.ajax({
    type: "GET",
    url: path,
    dataType: 'json',
    cache: false,
    success: function (result) {
      if (result.status == 1) {
        const markers = result.data;
        const bounds = new google.maps.LatLngBounds();
        resetMarkers();

        markers.forEach(markerData => {
          const latLng = new google.maps.LatLng(parseFloat(markerData.latitude), parseFloat(markerData.longitude));
          bounds.extend(latLng);

          const v_type = fontawesome.markers[markerData.v_type] || fontawesome.markers.TRUCK;

          const marker = new google.maps.Marker({
            map: map,
            position: latLng,
            icon: {
              path: v_type,
              scale: 0.4,
              strokeWeight: 0.2,
              strokeColor: 'black',
              fillColor: markerData.v_color,
              fillOpacity: 1.0
            }
          });

          const html = `<div><b>Name:</b> ${markerData.v_name}<br><b>Speed:</b> ${Math.round(markerData.speed)} Km/h<br><b>Updated:</b> ${markerData.time}</div>`;
          bindInfoWindow(marker, html);
          markersArray.push(marker);
        });

        map.fitBounds(bounds);
      } else {
        alertmessage(result.message, 2);
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error:", xhr.responseText);
      alertmessage('Unexpected error.', 2);
    }
  });
}

function resetMarkers() {
  markersArray.forEach(marker => marker.setMap(null));
  markersArray = [];
}

function bindInfoWindow(marker, html) {
  marker.addListener('click', function () {
    infoWindow.setContent(html);
    infoWindow.open(map, marker);
  });
}

function alertmessage(msg, type) {
  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: type === 1 ? 'success' : 'error',
    title: msg,
    showConfirmButton: false,
    timer: 5000
  });
}
</script>

<!-- ✅ Best Practice: Load Google Maps API async + callback -->
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=<?= $data['s_googel_api_key']; ?>&callback=initMap&libraries=places,drawing&v=weekly">
</script>

</body>
</html>
