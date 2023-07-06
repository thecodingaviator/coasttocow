<?php
include "utils/config.php";

session_start();

$error = "";

if (isset($_POST['submit'])) {
  $first_name = $_POST['FirstName'];
  $last_name = $_POST['LastName'];
  $email = $_POST['Email'];
  $old_password = $_POST['CurrentPassword'];
  $new_password = $_POST['NewPassword'];
  $phone = $_POST['PhoneNumber'];
  $title = $_POST['JobTitle'];
  $institution = $_POST['Institution'];

  // Hash password using SHA-256
  $old_password = hash('sha256', $old_password);
  $new_password = hash('sha256', $new_password);

  $user_id = $_SESSION['user_id'];
  $U_Id = substr($user_id, 2);

  $sql = "SELECT UserPassword FROM C3UserNameAndPassword WHERE UserId = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$user_id]);
  $result = $stmt->fetchColumn();

  if ($result == $old_password) {
    $sql = "UPDATE `C3SignUp` SET `FirstName`=?,`LastName`=?,`Email`=?,`PhoneNumber`=?,`JobTitle`=?,`Institution`=? WHERE U_Id = ?";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$first_name, $last_name, $email, $phone, $title, $institution, $U_Id]);

    if ($result && $new_password != "") {
      $sql = "UPDATE `C3UserNameAndPassword` SET `UserPassword`=?,`UIdSU`=? WHERE UserId = ?";
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute([$new_password, $email, $user_id]);

      if ($result) {
        $_SESSION['logged_in'] = true;
        $update_status = "<div class='results-container'><p>Profile and password updated successfully</p></div>";
      } else {
        $update_status = "<div class='results-container'><p>Failed to update password. Profile edited successfully</p></div>";
      }
    } else {
      $update_status = "<div class='results-container'><p>Profile updated successfully</p></div>";
    }
  } else {
    $update_status = "<div class='results-container'><p>Current password is incorrect. Try again</p></div>";
  }
} else {
  $user_id = $_SESSION['user_id'];
  $U_Id = substr($user_id, 2);

  $sql = "SELECT * FROM C3SignUp WHERE U_Id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$U_Id]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    $first_name = $user['FirstName'];
    $last_name = $user['LastName'];
    $email = $user['Email'];
    $phone = $user['PhoneNumber'];
    $title = $user['JobTitle'];
    $institution = $user['Institution'];
  } else {
    $error = "User data not found. Please contact the administrator if you think this is wrong.";
  }
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
              <input type="text" placeholder="First Name" name="FirstName" value="<?php echo $first_name; ?>" readonly required>
            </div>
            <div class="div2">
              <input type="text" placeholder="Last Name" name="LastName" value="<?php echo $last_name; ?>" readonly required>
            </div>
            <div class="div3">
              <input type="email" placeholder="Email" name="Email" value="<?php echo $email; ?>" required>
            </div>
            <div class="div4">
              <input type="text" placeholder="Phone Number" name="PhoneNumber" value="<?php echo $phone; ?>">
            </div>
            <div class="div5">
              <input type="text" placeholder="Title" name="JobTitle" value="<?php echo $title; ?>" required>
            </div>
            <div class="div6">
              <input type="text" placeholder="Institution" name="Institution" value="<?php echo $institution; ?>"
                readonly required>
            </div>
            <div class="div7">
              <input type="password" placeholder="New Password" name="NewPassword">
            </div>
            <div class="div8">
              <input type="password" placeholder="Current Password" name="CurrentPassword" required autocomplete="email">
            </div>
            <div class="div9">
              <input type="submit" name="submit" value="Edit Profile">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>