<?php
session_start();
if(!isset($_SESSION["userid"])){
    header ("Location: /projects/Bookface/login.php");
    exit();
}
?>
<?php

require dirname(__FILE__). "/PHPFunc/db-connect.php";

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BookFace</title>
        <?php require dirname(__FILE__). "/Style/links.php"; ?>

        <style>

        .avatar{
            
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-left: 1%;
            margin-right: 1%;
            float: left;
            border-style: solid;
            border-color: black;
        }
        </style>

    </head>
    <body>

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
    </body>
    </html>