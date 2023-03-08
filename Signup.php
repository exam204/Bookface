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
</head>
<body>
    
    <?php require dirname(__FILE__). "/templates/nav.php"; ?>

    <?php
    if(isset($_SESSION["emailverify"])){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Oops!!</strong> Email already exists!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        unset($_SESSION["emailverify"]);
    }
    
    ?>
    
    <form action="/projects/Bookface/signup-action.php" method="post">
        <div class="form-group" >
            <label for="exampleInputName" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Name</label>
            <input type="text" name="name" class="form-control" id="exampleInputName" aria-describedby="nameHelp" placeholder="Enter Name" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;" required>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;"required>
        </div>
        <div class="form-group">
            <input type="submit" value="Sign Up" class="btn btn-primary form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block"></input>
        </div>
        <div class="form-group">
            <a href="login.php" class="btn btn-primary form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Already Got An Account?</a>
        </div>
    </form>
    
    
    
</body>
</html>