@extends('layouts.app')
<style>
    #map {
        height: 100%;
    }
</style>
@section('content')
    <div class="row">
        <div class="col-lg-12 body-content">
            <div id="map"></div>
        </div>
    </div>
    <script>
        function initMap() {
             
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 16,
            
            });



            var infoWindow = new google.maps.InfoWindow({map: map});

            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                                      'Error: The Geolocation service failed.' :
                                      'Error: Your browser doesn\'t support geolocation.');
              }

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude
                };

                var marker = new google.maps.Marker({
                  position: pos,
                  map: map,
                  title: 'TMS Center.'
                });
                map.setCenter(pos);
              }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
              });
            } else {
              // Browser doesn't support Geolocation
              handleLocationError(false, infoWindow, map.getCenter());
            }
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBY2xnVxwjLYhuBNmhiMDUExm-vpUBa-IY&callback=initMap&libraries=places"
            async defer></script>

@endsection