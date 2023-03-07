<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookFace</title>
    <?php require dirname(__FILE__)."/Style/links.php"; ?>
    <?php require dirname(__FILE__)."/PHPFunc/db-connect.php";?>

</head>
<body>
    
     




<?php require dirname(__FILE__). "/templates/nav.php"; ?>
  

    <?php
    if(isset($_SESSION["signup"])){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> You have successfully signed up.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        unset($_SESSION["signup"]);
    }
    
    if(isset($_SESSION["loggedin"])){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!!</strong> You're Logged In!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        unset($_SESSION["loggedin"]);
    }
    
    if(isset($_SESSION["loggedout"])){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!!</strong> You are not logged in!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        unset($_SESSION["loggedout"]);
    }
    if(isset($_SESSION["tried-to-access-admin"])){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Oops!!</strong> You Cannot Acces This Page!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        unset($_SESSION["tried-to-access-admin"]);
    }
   
    if(isset($_SESSION["userid"])){
        
        echo "<div class = 'conatiner'>
        <img src='Images\logged_in_bookface.png' class='img-fluid rounded-top' alt='' style='margin-top: 1%; margin-left: auto; margin-right: auto; width: 70%; height: 80%; display:block'>
        </div>";
    }
    if(!isset($_SESSION["userid"])){
        echo "<div class = 'conatiner'>
        <img src='Images\BOOKFACE.png' class='img-fluid rounded-top' alt='' style='margin-top: 1%; margin-left: auto; margin-right: auto; width: 80%; display:block'>
        </div>";
    }


    

    ?>
  



</body>
</html>