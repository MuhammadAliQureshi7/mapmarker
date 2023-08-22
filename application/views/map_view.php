<!DOCTYPE html>
<html>
<head>
    <title>Map Integration in CodeIgniter</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTlnNe8ikXLYvq9jhRbG3-5R3Q75pM-Jo&libraries=places"></script>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 7,
                center: {lat: 24.86735372026556, lng: 67.08136600875855}
            });

            var marker = new google.maps.Marker({
                position: {lat: 24.86735372026556, lng: 67.08136600875855},
                map: map,
                draggable: true
            });           
            google.maps.event.addListener( marker, "dragend", function ( event ) {
                var lat, long, address, resultArray, citi;

                console.log( 'i am dragged' );
                lat = marker.getPosition().lat();
                long = marker.getPosition().lng();

                var geocoder = new google.maps.Geocoder();
                geocoder.geocode( { latLng: marker.getPosition() }, function ( result, status ) {
                    if ( 'OK' === status ) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
                        address = result[0].formatted_address;
                        resultArray =  result[0].address_components;
                        
                        document.getElementById( "address" ).value = address;
                        document.getElementById( "latitude" ).value = lat;
                        document.getElementById( "longitude" ).value = long;

                    } else {
                        console.log( 'Geocode was not successful for the following reason: ' + status );
                    }

                    // Closes the previous info window if it already exists
                    if ( infoWindow ) {
                        infoWindow.close();
                    }

                    /**
                     * Creates the info Window at the top of the marker
                     */
                    infoWindow = new google.maps.InfoWindow({
                        content: address
                    });

                    infoWindow.open( map, marker );
                } );
            });
          
        }        
    </script>
</head>
<body onload="initMap()">
    <div id="map" style="height: 500px;"></div>
    <form method="post" action="<?php echo base_url('welcome/save_location'); ?>">
        <input type="text" id="latitude" name="latitude" placeholder="Latitude">
        <input type="text" id="longitude" name="longitude" placeholder="Longitude">
        <input type="text" name="address" id="address">
        <input type="submit" value="Save">
    </form>
</body>
</html>
