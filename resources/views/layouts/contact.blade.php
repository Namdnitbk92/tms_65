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
                center: {lat: 40.674, lng: -73.945},
                zoom: 12,
                styles: [
                    {
                        featureType: 'all',
                        stylers: [
                            {saturation: -80}
                        ]
                    }, {
                        featureType: 'road.arterial',
                        elementType: 'geometry',
                        stylers: [
                            {hue: '#00ffee'},
                            {saturation: 50}
                        ]
                    }, {
                        featureType: 'poi.business',
                        elementType: 'labels',
                        stylers: [
                            {visibility: 'off'}
                        ]
                    }
                ]
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBY2xnVxwjLYhuBNmhiMDUExm-vpUBa-IY&callback=initMap"
            async defer></script>

@endsection