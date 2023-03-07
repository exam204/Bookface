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
    <title>Messages</title>
    <?php require dirname(__FILE__). "/Style/links.php"; ?>
    <?php require dirname(__FILE__). "/PHPFunc/db-connect.php";?>
    <?php require dirname(__FILE__). "/PHPFunc/dbcheck.php";?>

    
    <script>
        const interval = setInterval(function() {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById("messages").innerHTML = this.responseText;
        };
        xhttp.open("GET", "messages-update.php");
        xhttp.send();
        }, );
    </script>
    
    <style>


    .avatar{
        
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-left: 1%;
        margin-right: 1%;
        
        border-style: solid;
        border-color: black;
    }
    </style>

</head>
<body>

<?php require dirname(__FILE__). "/templates/nav.php"; ?>
<?php
function get_ft($userid){
            $conn = connect();
            $query = "SELECT ft FROM users WHERE id = $userid";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            //$_SESSION["dbft"] = $row["ft"];
            return $row["ft"];
        }
?>
    
    
<div id="messages" class="col-sm-4 tp-5 mx-auto">
<?php
        $conn = connect();
        $sql = "SELECT messages.id AS msg_id, name, message, date, userid FROM messages LEFT JOIN users ON messages.userid = users.id ORDER BY messages.id DESC"; 
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $name = $row['name'];
            $message = $row['message'];
            $date = $row['date'];
            if(substr($date,0,10) == date("Y-m-d")){
                $date = substr($date, 11 ,5);
            }
            else{
                $date = substr($date, 0, 16);
            }
            if ($row["userid"] == $_SESSION["userid"] ){
                $style = "background-color: #2780E3; color: #ffffff;"; 
                $style2 = "margin: 10px; margin-left: 200px; ";
            }
            else{
                $style = "background-color: #eeeeee;";
                $style2 = "margin: 10px; margin-right: 200px;";
            }
        
            ?>
            <div class="toast show" role="alert" aria-live="assertive" aSria-atomic="true" style="<?= $style2 ?>">

            <div class="toast-header" style="<?= $style ?>">
            <?php
                $ft = get_ft($row["userid"]);
                if($ft == "0"){
                    echo "<img src='Images/avatar.png' alt='Avatar' class='avatar'  >";
                }else{
                    $pfp = $row["userid"] . "." . $ft;?>
                    <img src='<?="pfp-images/".$pfp?>' alt='Avatar' class='avatar'  > <?php 
                }
                ?>
            
                <strong class="me-auto"><?=$name?></strong>
                <small>
                    <?=$date?>
                    <?php if($_SESSION["isadmin"]==true){ ?>
                        <form action="delete-messages-action.php?id=<?= $row["msg_id"] ?>" method="post">       
                            <input type='submit' value="Delete" class='btn btn-danger'></input>
                        </form>
                    <?php
                    }    
                    ?>
                </small>     
                <span aria-hidden="true"></span>
            </div>
            <div class="toast-body" style="<?= $style ?>">
                <?=$message?>
            </div>
        </div>
        <?php
        }
        ?>

</div>
<style>
#form {
  padding-top: 50px;
  padding-right: 30px;
  padding-bottom: 50px;
  padding-left: 80px;
}
</style>

<?php
    if(isset($_SESSION["no_input_message"])){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Oops!!</strong> Message Cannot Be Blank!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        unset($_SESSION["no_input_message"]);
    }
    ?>

<div id="form" class="row fixed-bottom">
    <div class="row">
        <div style="width: 100%;" >
            <form action="messages-action.php" method="post">
                <div class="input-group" >
                    
                    <input type="text" class="form-control" placeholder="Message"  id="message" name="message"  >

                    <span> <button type="submit" class="btn btn-primary">Submit</span>
                </div>
                 
            </form>
        </div>
    </div>
</div>


</body>
</html>