<?php
//Gordon Doore, Parth Parth
//Last modified: 11/27/2023
//Purpose: Get data from ReadMe Table in SQL db for filling form
include "config.php";
// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Check if the 'title' parameter is set in the URL
if (isset($_GET['title'])) {
    $confirm = ['title'=>$_GET['title']]; //['title'=>'some_title
    echo json_encode($confirm);
    // Get the value of the 'title' parameter
    $selectedTitle = $_GET['title'];
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM C3ReadMeAT WHERE title_subtitle = ?");

    // Execute the statement
    $stmt->execute([$selectedTitle]);

    // Get the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if a row is found
    if ($result) {
        // Output the JSON response
        echo json_encode($result);
    } else {
        // If no row is found, return an error response
        $errorResponse = ['error' => 'No matching row found'];
        header('Content-Type: application/json');
        echo json_encode($errorResponse);
    }

    // Close the statement
    $stmt = null;
} else {
    // If 'title' parameter is not set, return an error response
    $errorResponse = ['error' => 'Title parameter is missing'];
    header('Content-Type: application/json');
    echo json_encode($errorResponse);
}

?>