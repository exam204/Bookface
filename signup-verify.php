<?php
    session_start();
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require dirname(__FILE__). "/Style/links.php"; ?>
    <?php require dirname(__FILE__). "/PHPFunc/db-connect.php";?>
    <?php require dirname(__FILE__). "/PHPFunc/dbcheck.php";?>
</head>
<body>
    <?php require dirname(__FILE__). "/templates/nav.php"; ?>  
    

    <?php
    if(isset($_SESSION["wrong_auth"])){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Oops!!</strong> Wrong Code!!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
            unset($_SESSION["wrong_auth"]);
        }

    $_SESSION["visited-verify"] = true;

    emailauth();

?>
    <?php echo $_SESSION["authnumber"]?>
    <form action="signup-action.php" method="post">
        <div class="form-group" >
            <label for="exampleInputAuth" class="form-label mt-4" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Code</label>
            <input type="text" name="enterauth" class="form-control" id="exampleInputAuth" aria-describedby="authHelp" placeholder="Enter Verification Code" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Enter" class="btn btn-primary form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">
        </div>
    </form>

<?php
    function emailauth(){
        $authnumber = rand(100000, 999999);
        $_SESSION["authnumber"] = $authnumber;
        
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.outlook.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'bookfaceauth@outlook.com';                     //SMTP username
        $mail->Password   = 'LocalHost#123';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('bookfaceauth@outlook.com', 'BookFace');
        $mail->addAddress($_SESSION["emailauth"], $_SESSION["nameauth"]);     //Add a recipient


        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Your Verification Code';
        $mail->Body    = 'Please Type This Number into Text Field On Screen ' . $authnumber;
        $_SESSION["authnumber"] = $authnumber;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


        $mail->send();


        
    } catch (Exception $e) {
        
    }
}

    
    
    ?>



</body>
</html>