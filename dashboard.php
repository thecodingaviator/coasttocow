<?php
include "utils/config.php";

// Check if the session is not already started, start a new session
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: index.php"); // Redirect the user to index.php
  exit(); // Stop executing the rest of the code
}

// Check if an email was sent
$emailSent = false;
if (isset($_SESSION['email_sent']) && $_SESSION['email_sent'] === true) {
  $emailSent = true;
  // Unset the session variable to avoid displaying the notification multiple times
  unset($_SESSION['email_sent']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C3 | Dashboard</title>

  <link rel="stylesheet" href="utils/css/dashboard-common.css">
  <link rel="stylesheet" href="utils/css/dashboard.css">
</head>

<body>
  <?php if (!empty($error)): ?>
    <div class="error-div">
      <p id="error-message">
        <?php echo $error; ?>
      </p>
    </div>
  <?php endif; ?>
  <div class="wrapper-background">
    <p> </p>
  </div>
  <div class="wrapper">
    <?php include "navbar.php"; ?>
    <div class="content-wrapper">
      <div class="content">
        <?php if ($emailSent): ?>
          <div class="notification">
            Notice: An Email containing your UserID has been sent to your email address.
            This will be your login id.
          </div>
        <?php endif; ?>
        <div class="scrollable-content">
          <h2>Dashboard</h2>
        </div>
        <div class="welcome-row">Welcome to the C3 Data Repository. This platform serves as a central hub for
          participants of the C3 Grant, facilitating sharing and exploration of data generated during the C3 project.
        </div>
      </div>
    </div>
  </div>
</body>

</html>