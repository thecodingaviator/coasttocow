<?php
include "utils/config.php";

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
    <div class="logo-div">
        <h1>
            <a href="dashboard.php">
            Coast to Cow
            </a>
        </h1>
    </div>
    <ul>
        <li><a href="explore.php">Explore</a></li>
        <li><a href="submit.php">Submit</a></li>
        <li><a href="templates.php">Templates</a></li>
        <li><a href="https://github.com/coast-cow-consumer">GitHub</a></li>
    </ul>
    <div class="profile-dropdown">
        <ul>
            <li>
                <a href="#">
                    <?php echo $firstName . ' ' . $lastName ?>
                    <span class="arrow">&#9662;</span>
                    <script>
                        const dropdown = document.querySelector('.profile-dropdown');
                        const arrow = document.querySelector('.arrow');

                        dropdown.addEventListener('mouseover', () => {
                            arrow.style.transform = 'rotate(180deg)';
                        });

                        dropdown.addEventListener('mouseout', () => {
                            arrow.style.transform = 'rotate(0deg)';
                        });
                    </script>
                </a>
                <ul>
                    <li><a href="modify.php">Edit Profile</a></li>
                    <li>
                        <form action="" method="POST" name="logoutForm">
                            <button type="submit" name="logout">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>