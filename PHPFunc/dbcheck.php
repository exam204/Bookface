<?php

include_once dirname(__FILE__)."/db-connect.php";

function dbcheck(){
    //session_start();

    $conn = connect();
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_POST["email"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $email = $result->fetch_assoc();
    if($email){
        $_SESSION["emailverify"] = true;
    }else{}
}

function dbchecklogin(){
    //session_start();
    //dirname(__FILE__).require "/db-connect.php";
    $conn = connect();
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_POST["email"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $email = $result->fetch_assoc();
    if(password_verify($_POST["password"], $email["password"])){
        $_SESSION["loggedin"] = true;
        $_SESSION["userid"] = $email["id"];
        header ("Location: /projects/Bookface/Index.php");
        //echo "pass";
        
    }else{
        $_SESSION["loginerror"] = true;
        header ("Location: /projects/Bookface/login.php");
        //echo "fail";
        
    }
}

function check_admin(){
    //echo "working";
    $conn = connect();
    $query = "SELECT * FROM users WHERE id = $_SESSION[userid]";
    $result = mysqli_query($conn, $query);
    $num = mysqli_num_rows($result);
    if ($num == 1){
        while($row = mysqli_fetch_assoc($result)){
            $admin = $row["is_admin"];
        }
    
    if($admin == 1){
        $_SESSION["isadmin"] = true;
        //header ("Location: /projects/Bookface/Index.php");
        
    }
    else{
        $_SESSION["isadmin"] = false;
        //header ("Location: /projects/Bookface/Index.php");
        
    }
}
}


function dbpasswordcheck(){
    //session_start();
    //require "PHPFunc\db-connect.php";
    $conn = connect();
    $query = "SELECT * FROM users WHERE password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_POST["password"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $password = $result->fetch_assoc();
    if(password_verify($_POST[$password] == $password)){
        $_SESSION["passwordverify"] = true;
        header ("Location: /project/Bookface/signup.php");
        exit();
}}

function delete_user(){
    $conn = connect();
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_GET["id"]);
    $stmt->execute();
    $_SESSION["delete_user"] = true;
    header ("Location: /projects/Bookface/admin.php");
    
}

function reset_pfp(){
    $conn = connect();
    $query = "UPDATE users SET ft = '0' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_GET["id"]);
    $stmt->execute();
    $_SESSION["reset_pfp"] = true;
    
    
}

function delete_messages(){
    $conn = connect();
    $query = "DELETE FROM messages WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_GET["id"]);
    $stmt->execute();
    $_SESSION["delete_message"] = true;
    header ("Location: /projects/Bookface/messages.php");
    
}

function file_type_upload(){
    $filetype = $_SESSION["file_type"];
    $conn = connect();
    $query = "UPDATE users SET ft = '$filetype' WHERE id = '$_SESSION[userid]'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    unset($_SESSION["file_type"]);
}