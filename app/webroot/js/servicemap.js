function initHealthMap() {
    var map = new google.maps.Map(document.getElementById('service-map-wrap'), {
        zoom: 13,
        center: {lat: -37.8180, lng: 144.9760},
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    });
    //Add hospitals data into maps
    var ctaLayer = new google.maps.KmlLayer({
        url: kmlPath,
        map: map,
        preserveViewport: true
    });
    //Add an info window to show current position information
    var infoWindow = new google.maps.InfoWindow();

    var marker = new google.maps.Marker({
        icon: "https://www.phoenixchildrens.org/sites/default/files/images/hospital-building.png",
        map: map
    });

    // Determine user's current location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Here is your current location');
            infoWindow.setMap(map);
            map.setCenter(pos);
        });
    }
}