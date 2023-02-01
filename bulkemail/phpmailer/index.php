<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$mail = new PHPMailer(true);
try {
    
    $mail->SMTPDebug = false;
    $mail->isSMTP();
    $mail->Host = 'visionarywritings.com';
    
    $mail->Username = 'developer@visionarywritings.com';
    $mail->Password = 'shgJo6X&FNL~Zu[lHm';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;  
	
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = true;                                  // TCP port to connect to

    //Recipients
    $mail->setFrom('smtp@ekarsh-projects.com', 'Mailer');
    $mail->addAddress('test.ekarsh@gmail.com', 'Joe User');     // Add a recipient

    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Trooommm';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
?>