<?php
// File: download.php
// Authors: Gordon Doore, Parth Parth
// Last modified: 07/24/2023
// Downloads file from Google Drive using service account defined in credentials.php
// Touching anything in this file breaks it. Do not touch. - Parth and Gordon

require_once __DIR__ . '/vendor/autoload.php';
include "utils/config.php";
include "utils/logActivity.php";

putenv('GOOGLE_APPLICATION_CREDENTIALS=utils/c3-upload.json');

$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->setScopes([
  'https://www.googleapis.com/auth/drive.file',
  'https://www.googleapis.com/auth/drive',
  'https://www.googleapis.com/auth/drive.file',
  'https://www.googleapis.com/auth/drive.metadata',
  'https://www.googleapis.com/auth/drive.readonly' // Add this scope for accessing shared drives
]);

$service = new Google_Service_Drive($client);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['name'])) {
  $fileId = $_GET['name'];

  if ($fileId) {
    // Fetch the file metadata
    $file = $service->files->get($fileId, ['fields' => 'name, mimeType', 'supportsAllDrives' => true]);

    // Set the appropriate headers for the file download
    header('Content-Description: File Transfer');
    header('Content-Type: ' . $file->getMimeType());
    header('Content-Disposition: attachment; filename=' . $file->getName());
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . $file->getSize());

    // Download the file content
    $response = $service->files->get($fileId, ['alt' => 'media', 'supportsAllDrives' => true]);
    $content = $response->getBody()->getContents();

    // //record file download
    try {
      $userID = $_SESSION['user_id'];
      $activity = "Downloaded file from href: " . $file->getName();
      logActivity($conn, $userID, $activity);
  } catch (Exception $e) {
      error_log($e->getMessage());
  }
    exit;
  } else {
    echo "File not found.";
  }
} else {
  echo "Invalid request.";
}
?>