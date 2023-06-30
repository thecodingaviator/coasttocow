<?php
// Downloads file from Google Drive using service account defined in credentials.php

require_once __DIR__ . '/vendor/autoload.php';
include "utils/config.php";

putenv('GOOGLE_APPLICATION_CREDENTIALS=utils/c3-testing-389115-f39fd8b05d5d.json');

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

        // Output the file content to the browser
        echo $content;
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request.";
}
?>
