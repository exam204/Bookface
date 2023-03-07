<?php
session_start();

require dirname(__FILE__). "/PHPFunc/db-connect.php"; 

require dirname(__FILE__). "/PHPFunc/dbcheck.php"; 


$conn = connect();
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET["id"]);
$row = $stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <?php require dirname(__FILE__). "/Style/links.php"; ?>


    <style>
    h1 {
        text-align: center;
        
        background: #2780E3;
        color: white;
    }
    </style>
</head>
<body>

    <?php require dirname(__FILE__). "/templates/nav.php"; ?>
    <?php
    if(isset($_SESSION["isadmin"]) && $_SESSION["isadmin"] == true){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Welcome To The Edit Page!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } else {
        $_SESSION["tried-to-access-admin"] = true;
        header("location: index.php");
        exit;
    }
?>

    <div class="form-group">
        <span class ="primary form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block; text-align: center"> Edit User Details (Admin) </span>
    </div>



    <form action="edit-user-action.php" method="post">
        <div class="form-group">
        <label for="exampleInputName" class="form-label mt-4" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Name</label>
            <input type="text" name="name" value="<?= $row["name"]  ?>" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label mt-4" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Email address</label>
            <input type="text" name="email" value="<?= $row["email"] ?>" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">
        </div>
        <div class="form-group">
            <label for="exampleInputAdmin1" class="form-label mt-4" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Is Admin</label>
            <input type="text" name="isadmin" value="<?= $row["is_admin"] ?>" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label mt-4" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Reset Password</label>
            <input type="submit" name="password" value="password" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">
        </div>
        <div class = form-group>
            <input type="hidden" name="id" value="<?= $row["id"] ?>" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">
            <input type="submit" value="Update" class="btn btn-primary form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block"></input>
        </div>
        <div class="form-group">
            <a href="admin.php" class="btn btn-primary form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Back</a>
        </div>
    </form>
        




<?php

$result->free_result();
$conn->close();

?>



</body>
</html>