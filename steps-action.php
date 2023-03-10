<?php
session_start();
require dirname(__FILE__). '/PHPFunc/db-connect.php';

function addSteps($steps, $date) {
    $conn = connect();
    $stmt = $conn->prepare('INSERT INTO steps (date, steps, userid) VALUES (?, ?, ?)');
    $stmt->bind_param('sii', $date, $steps, $_SESSION['userid']);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['steps']) || !isset($_POST['date'])) {
        http_response_code(400); // Bad Request
        exit();
    }

    $steps = intval($_POST['steps']);
    $date = $_POST['date'];

    if ($steps <= 0) {
        http_response_code(400); // Bad Request
        exit();
    }

    $success = addSteps($steps, $date);

    if (!$success) {
        http_response_code(500); // Internal Server Error
        exit();
    }

    http_response_code(200); // OK
    exit();
}
  ?>