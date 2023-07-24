<?php
// File: modify.php
// Authors: Gordon Doore, Parth Parth
// Last modified: 07/24/2023
// Purpose: Edit user profile
include "utils/config.php";

session_start();

$error = "";
$update_status = "";
$email_error = "";

$first_name = ""; // Initialize the variable here

//get data from db about user currently logged in
$user_id = $_SESSION['user_id'];
$U_Id = substr($user_id, 2);

//get user's current info
$sql = "SELECT * FROM C3SignUp WHERE U_Id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$U_Id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
  $error = "User not found";
} else {
  //set local vars
  $first_name = $user['FirstName'];
  $last_name = $user['LastName'];
  $email = $user['Email'];
  $phone = $user['PhoneNumber'];
  $title = $user['JobTitle'];
  $institution = $user['Institution'];
}

function changeUserInfo($password, $email, $phone, $title, $conn)
{
  $user_id = $_SESSION['user_id'];
  $U_Id = substr($user_id, 2);

  //retrieve user's current pass from db
  $sql = "SELECT UserPassword FROM C3UserNameAndPassword WHERE UserId = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$user_id]);
  $result = $stmt->fetchColumn();

  //check if current pass matches user's input
  if ($result == $password) {
    // Update user info
    $sql = "UPDATE `C3SignUp` SET `Email`=?,`PhoneNumber`=?,`JobTitle`=? WHERE U_Id = ?";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$email, $phone, $title, $U_Id]);

    if ($result) {
      $_SESSION['logged_in'] = true;
      global $update_status;
      $update_status = "<div class='results-container'><p>Profile updated successfully</p></div>";
    } else {
      global $update_status;
      $update_status = "<div class='results-container'><p>Failed to update profile, please contact admin.</p></div>";
    }
  } else {
    global $update_status;
    $update_status = "<div class='results-container'><p>Current password is incorrect. Try again</p></div>";
  }
}

function updatePassword($current_password, $new_password, $conn)
{
  //retrieve user info
  $user_id = $_SESSION['user_id'];
  $U_Id = substr($user_id, 2);
  //get user's current pass
  $sql = "SELECT UserPassword FROM C3UserNameAndPassword WHERE UserId = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$user_id]);
  $result = $stmt->fetchColumn();
  //check if pass matches user's input
  if ($result == $current_password) {
    // Update password
    $sql = "UPDATE `C3UserNameAndPassword` SET `UserPassword`=? WHERE UserId = ?";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$new_password, $user_id]);

    if ($result) {
      $_SESSION['logged_in'] = true;
      global $update_status;
      $update_status = "<div class='results-container'><p>Password updated successfully</p></div>";
    } else {
      global $update_status;
      $update_status = "<div class='results-container'><p>Failed to update password</p></div>";
    }
  } else {
    global $update_status;
    $update_status = "<div class='results-container'><p>Current password is incorrect. Try again</p></div>";
  }
}

//in case where user info is updated:
if (isset($_POST['submit'])) {
  $password = $_POST['Password'];
  $password = hash('sha256', $password);
  $email = $_POST['Email'];
  $phone = $_POST['PhoneNumber'];
  $title = $_POST['JobTitle'];

  changeUserInfo($password, $email, $phone, $title, $conn);
}
if (isset($_POST['change_password'])) {
  $current_password = $_POST['CurrentPassword'];
  $new_password = $_POST['NewPassword'];
  //encrypt both passwords
  $current_password = hash('sha256', $current_password);
  $new_password = hash('sha256', $new_password);

  updatePassword($current_password, $new_password, $conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C3 | Edit Profile</title>

  <link rel="stylesheet" href="utils/css/dashboard-common.css">
  <link rel="stylesheet" href="utils/css/modify.css">
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
        <div class="dashboard-top">
          <h1>Edit Profile</h1>
          <?php if (!empty($update_status)): ?>
            <?php echo $update_status; ?>
          <?php endif; ?>
        </div>
        <form action="" method="POST">
          <div class="parent">
            <div class="div1">
              <input type="text" placeholder="First Name" name="FirstName" value="<?php echo $first_name; ?>" readonly
                required>
            </div>
            <div class="div2">
              <input type="text" placeholder="Last Name" name="LastName" value="<?php echo $last_name; ?>" readonly
                required>
            </div>
            <div class="div3">
              <input type="email" placeholder="Email" name="Email" value="<?php echo $email; ?>" required>
            </div>
            <div class="div4">
              <input type="email" placeholder="Confirm Email" name="ConfirmEmail" required>
              <?php if (!empty($email_error)): ?>
                <div class="popup">
                  <span class="popuptext" id="popup">
                    <?php echo $email_error; ?>
                  </span>
                </div>
              <?php endif; ?>
            </div>
            <div class="div5">
              <input type="text" placeholder="Phone Number" name="PhoneNumber" value="<?php echo $phone; ?>">
            </div>
            <div class="div6">
              <input type="text" placeholder="Title" name="JobTitle" value="<?php echo $title; ?>" required>
            </div>
            <div class="div7">
              <input type="text" placeholder="Institution" name="Institution" value="<?php echo $institution; ?>"
                readonly required>
            </div>
            <div class="div8">
              <input type="password" placeholder="Current Password" name="Password" required autocomplete="email">
            </div>
            <div class="div9">
              <input type="submit" name="submit" value="Edit Profile">
            </div>
          </div>
        </form>

        <div class="change-password">
          <h2>Change Password</h2>
          <form action="" method="POST">
            <div class="parent">
              <div class="div8">
                <input type="password" placeholder="Current Password" name="CurrentPassword" required>
              </div>
              <div class="div7">
                <input type="password" placeholder="New Password" name="NewPassword" required>
              </div>
              <div class="div9">
                <input type="submit" name="change_password" value="Change Password">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>