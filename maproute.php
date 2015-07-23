<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Directions service</title>
    <style>
      html, body, #map-canvas {
        height:100%;
        margin: 0;
        padding: 0;
      }

      #panel {
        position: absolute;
	width: 35%;
        top: 2px;
        left: 5px;
        margin-left: 0%;

        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }

      /*
      Provide the following styles for both ID and class,
      where ID represents an actual existing "panel" with
      JS bound to its name, and the class is just non-map
      content that may already have a different ID with
      JS bound to its name.
      */

      #panel, .panel {
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }

      #panel select, #panel input, .panel select, .panel input {
        font-size: 15px;
      }

      #panel select, .panel select {
        width: 100%;
      }

      #panel i, .panel i {
        font-size: 12px;
      }

    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script>
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;

function initialize() {
  directionsDisplay = new google.maps.DirectionsRenderer();
  var chicago = new google.maps.LatLng(41.850033, -87.6500523);
  var mapOptions = {
    zoom:7,
    center: chicago
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  directionsDisplay.setMap(map);
}

function calcRoute() {
  var start = document.getElementById('start').value;
  var end = document.getElementById('end').value;
  var request = {
      origin:start,
      destination:end,
      travelMode: google.maps.TravelMode.DRIVING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    }
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="panel">

    <b>Start: </b>
    <select id="start" onchange="calcRoute();">
      <option>Select starting point</option>
      <?php require 'db/connect.php';
      $result=$conn->query("SELECT address,name FROM place"); 
      if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
      ?>
      <option value="<?php echo $row['address']; ?>"><?php echo $row['name']?></option>
      <?php }} ?>    
    </select>

    <b>End: </b>
    <select id="end" onchange="calcRoute();">
      <option value="">Select Destination</option>
      <?php require 'db/connect.php';
      $result=$conn->query("SELECT address,name FROM place"); 
      if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
      ?>
      <option value="<?php echo $row['address']; ?>"><?php echo $row['name']?></option>
      <?php }} ?>    
    </select>
    </div>
    <div id="map-canvas"></div>
  </body>
</html>


