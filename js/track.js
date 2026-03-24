function maploadkar() {
   
    if (!bus) {
        console.error("Bus parameter is missing in the URL.");
        return; // Exit if bus parameter is not found
    }

    var mark, map;

    function any() {
        map = new MapmyIndia.Map("map", {
            center: [28.6139, 77.2090],  // Default center (Delhi)
            zoom: 15
        });
        mark = new L.marker([28.6139, 77.2090]).addTo(map);
        uplo();
        setInterval(uplo, 2000);  // Update every 5 seconds
    }

    function uplo() {
        const formData2 = new FormData();
        formData2.append("bus", bus);  // Always send bus number

        fetch('backend/track.php', {
            method: "POST",
            body: formData2
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const latitude = parseFloat(data.LATITUDE || data.latitude);
            const longitude = parseFloat(data.LONGITUDE || data.longitude);

            if (!isNaN(latitude) && !isNaN(longitude)) {
                mark.setLatLng([latitude, longitude]);
                map.setView([latitude, longitude], 15);
            } else {
                console.warn("Invalid coordinates:", data);
            }
        })
        .catch(error => {
            console.error('Error occurred:', error);
            alert('Failed to fetch location data. Please check the server.');
        });
    }

    any(); // Call the function to initialize the map
}
setTimeout(maploadkar, 1000); 