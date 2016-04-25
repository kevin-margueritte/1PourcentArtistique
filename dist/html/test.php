<!DOCTYPE html>
<html>

  <head>
    <title>Drawing tools</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      
      #map {
        height: 100%;
      }
    </style>
  </head>

  <body>
    <div id="map"></div>
    <script>
      function initMap()
      {
        var map = new google.maps.Map(document.getElementById('map'),
        {
          center:
          {
            lat: -34.397,
            lng: 150.644
          },
          zoom: 8
        });
        var marker;

        function placeMarker(location)
        {
          if (marker)
          {
            marker.setPosition(location);
          }
          else
          {
            marker = new google.maps.Marker(
            {
              position: location,
              map: map
            });
          }
        }
        map.addListener('click', function(event)
        {
          console.log(event.latLng.lat());
          console.log(event.latLng.lng());
          placeMarker(event.latLng);
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDj9L77r-tVMiQNKm0iDaqYVnbjRO57HPc&signed_in=true&libraries=drawing&callback=initMap" async defer></script>
  </body>

</html>