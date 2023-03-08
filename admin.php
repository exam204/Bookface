<?php
session_start();

if(!isset($_SESSION["userid"])){
    header ("Location: /projects/Bookface/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <?php require dirname(__FILE__). "/PHPFunc/db-connect.php"; ?>
    <?php require dirname(__FILE__). "/Style/links.php"; ?>
    <?php require dirname(__FILE__). "/PHPFunc/dbcheck.php"; ?>


    <style>
    
    table {
      
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        font-family: sans-serif;
        min-width: 400px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);

    }

    table th {
        
        color: white;
        text-align: left;
        padding: 12px;
        
    }

    table th,
    table td {
        padding: 12px 15px;
    }

    table tr {
        border-bottom: 1px solid #dddddd;
    }

    table tr:nth-of-type(even) {
        
    }

    h1 {
        text-align: center;
        color: white;
    }
    </style>

</head>
<body>

    <?php require dirname(__FILE__). "/templates/nav.php"; ?>

    <h1> Users In Database (Admin) </h1>

    <center>
    <table>
        <tr>
            <th> Name </th>
            <th> Email </th>
            <th> IsAdmin </th>
            <th> Edit </th>
            <th> Reset </th>
            <th> Delete </th>
        </tr>
    </center>

<?php

$conn = connect();
$sql = "SELECT * FROM users";
$result = $conn->query($sql);



if(isset($_SESSION["isadmin"]) && $_SESSION["isadmin"] == true){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Welcome To The Admin Page!
    </div>";
} else {
    $_SESSION["tried-to-access-admin"] = true;
    header("location: index.php");
    exit;
}

?>


<?php while ($row = $result-> fetch_array(MYSQLI_ASSOC)): ?>
    <tr>
        <td><?= $row["name"] ?></td>
        <td><?= $row["email"] ?></td>
        <td><?= $row["is_admin"] ?></td>
        <td><a href="edit-user.php?id=<?= $row["id"] ?>"> Edit </a> </td>
        <td><a href="reset-pfp.php?id=<?= $row["id"] ?>"> PFP </a> </td>
        <td><a href="delete-user.php?id=<?= $row["id"] ?>"> Delete </a> </td>

    </tr>
<?php endwhile; ?>

<?php

$result->free_result();

$conn->close();


?>



</body>
</html>