<?php
// File: confirmation.php
// Authors: Gordon Doore, Parth Parth
// Purpose: Confirmation page after upload/record a file
// Last modified: 07/23/2023

include "utils/config.php";
include "mail.php";

// Check if the session is not already started, start a new session
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
// Check if an email was sent

if (isset($_SESSION['email']) && !isset($_SESSION['confirmation_mail'])) {
  sendMail("File Uploaded", "Your file has been uploaded to the C3 Database Repo.", $_SESSION['email'], $mail_pass);
  $_SESSION['confirmation_mail'] = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C3 | Confirmation</title>

  <link rel="stylesheet" href="utils/css/dashboard-common.css">
  <link rel="stylesheet" href="utils/css/dashboard.css">
</head>

<body>
  <div class="wrapper-background">
    <p> </p>
  </div>
  <div class="wrapper">
    <?php include "navbar.php"; ?>
    <div class="content-wrapper">
      <div class="content">
        <?php // Retrieve and display the debugging messages
          if (isset($_SESSION['update']) && !empty($_SESSION['update'])) {
            echo "<h1>Confirmation:</h1>";
            foreach ($_SESSION['update'] as $message) {
              echo "<p>$message</p>";
            }
            unset($_SESSION['update']);
          } else {
            echo "<p>No debugging messages found.</p>";
          }
        ?>
      </div>
    </div>
  </div>
</body>

</html>
