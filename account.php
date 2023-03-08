<?php
session_start();
if(!isset($_SESSION["userid"])){
    header ("Location: /projects/Bookface/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <?php require dirname(__FILE__). "/Style/links.php"; ?>
    <?php require dirname(__FILE__). "/PHPFunc/db-connect.php";?>

    <style>

        .avatar{
            margin-top: 1%;
            margin-left: auto;
            margin-right: auto;
            width: 10%;
            display:block;
            vertical-align: middle;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border-style: solid;
            border-color: black;
        }
    </style>
</head>
<body>

<?php require dirname(__FILE__). "/templates/nav.php"; ?>

    <?php
        if(isset($_SESSION["updated"])){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!!</strong> You Have Updated Your Details!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
            unset($_SESSION["updated"]);
        }
    
    
        function get_ft(){
            $conn = connect();
            $query = "SELECT ft FROM users WHERE id = $_SESSION[userid]";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $_SESSION["dbft"] = $row["ft"];
        }


    ?>

    <?php
    get_ft();
    if($_SESSION["dbft"] == "0"){
        echo "<img src='Images/avatar.png' alt='Avatar' class='avatar'  >";
    }else{
        $pfp = $_SESSION["userid"] . "." . "$_SESSION[dbft]";?>
        <img src='<?="pfp-images/".$pfp?>' alt='Avatar' class='avatar'  > <?php 
    }
    ?>


    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label class="form-label mt-4" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 10%; display:block">Select image to upload</label>
        <input type="file" name="fileToUpload" id="fileToUpload" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 10%; display:block">
        <input type="submit" value="Upload Image" name="submit" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 10%; display:block">
    </form>





    <form action="account-edit.php" method="post">
        <button type="submit" name="editdetails" class="btn btn-primary" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Edit Details</button>
    </form>

    <form action="account-action.php" method="post">
        <button type="submit" name="logout" class="btn btn-danger" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Log Out</button>
    </form>

    <?php

        


    ?>




</body>
</html>