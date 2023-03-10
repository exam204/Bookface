<?php
session_start();
?>
<!-- https://grid.layoutit.com/ -->
<!DOCTYPE html>
<html>
  <head>
    
    <title>Air Quality Map</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBY8fSIy0uw7pMxa86nkkM-BLQ9DA_4t-0"></script>
	<?php require dirname(__FILE__). "/Style/links.php";?>
	<?php require dirname(__FILE__). "/PHPFunc/db-connect.php";?>
	<style>
	.container {  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
  grid-template-rows: 1fr 1fr 1fr 1fr 1fr;
  gap: 0px 0px;
  grid-auto-flow: row;
  grid-template-areas:
    "Navb Navb Navb Navb Navb Navb"
    "step step kcal kcal heft heft"
    "step step kcal kcal heft heft"
    "imsg dash dash dash dash imgs"
    "imsg dash dash dash dash imgs";
}

.Navb { grid-area: Navb; }

.step { grid-area: step; }

.kcal { grid-area: kcal; }

.heft { grid-area: heft; }

.dash { grid-area: dash; }

.imgs { grid-area: imgs; }

.imsg { grid-area: imsg; }


html, body , .container {
  height: 100%;
  max-width: 100% !important;
}

/* For presentation only, no need to copy the code below */

.container * {
  border: 1px solid red;
  position: relative;
}

.container *:after {
  content:attr(class);
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: grid;
  align-items: center;
  justify-content: center;
}
	</style>
  
    <script>
      function mapload(){
      
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
          var location = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
      var map = new google.maps.Map(document.getElementById('map'), {
        center: location,
        zoom: 10
      });
      // Make request to AirVisual API to get air quality data
      // ...
    }, function() {
      alert('Geolocation failed. Please enter a postcode to get air quality data.');
    });
  } else {
    alert('Geolocation is not supported by this browser. Please enter a postcode to get air quality data.');
  }
}


      window.onload = function() {
        mapload();
      };

      function initMap() {
        var geocoder = new google.maps.Geocoder();
        var address = document.getElementById('postcode').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            var location = results[0].geometry.location;
            var map = new google.maps.Map(document.getElementById('map'), {
              center: location,
              zoom: 10
            });
            // Make request to AirVisual API to get air quality data
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'https://api.airvisual.com/v2/nearest_city?key=fc530c3a-1e3d-4e19-afa4-74045818d1f1&lat=' + location.lat() + '&lon=' + location.lng());
            xhr.onload = function() {
              if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText).data.current.pollution;
                var aqi = data.aqius;
                var category = data.aqicn;
                var color;
                if (aqi <= 50) {
                  category = 'Good';
                  color = 'green';
                } else if (aqi <= 100) {
                  category = 'Moderate';
                  color = 'yellow';
                } else if (aqi <= 150) {
                  category = 'Unhealthy for Sensitive Groups';
                  color = 'orange';
                } else if (aqi <= 200) {
                  category = 'Unhealthy';
                  color = 'red';
                } else if (aqi <= 300) {
                  category = 'Very Unhealthy';
                  color = 'purple';
                } else {
                  category = 'Hazardous';
                  color = 'maroon';
                }

                // Create custom marker and info window for air quality data
                var marker = new google.maps.Marker({
                  position: location,
                  map: map,
                  icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|' + color
                });
                var infowindow = new google.maps.InfoWindow({
                  content: '<h3>Air Quality Data</h3>' +
                           '<p>Location: ' + address + '</p>' +
                           '<p>AQI: ' + aqi + '</p>' +
                           '<p>Category: ' + category + '</p>'
                });
                infowindow.open(map, marker);
              } else {
                alert('Request failed. Returned status of ' + xhr.status);
              }
            };
            xhr.send();
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
    </script>
  </head>
  <body>
	  


  <div class="container">
    <div class="Navb">
      <?php require dirname(__FILE__). "/templates/nav.php"; ?>
    </div>
    <div class="step"></div>
    <div class="kcal"></div>
    <div class="heft"></div>

    <div class="dash">
    <form>
      <label for="postcode">Enter postcode:</label>
      <input type="text" id="postcode" name="postcode">
      <button type="button" onclick="initMap()">Get Air Quality Data</button>
    </form>
      <div id="map" style="height: 400px; width: 50%;" ></div>
      <div name="airvisual_widget" key="64089b73b0b7ebb6110eaeea"></div>
      <script type="text/javascript" src="https://widget.iqair.com/script/widget_v3.0.js"></script>
    </div>

    <div class="imgs"></div>
    <div class="imsg"></div>
  </div>





	

</body>
</html>

