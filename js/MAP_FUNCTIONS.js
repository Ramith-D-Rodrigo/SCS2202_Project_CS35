//to get the coordinates of the clicked point on the map

//map functions
const intializeMap = (divID, lat, lng) => {
    const map = L.map(divID).setView([lat, lng], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);
    return map;
}

const setMarker = (map, lat, lng) => {   //set marker on the map with the given coordinates
    //get the current zoom level of the map
    map.setView([lat, lng], map.getZoom());
    L.marker([lat, lng]).addTo(map);
}


const getCurrentLocationAsync = () => {
    return new Promise((resolve, reject) => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                const latitude =  position.coords.latitude;
                const longitude = position.coords.longitude;
                resolve({latitude, longitude});
            }, (error) => {
                console.log(error);
                reject(error);
            });
        } else {
            reject("Geolocation is not supported by this browser.");
        }
    });
}

const getCurrentLocationSync = async () => {
    try{
        const currentLocation = await getCurrentLocationAsync();
        return currentLocation;
    }
    catch(error){
        console.log(error);
    }
}



//to get the coordinates of the clicked point on the map
const getClickedCoordinates = (map, event) => {
    //reset the map
    resetMap(map);

    const latitude = event.latlng.lat;
    const longitude = event.latlng.lng;
    
    return {latitude, longitude};
}

const resetMap = (map) => {
    //remove all markers from the map
    map.eachLayer((layer) => {
        if (layer instanceof L.Marker) {
            map.removeLayer(layer);
        }
    });
}

//export everything
export { intializeMap, getCurrentLocationSync, getClickedCoordinates, resetMap, setMarker};