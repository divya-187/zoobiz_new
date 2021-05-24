<?php
// include 'common/object.php';
$q=$d->select("email_configuration","");
$data=mysqli_fetch_array($q);
extract($data);
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
try {
    //Server settings
  // $mail->SMTPDebug = SMTP::DEBUG_SERVER;


    if ($smtp_type!='') {
        $mail->$smtp_type();
    }else {
        $mail->isMail();
    }                      // Enable verbose debug output
                                            // Send using SMTP
    $mail->Host       = $email_smtp;                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $sender_email_id;                     // SMTP username
    $mail->Password   = $email_password;                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = $email_port;                                    // TCP port to connect to
    //Recipients
    $mail->setFrom($sender_email_id, $sender_name);

//IS_67
    /*if(is_array($to)){
       foreach($to as $add)
        {  
          $mail->addAddress($add);
        }   
    } else {
         
        $mail->addAddress($to);  
    }*/
   //IS_67 

   $mail->addAddress($to);  
       // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // // Attachments
    // $mail->addAttachment('att_data.csv');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
      $mail->Body    = $message;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    // echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}