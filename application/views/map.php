<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADwbHO4npy1NA-CWARlFal4I4A5WZ8Bao&callback=initialize"></script>

</head>
<body>
    <div id="map"></div>
    <?php /* echo form_open('welcome/get_location'); ?>
        <input type="text" name="address" placeholder="Enter your address">
        <button type="submit">Get Location</button>
    <?php echo form_close(); */?>
    <script>
    // Initialize the map
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: {lat: -34.397, lng: 150.644}
    });

    // Try HTML5 geolocation to get the user's current location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            // Add a marker for the user's current location
            var marker = new google.maps.Marker({
                position: pos,
                map: map
            });

            // Save the user's lat and lng to the database
            $.ajax({
                url: '<?php echo base_url('welcome/save_location'); ?>',
                type: 'POST',
                data: {lat: pos.lat, lng: pos.lng},
                success: function(response) {
                    console.log(response);
                }
            });

            map.setCenter(pos);
        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
</script>

</body>
</html>