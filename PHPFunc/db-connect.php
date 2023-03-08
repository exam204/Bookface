<?php

function connect(){
    $servername = "localhost";
    $username = "hag";
    $password = "1234";

    // Create connection
    try {
        $conn = new mysqli($servername, $username, $password, "hag");
    }   catch (Exception $e) {
        // return false;
        echo "DB ERROR";
    }

    // Check connection
    if($conn->connect_error) {
        
    }
    return $conn;

}
?>