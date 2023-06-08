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
?>

<link rel="stylesheet" href="css/navbar.css">

<nav>
    <div>
        <h1>Coast to Cow</h1>
    </div>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="submit.php">Submit</a></li>
        <li><a href="page3.php">Page 3</a></li>
    </ul>
    <form action="" method="POST" name="logoutForm">
        <button type="submit" name="logout">Logout</button>
    </form>
</nav>
