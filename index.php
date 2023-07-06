<?php
include "utils/config.php";

session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
    header("Location: dashboard.php");
    exit();
}

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
        $_SESSION['user_id'] = $userID;
        $_SESSION['logged_in'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Due to either a wrong user name or incorrect password we are unable to log you in. \nPlease check that all fields are filled correctly and try again. \nIf you are unable to login in please contact kara.kugelmeyer@colby.edu";
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
    <link rel="stylesheet" href="utils/css/index.css">
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
                <h2>Welcome to Coast to Cow Consumer Data Repository!</h2>
            </div>
            <div class="div2">
                <h2>Sign in to C3 Data Repository</h2>
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