<?php
// File: config.php
// Authors: Gordon Doore, Parth Parth
// Purpose: Configuration file for the site
// Last modified: 04/05/2023

include 'credentials.php';

try {
  $conn = new PDO("mysql:host=$server;dbname=$dbname;port=$port", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  echo " This is likely an issue on our end. Please contact the administrator";
}

?>