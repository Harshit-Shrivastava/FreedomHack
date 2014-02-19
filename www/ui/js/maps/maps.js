var geocoder;
var map;
var directionsService;
var markerArray;
var directionsDisplay;
var noOfDisplayRenderers = 0;
var directionsDisplayMultiple;
function union_arrays (x, y) {
 var obj = {};
 for (var i = x.length-1; i >= 0; -- i)
    obj[x[i]] = x[i];
 for (var i = y.length-1; i >= 0; -- i)
    obj[y[i]] = y[i];
 var res = []
 for (var k in obj) {
   if (obj.hasOwnProperty(k))  // <-- optional
     res.push(obj[k]);
 }
 return res;
}

function initialize(data) {
 //alert('init');
 geocoder = new google.maps.Geocoder();
 markerArray = [];
 directionsService = new google.maps.DirectionsService();
 var rendererOptions = { map: map };
 //directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
 directionsDisplayMultiple = [];

 for(var i = 0; i < data.arrivals.length; i++) {
   directionsDisplayMultiple[i] = new google.maps.DirectionsRenderer({
     suppressMarkers: true
   });
   }
 var latlng = new google.maps.LatLng(-34.397, 150.644);
 var mapOptions = {
   zoom: 6,
   center: latlng
 }
 map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
 
 var arr = union_arrays(data.departures, data.arrivals);
 
 /*for(var i = 0; i < arr.length; i++) {
   drawMap(arr[i], arr[i]);
 }*/

 for(var i = 0; i < data.departures.length; i++) {
   //drawMap(data.departures[i], data.departures[i]);
   //drawMap(data.arrivals[i], data.arrivals[i]);
   
   //drawMap(arr[i], arr[i]);
   calcRoute(data.departures[i], data.arrivals[i], i);
   directionsDisplayMultiple[i].setMap(map);
 }
}

function initializeMapData(start, end) {
 //alert('init');
 geocoder = new google.maps.Geocoder();
 markerArray = [];
 directionsService = new google.maps.DirectionsService();
 var rendererOptions = { map: map };
 //directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
 directionsDisplay = new google.maps.DirectionsRenderer({
   suppressMarkers: true
 });
 var latlng = new google.maps.LatLng(-34.397, 150.644);
 var mapOptions = {
   zoom: 6,
   center: latlng
 }
 map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
 directionsDisplay.setMap(map);
 calcRouteMapData(start, end);
}

function drawMap(place, contentString) {
 //alert(geocoder);
 
 geocoder.geocode( { 'address': place}, function(results, status) {
   if (status == google.maps.GeocoderStatus.OK) {
     map.setCenter(results[0].geometry.location);
     var marker = new google.maps.Marker({
         map: map,
         position: results[0].geometry.location
     });
     /*var infowindow = new google.maps.InfoWindow({
         content: contentString
     });
     google.maps.event.addListener(marker, 'click', function() {
       infowindow.open(map,marker);
     });*/
   } else {
     alert('Geocode was not successful for the following reason: ' + status);
   }
 });

}

function calcRoute(start, end, index) {
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

 // First, remove any existing markers from the map.
 for (var i = 0; i < markerArray.length; i++) {
   markerArray[i].setMap(null);
 }

 // Now, clear the array itself.
 markerArray = [];

 // Route the directions and pass the response to a
 // function to create markers for each step.
 directionsService.route(request, function(response, status) {
   if (status == google.maps.DirectionsStatus.OK) {
     //return response;
     directionsDisplayMultiple[index].setDirections(response);
     showSteps(response, 0);
     //Show Steps to draw path
   }
 });
}

function calcRouteMapData(start, end) {
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

 // First, remove any existing markers from the map.
 for (var i = 0; i < markerArray.length; i++) {
   markerArray[i].setMap(null);
 }

 // Now, clear the array itself.
 markerArray = [];

 // Route the directions and pass the response to a
 // function to create markers for each step.
 directionsService.route(request, function(response, status) {
   if (status == google.maps.DirectionsStatus.OK) {
     //return response;
     directionsDisplay.setDirections(response);
     var bestRouteIndex = calculateBestRoute(response);
     showStepsMapData(response, bestRouteIndex);
     //Show Steps to draw path
   }
 });
}

function attachInstructionText(marker, text) {
 google.maps.event.addListener(marker, 'click', function() {
   // Open an info window when the marker is clicked on,
   // containing the text of the step.
   stepDisplay.setContent(text);
   stepDisplay.open(map, marker);
 });
}

function showSteps(directionResult, index) {
 map.setCenter(directionResult.routes[index].legs[0].start_location);
 var myRoute = directionResult.routes[index].legs[0];
     var marker = new google.maps.Marker({
       position: myRoute.steps[0].start_location,
       map: map
     });
     var infowindow = new google.maps.InfoWindow({
         content: 'From: ' + directionResult.routes[index].legs[0].start_address + "<br />" + 'To: ' + directionResult.routes[index].legs[0].end_address + '<br />Carbon Footprint: ' + (directionResult.routes[0].legs[0].distance.value * 175) / 1000000 + ' kg/tonne'
     });
     google.maps.event.addListener(marker, 'click', function() {
       infowindow.open(map,marker);
     });
   /*for (var i = 0; i < myRoute.steps.length; i++) {
     var marker = new google.maps.Marker({
       position: myRoute.steps[i].start_location,
       map: map
     });
     var isPresent = map.getBounds().contains(marker.getPosition())
       if(!isPresent) {
         var infowindow = new google.maps.InfoWindow({
             content: '' + (directionResult.routes[0].legs[0].distance.value * 175) / 1000
         });
         google.maps.event.addListener(marker, 'click', function() {
           infowindow.open(map,marker);
         });
         attachInstructionText(marker, myRoute.steps[i].instructions);
         markerArray[i] = marker;
         map.setCenter(myRoute.steps[i].start_location);
         
     }
   }*/
}

function showStepsMapData(directionResult, index) {
 map.setCenter(directionResult.routes[index].legs[0].start_location);
 var myRoute = directionResult.routes[index].legs[0];
     var marker = new google.maps.Marker({
       position: myRoute.start_location,
       map: map
     });
     var infowindow = new google.maps.InfoWindow({
         content: 'From: ' + directionResult.routes[index].legs[0].start_address + "<br />" + 'To: ' + directionResult.routes[index].legs[0].end_address + '<br />Carbon Footprint: ' + (directionResult.routes[0].legs[0].distance.value * 175) / 1000000 + ' kg/tonne'
     });
     google.maps.event.addListener(marker, 'click', function() {
       infowindow.open(map,marker);
     });

     var marker_end = new google.maps.Marker({
       position: myRoute.end_location,
       map: map
     });
     var infowindow = new google.maps.InfoWindow({
         content: 'From: ' + directionResult.routes[index].legs[0].start_address + "<br />" + 'To: ' + directionResult.routes[index].legs[0].end_address + '<br />Carbon Footprint: ' + (directionResult.routes[0].legs[0].distance.value * 175) / 1000000 + ' kg/tonne'
     });
     google.maps.event.addListener(marker_end, 'click', function() {
       infowindow.open(map,marker_end);
     });

   /*for (var i = 0; i < myRoute.steps.length; i++) {
     var marker = new google.maps.Marker({
       position: myRoute.steps[i].start_location,
       map: map
     });
     var isPresent = map.getBounds().contains(marker.getPosition())
       if(!isPresent) {
         var infowindow = new google.maps.InfoWindow({
             content: '' + (directionResult.routes[0].legs[0].distance.value * 175) / 1000
         });
         google.maps.event.addListener(marker, 'click', function() {
           infowindow.open(map,marker);
         });
         attachInstructionText(marker, myRoute.steps[i].instructions);
         markerArray[i] = marker;
         map.setCenter(myRoute.steps[i].start_location);
         
     }
   }*/
}

function attachInstructionText(marker, text) {
 /*google.maps.event.addListener(marker, 'click', function() {
   // Open an info window when the marker is clicked on,
   // containing the text of the step.
   stepDisplay.setContent(text);
   stepDisplay.open(map, marker);
 });*/
}

function calculateBestRoute(response) {
  var lowestIndex = 0;
  for(var i = 0; i < response.routes.length; i++) {
    if(response.routes[i].legs[0].distance.value < response.routes[lowestIndex].legs[0].distance.value)
      lowestIndex = i;
  }
  return lowestIndex;
}