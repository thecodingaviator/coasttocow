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
    $free_download = $_SESSION['free_download'];
    $agree_terms = $_SESSION['agree_terms'];
    $email = $_SESSION['email'];
    $last_name = $_SESSION['last_name'];
    $first_name = $_SESSION['first_name'];
    $institution = $_SESSION['institution'];
    $file_id = $_SESSION['file_id'];
    $keywords = $_SESSION['keywords'];
    $num_files_set = $_SESSION['num_files_set'];
    $file_ext = $_SESSION['file_ext'];
    $link_github_repo = $_SESSION['link_github_repo'];

    $sql = "INSERT INTO `C3DataMasterTest` (`unique_name`, `dataset_name`, `dataset_description`, `social_science`, `natural_science_in_vivo`, `natural_science_in_vitro`,
     `raw_dataset`, `published_dataset`, `readme`, `irb`, `data_dictionary`, `publication`, `free_download`,`keywords`,`num_files_set`,`file_ext`,`link_github_repo`,`agree_terms`, `email`, `last_name`, `first_name`, `institution`, `file_id`) VALUES (
      ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    try {
      $stmt->execute([
        $unique_name,//
        $dataset_name,//
        $dataset_description,//
        $social_science,//
        $natural_science_in_vivo,
        $natural_science_in_vitro,//
        $raw_dataset,//
        $published_dataset,//
        $readme,//
        $irb,//
        $data_dictionary,//
        $publication,//
        $free_download,//
        $keywords,
        $num_files_set,
        $file_ext,
        $link_github_repo,
        $agree_terms,
        $email,
        $last_name,
        $first_name,
        $institution,
        $file_id
      ]);

      // Delete session variables except for user id
      unset($_SESSION['unique_name']);
      unset($_SESSION['dataset_name']);
      unset($_SESSION['dataset_description']);
      unset($_SESSION['social_science']);
      unset($_SESSION['natural_science_in_vivo']);
      unset($_SESSION['natural_science_in_vitro']);
      unset($_SESSION['raw_dataset']);
      unset($_SESSION['published_dataset']);
      unset($_SESSION['readme']);
      unset($_SESSION['irb']);
      unset($_SESSION['data_dictionary']);
      unset($_SESSION['publication']);
      unset($_SESSION['free_download']);
      unset($_SESSION['keywords']);
      unset($_SESSION['num_files_set']);
      unset($_SESSION['file_ext']);
      unset($_SESSION['link_github_repo']);

      // Redirect to success page
      header("Location: confirmation.php");

    } catch (PDOException $e) {
      $error = "Error submitting dataset. Please try again.";
      $error = $e->getMessage();
      error_log($error);
    }
  }
  else {
    error_log("Error uploading file: " . $_FILES['file_input']['error']);
  }
}
?>
