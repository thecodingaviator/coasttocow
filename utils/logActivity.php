<?php

include "config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function logActivity($conn, $userID, $activity) {
    // Get the current server time
    $timeHappened = date('Y-m-d H:i:s');

    //get activity report
    $userIP = ip2long($_SERVER['REMOTE_ADDR']);
    
    //if user IP not an integer, set to 0
    if ($userIP === false) {
        $userIP = 0;
    }

    // Prepare an SQL statement
    $stmt = $conn->prepare("INSERT INTO C3Activity (userID, userIP, activityReport, timeHappened) VALUES (?, ?, ?, ?)");

    try {
        // Execute the SQL statement with an array of parameters
        $success = $stmt->execute([$userID, $userIP, $activity, $timeHappened]);
        if ($success) {
            echo "Activity logged successfully.";
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        $error = "Error logging activity. Please try again.";
        $error = $e->getMessage();
        //echo $error;
    }

    // Close the statement
    $stmt = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['activity'])) {
    // Get the user ID from the session
    $userID = $_SESSION['user_id'];

    // Get the activity from the POST data
    $activity = $_POST['activity'];
    
    // Log the activity
    logActivity($conn, $userID, $activity);
  }
}
?>