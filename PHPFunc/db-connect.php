<?php

function connect(){
    $servername = "localhost";
    $username = "bookface";
    $password = "1234";

    // Create connection
    try {
        $conn = new mysqli($servername, $username, $password, "bookface");
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