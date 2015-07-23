<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <title>Directions service</title>
    <style>
      html, body, #map-canvas {
        height:100%;
  height:100%;
  width:100%;
        margin: -20;
        padding: 0;
      }

      #panel {
        position: absolute;
	width: 35%;
        top: 2px;
        left: 200px;
        margin-left: 0%;

        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
#overmap {
  position:absolute;
  top:20px;
  left:20px;
  z-index:99;
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
  var chicago = new google.maps.LatLng(38.892721,-77.079252);
  var mapOptions = {
    zoom:7,
    center: chicago
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  directionsDisplay.setMap(map);
}

function calcRouteInput() {
  var start2 = document.getElementById('start2').value;
  var end2 = document.getElementById('end2').value;
  var request2 = {
      origin:start2,
      destination:end2,
      travelMode: google.maps.TravelMode.DRIVING
  };
  directionsService.route(request2, function(response2, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response2);
    }
  });
}

function calcRouteSelect() {
  var start1 = document.getElementById('start1').value;
  var end1 = document.getElementById('end1').value;
  //var end = <?php echo $_POST["destination"];?>;
  var request = {
      origin:start1,
      destination:end1,
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
    <div data-role="page" >
      <div data-role="panel" id="overlayPanel" data-display="overlay">
        <h2>Overlay Panel</h2> 
        <p>Some text here</p>

<br>
    <b>Start: </b>
    <select id="start1" onchange="calcRouteSelect();">
      <option value="">Select starting point</option>
      <?php require 'db/connect.php';
      $result=$conn->query("SELECT address,name FROM place"); 
      if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
      ?>
      <option value="<?php echo $row['address']; ?>"><?php echo $row['name']?></option>
      <?php }} ?>    
    </select>

    <b>End: </b>
    <select id="end1" onchange="calcRouteSelect()">
      <option value="">Select Destination</option>
      <?php require 'db/connect.php';
      $result=$conn->query("SELECT address,name FROM place"); 
      if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
      ?>
      <option value="<?php echo $row['address']; ?>"><?php echo $row['name']?></option>
      <?php }} ?>    
    </select>

      <input type="text" id='start2' onchange="calcRouteInput()">
        <option value=""></option>
      </input>
      <input type="text" id='end2' onchange="calcRouteInput()">
        <option value=""></option>
      </input>
      <input type="submit" value="Submit">

      <div align="center">  <a href="#panel" data-rel="close" class="ui-btn ui-btn-inline ui-shadow ui-corner-all ui-btn-a ui-icon-delete ui-btn-icon-left ui-mini">Close panel</a></div>

    </div>
  </div>
  <div data-role="panel" id="overmap" class="ui-content">
    <a href="#overlayPanel" class="ui-btn ui-btn-inline ui-corner-all ui-shadow">Overlay Panel</a>
  </div>

    <div id="map-canvas"></div>
  </body>
</html>


