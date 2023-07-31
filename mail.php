<?php
// File: mail.php
// Authors: Gordon Doore, Parth Parth
// Purpose: Send emails with smtp using PHPMailer
// Last modified: 07/24/2023
include "utils/config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'vendor/autoload.php';



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Sends an email using PHPMailer.
 *
 * @param string $subject: The subject of the email.
 * @param string $content: The content of the email.
 * @param string $recipient: The recipient's email address.
 * @param string $password: The sender's email password.
 *
 * @return bool Returns true if the mail was successfully sent, false otherwise.
 *
 * @throws Exception If there is an error while sending the email.
 */
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
        $_SESSION['update'][] = "Message has been sent";
        return true;
    } catch (Exception $e) {
        $_SESSION['update'][] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}


?>