<?php

include "config.php";

if (isset($_POST['submit'])) {

  echo "Form Submitted Successfully.";

  $first_name = $_POST['FirstName'];

  $last_name = $_POST['LastName'];

  $email = $_POST['Email'];

  $password = $_POST['password'];
  // Hash password using SHA-256
  $password = hash('sha256', $password);

  $phone = $_POST['PhoneNumber'];

  $title = $_POST['JobTitle'];

  $institution = $_POST['Institution'];

  $sql = "INSERT INTO `C3SignUp`(`FirstName`, `LastName`, `Email`, `Password`, `PhoneNumber`, `JobTitle`, `Institution`) 

           VALUES ('$first_name','$last_name','$email','$password','$phone','$title','$institution')";

  $result = $conn->query($sql);

  if ($result == TRUE) {

    echo "New record created successfully.";

    // Query by LastName and Email to get the UserID

    $sql = "SELECT U_Id FROM users WHERE LastName = '$last_name' AND Email = '$email'";

    $U_Id = $conn->query($sql);

    $sql = "INSERT INTO `C3UsernameAndPassword`(`UserId`, `Password`)

           VALUES ('$U_Id','$password')";

    $result = $conn->query($sql);

    if ($result == TRUE) {

      echo "New record created successfully with user id as $U_Id.";

    } else {

      echo "There was an error. Please ensure all fields are filled and try again";

    }

  } else {

    echo "There was an error. Please ensure all fields are filled and try again";

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

</head>

<body>
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
    <div class=" div4 input-div">
      <input type="email" placeholder="Email" name="Email" required>
    </div>
    <div class="div5 input-div">
      <input type="password" placeholder="Password" name="Password" required>
    </div>
    <div class="div6 input-div">
      <input type="text" placeholder="Phone Number" name="PhoneNumber">
    </div>
    <div class="div7 input-div">
      <input type="text" placeholder="Title" name="Title">
    </div>
    <div class="div8 input-div">
      <input type="text" placeholder="Institution" name="Institution">
    </div>
    <div class="div9 button-div">
      <button type="submit" name="submit">Sign Up</button>
    </div>
    <div class="div10">
      <a href="index.php" rel="noopener noreferrer">Sign In</a>
    </div>
  </div>
</body>

</html>