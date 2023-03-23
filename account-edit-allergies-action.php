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

session_start();
if(!isset($_SESSION["userid"])){
    header("location: login.php");
    exit;
}

if ($_POST['allergies'] == null){
	$allergies = " ";
}
else{
	$allergies = implode(',', $_POST['allergies']);
}

// update user allergies
$user_id = $_SESSION["userid"];
$conn = connect();
$query = "UPDATE users SET dob=?, postcode=?, gender=?, allergies=? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $_POST["dob"], $_POST["postcode"], $_POST["gender"], $allergies, $user_id);
$stmt->execute();
header("location: account-edit.php");


?>




</body>
</html>