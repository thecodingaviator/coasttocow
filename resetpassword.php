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

    $U_Id = 'C3' . $U_Id;

    $sql = "INSERT INTO `C3UserNameAndPassword`(`UserId`, `UserPassword`) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$U_Id, $password]);

    if ($result) {
      $error = "New user created successfully! Your user ID is: " . $U_Id . ". Please sign in to continue.";
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
  <link rel="stylesheet" href="css/resetpassword.css">

</head>

<body>
<?php if (!empty($error)): ?>
    <div class="error-div">
      <p id="error-message">
        <?php echo $error; ?>
      </p>
    </div>
  <?php endif; ?>
  <form action="" method="POST" name="reset">
  <div id="signin">
    <div class="div1">
      <h1>Reset Password</h1>
    </div>
    <div class="div2">
      <p>Welcome to Coast to Cow Consumer!</p>
    </div>
    <div class="div3">
      <input type="text" placeholder="User ID">
    </div>
    <div class="div4">
      <input type="email" placeholder="Email">
    </div>
    <div class="div5">
    <input type="hidden" name="submit" value="Reset Password">
      <button type="submit" name="submit" id="submit-button">Reset Password</button>
    </div>
    <div class="div6">
      <a href="index.php" rel="noopener noreferrer">Sign In</a>
    </div>
  </div>
</form>
</body>

</html>