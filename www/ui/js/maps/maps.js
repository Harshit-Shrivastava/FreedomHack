var geocoder;
var map;
var directionsService;
function initialize() {
  geocoder = new google.maps.Geocoder();
  directionsService = new google.maps.DirectionsService();
  var latlng = new google.maps.LatLng(-34.397, 150.644);
  var mapOptions = {
    zoom: 8,
    center: latlng
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}

function codeAddress(place) {
  geocoder.geocode( { 'address': place}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

function calcRoute(start, end) {
  // Retrieve the start and end locations and create
  // a DirectionsRequest using WALKING directions.
  var request = {
      origin: start,
      destination: end,
      travelMode: google.maps.TravelMode.DRIVING,
      provideRouteAlternatives: true,
      avoidHighways: false,
      avoidTolls: false

  };

  // Route the directions and pass the response to a
  // function to create markers for each step.
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      return response;
    }
  });
}