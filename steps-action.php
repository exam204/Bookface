<?php
require dirname(__FILE__). 'PHPfunc/db-connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405); // Method Not Allowed
  exit();
}

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

$stmt = $pdo->prepare('INSERT INTO steps (date, steps) VALUES (?, ?)');
$stmt->execute([$date, $steps]);

$stmt = $pdo->prepare('SELECT date, steps FROM steps ORDER BY date ASC');
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$data = array();
foreach ($rows as $row) {
  $data[] = array(strtotime($row['date']) * 1000, intval($row['steps']));
}

echo json_encode($data);
?>
