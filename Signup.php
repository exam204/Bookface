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
    "msic main main main main misc"
    "msic main main main main misc"
    "msic main main main main misc"
    "msic mis1 mis1 mis1 mis1 misc";
}

.mis1 { grid-area: mis1; }

.navb { grid-area: navb; }

.msic { grid-area: msic; }

.misc { grid-area: misc; }

.main { grid-area: main; }


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
    <div class="main">
    <div class="container">
    <h1>Registration Form</h1>
    <form>
      <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control" id="firstName" name="firstName" required>
      </div>
      <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" id="lastName" name="lastName" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="dateOfBirth">Date of Birth</label>
        <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" required>
      </div>
      <div class="form-group">
        <label for="gender">Gender</label>
        <select class="form-control" id="gender" name="gender" required>
          <option value="">-- Select Gender --</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
      </div>
      <div class="form-group">
        <label for="location">Location</label>
        <input type="text" class="form-control" id="location" name="location" required>
      </div>
      <div class="form-group">
        <label for="healthConditions">Health Conditions</label>
        <textarea class="form-control" id="healthConditions" name="healthConditions" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>

        

        <div class="mis1"></div>
        <div class="msic"></div>
        <div class="misc"></div>
    </div>


    
    
    
</body>
</html>