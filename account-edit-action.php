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
$name_clean = strip_tags($_POST["name"], '<br>');
$query = "UPDATE users SET name=?, password=? WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $name_clean, $hash, $_POST["id"]);
$stmt->execute();

$_SESSION["updated"] = true;

header ("Location: /projects/Bookface/account.php");

?>



</body>
</html>