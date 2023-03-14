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

// update user's allergies in the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = connect();
  $allergies = implode(",", $_POST["allergies"]); // convert array of selected allergies to comma-separated string
  $userid = $_SESSION["userid"];
  $query = "UPDATE users SET allergies=? WHERE id=?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ss", $allergies, $email);
  $stmt->execute();
  $_SESSION["allergies"] = $allergies; // update allergies in session variable
  header("Location: account-edit.php"); // redirect to edit details page
  exit();
}
?>




</body>
</html>