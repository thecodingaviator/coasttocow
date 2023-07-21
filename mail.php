<?php
include "utils/config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'vendor/autoload.php';



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMail($subject, $content, $recipient, $password){
    $mail = new PHPMailer(true);
    try {                                   
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com';                   
        $mail->SMTPAuth   = true;                            
        $mail->Username   = 'c3-database-repo@coastcowconsumer.com';                
        $mail->Password   = $password;                
        $mail->SMTPSecure = 'tls';                             
        $mail->Port       = 587; 
     
        $mail->setFrom('c3-database-repo@coastcowconsumer.com', 'C3 Database Repo');          
        $mail->addAddress($recipient);
                                      
        $mail->Subject = $subject;
        $mail->Body    = $content;
        $mail->send();
        echo "Mail has been sent successfully!";
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}


?>