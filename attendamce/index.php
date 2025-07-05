<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Attendance Tracker</title>
<script src="https://cdn.tailwindcss.com/3.4.16"></script>
<script>tailwind.config={theme:{extend:{colors:{primary:'#4f46e5',secondary:'#6366f1'},borderRadius:{'none':'0px','sm':'4px',DEFAULT:'8px','md':'12px','lg':'16px','xl':'20px','2xl':'24px','3xl':'32px','full':'9999px','button':'8px'}}}}</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
<style>
:where([class^="ri-"])::before { content: "\f3c2"; }
body {
font-family: 'Inter', sans-serif;
background-color: #f9fafb;
}
.clock-circle {
box-shadow: 0 0 30px rgba(79, 70, 229, 0.2);
}
.calendar-scroll::-webkit-scrollbar {
display: none;
}
.calendar-scroll {
-ms-overflow-style: none;
scrollbar-width: none;
}
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
-webkit-appearance: none;
margin: 0;
}
.custom-switch {
position: relative;
display: inline-block;
width: 48px;
height: 24px;
}
.custom-switch input {
opacity: 0;
width: 0;
height: 0;
}
.slider {
position: absolute;
cursor: pointer;
top: 0;
left: 0;
right: 0;
bottom: 0;
background-color: #e5e7eb;
transition: .4s;
border-radius: 24px;
}
.slider:before {
position: absolute;
content: "";
height: 18px;
width: 18px;
left: 3px;
bottom: 3px;
background-color: white;
transition: .4s;
border-radius: 50%;
}
input:checked + .slider {
background-color: #4f46e5;
}
input:checked + .slider:before {
transform: translateX(24px);
}
</style>
</head>
<body class="min-h-screen">
<!-- Header -->
<header class="bg-white shadow-sm sticky top-0 z-10">
<div class="container mx-auto px-4 py-4 flex justify-between items-center">
<div>
<h1 class="text-xl font-semibold text-gray-800">Attendance</h1>
<p class="text-sm text-gray-500" id="current-date">June 11, 2025</p>
</div>
<div class="flex items-center gap-3">
<div class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-full cursor-pointer">
<i class="ri-notification-3-line text-gray-600"></i>
</div>
<div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden cursor-pointer">
<img src="https://readdy.ai/api/search-image?query=professional%20headshot%20of%20a%20young%20business%20person%20with%20a%20friendly%20smile%2C%20high%20quality%20professional%20photo%2C%20clean%20background%2C%20business%20attire&width=100&height=100&seq=profile1&orientation=squarish" alt="Profile" class="w-full h-full object-cover">
</div>
</div>
</div>
</header>
<main class="container mx-auto px-4 py-6 pb-24">
<!-- Check-in/Check-out Module -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6 flex flex-col items-center">
<div class="clock-circle w-40 h-40 rounded-full border-4 border-primary flex items-center justify-center mb-6 relative">
<div class="text-center">
<p class="text-sm text-gray-500 mb-1">Current Time</p>
<p class="text-2xl font-bold text-gray-800" id="current-time">09:45 AM</p>
</div>
</div>
<div class="w-full flex flex-col items-center">
<p class="text-sm text-gray-500 mb-3" id="status-text">Not Checked In</p>
<button id="check-button" class="w-full bg-primary text-white py-3 font-medium !rounded-button mb-3 flex items-center justify-center gap-2 whitespace-nowrap">
<i class="ri-login-circle-line"></i>
Check In
</button>
<div class="flex items-center gap-2 text-sm text-gray-600">
<div class="w-5 h-5 flex items-center justify-center">
<i class="ri-map-pin-line"></i>
</div>
<span id="location-status">Verifying your location...</span>
</div>
</div>
</div>
<!-- Today's Statistics -->
<div class="bg-white rounded-lg shadow-sm p-5 mb-6">
<h2 class="text-lg font-semibold text-gray-800 mb-4">Today's Statistics</h2>
<div class="grid grid-cols-2 gap-4">
<div class="border border-gray-100 rounded p-3">
<p class="text-sm text-gray-500 mb-1">Work Duration</p>
<p class="text-xl font-bold text-gray-800" id="work-duration">00:00 hrs</p>
</div>
<div class="border border-gray-100 rounded p-3">
<p class="text-sm text-gray-500 mb-1">Check-in Time</p>
<p class="text-xl font-bold text-gray-800" id="check-in-time">--:--</p>
</div>
<div class="border border-gray-100 rounded p-3">
<p class="text-sm text-gray-500 mb-1">Location</p>
<p class="text-md font-medium text-gray-800 truncate" id="current-location">Not available</p>
</div>
<div class="border border-gray-100 rounded p-3">
<p class="text-sm text-gray-500 mb-1">Status</p>
<div class="flex items-center gap-1">
<span class="w-2 h-2 rounded-full bg-gray-300" id="status-indicator"></span>
<p class="text-md font-medium text-gray-800" id="attendance-status">Not checked in</p>
</div>
</div>
</div>
</div>
<!-- Weekly Overview -->
<div class="bg-white rounded-lg shadow-sm p-5 mb-6">
<div class="flex justify-between items-center mb-4">
<h2 class="text-lg font-semibold text-gray-800">Weekly Overview</h2>
<p class="text-sm text-gray-500">Total: <span class="font-semibold">38.5 hrs</span></p>
</div>
<div class="calendar-scroll overflow-x-auto flex gap-3 pb-2">
<div class="flex-shrink-0 w-14 text-center">
<p class="text-xs text-gray-500">Mon</p>
<div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mx-auto my-2">
<span class="text-sm font-medium">05</span>
</div>
<p class="text-xs font-medium text-green-600">8.2h</p>
</div>
<div class="flex-shrink-0 w-14 text-center">
<p class="text-xs text-gray-500">Tue</p>
<div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mx-auto my-2">
<span class="text-sm font-medium">06</span>
</div>
<p class="text-xs font-medium text-green-600">8.5h</p>
</div>
<div class="flex-shrink-0 w-14 text-center">
<p class="text-xs text-gray-500">Wed</p>
<div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mx-auto my-2">
<span class="text-sm font-medium">07</span>
</div>
<p class="text-xs font-medium text-green-600">7.8h</p>
</div>
<div class="flex-shrink-0 w-14 text-center">
<p class="text-xs text-gray-500">Thu</p>
<div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center mx-auto my-2">
<span class="text-sm font-medium">08</span>
</div>
<p class="text-xs font-medium text-yellow-600">6.5h</p>
</div>
<div class="flex-shrink-0 w-14 text-center">
<p class="text-xs text-gray-500">Fri</p>
<div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mx-auto my-2">
<span class="text-sm font-medium">09</span>
</div>
<p class="text-xs font-medium text-green-600">7.5h</p>
</div>
<div class="flex-shrink-0 w-14 text-center">
<p class="text-xs text-gray-500">Sat</p>
<div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto my-2">
<span class="text-sm font-medium">10</span>
</div>
<p class="text-xs font-medium text-gray-400">0h</p>
</div>
<div class="flex-shrink-0 w-14 text-center">
<p class="text-xs text-gray-500">Sun</p>
<div class="w-12 h-12 rounded-full bg-primary bg-opacity-10 border-2 border-primary flex items-center justify-center mx-auto my-2">
<span class="text-sm font-medium">11</span>
</div>
<p class="text-xs font-medium text-primary">0h</p>
</div>
</div>
</div>
<!-- Recent Activity -->
<div class="bg-white rounded-lg shadow-sm p-5">
<div class="flex justify-between items-center mb-4">
<h2 class="text-lg font-semibold text-gray-800">Recent Activity</h2>
<button class="text-sm text-primary font-medium whitespace-nowrap">View All</button>
</div>
<div class="space-y-4">
<div class="border-b border-gray-100 pb-4">
<div class="flex justify-between mb-1">
<p class="font-medium text-gray-800">Tuesday, June 10</p>
<span class="text-sm text-green-600 font-medium">8.5 hrs</span>
</div>
<div class="flex justify-between text-sm text-gray-500">
<div class="flex items-center gap-1">
<div class="w-4 h-4 flex items-center justify-center">
<i class="ri-login-circle-line"></i>
</div>
<span>09:02 AM</span>
</div>
<div class="flex items-center gap-1">
<div class="w-4 h-4 flex items-center justify-center">
<i class="ri-logout-circle-line"></i>
</div>
<span>05:32 PM</span>
</div>
</div>
<p class="text-xs text-gray-500 mt-1">
<span class="inline-flex items-center">
<div class="w-3 h-3 flex items-center justify-center mr-1">
<i class="ri-map-pin-line"></i>
</div>
Headquarters Office, 123 Business Ave
</span>
</p>
</div>
<div class="border-b border-gray-100 pb-4">
<div class="flex justify-between mb-1">
<p class="font-medium text-gray-800">Monday, June 09</p>
<span class="text-sm text-green-600 font-medium">7.5 hrs</span>
</div>
<div class="flex justify-between text-sm text-gray-500">
<div class="flex items-center gap-1">
<div class="w-4 h-4 flex items-center justify-center">
<i class="ri-login-circle-line"></i>
</div>
<span>09:15 AM</span>
</div>
<div class="flex items-center gap-1">
<div class="w-4 h-4 flex items-center justify-center">
<i class="ri-logout-circle-line"></i>
</div>
<span>04:45 PM</span>
</div>
</div>
<p class="text-xs text-gray-500 mt-1">
<span class="inline-flex items-center">
<div class="w-3 h-3 flex items-center justify-center mr-1">
<i class="ri-map-pin-line"></i>
</div>
Headquarters Office, 123 Business Ave
</span>
</p>
</div>
<div class="border-b border-gray-100 pb-4">
<div class="flex justify-between mb-1">
<p class="font-medium text-gray-800">Friday, June 06</p>
<span class="text-sm text-yellow-600 font-medium">6.5 hrs</span>
</div>
<div class="flex justify-between text-sm text-gray-500">
<div class="flex items-center gap-1">
<div class="w-4 h-4 flex items-center justify-center">
<i class="ri-login-circle-line"></i>
</div>
<span>09:45 AM</span>
<span class="text-xs text-yellow-600 ml-1">(Late)</span>
</div>
<div class="flex items-center gap-1">
<div class="w-4 h-4 flex items-center justify-center">
<i class="ri-logout-circle-line"></i>
</div>
<span>04:15 PM</span>
</div>
</div>
<p class="text-xs text-gray-500 mt-1">
<span class="inline-flex items-center">
<div class="w-3 h-3 flex items-center justify-center mr-1">
<i class="ri-map-pin-line"></i>
</div>
Downtown Branch, 456 City Center
</span>
</p>
</div>
<div>
<div class="flex justify-between mb-1">
<p class="font-medium text-gray-800">Thursday, June 05</p>
<span class="text-sm text-green-600 font-medium">8.2 hrs</span>
</div>
<div class="flex justify-between text-sm text-gray-500">
<div class="flex items-center gap-1">
<div class="w-4 h-4 flex items-center justify-center">
<i class="ri-login-circle-line"></i>
</div>
<span>08:55 AM</span>
</div>
<div class="flex items-center gap-1">
<div class="w-4 h-4 flex items-center justify-center">
<i class="ri-logout-circle-line"></i>
</div>
<span>05:07 PM</span>
</div>
</div>
<p class="text-xs text-gray-500 mt-1">
<span class="inline-flex items-center">
<div class="w-3 h-3 flex items-center justify-center mr-1">
<i class="ri-map-pin-line"></i>
</div>
Headquarters Office, 123 Business Ave
</span>
</p>
</div>
</div>
</div>
</main>
<!-- Bottom Navigation -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2 z-10">
<div class="flex justify-around items-center">
<a href="#" class="flex flex-col items-center py-1">
<div class="w-6 h-6 flex items-center justify-center text-gray-500">
<i class="ri-home-5-line"></i>
</div>
<span class="text-xs text-gray-500 mt-1">Home</span>
</a>
<a href="#" class="flex flex-col items-center py-1">
<div class="w-6 h-6 flex items-center justify-center text-primary">
<i class="ri-time-line"></i>
</div>
<span class="text-xs text-primary font-medium mt-1">Attendance</span>
</a>
<a href="#" class="flex flex-col items-center py-1">
<div class="w-6 h-6 flex items-center justify-center text-gray-500">
<i class="ri-file-chart-line"></i>
</div>
<span class="text-xs text-gray-500 mt-1">Reports</span>
</a>
<a href="#" class="flex flex-col items-center py-1">
<div class="w-6 h-6 flex items-center justify-center text-gray-500">
<i class="ri-settings-3-line"></i>
</div>
<span class="text-xs text-gray-500 mt-1">Settings</span>
</a>
</div>
</nav>
<!-- Location Permission Modal -->
<div id="location-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-20 hidden">
<div class="bg-white rounded-lg p-6 w-11/12 max-w-md">
<div class="w-16 h-16 rounded-full bg-primary bg-opacity-10 flex items-center justify-center mx-auto mb-4">
<div class="w-8 h-8 flex items-center justify-center text-primary">
<i class="ri-map-pin-line text-2xl"></i>
</div>
</div>
<h3 class="text-lg font-semibold text-center mb-2">Location Access Required</h3>
<p class="text-gray-600 text-sm text-center mb-6">
We need your location to verify your attendance. This helps ensure accurate time tracking.
</p>
<div class="flex gap-3">
<button id="deny-location" class="flex-1 border border-gray-300 py-2 text-gray-700 font-medium !rounded-button whitespace-nowrap">
Not Now
</button>
<button id="allow-location" class="flex-1 bg-primary text-white py-2 font-medium !rounded-button whitespace-nowrap">
Allow Access
</button>
</div>
</div>
</div>
<!-- Settings Modal -->
<div id="settings-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-20 hidden">
<div class="bg-white rounded-lg p-6 w-11/12 max-w-md">
<div class="flex justify-between items-center mb-4">
<h3 class="text-lg font-semibold">Attendance Settings</h3>
<button id="close-settings" class="w-8 h-8 flex items-center justify-center text-gray-500">
<i class="ri-close-line text-xl"></i>
</button>
</div>
<div class="space-y-4">
<div class="flex justify-between items-center py-2">
<div>
<p class="font-medium text-gray-800">Location Verification</p>
<p class="text-xs text-gray-500">Require location for check-in/out</p>
</div>
<label class="custom-switch">
<input type="checkbox" checked>
<span class="slider"></span>
</label>
</div>
<div class="flex justify-between items-center py-2">
<div>
<p class="font-medium text-gray-800">Work Hour Notifications</p>
<p class="text-xs text-gray-500">Remind you to check in/out</p>
</div>
<label class="custom-switch">
<input type="checkbox" checked>
<span class="slider"></span>
</label>
</div>
<div class="flex justify-between items-center py-2">
<div>
<p class="font-medium text-gray-800">Offline Mode</p>
<p class="text-xs text-gray-500">Allow check-in without internet</p>
</div>
<label class="custom-switch">
<input type="checkbox">
<span class="slider"></span>
</label>
</div>
<div class="pt-2">
<p class="font-medium text-gray-800 mb-2">Working Hours</p>
<div class="grid grid-cols-2 gap-3">
<div>
<label class="text-xs text-gray-500 block mb-1">Start Time</label>
<input type="time" value="09:00" class="w-full border border-gray-300 rounded p-2 text-sm">
</div>
<div>
<label class="text-xs text-gray-500 block mb-1">End Time</label>
<input type="time" value="17:00" class="w-full border border-gray-300 rounded p-2 text-sm">
</div>
</div>
</div>
</div>
<button class="w-full bg-primary text-white py-3 font-medium !rounded-button mt-6 whitespace-nowrap">
Save Changes
</button>
</div>
</div>
<script id="dateTimeHandler">
document.addEventListener('DOMContentLoaded', function() {
// Set current date
const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
const currentDate = new Date();
document.getElementById('current-date').textContent = currentDate.toLocaleDateString('en-US', dateOptions);
// Update time every second
function updateTime() {
const now = new Date();
const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: true };
document.getElementById('current-time').textContent = now.toLocaleTimeString('en-US', timeOptions);
}
updateTime();
setInterval(updateTime, 1000);
});
</script>
<script id="attendanceHandler">
document.addEventListener('DOMContentLoaded', function() {
const checkButton = document.getElementById('check-button');
const statusText = document.getElementById('status-text');
const workDuration = document.getElementById('work-duration');
const checkInTime = document.getElementById('check-in-time');
const statusIndicator = document.getElementById('status-indicator');
const attendanceStatus = document.getElementById('attendance-status');
let isCheckedIn = false;
let checkInTimeValue = null;
let durationInterval = null;
checkButton.addEventListener('click', function() {
if (!currentPosition) {
  locationModal.classList.remove('hidden');
  return;
}
if (!isCheckedIn) {
// Check in
isCheckedIn = true;
checkInTimeValue = new Date();
const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: true };
checkButton.innerHTML = '<i class="ri-logout-circle-line"></i> Check Out';
checkButton.classList.remove('bg-primary');
checkButton.classList.add('bg-red-500');
statusText.textContent = 'Currently Working';
checkInTime.textContent = checkInTimeValue.toLocaleTimeString('en-US', timeOptions);
statusIndicator.classList.remove('bg-gray-300');
statusIndicator.classList.add('bg-green-500');
attendanceStatus.textContent = 'On time';
// Start duration counter
durationInterval = setInterval(updateDuration, 1000);
// Show location
document.getElementById('current-location').textContent = 'Headquarters Office, 123 Business Ave';
} else {
// Check out
isCheckedIn = false;
clearInterval(durationInterval);
checkButton.innerHTML = '<i class="ri-login-circle-line"></i> Check In';
checkButton.classList.remove('bg-red-500');
checkButton.classList.add('bg-primary');
statusText.textContent = 'Not Checked In';
statusIndicator.classList.remove('bg-green-500');
statusIndicator.classList.add('bg-gray-300');
attendanceStatus.textContent = 'Not checked in';
}
});
function updateDuration() {
if (checkInTimeValue) {
const now = new Date();
const diffMs = now - checkInTimeValue;
const diffHrs = Math.floor(diffMs / 3600000);
const diffMins = Math.floor((diffMs % 3600000) / 60000);
workDuration.textContent = `${String(diffHrs).padStart(2, '0')}:${String(diffMins).padStart(2, '0')} hrs`;
}
}
});
</script>
<script id="locationHandler">
document.addEventListener('DOMContentLoaded', function() {
const locationModal = document.getElementById('location-modal');
const allowLocationBtn = document.getElementById('allow-location');
const denyLocationBtn = document.getElementById('deny-location');
const locationStatus = document.getElementById('location-status');
let currentPosition = null;
function getLocation() {
  if (navigator.geolocation) {
    locationStatus.textContent = 'Getting your location...';
    navigator.geolocation.watchPosition(
      (position) => {
        currentPosition = position;
        const accuracy = Math.round(position.coords.accuracy);
        locationStatus.innerHTML = `
          <span class="text-green-600">Location tracked</span><br>
          <span class="text-xs">Accuracy: ${accuracy}m</span>
        `;
        document.getElementById('current-location').innerHTML = `
          <div class="flex items-center gap-1">
            <span>Lat: ${position.coords.latitude.toFixed(6)}</span>
            <span>Long: ${position.coords.longitude.toFixed(6)}</span>
          </div>
        `;
      },
      (error) => {
        switch(error.code) {
          case error.PERMISSION_DENIED:
            locationStatus.textContent = "Location access denied";
            break;
          case error.POSITION_UNAVAILABLE:
            locationStatus.textContent = "Location unavailable";
            break;
          case error.TIMEOUT:
            locationStatus.textContent = "Location request timed out";
            break;
        }
        locationStatus.classList.add('text-red-500');
      },
      {
        enableHighAccuracy: true,
        timeout: 10000,
        maximumAge: 0
      }
    );
  } else {
    locationStatus.textContent = 'Geolocation is not supported';
    locationStatus.classList.add('text-red-500');
  }
}
// Show location modal after a short delay
setTimeout(() => {
  locationModal.classList.remove('hidden');
}, 1500);
allowLocationBtn.addEventListener('click', function() {
  locationModal.classList.add('hidden');
  getLocation();
});
denyLocationBtn.addEventListener('click', function() {
locationModal.classList.add('hidden');
locationStatus.textContent = 'Location access denied';
locationStatus.classList.add('text-red-500');
});
});
</script>
<script id="settingsHandler">
document.addEventListener('DOMContentLoaded', function() {
const settingsLinks = document.querySelectorAll('a[href="#"]');
const settingsModal = document.getElementById('settings-modal');
const closeSettings = document.getElementById('close-settings');
settingsLinks.forEach(link => {
if (link.querySelector('i.ri-settings-3-line')) {
link.addEventListener('click', function(e) {
e.preventDefault();
settingsModal.classList.remove('hidden');
});
}
});
closeSettings.addEventListener('click', function() {
settingsModal.classList.add('hidden');
});
});
</script>
</body>
</html>