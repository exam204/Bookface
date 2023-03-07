<?php
session_start()
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <?php require dirname(__FILE__). "/PHPFunc/db-connect.php"; ?>
    <?php require dirname(__FILE__). "/Style/links.php"; ?>
    <?php require dirname(__FILE__). "/PHPFunc/dbcheck.php"; ?>

</head>
<body>
    
<?php

$conn = connect();
$hash = $_POST["password"];
$hash = password_hash($hash, PASSWORD_DEFAULT);
$query = "UPDATE users SET name=?, email=?, password=?, is_admin=? WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssii", $_POST["name"], $_POST["email"], $hash, $_POST["isadmin"], $_POST["id"]);
$stmt->execute();

header ("Location: /projects/Bookface/admin.php");

?>



</body>
</html>