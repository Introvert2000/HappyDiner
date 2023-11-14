<!DOCTYPE html>
<html>
<head>
    <title>Get Current Location</title>
</head>
<body>
    <button onclick="getLocation()">Get My Location</button>
    <p id="location"></p>

    <script>
        function getLocation() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;

                    var locationInfo = "Latitude: " + latitude + "<br>Longitude: " + longitude;
                    document.getElementById("location").innerHTML = locationInfo;
                });
            } else {
                alert("Geolocation is not supported by your browser.");
            }
        }
    </script>
</body>
</html>
