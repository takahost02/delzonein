let livetrackmap, infoPopup, markersLayer;
let markersArray = [];

// FontAwesome class mapping for vehicle types
const vehicleIcons = {
    MOTORCYCLE: 'fa-motorcycle',
    BICYCLE: 'fa-bicycle',
    CAR: 'fa-car',
    TRUCK: 'fa-truck',
    BUS: 'fa-bus',
    TAXI: 'fa-taxi',
};

window.onload = function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            document.cookie = "latitude=" + position.coords.latitude;
            document.cookie = "longitude=" + position.coords.longitude;
        });
    }

    fetchInitialData();
};

function fetchInitialData() {
    let path = $("#base").val() + "/api/currentpositions";
    if ($("#group").attr("data-name") != 0) {
        path += "?gr=" + $("#group").attr("data-name");
    }

    $.ajax({
        type: "GET",
        url: path,
        dataType: 'json',
        cache: false,
        success: function (result) {
            if (result.status == 1) {
                const markers = result.in_trip;
                const idleMarkers = result.idle;
                if (markers.length > 0 && isValidCoordinates(markers[markers.length - 1].latitude, markers[markers.length - 1].longitude)) {
                    const lastMarker = markers[markers.length - 1];
                    initializeMap(parseFloat(lastMarker.latitude), parseFloat(lastMarker.longitude));
                } else {
                    initializeMap(52.696361078274485, -111.4453125);
                }

                populateMarkers(markers, idleMarkers);
                updateLegend(markers, idleMarkers);
            } else {
                alertmessage(result.message, 2);
            }
        },
        error: function () {
            console.log('Unexpected error.');
        }
    });
}

function initializeMap(lat, lng) {
    if (isValidCoordinates(lat, lng)) {
        livetrackmap = L.map('map_canvas').setView([lat, lng], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(livetrackmap);
        infoPopup = L.popup();
        markersLayer = L.layerGroup().addTo(livetrackmap);
        setInterval(() => livetracking(), 15000);  // Corrected reference
    } else {
        console.error("Invalid coordinates for map initialization.");
    }
}

function livetracking() {
    let path = $("#base").val() + "/api/currentpositions";
    if ($("#group").attr("data-name") != 0) {
        path += "?gr=" + $("#group").attr("data-name");
    }

    $.ajax({
        type: "GET",
        url: path,
        dataType: 'json',
        cache: false,
        success: function (result) {
            if (result.status == 1) {
                populateMarkers(result.in_trip, result.idle);
                updateLegend(result.in_trip, result.idle);
            } else {
                alertmessage(result.message, 2);
            }
        },
        error: function () {
            console.log('Unexpected error.');
        }
    });
}

function populateMarkers(inTripMarkers, idleMarkers) {
    resetMarkers();

    inTripMarkers.forEach(markerData => {
        if (isValidCoordinates(markerData.latitude, markerData.longitude)) {
            addMarker(markerData, "In Trip");
        }
    });

    idleMarkers.forEach(markerData => {
        if (isValidCoordinates(markerData.latitude, markerData.longitude)) {
            addMarker(markerData, "Idle");
        }
    });
}

function addMarker(markerData, status) {
    const point = [parseFloat(markerData.latitude), parseFloat(markerData.longitude)];
    const vType = vehicleIcons[markerData.v_type] || vehicleIcons['CAR'];
    const html = `
        <div>
            <b>Name:</b> ${markerData.v_name}<br>
            <b>Status:</b> ${status}<br>
            <b>Speed:</b> ${Math.round(markerData.speed || 0)} Km/h<br>
            <b>Updated On:</b> ${markerData.last_update_time}
        </div>
    `;

    const icon = L.divIcon({
        html: `<i class="fas ${vType}" style="color:${markerData.v_color}; font-size:24px;"></i>`,
        className: '',
        iconSize: [24, 24],
        iconAnchor: [12, 12],
    });

    const marker = L.marker(point, { icon }).addTo(markersLayer);
    marker.bindPopup(html);

    markersArray.push(marker);
}

function isValidCoordinates(lat, lng) {
    return !isNaN(parseFloat(lat)) && !isNaN(parseFloat(lng));
}

function resetMarkers() {
    markersLayer.clearLayers();
    markersArray = [];
}



function updateLegend(inTripMarkers, idleMarkers) {
    const legendContainer = document.getElementById('legend');
    legendContainer.innerHTML = '';

    const inTripRows = inTripMarkers.map(marker => {
        const vType = vehicleIcons[marker.v_type] || vehicleIcons['CAR'];
        return `
            <tr data-lat="${marker.latitude}" data-lng="${marker.longitude}" class="legend-row">
                <td>${marker.v_name}</td>
                <td>In Trip</td>
                <td>${Math.round(marker.speed || 0)} ${$("#mapunit").val()}/h</td>
                <td><i class="fas ${vType}" style="color:${marker.v_color}; font-size:18px;"></i></td>
                <td>${marker.last_update_time} <span style="font-size:9px;">(${marker.last_update_time_ago})<span></td>
            </tr>
        `;
    }).join('');

        const idleRows = idleMarkers.map(marker => { 

        if (marker.latitude && marker.longitude) {
            const vType = vehicleIcons[marker.v_type] || vehicleIcons['CAR'];
            return `
                <tr data-lat="${marker.latitude}" data-lng="${marker.longitude}" class="legend-row">
                    <td>${marker.v_name}</td>
                    <td>Idle</td>
                    <td>${Math.round(marker.speed || 0)} ${$("#mapunit").val()}/h</td>
                    <td><i class="fas ${vType}" style="color:${marker.v_color}; font-size:18px;"></i></td>
                    <td>${marker.last_update_time} <span style="font-size:9px;">(${marker.last_update_time_ago})<span></td>
                </tr>
            `;
        }
        return ''; // Return empty string for invalid markers
    }).join('');

    const legendHtml = `
        <table border="1" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Speed</th>
                    <th>Icon</th>
                    <th>Last Update</th>
                </tr>
            </thead>
            <tbody>
                ${inTripRows}
                ${idleRows}
            </tbody>
        </table>
    `;

    legendContainer.innerHTML = legendHtml;

    // Add click event listener to rows
    const rows = document.querySelectorAll('.legend-row');
    rows.forEach(row => {
        row.addEventListener('click', function() {
            const lat = parseFloat(this.getAttribute('data-lat'));
            const lng = parseFloat(this.getAttribute('data-lng'));

            // Zoom to the selected vehicle's location on the map
            if (!isNaN(lat) && !isNaN(lng)) {
                zoomToLocation(lat, lng);
            }
        });
    });
}

// Function to zoom to a specific location on the map
function zoomToLocation(lat, lng) {
    // Assuming you're using Leaflet or Google Maps, replace with your map's API zoom method
    if (livetrackmap) {
        livetrackmap.setView([lat, lng], 14); // Set zoom level (14 is an example)
    } else {
        console.error("Map object not found!");
    }
}



function alertmessage(msg, type) {
    const position = 'top-center';
    const options = {
        text: msg,
        position,
        stack: false,
        showHideTransition: 'slide'
    };
    if (type == 1) {
        $.toast({ ...options, heading: 'Success', icon: 'info', loaderBg: '#2196f3' });
    } else {
        $.toast({ ...options, heading: 'Error', icon: 'error', loaderBg: '#f44336' });
    }
}
