<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookFace</title>
    <?php require dirname(__FILE__). "/Style/links.php"; ?>
    <?php require dirname(__FILE__). "/PHPFunc/db-connect.php";?>
    <?php require dirname(__FILE__). "/PHPFunc/dbcheck.php";?>
</head>
<body>
    


<?php
    if ($_POST["message"] == "" ){
        $_SESSION["no_input_message"] = true;
        header ("Location: messages.php");
    }



    else{
        check_admin();
        $conn = connect();
        $message_clean = strip_tags($_POST["message"]);
        $query = "INSERT INTO messages (message, userid) VALUES (?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $message_clean,$_SESSION["userid"]);
        $stmt->execute();
        $_SESSION["message"] = true;
        header ("Location: messages.php");
    }

?>




</body>
</html>