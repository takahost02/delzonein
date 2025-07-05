(function($){ 
  'use strict';
  document.addEventListener("DOMContentLoaded", function () {
    function initAutocomplete(inputId, listId, latId, lonId) {
        let input = document.getElementById(inputId);
        let list = document.getElementById(listId);
        if (!input || !list) return;
  
        const loader = document.createElement("div");
        loader.className = "loader";
        input.parentElement.style.position = "relative";
        input.parentElement.appendChild(loader);
  
        let debounceTimer;
  
        input.addEventListener("input", function () {
            clearTimeout(debounceTimer);
  
            let query = this.value.trim();
            if (!query) {
                list.innerHTML = "";
                loader.style.display = "none";
                return;
            }
  
            loader.style.display = "block";
  
            debounceTimer = setTimeout(() => {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        list.innerHTML = "";
                        loader.style.display = "none";
  
                        data.forEach(place => {
                            let item = document.createElement("li");
                            item.textContent = place.display_name;
                            item.onclick = function () {
                              input.value = place.display_name;
                              if (latId && document.getElementById(latId)) {
                                document.getElementById(latId).value = place.lat;
                              }
                              if (lonId && document.getElementById(lonId)) {
                                  document.getElementById(lonId).value = place.lon;
                              }
                              list.innerHTML = "";
                              list.style.display = "none";  // Close the autocomplete suggestion
                              calculateDistance();
                          };
                          
                            list.appendChild(item);
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching location data:", error);
                        loader.style.display = "none";
                    });
            }, 500);
        });
  
        document.addEventListener("click", function (e) {
            if (!list.contains(e.target) && e.target !== input) {
                list.innerHTML = "";
            }
        });
      }
  
      function calculateDistance() {
          let lat1 = parseFloat(document.getElementById("t_trip_fromlat").value);
          let lon1 = parseFloat(document.getElementById("t_trip_fromlog").value);
          let lat2 = parseFloat(document.getElementById("t_trip_tolat").value);
          let lon2 = parseFloat(document.getElementById("t_trip_tolog").value);
          if (!lat1 || !lon1 || !lat2 || !lon2) return;
  
          let R = document.getElementById('mapunit').value === "mile" ? 3958.8 : 6371;
          let dLat = (lat2 - lat1) * Math.PI / 180;
          let dLon = (lon2 - lon1) * Math.PI / 180;
          let a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
          let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
          let distance = (R * c).toFixed(2);
          document.getElementById("t_totaldistance").value = distance;
      }
  
      initAutocomplete("autocomplete", "autocomplete-list", "t_trip_fromlat", "t_trip_fromlog");
      initAutocomplete("autocomplete2", "autocomplete-list2", "t_trip_tolat", "t_trip_tolog");
      initAutocomplete("autocomplete3", "autocomplete-list3", "t_trip_stops", "t_trip_stops");
  
      // Expose as global
      window.initAutocomplete = initAutocomplete;  
  
  });
  })(jQuery);
  