<?php
session_start();
?>
<!-- https://grid.layoutit.com/ -->

<?php
require dirname(__FILE__). "/PHPFunc/db-connect.php";

if(!isset($_SESSION['userid'])){
  header("Location: /projects/Bookface/login.php");
}

require dirname(__FILE__). "/PHPFunc/dbcheck.php";
getuserspc();

if(($_SESSION['postcode'] == false)){
  header("Location: /projects/Bookface/account-edit.php");
}


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
      <div id="map" style="height: 100%; width: 100%;" ></div>
    </div>
    <!-- Health Advice -->
<div class="Health-Advice">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Weather and Air Quality</h5>

      <div name="airvisual_widget" key="6411d64e653f8acc0aa6507d"></div>
      <script type="text/javascript" src="https://widget.iqair.com/script/widget_v3.0.js"></script>


      <?php
      $google_maps_api_key = 'AIzaSyBY8fSIy0uw7pMxa86nkkM-BLQ9DA_4t-0'; // replace with actual API key
      $air_visual_api_key = 'fc530c3a-1e3d-4e19-afa4-74045818d1f1'; // replace with actual API key

      // get postcode from session

      $postcode = $_SESSION["postcode"];

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
      $temperature = $data['data']['current']['weather']['tp'];
      $weather = $data['data']['current']['weather']['ic'];
      $aqi = $data['data']['current']['pollution']['aqius'];
      $pollen = $data['data']['current']['pollution']['aqicn'];
      $humidity = $data['data']['current']['weather']['hu'];
      $wind_speed = $data['data']['current']['weather']['ws'];


      // get the user's allergies from the database
      $user_id = $_SESSION["userid"];
      $query = "SELECT allergies FROM users WHERE id=?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $stmt->bind_result($allergies);
      $stmt->fetch();


      if($weather == "01d" || $weather == "01n") {
        $weather = "Clear";
      } else if($weather == "02d" || $weather == "02n") {
        $weather = "Partly Cloudy";
      } else if($weather == "03d" || $weather == "03n") {
        $weather = "Cloudy";
      } else if($weather == "04d" || $weather == "04n") {
        $weather = "Overcast";
      } else if($weather == "09d" || $weather == "09n") {
        $weather = "Drizzle";
      } else if($weather == "10d" || $weather == "10n") {
        $weather = "Rain";
      } else if($weather == "11d" || $weather == "11n") {
        $weather = "Thunderstorm";
      } else if($weather == "13d" || $weather == "13n") {
        $weather = "Snow";
      } else if($weather == "50d" || $weather == "50n") {
        $weather = "Mist";
      }

  //weather data
  echo "Weather: $weather<br>";
  echo "Temperature: $temperature °C<br>";
  echo "Humidity: $humidity%<br>";
  echo "Wind Speed: $wind_speed m/s<br>";
  echo "AQI: $aqi<br>";
  echo "Pollen: $pollen<br>";
  echo "Allergies: $allergies<br>";


  // no allergies, provide general health advice
  echo "<h1> Health Advice </h1>";
  if ($aqi <=10){
      if ($weather == 'Clear' || $weather == 'Partly Cloudy' || $weather == "Cloudy" ||$weather == 'Overcast') {
        if ($temperature >= 10 || $temperature <= 15 && $humidity <= 60) {
            echo "Air quality is great. Enjoy outdoor activities! Stay Hydrated!";
        } else if ($temperature < 8) {
            echo "Air quality is great. Bundle up and enjoy the fresh air! Stay Hydrated!";
        } else if ($weather == 'Rain') {
            echo "Air quality is good. If you need to go outside, remember to bring an umbrella!";
        } else if ($weather == 'Thunderstorm') {
            echo "Air quality is moderate. If you need to go outside, remember to bring an umbrella!";
        } else if ($weather == 'Snow') {
            echo "Air quality is moderate. If you need to go outside, remember to bring an umbrella!";
        } else if ($weather == 'Mist') {
            echo "Air quality is moderate. If you need to go outside, remember to bring an umbrella!";
        } else {
          echo "Air quality is great. Be sure to stay hydrated!";
        }
      }
  }
  else if ($aqi >= 10) {
      if($allergies == " "){
        echo "Air quality is good. Enjoy outdoor activities! Stay Hydrated!";
      } else {
        echo "Air quality is good. Enjoy outdoor activities! Stay Hydrated! Be sure to take your allergy medication!";
      }
  } else if ($aqi <= 50) {
      if ($weather == 'Clear' || $weather == 'Partly Cloudy' || $weather == 'Overcast') {
          if ($temperature >= 50 && $temperature <= 80 && $humidity <= 60) {
              echo "Air quality is moderate. It's a great day to be outdoors! Stay Hydrated!";
          } else if ($temperature < 50) {
              echo "Air quality is moderate. Bundle up and enjoy the fresh air! Stay Hydrated!";
          } else {
              echo "Air quality is moderate. Be sure to stay hydrated!";
          }
      }else if ($weather == 'Rain') {
          echo "Air quality is good. If you need to go outside, remember to bring an umbrella!";
      } else if ($weather == 'Rain' || $weather == 'Thunderstorm' || $weather == 'Snow') {
          echo "Air quality is moderate. Be prepared for any weather conditions and use appropriate gear!";
      } else {
          echo "Air quality is moderate. Be prepared for any weather conditions!";
      }
  } else if ($aqi <= 100) {
      if ($weather == 'Clear' || $weather == 'Partly Cloudy' || $weather == 'Overcast') {
          if ($temperature >= 50 && $temperature <= 80 && $humidity <= 60) {
              echo "Air quality is moderate. It's a great day to be outdoors! Stay Hydrated!";
          } else if ($temperature < 50) {
              echo "Air quality is moderate. Bundle up and enjoy the fresh air! Stay Hydrated!";
          } else {
              echo "Air quality is moderate. Be sure to stay hydrated!";
          }
      } else if ($weather == 'Rain' || $weather == 'Thunderstorm' || $weather == 'Snow') {
          echo "Air quality is moderate. Be prepared for any weather conditions and use appropriate gear!";
      } else {
          echo "Air quality is moderate. Be prepared for any weather conditions!";
      }
  } else if ($aqi <= 150) {
      if ($weather == 'Clear' || $weather == 'Partly Cloudy' || $weather == 'Overcast') {
          echo "Air quality is unhealthy for sensitive groups. If you have heart or lung disease, older adults, and children, you should reduce prolonged or heavy exertion.";
      } else if ($weather == 'Rain' || $weather == 'Thunderstorm' || $weather == 'Snow') {
          echo "Air quality is unhealthy for sensitive groups. Try to avoid outdoor activities if possible and use appropriate gear!";
      } else {
          echo "Air quality is unhealthy for sensitive groups. Be cautious and avoid prolonged or heavy exertion!";
      }
  } else if ($aqi <= 200) {
      if ($weather == 'Clear' || $weather == 'Partly Cloudy' || $weather == 'Overcast') {
          echo "Air quality is unhealthy. If you have heart or lung disease, older adults, and children should avoid prolonged or heavy exertion. Everyone else should reduce prolonged or heavy exertion.";
      } else if ($weather == 'Rain' || $weather == 'Thunderstorm' || $weather == 'Snow') {
          echo "Air quality is unhealthy. Try to avoid outdoor activities if possible and use appropriate gear!";
      } else {
          echo "Air quality is unhealthy. Be cautious and avoid prolonged or heavy exertion!";
      }
  }

  $allergies = explode(',', $allergies);

  echo "<br><br>";

  if (in_array('Pollen', $allergies)) {
    echo "<h1> Pollen Allergies </h1>";
      if ($pollen <= 50) {
          echo "Pollen levels are low. You can safely spend time outdoors!";
      } else if ($pollen <= 100) {
          echo "Pollen levels are moderate. You may want to limit your time outdoors.";
      } else if ($pollen <= 150) {
          echo "Pollen levels are high. You may want to stay indoors.";
      } else {
          echo "Pollen levels are very high. You should stay indoors as much as possible.";
      }
  }
  
  echo "<br><br>";
  
  if (in_array('Dust', $allergies)) {
    echo "<h1> Dust Allergies </h1>";
      if ($aqi <= 50) {
          echo "Air quality is good. Enjoy outdoor activities!";
      } else if ($aqi <= 100) {
          if ($weather == 'Clear' || $weather == 'Cloudy') {
              if ($temperature >= 50 && $temperature <= 80) {
                  echo "Air quality is moderate. It's a great day to be outdoors!";
              } else if ($temperature < 50) {
                  echo "Air quality is moderate. Bundle up and enjoy the fresh air!";
              } else {
                  echo "Air quality is moderate. Be sure to stay hydrated!";
              }
          } else if ($weather == 'Rain') {
              echo "Air quality is moderate. Bring an umbrella and enjoy the rain!";
          } else {
              echo "Air quality is moderate. Be prepared for any weather conditions!";
          }
      } else if ($aqi <= 150) {
          echo "Air quality is unhealthy for sensitive groups. If you have heart or lung disease, older adults, and children, you should reduce prolonged or heavy exertion.";
      } else if ($aqi <= 200) {
          echo "Air quality is unhealthy. If you have heart or lung disease, older adults, and children should avoid prolonged or heavy exertion. Everyone else should reduce prolonged or heavy exertion.";
      } else if ($aqi <= 300) {
          echo "Air quality is very unhealthy. Avoid all outdoor exertion if possible. If you must be outside, wear an N95 respirator mask.";
      } else {
          echo "Air quality is hazardous. Do not go outside without an N95 respirator mask.";
      }
  }
  
  echo "<br><br>";

  if (in_array('Mold', $allergies)) {
    echo "<h1> Mold Allergies </h1>";
      if ($humidity <= 60) {
          echo "Mold levels are low. You can safely spend time indoors or outdoors!";
      } else if ($humidity <= 70) {
          echo "Mold levels are moderate. You may want to limit your time outdoors.";
      } else if ($humidity <= 80) {
          echo "Mold levels are high. You should try to stay indoors.";
      } else {
          echo "Mold levels are very high. You should stay indoors as much as possible.";
      }
  }
  

?>

</div>
</div>
</div>
    
  



</body>
</html>

