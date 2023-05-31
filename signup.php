<?php
include "config.php";

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

    $sql = "INSERT INTO `C3UserNameAndPassword`(`UserId`, `UserPassword`) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$U_Id, $password]);

    if ($result) {
      $error = "New user created successfully!";
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
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/universal.css">
  <link rel="stylesheet" href="css/signup.css">
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
    <script>
      // Hide div after 5s.
      setTimeout(function() {
        document.querySelector(".error-div").style.display = "none";
      }, 5000);
    </script>
  <?php endif; ?>
  <form action="" method="POST" name="signup">
    <div id="signin">
      <div class="div1">
        <h1>Sign Up</h1>
      </div>
      <div class="div2 input-div">
        <input type="text" placeholder="First Name" name="FirstName" required>
      </div>
      <div class="div3 input-div">
        <input type="text" placeholder="Last Name" name="LastName" required>
      </div>
      <div class="div4 input-div">
        <input type="email" placeholder="Email" name="Email" required>
      </div>
      <div class="div5 input-div">
        <input type="password" placeholder="Password" name="Password" required>
      </div>
      <div class="div6 input-div">
        <input type="text" placeholder="Phone Number" name="PhoneNumber">
      </div>
      <div class="div7 input-div">
        <input type="text" placeholder="Title" name="JobTitle" required>
      </div>
      <div class="div8 input-div">
        <input type="text" placeholder="Institution" name="Institution" required>
      </div>
      <div class="div9 button-div">
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