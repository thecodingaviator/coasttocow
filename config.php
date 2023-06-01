<?php

include 'credentials.php';

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname;port=25060", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  echo " This is likely an issue on our end. Please contact the administrator";
}

?>