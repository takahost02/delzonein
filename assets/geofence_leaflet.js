var map;
var drawnItems = new L.FeatureGroup();
var selectedShape = null;

function initialize() {
  map = L.map('map').setView([24.8998373, 91.8258764], 12);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data © <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
  }).addTo(map);

  var drawControl = new L.Control.Draw({
      edit: {
          featureGroup: drawnItems,
          remove: true,
      },
      draw: {
          polyline: true,
          polygon: true,
          rectangle: true,
          circle: true,
          marker: true,
      },
  });

  map.addControl(drawControl);
  map.addLayer(drawnItems);

  // Handle draw:created event
  map.on('draw:created', function(event) {
      var layer = event.layer; // The layer that was just drawn

      // Add the layer to the drawnItems group
      drawnItems.addLayer(layer);

      // Automatically select the new shape
      selectShape(layer);
  });

  setupAddressAutocomplete();
}


function setupAddressAutocomplete() {
    const addressInput = document.getElementById('pac-input');
    const suggestionsList = document.getElementById('suggestions');
    addressInput.addEventListener('input', function() {
        const query = addressInput.value;
        suggestionsList.innerHTML = '';
        if (query.length > 2) {
            fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&limit=5`)
                .then((response) => response.json())
                .then((data) => {
                    if (data.features.length === 0) {
                        const noResultItem = document.createElement('li');
                        noResultItem.className = 'list-group-item';
                        noResultItem.textContent = 'No results found';
                        suggestionsList.appendChild(noResultItem);
                        return;
                    }
                    data.features.forEach((feature) => {
                        const li = document.createElement('li');
                        li.className = 'list-group-item';
                        li.textContent = feature.properties.name || 'Unnamed location';
                        li.addEventListener('click', () => {
                            selectAddress(feature);
                            suggestionsList.innerHTML = '';
                        });
                        suggestionsList.appendChild(li);
                    });
                })
                .catch((error) => {
                    console.error('Error fetching address suggestions:', error);
                });
        }
    });

    document.addEventListener('click', function(event) {
        if (!addressInput.contains(event.target) && !suggestionsList.contains(event.target)) {
            suggestionsList.innerHTML = '';
        }
    });
}

function selectAddress(feature) {
    const {
        geometry,
        properties
    } = feature;
    const [lon, lat] = geometry.coordinates;

    // Set map view to the selected location
    map.setView([lat, lon], 15);

    // // Add a marker at the selected location
    // L.marker([lat, lon])
    //   .addTo(map)
    //   .bindPopup(properties.name || 'Unnamed location')
    //   .openPopup();

    // Set the selected location in the input field
    document.getElementById('pac-input').value = properties.name || 'Unnamed location';
}


function selectShape(layer) {
    // Clear selection
    clearSelection();

    // Set new selected shape
    selectedShape = layer;
    if (selectedShape instanceof L.Polygon || selectedShape instanceof L.Rectangle) {
        selectedShape.editing.enable();
    }

    updateCurSelText(selectedShape);
}

function clearSelection() {
    if (selectedShape) {
        if (selectedShape instanceof L.Polygon || selectedShape instanceof L.Rectangle) {
            selectedShape.editing.disable();
        }
        selectedShape = null;
    }
}

function updateCurSelText(shape) {
    if (!shape) return;

    var geoJson = shape.toGeoJSON();
    var coordinates = geoJson.geometry.coordinates;

    // Flatten and format coordinates for Polygon or LineString
    if (geoJson.geometry.type === "Polygon" || geoJson.geometry.type === "LineString") {
        // For Polygon, the first element is an array of coordinate arrays
        if (geoJson.geometry.type === "Polygon") {
            coordinates = coordinates[0]; // Use the first array for polygons
        }

        var formattedCoords = coordinates
            .map(coord => coord[1].toFixed(6) + "," + coord[0].toFixed(6))
            .join(" , ");

        document.getElementById("geo_area").value = formattedCoords + " , ";
    } else if (geoJson.geometry.type === "Point") {
        // For Point geometries (like markers)
        var formattedPoint = coordinates[1].toFixed(6) + "," + coordinates[0].toFixed(6);
        document.getElementById("geo_area").value = formattedPoint + " , ";
    }
}


function deleteSelectedShape() {
    if (selectedShape) {
        drawnItems.removeLayer(selectedShape);
        selectedShape = null;
        document.getElementById("geo_area").value = "";
    }
}

function buildColorPalette() {
    var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];
    var colorPalette = document.getElementById('color-palette');

    colors.forEach(function(color) {
        var button = document.createElement('button');
        button.style.backgroundColor = color;
        button.className = 'color-button';
        button.onclick = function() {
            setSelectedShapeColor(color);
        };
        colorPalette.appendChild(button);
    });
}

function setSelectedShapeColor(color) {
    if (selectedShape) {
        if (selectedShape instanceof L.Polygon || selectedShape instanceof L.Rectangle || selectedShape instanceof L.Circle) {
            selectedShape.setStyle({
                fillColor: color,
                color: color
            });
        }
    }
}

// Initialize the map on page load
document.addEventListener('DOMContentLoaded', function() {
    initialize();
    buildColorPalette();
});