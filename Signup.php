<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <?php require dirname(__FILE__). "/Style/links.php"; ?>
    <?php require dirname(__FILE__). "/PHPFunc/db-connect.php";?>

<style>
.container {  display: grid;
  grid-template-columns: 1.5fr 0.9fr 1fr 1fr 0.9fr 1.5fr;
  grid-template-rows: 1fr 1fr 1fr 1fr 1fr;
  gap: 0px 0px;
  grid-auto-flow: row;
  grid-template-areas:
    "navb navb navb navb navb navb"
    "msic main main adds adds misc"
    "msic main main adds adds misc"
    "msic main main adds adds misc"
    "msic mis1 mis1 mis1 mis1 misc";
}

.mis1 { grid-area: mis1; }

.navb { grid-area: navb; }

.msic { grid-area: msic; }

.misc { grid-area: misc; }

.main { grid-area: main; }

.adds { grid-area: adds; }


html, body , .container {
  height: 100%;
  max-width: 100% !important;
}

/* For presentation only, no need to copy the code below */

.container * {
  /*border: 1px solid red;*/
  position: relative;
}

.container *:after {
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

</head>
<body>


<div class="container">
  <div class="mis1"></div>

  <!-- Nav Bar -->
  <div class="navb">
  <?php require dirname(__FILE__). "/templates/nav.php"; ?>
        <?php
        if(isset($_SESSION["emailalert"])){
            if($_SESSION["emailverify"] == false){
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Oops!!</strong> Email already exists!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
            unset($_SESSION["emailalert"]);
        }
        ?>
  </div>
    <!-- Misc -->
  <div class="msic"></div>
  <div class="misc"></div>
    <!-- Main -->
  <div class="main">
  <form action="signup-action.php" method="post">
      <div class="form-group">
        <label for="firstName" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block; margin-right: auto; ">First Name</label>
        <input type="text" class="form-control" id="firstName" name="fname" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block; margin-right: auto; " required>
      </div>
      <div class="form-group">
        <label for="lastName" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block;margin-right: auto; ">Last Name</label>
        <input type="text" class="form-control" id="lastName" name="lname" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block;margin-right: auto; "  required>
      </div>
      <div class="form-group">
        <label for="username" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block;margin-right: auto; ">Username</label>
        <input type="text" class="form-control" id="uname" name="uname" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block;margin-right: auto; "  required>
      </div>
      <div class="form-group">
        <label for="email" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block;margin-right: auto; ">Email</label>
        <input type="email" class="form-control" id="email" name="email" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block;margin-right: auto; " required>
      </div>
      <div class="form-group">
        <label for="dateOfBirth" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block;margin-right: auto;">Date of Birth</label>
        <input type="date" class="form-control" id="dateOfBirth" name="dob" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block;margin-right: auto; " required>
      </div>
      <div class="form-group">
        <label for="gender" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block;margin-right: auto; ">Gender</label>
        <select class="form-control" id="gender" name="gender" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block;margin-right: auto; " required>
          <option value="">-- Select Gender --</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
      </div>
      <div class="form-group">
        <label for="location" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block;margin-right: auto; ">Location</label>
        <input type="text" class="form-control" id="location" name="location" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block;margin-right: auto; " required>
      </div>
      <div class="form-group">
        <label for="healthConditions" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block;margin-right: auto; ">Health Conditions</label>
        <textarea class="form-control" id="healthConditions" placeholder="If you have none leave blank" style="margin-top: 1%;  margin-left: auto; width: 80%; display:block;margin-right: auto; " name="healthcon" rows="3"  ></textarea>
      </div>
      
  </div>
  <!-- Adds -->
  <div class="adds">
    <style>
        .adds{
            height: 100%;
            width: 80%;
            margin-top: 1%;
            margin-left: auto;
            margin-right: auto;
            display: block;
            border-radius: 10px;
        }
        </style>
    <?php
    
    $allergies = array(
        'Pollen',
        'Dust',
        'Mold',
        'Dogs',
        'Cats',
        'Dairy',
        'Eggs',
        'Gluten',
        'Nuts'
    );


if(isset($_SESSION["pass-match"])){
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Oops!!</strong> Passwords do not match!
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    unset($_SESSION["pass-match"]);
}
?>
<div class="form-group">
    <label for="password" >Password</label>
    <input type="password" class="form-control" id="myInput1" name="password" onkeyup='check();'  />
</div>
<div class="form-group">
    <label for="password-verify" >Password</label>
    <input type="password" class="form-control" id="myInput" name="password-verify" id="confirm_password"  onkeyup='check();' />
    <span id='message'></span> <br>
    <input type="checkbox" onclick="myFunction()">Show Password
</div>

<script>
var check = function() {
  if (document.getElementById('myInput1').value ==
    document.getElementById('myInput').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'Matching';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'Not Matching';
  }
}
    
function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
  var x = document.getElementById("myInput1");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

<div class="form-group">
    <span class ="primary form-control" style="text-align: center"> Edit Allergies </span>
</div>

<?php foreach ($allergies as $allergy) : ?>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="allergies[]" value="<?= $allergy ?>"
            id="<?= $allergy ?>">
        <label class="form-check-label" for="<?= $allergy ?>" >
            <?= $allergy ?>
        </label>
    </div>
<?php endforeach; ?>

<div class="form-group">
    <input type="submit" value="Sign Up" class="btn btn-primary form-control" ></input>
</div>

</form>
</div>


    
</body>
</html>