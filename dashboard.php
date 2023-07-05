<?php
include "utils/config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: index.php");
  exit();
}

// Check if email was sent
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
                    <h1>Dashboard</h1>
                    <div class="button-grid-4">
                        <div class="dash-button">
                            <a href="templates.php"><i><img src="utils/icons/file_lines.svg" alt="Template Icon"></i>Templates</a>
                        </div>
                        <div class="dash-button">
                            <a href="explore_dash.php"><i><img src="utils/icons/magnifying_glass.svg" alt="Explore Icon"></i>Explore</a>
                        </div>
                        <div class="dash-button">
                            <a href="submit.php"><i><img src="utils/icons/paste.svg" alt="Submit Icon"></i>Submit</a>
                        </div>
                        <div class="dash-button">
                            <a href="modify.php"><i><img src="utils/icons/gear.svg" alt="Gear Icon"></i>Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>