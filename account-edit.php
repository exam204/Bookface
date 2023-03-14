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
  grid-template-rows: 1fr 1fr 1fr 1fr 1fr;
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
            <span class ="primary form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block; text-align: center"> Edit Details </span>
        </div>

  <form action="account-edit-action.php" method="post">
        <div class="form-group">
        <label for="exampleInputName" class="form-label mt-4" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Name</label>
            <input type="text" name="name" value="<?= $row["name"]  ?>" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block" required>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label mt-4" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Email address</label>
            <input type="text" name="email" value="<?= $row["email"] ?>" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block" disabled>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label mt-4" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Change Password</label>
            <input type="text" name="password" value="" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block" placeholder = "Enter Password">
        </div>
        <div class = form-group>
            <input type="hidden" name="id" value="<?= $row["id"] ?>" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">
            <input type="submit" value="Update" class="btn btn-primary form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block"></input>
        </div>
        <div class="form-group">
            <a href="account.php" class="btn btn-primary form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Back</a>
        </div>
    </form>
  </div>

  <div class="alle">
    <!-- edit details form -->
    <form method="post" action="account-edit-allergies-action.php">
        <div class="form-group">
            <label for="allergies" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Allergies:</label>

            <div class="form-group">
                <label for="exampleInputPollen" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Pollen</label>
                <input type="checkbox" name="allergies[]" value="Pollen" style="margin-top: 1%; margin-left: auto; margin-right: auto; display:block">
            </div>
                <div class="form-group">
                <label for="exampleInputDust" class="form-label mt-4"  style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Dust</label>
                <input type="checkbox" name="allergies[]" value="Dust" style="margin-top: 1%; margin-left: auto; margin-right: auto; display:block">
            </div>
                <div class="form-group">
                <label for="exampleInputMold" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Mold</label>
                <input type="checkbox" name="allergies[]" value="Mold" style="margin-top: 1%; margin-left: auto; margin-right: auto; display:block">
            </div>
            <div class="form-group">
                <label for="exampleInputPetDander" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Pet Dander</label>
                <input type="checkbox" name="allergies[]" value="Pet Dander" style="margin-top: 1%; margin-left: auto; margin-right: auto; display:block">
            </div>

        </div>
        <button type="submit" class="btn btn-primary form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; ; display:block">Save Changes</button>
    </form>
  </div>


  <div class="mis1"></div>

  <div class="navb">
    <?php require dirname(__FILE__). "/templates/nav.php"; ?>
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