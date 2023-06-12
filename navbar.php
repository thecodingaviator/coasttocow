<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

// Logout functionality
if (isset($_POST['logout'])) {
    // Clear session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: index.php");
    exit();
}

// Get user's name
$userID = $_SESSION['user_id'];
$sql = "SELECT FirstName, LastName FROM C3SignUp WHERE U_Id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([substr($userID, 2)]);

// Get the first row of the result
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Get the first name and last name
$firstName = $result['FirstName'];
$lastName = $result['LastName'];
?>

<link rel="stylesheet" href="css/navbar.css">
<link rel="stylesheet" href="css/normalize.css">

<nav>
    <div>
        <h1>Coast to Cow</h1>
        <p><?php echo 'Hi, ' . $firstName . ' ' . $lastName . '!' ?></p>
    </div>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="submit.php">Submit</a></li>
        <li><a href="modify.php">Edit Profile</a></li>
    </ul>
    <form action="" method="POST" name="logoutForm">
        <button type="submit" name="logout">Logout</button>
    </form>
</nav>