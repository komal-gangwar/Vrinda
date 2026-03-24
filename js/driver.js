function send() {
    if (!navigator.geolocation) {
        alert("Geolocation is not supported by your browser.");
        return;
    }

    const options = {
        enableHighAccuracy: true,
        timeout: 10000,
        maximumAge: 0
    };

    navigator.geolocation.watchPosition(function (position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        const bus = document.getElementById('busDropdown').value;

        const formData = new FormData();
        formData.append("lati", latitude);
        formData.append("long", longitude);
        formData.append("bus", bus);
        console.log(latitude, longitude);

        fetch("backend/driver.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "") {
                    document.getElementById("response").textContent = "Location updated.";
                } else {
                    document.getElementById("response").textContent = "Error: " + data;
                }
                //sendNotification(); // Schedule next update
            })
            .catch(error => {
                console.error("Fetch error:", error);
                document.getElementById("response").textContent = "Something went wrong.";
                setTimeout(send, 1000); // retry after delay
            });

    }, function (error) {
        console.error("Geolocation error:", error);
        document.getElementById("response").textContent = "Geolocation failed.";
        setTimeout(send, 1000); // retry after delay
    }, options);
}

// Introduce a delay here to avoid rapid-fire requests
function sendNotification() {
    send();
    // setTimeout(send, 2000); // call send after 5 seconds
}


function getDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // km
    const dLat = toRad(lat2 - lat1);
    const dLon = toRad(lon2 - lon1);
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}

function toRad(value) {
    return value * Math.PI / 180;
}
function noti() {
    const bus = document.getElementById('busDropdown').value;
    const refLat = 28.476875;
    const refLng = 79.436193;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const currentLat = position.coords.latitude;
                const currentLng = position.coords.longitude;
                const distance = getDistance(currentLat, currentLng, refLat, refLng);

                const formData = new FormData();
                formData.append("bus", bus);

                if (distance <= 3) {

                    alert("bus nikal gayi");
                    // 🚍 Bus is near reference: call bus_start.php
                    fetch("backend/bus_start.php", {
                        method: "POST",
                        body: formData
                    })
                        .then(response => response.text())
                        .then(data => {
                            alert("Bus Start: " + data);
                        });
                } else {
                    alert("bus nikal gayi ha");
                    // 🛣️ Bus is far: call checkstp.php
                    let data1;
                    function uplo1() {
                        // Get bus from URL

                        if (!bus) {
                            console.error("Bus parameter is missing in the URL.");
                            return; // Exit if bus parameter is not found
                        }
                        const formData2 = new FormData();
                        formData2.append("bus", bus);
                        fetch('backend/stopcr.php', {
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
                                data1 = data;
                            })
                    }
                    uplo1();
                    let i = 0;
                    let isChecking = false;

                    function uplo2() {
                        if (isChecking || !data1 || i >= data1.length) return;
                        isChecking = true;

                        var bus1 = bus;
                        const formData3 = new FormData();
                        formData3.append("stop", data1[i].trim());  // Just to be extra sure
                        formData3.append("bus", bus1);

                        fetch('backend/checkstp.php', {
                            method: "POST",
                            body: formData3
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(dataa => {
                                console.log("Raw dataa:", dataa);
                                if (dataa.key == 1) {
                                    i++;
                                }
                                console.log(dataa.text, " ", dataa.key);
                            })
                            .catch(err => console.error("Fetch error:", err))
                            .finally(() => {
                                isChecking = false;
                            });
                    }

                    setInterval(() => {
                        uplo2();
                        console.log("called");
                    }, 2000);

                }
            },
            (error) => {
                alert("GPS access denied or unavailable.");
            }
        );
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}