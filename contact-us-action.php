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

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Instantiate PHPMailer
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.outlook.com';                       // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'hagauth@outlook.com';                 // SMTP username
        $mail->Password   = 'HealthAdviceGroup123#';                         // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                                  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('hagauth@outlook.com', 'Health Advice Group');
        $mail->addAddress($email, $name);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Contact Form Submission';
        $mail->Body    = "Name: $name <br> Email: $email <br> Phone: $phone <br> Message: $message";

        $mail->send();
        $_SESSION['contact'] = 'Message has been sent';
		header ('Location: contact-us.php');
    } catch (Exception $e) {
        $_SESSION['contact-fail'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
		header ('Location: contact-us.php');
    }
}
?>