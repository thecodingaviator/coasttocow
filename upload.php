<?php
//Uploads file to google drive using service account defined in credentials.php

require_once __DIR__ . '/vendor/autoload.php';
include "utils/config.php";

putenv('GOOGLE_APPLICATION_CREDENTIALS=utils/c3-testing-389115-f39fd8b05d5d.json');

$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->setScopes(['https://www.googleapis.com/auth/drive.file']);

$service = new Google_Service_Drive($client);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_FILES['file_input']) && $_FILES['file_input']['error'] == 0) {
    $file = $_FILES['file_input'];
    $folder_selection = $_POST['folder_selection'];
    echo "Selected folder: " . $folder_selection . "<br>";

    // Get the ID of the selected folder
    $folder_id = $folder_ids[$folder_selection];
    echo "Folder ID: " . $folder_id . "<br>";

    // TODO: validate the folder selection and file details before using them

    $fileMetadata = new Google_Service_Drive_DriveFile([
      'name' => $file['name'],
      // 'parents' => [$folder_id] // Not supported in shared drives
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

    echo "The file has been uploaded to Drive with ID: " . $movedFile->id;

    // Store file ID in session variable
    $_SESSION['file_id'] = $movedFile->id;
  }
}
else{
  echo "No file uploaded";
}
?>
