<?php
// File: signup.php
// Authors: Gordon Doore, Parth Parth
// Purpose: Sign up page
// Last modified: 07/24/2023

session_start();

include "utils/config.php";
include "mail.php";

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
  header("Location: dashboard.php");
  exit();
}

if (isset($_POST['submit'])) {
  $first_name = $_POST['FirstName'];
  $last_name = $_POST['LastName'];
  $email = $_POST['Email'];
  $password = $_POST['Password'];
  $phone = $_POST['PhoneNumber'];
  $title = $_POST['JobTitle'];
  $institution = $_POST['Institution'];

  // Hash password using SHA-256
  $password = hash('sha256', $password);

  $sql = "INSERT INTO `C3SignUp`(`FirstName`, `LastName`, `Email`, `PhoneNumber`, `JobTitle`, `Institution`) 
    VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $result = $stmt->execute([$first_name, $last_name, $email, $phone, $title, $institution]);

  if ($result) {
    $sql = "SELECT U_Id FROM C3SignUp WHERE LastName = ? AND Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$last_name, $email]);
    $U_Id = $stmt->fetchColumn();

    $U_Id = 'C3' . $U_Id;

    $sql = "INSERT INTO `C3UserNameAndPassword`(`UserId`, `UserPassword`, `UIdSU`) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$U_Id, $password, $email]);

    if ($result) {
      $_SESSION['logged_in'] = true;
      $_SESSION['user_id'] = $U_Id;

      // Send email with confirmation and user ID
      $to = $email;
      $subject = "Account Confirmation";
      $message = "Thank you for signing up! Your user ID is: $U_Id";
      $headers = "From: your_email@example.com"; // Replace with your own email address

      // Uncomment the following line to send the email
      if (sendMail($subject, $message, $to, $mail_pass)) {
        $_SESSION['email_sent'] = true;
      } else {
        $_SESSION['email_sent'] = false;
      }
      // Set a session variable to indicate that the email was sent

      header("Location: dashboard.php");
      exit();
    } else {
      $error = "There was an error. Please ensure all fields are filled and try again";
    }
  } else {
    $error = "There was an error. Please ensure all fields are filled and try again";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coast To Cow Consumer</title>
  <link rel="stylesheet" href="utils/css/normalize.css">
  <link rel="stylesheet" href="utils/css/universal.css">
  <link rel="stylesheet" href="utils/css/signup.css">
  <script>
    function submitForm() {
      document.forms["signup"].submit();
    }
  </script>
</head>

<body>
  <?php if (!empty($error)): ?>
    <div class="error-div">
      <p id="error-message">
        <?php echo $error; ?>
      </p>
    </div>
  <?php endif; ?>
  <form action="" method="POST" name="signup">
    <div id="signin">
      <div class="heading-div">
        <h2>Create a C3 Data Repository Account</h2>
      </div>
      <div class="conditions-div">
        <p>By creating a C3 Data Repository Account you are confirming that you are part of the C3 Project and will
          abide by the terms and conditions surrounding data sharing and use.
        </p>
      </div>
      <div class="div2">
        <input type="text" placeholder=" First Name" name="FirstName" required>
      </div>
      <div class="div3">
        <input type="text" placeholder=" Last Name" name="LastName" required>
      </div>
      <div class="div4">
        <input type="email" placeholder=" Email" name="Email" required>
      </div>
      <div class="div5">
        <input type="password" placeholder=" Password" name="Password" required>
      </div>
      <div class="div6">
        <input type="text" placeholder=" Phone Number" name="PhoneNumber">
      </div>
      <div class="div7">
        <input type="text" placeholder=" Title" name="JobTitle" required>
      </div>
      <div class="div8">
        <select id="institution" name="Institution" required>
          <option value="">Select an option</option>
          <option value="Bigelow">Bigelow</option>
          <option value="Clarkson University">Clarkson University</option>
          <option value="Colby College">Colby College</option>
          <option value="Cornell University">Cornell University</option>
          <option value="Syracuse University">Syracuse University</option>
          <option value="Miner Institute">Miner Institute</option>
          <option value="UNH">UNH</option>
          <option value="UVM">UVM</option>
          <option value="Wolf's Neck Center">Wolf's Neck Center</option>
        </select>
      </div>
      <div class="button-div">
        <input type="hidden" name="submit" value="Sign Up!">
        <button type="submit" name="submit" id="submit-button">Sign Up</button>
      </div>
      <div class="div10">
        <a href="index.php" rel="noopener noreferrer">Sign In</a>
      </div>
    </div>
  </form>
</body>

</html>