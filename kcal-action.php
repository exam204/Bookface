<?php
session_start();
require dirname(__FILE__). '/PHPFunc/db-connect.php';

function addKcal($kcal, $date) {
    $conn = connect();
    $stmt = $conn->prepare('INSERT INTO kcal (date, kcal, userid) VALUES (?, ?, ?)');
    $stmt->bind_param('sii', $date, $kcal, $_SESSION['userid']);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
	
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['kcal']) || !isset($_POST['date'])) {
        http_response_code(400); // Bad Request
        
    }

    $kcal = intval($_POST['kcal']);
    $date = $_POST['date'];

    if ($kcal <= 0) {
        http_response_code(400); // Bad Request
        
    }

    $success = addKcal($kcal, $date);

    if (!$success) {
        http_response_code(500); // Internal Server Error
        
    }

    header("Location: dashboard.php");
    
}
  ?>