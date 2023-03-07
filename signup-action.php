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
    <?php require dirname(__FILE__). "/Style/links.php"; ?>
    <?php require dirname(__FILE__). "/PHPFunc/dbcheck.php";?>
</head>
<body>



<?php
    if(isset($_POST["email"])){
        dbcheck();
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["emailauth"] = $_POST["email"];
        $_SESSION["password"] = $_POST["password"];
        $_SESSION["name"] = $_POST["name"];
        $_SESSION["nameauth"] = $_POST["name"];
        header ("Location: /projects/Bookface/signup-verify.php");
    }
    if(isset($_SESSION["visited-verify"])){
        if($_POST["enterauth"] == $_SESSION["authnumber"]){
            addtodb();
            unset($_SESSION["visited-verify"]);
            header ("Location: /projects/Bookface/Index.php");
        }
        else{
            $_SESSION["wrong_auth"] = true;
            header ("Location: /projects/Bookface/signup-verify.php");
        }
    }

    
    
    
    //require dirname(__FILE__). "/PHPFunc/db-connect.php";

    
    

    
    
    ?>

<?php

function addtodb(){
    $conn = connect();
    $hash = $_SESSION["password"];
    $hash = password_hash($hash, PASSWORD_DEFAULT);
    $name_clean = strip_tags($_SESSION["name"], '<br>');
    $ft_signup = "0";
    $query = "INSERT INTO users (name, email, password, ft) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $name_clean, $_SESSION["email"], $hash, $ft_signup);
    $stmt->execute();
    $_SESSION["signup"] = true;
    //header ("Location: Index.php");

}


?>



</body>
</html>