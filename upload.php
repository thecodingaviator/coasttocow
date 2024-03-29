<?php
// File: upload.php
// Authors: Gordon Doore, Parth Parth
// Purpose: Uploads file to google drive using service account defined in credentials.php
// Last modified: 07/24/2023

//Uploads file to google drive using service account defined in credentials.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

require_once __DIR__ . '/vendor/autoload.php';
include "utils/config.php";

putenv('GOOGLE_APPLICATION_CREDENTIALS=utils/c3-upload.json');

$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->setScopes(['https://www.googleapis.com/auth/drive.file']);

$service = new Google_Service_Drive($client);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_FILES['file_input']) && $_FILES['file_input']['error'] == 0) {
    $file = $_FILES['file_input'];
    $folder_selection = $_POST['folder_selection'];
    echo "Selected folder: " . $folder_selection . "<br>";
    if (!isset($_SESSION['unique_name'])){
      $_SESSION['unique_name'] = $folder_selection .  '-' . uniqid();
    }
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
    //add notification update in session
    $_SESSION['update'][] = "File uploaded to Google Drive";
    // Store file ID in session variable
    $_SESSION['file_id'] = $movedFile->id;
    $_SESSION['confirmation'] = true;
    // Retrieve unique name from session
    $unique_name = $_SESSION['unique_name'];

    // insert file id into database at unique name
    $file_id = $_SESSION['file_id'];

    if (isset($_SESSION['submitMeta'])){
      $sql = "UPDATE `C3DataMasterTest` SET `file_id`=? WHERE unique_name = ?";
      $stmt = $conn->prepare($sql);

      try {
        $stmt->execute([$file_id, $unique_name]);
        $_SESSION['update'][] = "File ID updated in database";
        // Delete session variables except for user id
        unset($_SESSION['unique_name']);
        unset($_SESSION['file_id']);
        $_SESSION['file_uploaded'] = true;

      } catch (PDOException $e) {
        $error = "Error submitting dataset. Please try again.";
        $error = $e->getMessage();
        error_log($error, 0); // Print error to SAPI log
        $_SESSION['file_uploaded'] = false;
        $_SESSION['update'][] = $error;
    }
  }
  } else {
    error_log("Error uploading file: " . $_FILES['file_input']['error']);
  }
}
?>