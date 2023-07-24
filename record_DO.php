<?php include "utils/config.php";
//File: record_DO.php
//Authors: Gordon Doore, Parth Parth
//Last modified: 07/24/2023
//Purpose: Record DairyOne PDF file to operational drive

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$_SESSION['session_name'] = session_name();

$error = "";
$metaSubmitted = false;

$user_id = $_SESSION['user_id'];
$U_Id = substr($user_id, 2);

$sql = "SELECT * FROM C3SignUp WHERE U_Id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$U_Id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
  $email = $user['Email'];
  $last_name = $user['LastName'];
  $first_name = $user['FirstName'];
}

if (isset($_POST['submitMeta'])) {

  $email = $_POST['email'];
  $last_name = $_POST['primary_last_name'];
  $first_name = $_POST['primary_first_name'];
  $institution = $_POST['institution'];
  $dataset_name = $_POST['dataset_name'];
  $dataset_description = $_POST['dataset_description'];
  $social_science = $_POST['social_science_data'];
  $social_science = $social_science == 'Yes' ? 1 : 0;
  $natural_science_in_vivo = $_POST['natural_science_in_vivo'];
  $natural_science_in_vivo = $natural_science_in_vivo == 'Yes' ? 1 : 0;
  $natural_science_in_vitro = $_POST['natural_science_in_vitro'];
  $natural_science_in_vitro = $natural_science_in_vitro == 'Yes' ? 1 : 0;
  $raw_dataset = $_POST['raw_dataset'];
  $raw_dataset = $raw_dataset == 'Yes' ? 1 : 0;
  $published_dataset = $_POST['published_dataset'];
  $published_dataset = $published_dataset == 'Yes' ? 1 : 0;
  $readme = $_POST['readme'];
  $readme = $readme == 'Yes' ? 1 : 0;
  $irb = $_POST['irb'];
  $irb = $irb == 'Yes' ? 1 : 0;
  $data_dictionary = $_POST['data_dictionary'];
  $data_dictionary = $data_dictionary == 'Yes' ? 1 : 0;
  $publication = $_POST['dataset_publication'];
  $publication = $publication == 'Yes' ? 1 : 0;
  $free_download = $_POST['free_download'];
  $free_download = $free_download == 'Yes' ? 1 : 0;
  $link_data_set = $_POST['link_data_set'];
  $link_readme = $_POST['link_readme'];
  $link_github = $_POST['link_github'];
  $link_other = $_POST['link_other'];
  $link_data_dictionary = $_POST['link_data_dictionary'];
  $agree_terms = $_POST['agree_terms'];
  $agree_terms = $agree_terms == 'on' ? 'Accepted' : 'Not Accepted';

  // create unique name for dataset based on dataset name
  $unique_name = preg_replace('/[^A-Za-z0-9\-]/', '', $dataset_name);
  $unique_name = strtolower($unique_name);
  $unique_name = str_replace(' ', '-', $unique_name);
  $unique_name = $unique_name . '-' . uniqid();

  // save unique name as session variable
  $_SESSION['unique_name'] = $unique_name;

  // check if dataset name already exists
  $sql = "SELECT * FROM C3DataMasterTest WHERE unique_name = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$unique_name]);

  if ($stmt->rowCount() > 0) {
    $error = "Dataset name already exists. Please try again.";
  } else {
    // Save all variables as session variables
    $_SESSION['dataset_name'] = $dataset_name;
    $_SESSION['dataset_description'] = $dataset_description;
    $_SESSION['social_science'] = $social_science;
    $_SESSION['natural_science_in_vivo'] = $natural_science_in_vivo;
    $_SESSION['natural_science_in_vitro'] = $natural_science_in_vitro;
    $_SESSION['raw_dataset'] = $raw_dataset;
    $_SESSION['published_dataset'] = $published_dataset;
    $_SESSION['readme'] = $readme;
    $_SESSION['irb'] = $irb;
    $_SESSION['data_dictionary'] = $data_dictionary;
    $_SESSION['publication'] = $publication;
    $_SESSION['free_download'] = $free_download;
    $_SESSION['link_data_set'] = $link_data_set;
    $_SESSION['link_readme'] = $link_readme;
    $_SESSION['link_github'] = $link_github;
    $_SESSION['link_other'] = $link_other;
    $_SESSION['link_data_dictionary'] = $link_data_dictionary;
    $_SESSION['agree_terms'] = $agree_terms;
    $_SESSION['email'] = $email;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['institution'] = $institution;

    $_SESSION['file_link'] = null;

    $metaSubmitted = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cross-Origin-Opener-Policy" content="unsafe-none">
  <meta http-equiv="Cross-Origin-Embedder-Policy" content="unsafe-none">
  <title>C3 | Submit</title>

  <link rel="stylesheet" href="utils/css/dashboard-common.css">
  <link rel="stylesheet" href="utils/css/record_DO.css">
</head>

<body>
  <?php if (!empty($error)): ?>
    <div class="error-div">
      <p id="error-message">
        <?php echo $error; ?>
      </p>
    </div>
  <?php endif; ?>
  <div class="wrapper-background">
    <p> </p>
  </div>
  <div class="wrapper">
    <?php include "navbar.php"; ?>
    <div class="content-wrapper">
      <div class="content">
        <h1>Record DairyOne PDF</h1>
        <div class="dataset-submission">
          <div class="enter-data">
            <div class="dataset-submission">
              <div class="upload-file">
                <p>Please attach your DairyOne PDF here to submit it to the database. The metadata will be recorded from
                  the file.</p>
                <form id="upload_form" enctype="multipart/form-data">
                  <input type="file" id="file_input" name="file_input">
                  <div>
                    <label>
                      <input type="radio" name="folder_selection" value="analysis" checked> Analysis
                    </label>
                  </div>
                  <div>
                    <label>
                      <input type="radio" name="folder_selection" value="macro"> Macro
                    </label>
                  </div>
                  <div>
                    <label>
                      <input type="radio" name="folder_selection" value="fatty_acids"> Fatty Acids
                    </label>
                  </div>
                  <input type="button" value="Upload" onclick="handleFileUpload()">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="utils/js/submit.js"></script>
</body>

</html>