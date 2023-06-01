<?php
include "config.php";

if (isset($_POST['submit'])) {
  $userID = $_POST['UserID'];
  $password = $_POST['Password'];

  // Hash password using SHA-256
  $password = hash('sha256', $password);

  $sql = "SELECT UserPassword FROM C3UserNameAndPassword WHERE UserId = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$userID]);
  $result = $stmt->fetchColumn();

  if($result == $password) {
    $error = "Sign in successful!";
  } else {
    $error = "There was an error. Please ensure all fields are filled correctly and try again";
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
  <link rel="stylesheet" href="css/index.css">
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
      <div class="div1">
        <h1>Sign In!</h1>
      </div>
      <div class="div2">
        <p>Welcome to Coast to Cow Consumer!</p>
      </div>
      <div class="div3">
        <input type="text" placeholder="User ID" name="UserID">
      </div>
      <div class="div4">
        <input type="password" placeholder="Password" name="Password">
      </div>
      <div class="div5">
        <input type="hidden" name="submit" value="Sign In">
        <button type="submit" name="submit" id="submit-button">Sign In</button>
      </div>
      <div class="div6">
        <a href="signup.php" rel="noopener noreferrer">Sign Up</a>
      </div>
      <div class="div7">
        <a href="resetpassword.php" rel="noopener noreferrer">Forgot Password?</a>
      </div>
    </div>
  </form>
</body>

</html>