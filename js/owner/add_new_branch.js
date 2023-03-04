
const mymap = L.map(map).setView([51.505, -0.09], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
}).addTo(mymap);

let latitude = null;
let longitude = null;

const setMarker = (lat, lng) => {
    marker.setLatLng([lat, lng]);
    mymap.setView([lat, lng], 13);

    // Popup in leaflet
    marker.bindPopup('<p>Your location</p>').openPopup();
}

const getCurrentLocation = () => {
    if (navigator.geolocation) {    //check if geolocation is supported by the browser
        navigator.geolocation.getCurrentPosition((position) => {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;
            setMarker(position.coords.latitude, position.coords.longitude);
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}


//current location btn 
const currentLocationBtn = document.querySelector("#currLocation");