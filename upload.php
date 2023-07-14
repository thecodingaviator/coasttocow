<?php
//Uploads file to google drive using service account defined in credentials.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

require_once __DIR__ . '/vendor/autoload.php';
include "utils/config.php";

putenv('GOOGLE_APPLICATION_CREDENTIALS=utils/c3-testing-389115-f39fd8b05d5d.json');

$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->setScopes(['https://www.googleapis.com/auth/drive.file']);

$service = new Google_Service_Drive($client);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_FILES['file_input']) && $_FILES['file_input']['error'] == 0) {
    $file = $_FILES['file_input'];
    $folder_selection = $_POST['folder_selection'];
    echo "Selected folder: " . $folder_selection . "<br>";

    // Get the ID of the selected folder
    $folder_id = $folder_ids[$folder_selection];
    echo "Folder ID: " . $folder_id . "<br>";

    // TODO: validate the folder selection and file details before using them
    // Get file extension
    $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);

    $fileMetadata = new Google_Service_Drive_DriveFile([
      // session $unique_name
      'name' => $_SESSION['unique_name'] . "." . $file_ext,
    ]);
    $content = file_get_contents($file['tmp_name']);
    $driveFile = $service->files->create($fileMetadata, [
      'data' => $content,
      'uploadType' => 'multipart',
      'fields' => 'id',
      'supportsAllDrives' => true // Required for shared drives
    ]);
    // Move the file to the shared drive
    $emptyFileMetadata = new Google_Service_Drive_DriveFile();
    $movedFile = $service->files->update($driveFile->id, $emptyFileMetadata, [
      'addParents' => $folder_id,
      'supportsAllDrives' => true // Required for shared drives
    ]);
    // Store file ID in session variable
    $_SESSION['file_id'] = $movedFile->id;

    // Retrieve unique name from session
    $unique_name = $_SESSION['unique_name'];
    
    // insert file id into database at unique name
    $file_id = $_SESSION['file_id'];

    $sql = "UPDATE `C3DataMasterTest` SET `file_id`=? WHERE unique_name = ?";
    $stmt = $conn->prepare($sql);

    try {
      $stmt->execute([$file_id, $unique_name]);

      // Delete session variables except for user id
      unset($_SESSION['unique_name']);
      unset($_SESSION['file_id']);
      // Redirect to success page
      header("Location: confirmation.php");
      exit();

    } catch (PDOException $e) {
      $error = "Error submitting dataset. Please try again.";
      $error = $e->getMessage();
      error_log($error, 0); // Print error to SAPI log
      echo $error; // Print error to the developer console
    }
  }
  else {
    error_log("Error uploading file: " . $_FILES['file_input']['error']);
  }
}
?>
