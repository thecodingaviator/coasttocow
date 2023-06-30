<?php
//Uploads file to google drive using service account defined in credentials.php

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

    $fileMetadata = new Google_Service_Drive_DriveFile([
      // session $unique-name
      'name' => $_SESSION['unique_name'],
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

    // Retrieve variables from session
    $unique_name = $_SESSION['unique_name'];
    $dataset_name = $_SESSION['dataset_name'];
    $dataset_description = $_SESSION['dataset_description'];
    $social_science = $_SESSION['social_science'];
    $natural_science_in_vivo = $_SESSION['natural_science_in_vivo'];
    $natural_science_in_vitro = $_SESSION['natural_science_in_vitro'];
    $raw_dataset = $_SESSION['raw_dataset'];
    $published_dataset = $_SESSION['published_dataset'];
    $readme = $_SESSION['readme'];
    $irb = $_SESSION['irb'];
    $data_dictionary = $_SESSION['data_dictionary'];
    $publication = $_SESSION['publication'];
    $link_data_set = $_SESSION['link_data_set'];
    $link_readme = $_SESSION['link_readme'];
    $link_github = $_SESSION['link_github'];
    $link_other = $_SESSION['link_other'];
    $link_data_dictionary = $_SESSION['link_data_dictionary'];
    $agree_terms = $_SESSION['agree_terms'];
    $email = $_SESSION['email'];
    $last_name = $_SESSION['last_name'];
    $first_name = $_SESSION['first_name'];
    $institution = $_SESSION['institution'];
    $file_id = $_SESSION['file_id'];

    $sql = "INSERT INTO `C3DataMasterTest` (`unique_name`, `dataset_name`, `dataset_description`, `social_science`, `natural_science_in_vivo`, `natural_science_in_vitro`,
     `raw_dataset`, `published_dataset`, `readme`, `irb`, `data_dictionary`, `publication`, `link_data_set`, `link_readme`, `link_github`, `link_other`, `link_data_dictionary`,
      `agree_terms`, `email`, `last_name`, `first_name`, `institution`, `file_id`) VALUES (
      ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    try {
      $stmt->execute([
        $unique_name,
        $dataset_name,
        $dataset_description,
        $social_science,
        $natural_science_in_vivo,
        $natural_science_in_vitro,
        $raw_dataset,
        $published_dataset,
        $readme,
        $irb,
        $data_dictionary,
        $publication,
        $link_data_set,
        $link_readme,
        $link_github,
        $link_other,
        $link_data_dictionary,
        $agree_terms,
        $email,
        $last_name,
        $first_name,
        $institution,
        $file_id
      ]);
    } catch (PDOException $e) {
      $error = "Error submitting dataset. Please try again.";
      $error = $e->getMessage();
    }
  }
}
?>