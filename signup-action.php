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
if (isset($_POST["password"])){
    $_SESSION["password-verify"] = $_POST["password-verify"];
    $_SESSION["password"] = $_POST["password"];
}


if ($_SESSION["password"] == $_SESSION["password-verify"]){
    if(isset($_POST["email"])){
        dbcheck();
        if ($_SESSION["emailverify"] == false){
            $_SESSION["fname"] = $_POST["fname"];
            $_SESSION["lname"] = $_POST["lname"];
            $_SESSION["uname"] = $_POST["uname"];
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["emailauth"] = $_POST["email"];
            $_SESSION["dob"] = $_POST["dob"];
            $_SESSION["gender"]= $_POST["gender"];
            $_SESSION["location"] = $_POST["location"];
            $_SESSION["healthcon"] = $_POST["healthcon"];
            $_SESSION["allergies"] = $_POST["allergies"];
            $_SESSION["emailuser"] = true;
            $_SESSION["nameauth"] = $_POST["fname"];
            header ("Location: /projects/Bookface/signup-verify.php");
        }else{
            $_SESSION["emailverify"] = false;
            header ("Location: /projects/Bookface/signup.php");
        }
    }
}else{
    $_SESSION["pass-match"] = false;
    header ("Location: /projects/Bookface/Signup.php");
}
    
    if(isset($_SESSION["visited-verify"])){
        if($_POST["enterauth"] == $_SESSION["authnumber"]){
            addtodb();
            unset($_SESSION["visited-verify"]);
            header ("Location: /projects/Bookface/Index.php");
        }
        else{
            $_SESSION["wrong_auth"] = true;
            unset($_SESSION["emailuser"]);
            header ("Location: /projects/Bookface/signup-verify.php");
        }
    }
    ?>

<?php

function addtodb(){
    if($_SESSION["allergies"] == ""){
        $_SESSION["allergies"] = " ";
    }else if($_SESSION["healthcon"] == ""){
        $_SESSION["healthcon"] = " ";
    }
    //$dob = $_SESSION["dob"];
    //$dob = date("Y-m-d", strtotime($dob));
    $dob = 2005-01-01;
    $conn = connect();
    $hash = $_SESSION["password"];
    $hash = password_hash($hash, PASSWORD_DEFAULT);
    $fname_clean = strip_tags($_SESSION["fname"], '<br>');
    $lname_clean = strip_tags($_SESSION["lname"], '<br>');
    $ft_signup = "0";
    $query = "INSERT INTO users (name, lname, uname, email, dob, gender, postcode, healthcon, password, allergies, ft) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssissssss", $fname_clean, $lname_clean, $_SESSION["uname"], $_SESSION["email"], $dob, $_SESSION["gender"], $_SESSION["location"], $_SESSION["healthcon"], $hash, $_SESSION["allergies"], $ft_signup);
    $stmt->execute();
    $_SESSION["signup"] = true;
    //header ("Location: Index.php");

}


?>



</body>
</html>