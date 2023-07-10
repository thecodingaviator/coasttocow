<?php
include "utils/config.php";

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login page if the user is not authenticated
    exit();
}

$user_id = $_SESSION['user_id'];
$U_id = substr($user_id, 2);

$sql = "SELECT * FROM C3SignUp WHERE U_Id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$U_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$email = $result['Email'];
$phone = $result['PhoneNumber'];
$title = $result['JobTitle'];
$first_name = $result['FirstName'];
$last_name = $result['LastName'];
$institution = $result['Institution'];


function updateUserInfo($email, $phone, $title, $password, $conn){
  $user_id = $_SESSION['user_id'];
  $U_id = substr($user_id, 2);

  $sql = "SELECT UserPassword FROM C3UserNameAndPassword WHERE UserId = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$user_id]);
  $result = $stmt->fetchColumn();

  if (password_verify($password, $result)){
    $sql = "UPDATE C3SignUp SET Email = ?, PhoneNumber = ?, JobTitle = ? WHERE U_Id = ?";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$email, $phone, $title, $U_id]);
    return $result;
  } 
  return false;
}

function updatePassword($current_pass, $new_pass, $conn){
  $user_id = $_SESSION['user_id'];

  $sql = "SELECT UserPassword FROM C3UserNameAndPassword WHERE UserId = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$user_id]);
  $result = $stmt->fetchColumn();

  if (password_verify($current_pass, $result)){
    $new_pass_hash = password_hash($new_pass, PASSWORD_DEFAULT);
    $sql = "UPDATE C3UserNameAndPassword SET UserPassword = ? WHERE UserId = ?";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$new_pass_hash, $user_id]);
    return $result;
  }
  return false;
}

function main($conn){
  $update_status_internal = "";
  $error_internal = "";

  if (isset($_POST['update_user_info'])){
    $email = $_POST['Email'];
    $phone = $_POST['PhoneNumber'];
    $title = $_POST['JobTitle'];
    $password = $_POST['CurrentPassword'];
    $result = updateUserInfo($email, $phone, $title, $password, $conn);
    if ($result){
      $update_status_internal = "User info updated successfully!";
    } else {
      $update_status_internal = "User info update failed!";
      $error_internal = "Error occurred updating user information. Please check password and try again!";
    }
  } 
  else if (isset($_POST['update_password'])){
    $current_pass = $_POST['CurrentPassword'];
    $new_pass = $_POST['NewPassword'];
    $result = updatePassword($current_pass, $new_pass, $conn);
    if ($result){
      $update_status_internal = "Password updated successfully!";
    } else {
      $update_status_internal = "Password update failed!";
      $error_internal = "Error occurred updating password. Please check current password and try again!";
    }
  }
  $out = array(
    "update_status" => $update_status_internal,
    "error" => $error_internal
  );
  return $out;
}

$output = main($conn);
$update_status = $output['update_status'];
$error = $output['error'];
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
              <input type="email" placeholder="Confirm Email" name="ConfirmEmail" required>
              <?php if (!empty($email_error)): ?>
                <div class="popup">
                  <span class="popuptext" id="popup"><?php echo $email_error; ?></span>
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
              <input type="text" placeholder="Institution" name="Institution" value="<?php echo $institution; ?>" readonly required>
            </div>
            <div class="div8">
              <input type="password" placeholder="Current Password" name="CurrentPassword" required autocomplete="email">
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
                <input type="submit" name="submit" value="Change Password">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
