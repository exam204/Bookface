<?php
session_start();
if(!isset($_SESSION["userid"])){
    header ("Location: /projects/Bookface/login.php");
    exit();
}

require dirname(__FILE__). "/PHPFunc/db-connect.php"; 

require dirname(__FILE__). "/PHPFunc/dbcheck.php"; 


$conn = connect();
$userid = $_SESSION["userid"];
$sql = "SELECT * FROM users WHERE id = $userid";
$stmt = $conn->prepare($sql);
$row = $stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$conn -> close();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <?php require dirname(__FILE__). "/Style/links.php"; ?>

<style>
.container {  display: grid;
  grid-template-columns: 1.5fr 0.9fr 1fr 1fr 0.9fr 1.5fr;
  grid-template-rows: 1fr 1fr 5fr 1fr 1fr;
  gap: 5% 5%;
  grid-auto-flow: row;
  grid-template-areas:
    "navb navb navb navb navb navb"
    "msic main main alle alle misc"
    "msic main main alle alle misc"
    "msic main main alle alle misc"
    "msic mis1 mis1 mis1 mis1 misc";
}

.main { grid-area: main; }

.alle { grid-area: alle; }

.mis1 { grid-area: mis1; }

.navb { grid-area: navb; }

.msic { grid-area: msic; }

.misc { grid-area: misc; }


html, body , .container {
  height: 100%;
  max-width: 100%;
  margin: 0;
}

/* For presentation only, no need to copy the code below */

.container * {
  /*border: 1px solid red;*/
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

</head>
<body>

<div class="container">
    <div class="main">
        <div class="form-group">
            <span class ="primary form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block; text-align: center"> Edit User Details </span>
        </div>

  <form action="account-edit-action.php" method="post">
        <div class="form-group">
        <label for="exampleInputName" class="form-label mt-4" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Name</label>
            <input type="text" name="name" value="<?= $row["name"]  ?>" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block" required>
        </div>
        <div class="form-group">
        <label for="exampleInputLName" class="form-label mt-4" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Last Name</label>
            <input type="text" name="lname" value="<?= $row["lname"]  ?>" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block" required>
        </div>
        <div class="form-group">
        <label for="exampleInputUName" class="form-label mt-4" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Username</label>
            <input type="text" name="uname" value="<?= $row["uname"]  ?>" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block" required>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label mt-4" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Email address</label>
            <input type="text" name="email" value="<?= $row["email"] ?>" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block" disabled>
        </div>
        <?php
        if(isset($_SESSION["pass-match"])){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Oops!!</strong> Passwords do not match!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        unset($_SESSION["pass-match"]);
        }
        ?>
        <div class="form-group">
            <label for="password" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Password</label>
            <input type="password" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block" class="form-control" id="myInput1" name="password" onkeyup='check();'  required/>
        </div>
        <div class="form-group">
            <label for="password-verify" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Password</label>
            <input type="password" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block" class="form-control" id="myInput" name="password-verify" id="confirm_password"  onkeyup='check();' required/>
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

        <div class = form-group>
            <input type="hidden" name="id" value="<?= $row["id"] ?>" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">
            <input type="submit" value="Update" class="btn btn-success form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block"></input>
        </div>
        <div class="form-group">
            <a href="account.php" class="btn btn-primary form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Back</a>
        </div>
    </form>
  </div>

  <div class="alle">
    <?php
    $user_id = $_SESSION["userid"];

    $conn = connect();

    // get user allergies
    $query = "SELECT allergies FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_allergies);
    $stmt->fetch();

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

    $allergy_list = explode(',', $user_allergies);

    ?>
    <form action="account-edit-allergies-action.php" method="post">
    <div class="form-group">
        <span class ="primary form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block; text-align: center"> Edit Personal Details </span>
    </div>
    <div class="form-group">
        <label for="dateOfBirth" style="margin-top: 1%; display:block; margin-right: auto;">Date of Birth</label>
        <input type="date" class="form-control" id="dateOfBirth" value="<?= $row["dob"] ?>" name="dob" style="margin-top: 1%; display:block; margin-right: auto; " required>
      </div>
    <div class="form-group">
        <label for="exampleInputPC" class="form-label mt-4" class="form-label mt-4" style="margin-top: 1%; auto; margin-right: auto; ; display:block">Postcode</label>
        <input type="text" name="postcode" value="<?= $row["postcode"] ?>" class="form-control" style="margin-top: 1%; auto; margin-right: auto; ; display:block">
    </div>
    <div class="form-group">
        <label for="gender" style="margin-top: 1%; width: 80%; display:block; margin-right: auto; ">Gender</label>
        <select class="form-control" value="<?= $row["gender"] ?>" id="gender" name="gender"  required>
          <option value="">-- Select Gender --</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
      </div>

    <div class="form-group">
        <span class ="primary form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block; text-align: center"> Edit Allergies </span>
    </div>
    
    <?php foreach ($allergies as $allergy) : ?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="allergies[]" value="<?= $allergy ?>"
                id="<?= $allergy ?>" <?php if (in_array($allergy, $allergy_list)) echo 'checked' ?>>
            <label class="form-check-label" for="<?= $allergy ?>">
                <?= $allergy ?>
            </label>
        </div>
    <?php endforeach; ?>
    <input type="submit" class="btn btn-success form-control" value="Save">
    </form>
</div>

  <div class="mis1"></div>

  <div class="navb">
    <?php require dirname(__FILE__). "/templates/nav.php"; 
    if($_SESSION["postcode"] == false){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Oops!!</strong> No Postcode on account!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        
    }
    ?>
  </div>
  <div class="msic"></div>
  <div class="misc"></div>
</div>

<?php

$result->free_result();
$conn->close();

?>

</body>
</html>