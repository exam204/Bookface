<?php
session_start();
require dirname(__FILE__). '/PHPFunc/db-connect.php';

function addWeight($weight, $date) {
    $conn = connect();
    $stmt = $conn->prepare('INSERT INTO weight (date, weight, userid) VALUES (?, ?, ?)');
    $stmt->bind_param('sii', $date, $weight, $_SESSION['userid']);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
	
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['weight']) || !isset($_POST['date'])) {
        http_response_code(400); // Bad Request
        
    }

    $weight = intval($_POST['weight']);
    $date = $_POST['date'];

    if ($weight <= 0) {
        http_response_code(400); // Bad Request
        
    }

    $success = addWeight($weight, $date);

    if (!$success) {
        http_response_code(500); // Internal Server Error
        
    }

    header("Location: dashboard.php");
    
}
  ?>