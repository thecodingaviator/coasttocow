<?php
session_start();

include "utils/config.php";

function generateTemporaryPassword()
{
  $length = 8;
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $temporaryPassword = '';
  for ($i = 0; $i < $length; $i++) {
    $temporaryPassword .= $characters[rand(0, $charactersLength - 1)];
  }
  return $temporaryPassword;
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['submit'])) {
    $userID = $_POST['UserID'];
    $email = $_POST['Email'];

    $sql = "SELECT UserPassword FROM C3UserNameAndPassword WHERE UserId = ? AND UIdSU = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userID, $email]);
    $password = $stmt->fetchColumn();

    if ($password) {
        // Generate a temporary password
        $temporaryPassword = generateTemporaryPassword();

        // Update the user's password with the temporary password
        $sql = "UPDATE C3UserNameAndPassword SET UserPassword = ? WHERE UserId = ? AND UIdSU = ?";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([hash('sha256', $temporaryPassword), $userID, $email]);

        if ($result) {
            // Send the email with the temporary password
            $subject = "Password Reset";
            $message = "Your temporary password is: $temporaryPassword";
            $headers = "From: your_email@example.com";

            if (mail($email, $subject, $message, $headers)) {
                $error = "An email with the temporary password has been sent to your email address.";
            } else {
                $error = "Failed to send the email. Please try again later.";
            }
        } else {
            $error = "There was an error resetting your password. Please try again later.";
        }
    } else {
        $error = "Invalid userID or email. Please check your details and try again.";
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
    <link rel="stylesheet" href="utils/css/resetpassword.css">

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
                <h2> Reset Password </h2>
            </div>
            <div class="div3">
                <input type="text" name="UserID" placeholder="User ID">
            </div>
            <div class="div4">
                <input type="email" name="Email" placeholder="Email" autocomplete="email">
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