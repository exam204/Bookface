<?php
session_start();
?>
<!-- https://grid.layoutit.com/ -->

<?php
require dirname(__FILE__). "/PHPFunc/db-connect.php";



// Steps
  $userid = intval($_SESSION['userid']);
  $conn = connect();
  $query = "SELECT date, steps FROM steps WHERE userid = ? ORDER BY date ASC";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $userid);
  $stmt->execute();
  $result = $stmt->get_result();

  $stepdates = [];
  $steps = [];
  while ($row = $result->fetch_assoc()) {
    $stepdates[] = $row['date'];
    $steps[] = $row['steps'];
  }

//kcal

  $userid = intval($_SESSION['userid']);
  $conn = connect();
  $query = "SELECT date, kcal FROM kcal WHERE userid = ? ORDER BY date ASC";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $userid);
  $stmt->execute();
  $result = $stmt->get_result();

  $kcaldates = [];
  $kcal = [];
  while ($row = $result->fetch_assoc()) {
    $kcaldates[] = $row['date'];
    $kcal[] = $row['kcal'];
  }

//weight

  $userid = intval($_SESSION['userid']);
  $conn = connect();
  $query = "SELECT date, weight FROM weight WHERE userid = ? ORDER BY date ASC";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $userid);
  $stmt->execute();
  $result = $stmt->get_result();

  $weightdates = [];
  $weight = [];
  while ($row = $result->fetch_assoc()) {
    $weightdates[] = $row['date'];
    $weight[] = $row['weight'];
  }


?>

<!DOCTYPE html>
<html>
  <head>
    
    <title>Air Quality Map</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBY8fSIy0uw7pMxa86nkkM-BLQ9DA_4t-0"></script>
	  <?php require dirname(__FILE__). "/Style/links.php";?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<style>
.container {  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
  grid-template-rows: 0.25fr 0.5fr 1fr 0.25fr;
  gap: 0px 0px;
  grid-auto-flow: row;
  grid-template-areas:
    "Navb Navb Navb Navb Navb"
    "Step Kcal Heft Health-Advice Health-Advice"
    "Dash Dash Dash Health-Advice Health-Advice"
    ". . . . .";
}

.Navb { grid-area: Navb; }

.Step { grid-area: Step; }

.Kcal { grid-area: Kcal; }

.Heft { grid-area: Heft; }

.Dash { grid-area: Dash; }

.Health-Advice { grid-area: Health-Advice; }


html, body , .container {
  height: 100%;
  max-width: 100% !important;
}

/* For presentation only, no need to copy the code below */

.container * {
  
  position: relative;
}

.container *:after {
  /*content:attr(class);*/
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

    <!-- steps -->
    <div class="Step">
    <form method="post" action="steps-action.php">
        <div class="form-group">
          <input type="date" class="form-control" name="date" required>
        </div>
        <div class="form-group">
          <input type="number" placeholder="Steps" class="form-control" name="steps" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Submit" class="btn btn-primary form-control"></input>
        </div>
    </form>

      <div style="width: 100%; margin: 0 auto;">
		    <canvas id="steps"></canvas>
	    </div>
      <script>
        var ctx = document.getElementById('steps').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($stepdates); ?>,
                datasets: [{
                    label: 'Steps',
                    data: <?php echo json_encode($steps); ?>,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
      </script>
    </div>

    <!-- kcal -->
    <div class="Kcal">
    <form method="post" action="kcal-action.php">
        <div class="form-group">
          <input type="date" class="form-control" name="date" required>
        </div>
        <div class="form-group">
          <input type="number" placeholder="Kcal" class="form-control" name="kcal" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Submit" class="btn btn-primary form-control"></input>
        </div>
    </form>

      <div style="width: 100%; margin: 0 auto;">
		    <canvas id="kcal"></canvas>
	    </div>
      <script>
        var ctx = document.getElementById('kcal').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($kcaldates); ?>,
                datasets: [{
                    label: 'Kcal',
                    data: <?php echo json_encode($kcal); ?>,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
      </script>
    </div>
    <!-- weight -->
    <div class="Heft">
    <form method="post" action="weight-action.php">
        <div class="form-group">
          <input type="date" class="form-control" name="date" required>
        </div>
        <div class="form-group">
          <input type="number" placeholder="Weight" class="form-control" name="weight" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Submit" class="btn btn-primary form-control"></input>
        </div>
    </form>

      <div style="width: 100%; margin: 0 auto;">
		    <canvas id="weight"></canvas>
	    </div>
      <script>
        var ctx = document.getElementById('weight').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($weightdates); ?>,
                datasets: [{
                    label: 'Weight(KG)',
                    data: <?php echo json_encode($weight); ?>,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
      </script>
    </div>
    <!-- Dashboard -->
    <div class="Dash">
      <form>
      <div class="form-group" method="post">
        <input placeholder="Enter Postcode" type="text" id="postcode" name="postcode" style="width: 100%;">
        <button type="button" class="btn btn-primary form-control" onclick="initMap()">Get Air Quality Data</button>
      </div>
      </form>
      <div id="map" style="height: 400px; width: 100%;" ></div>
    </div>
    <!-- Health Advice -->
    <div class="Health-Advice">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Weather and Air Quality</h5>

            <?php              
            $postcode = $_SESSION["postcode"]; // replace with actual postcode
            $google_maps_api_key = 'AIzaSyBY8fSIy0uw7pMxa86nkkM-BLQ9DA_4t-0'; // replace with actual API key
            $air_visual_api_key = 'fc530c3a-1e3d-4e19-afa4-74045818d1f1'; // replace with actual API key

            // get latitude and longitude for postcode using Google Maps API
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($postcode) . "&key=" . $google_maps_api_key;
            $json = file_get_contents($url);
            $data = json_decode($json, true);
            $lat = $data['results'][0]['geometry']['location']['lat'];
            $lng = $data['results'][0]['geometry']['location']['lng'];

            // get weather and air quality data using Air Visual API
            $url = "https://api.airvisual.com/v2/nearest_city?lat=" . $lat . "&lon=" . $lng . "&key=" . $air_visual_api_key;
            $json = file_get_contents($url);
            $data = json_decode($json, true);
            $weather = $data['data']['current']['weather'];
            $aqi = $data['data']['current']['pollution']['aqius'];
            ?>

            <p class="card-text">Temperature: <?php echo $weather['tp'] ?> &deg;C</p>
            <p class="card-text">Humidity: <?php echo $weather['hu'] ?>%</p>
            <p class="card-text">Wind speed: <?php echo $weather['ws'] ?> m/s</p>
            <p class="card-text">Air quality index: <?php echo $aqi ?></p>
            <p class="card-text">Pollen: <?php echo $data['data']['current']['pollution']['aqicn'] ?></p>
      </div>
    </div>
  </div>
</div>
    
  



</body>
</html>

