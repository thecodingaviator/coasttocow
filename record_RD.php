<?php include "utils/config.php";

function fieldsToDataMasterSQL($conn, $post_data, $user_id){
  $error = "";
  // Retrieve variables from session
  $unique_name = $post_data['unique_name'];
  $dataset_name = $post_data['dataset_name'];
  $dataset_description = $post_data['dataset_description'];
  $social_science = $post_data['social_science_data'];
  $natural_science_in_vivo = $post_data['natural_science_in_vivo'];
  $natural_science_in_vitro = $post_data['natural_science_in_vitro'];
  $published_dataset = $post_data['published_dataset'];
  $irb = $post_data['irb'];
  $data_dictionary = $post_data['data_dictionary'];
  $publication = $post_data['dataset_publication'];
  $free_download = $post_data['free_download'];
  $agree_terms = $post_data['agree_terms'];
  $email = $post_data['email'];
  $last_name = $post_data['primary_last_name'];
  $first_name = $post_data['primary_first_name'];
  $institution = $post_data['institution'];
  $file_id = null;
  $keywords = $post_data['keywords'];
  $num_files_set = $post_data['num_files_set'];
  $link_github_repo = $post_data['link_github_repo'];

  $sql = "INSERT INTO `C3DataMasterTest` (`unique_name`, `dataset_name`, `dataset_description`, `social_science`, 
  `natural_science_in_vivo`, `natural_science_in_vitro`, `published_dataset`, `irb`, `data_dictionary`, `publication`,
  `free_download`,`keywords`,`num_files_set`,`link_github_repo`,`agree_terms`, `email`, `last_name`, `first_name`, `institution`, `file_id`) VALUES (
  ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);

  try {
    $stmt->execute([
      $unique_name,//
      $dataset_name,//
      $dataset_description,//
      $social_science,//
      $natural_science_in_vivo,
      $natural_science_in_vitro,//
      $published_dataset,//
      $irb,//
      $data_dictionary,//
      $publication,//
      $free_download,//
      $keywords,
      $num_files_set,
      $link_github_repo,
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
    error_log($error);
  }
  return $error;
}

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$_SESSION['session_name'] = session_name();
$_SESSION['update'] = [];
$error = "";
$metaSubmitted = false;

$user_id = $_SESSION['user_id'];
$U_Id = substr($user_id, 2);

$sql = "SELECT * FROM C3SignUp WHERE U_Id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$U_Id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user) {
  $email = $user['Email'];
  $last_name = $user['LastName'];
  $first_name = $user['FirstName'];
}

if (isset($_POST['submitMeta'])) {
  $post_data = $_POST;

  // create unique name for dataset based on dataset name
  $unique_name = preg_replace('/[^A-Za-z0-9\-]/', '', $post_data['dataset_name']);
  $unique_name = strtolower($unique_name);
  $unique_name = str_replace(' ', '-', $unique_name);
  $unique_name = $unique_name . '-' . uniqid();

  // save unique name as session variable
  $_SESSION['unique_name'] = $unique_name;
  $post_data['unique_name'] = $unique_name;

  // check if dataset name already exists
  $sql = "SELECT * FROM C3DataMasterTest WHERE unique_name = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$unique_name]);

  if ($stmt->rowCount() > 0) {
    $error = "Dataset name already exists. Please try again.";
  } else {

    $_SESSION['file_link'] = null;

    $metaSubmitted = true;
    $error = fieldsToDataMasterSQL($conn, $post_data, $user_id);
    $_SESSION['update'][] = "Sucessfully Recorded Metadata. an email will be sent to you to confirm this submission";
    $_SESSION['update'][] = $error;
  }
  if (isset($_POST['free_download']) && $_POST['free_download'] == 0 && $metaSubmitted) {
    header('Location: confirmation.php');
    exit();
  }
}
if (isset($_SESSION['file_uploaded'])){
  if ($_SESSION['file_uploaded'] == true) {
    unset($_SESSION['file_uploaded']);
    $_SESSION['update'][] = "Sucessfully Uploaded File";
  }
  else {
    unset($_SESSION['file_uploaded']);
    $_SESSION['update'][] = "Error Uploading File, please contact administrator";
  }
  header('Location: confirmation.php');
  exit();
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
  <title>C3 | Record</title>

  <link rel="stylesheet" href="utils/css/dashboard-common.css">
  <link rel="stylesheet" href="utils/css/record_RD.css">
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
        <h1>Record Research Data</h1>
        <div class="dataset-submission">
          <div class="enter-data">
            <div class="dataset-submission">
              <div class="enter-data" style="<?php echo $metaSubmitted?'display: none;':''; ?>">
                <form id="intake-form" action="" method="POST">
                  <h2>C3 Data Master Intake Form</h2>
                  <p><em>* Indicates required question</em></p>

                  <label for="email">Email *</label>
                  <input type="email" id="email" name="email" value="<?php echo $email?>" required>

                  <label for="primary_last_name">Primary Contact Last Name *</label>
                  <input type="text" id="primary_last_name" name="primary_last_name" value="<?php echo $last_name?>"
                  required>

                  <label for="primary_first_name">Primary Contact First Name *</label>
                  <input type="text" id="primary_first_name" name="primary_first_name" value="<?php echo $first_name?>"
                  required>

                  <label for="institution">Institution of Primary Contact *</label>
                  <select id="institution" name="institution" required>
                    <option value="">Select an option</option>
                    <option value="Bigelow">Bigelow</option>
                    <option value="Clarkson University">Clarkson University</option>
                    <option value="Colby College">Colby College</option>
                    <option value="Cornell University">Cornell University</option>
                    <option value="Syracuse University">Syracuse University</option>
                    <option value="Miner Institute">Miner Institute</option>
                    <option value="UNH">UNH</option>
                    <option value="UVM">UVM</option>
                    <option value="Wolf's Neck Center">Wolf's Neck Center</option>
                  </select>

                  <label for="dataset_name">Dataset Name (year_month_type_brief-description) *</label>
                  <input type="text" id="dataset_name" name="dataset_name" required>

                  <label for="dataset_description">Dataset Description *</label>
                  <textarea id="dataset_description" name="dataset_description" rows="6" required></textarea>
                  <label for="keywords">Keywords *</label>
                  <input type="text" id="keywords" name="keywords" required>

                  <label for="num_files_set">Number of Files *</label>
                  <input type="number" id="num_files_set" name="num_files_set" min="1" required>
                
                  <label for="link_github_repo" class = "repo">GitHub Repository Link </label>
                  <input type="text" id="link_github_repo" name="link_github_repo">

                  <div>
                    <p>Is the data classified as Social Science data? *</p>
                    <div>
                      <label>
                        <input type="radio" name="social_science_data" value=1 required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="social_science_data" value=0 required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>Is the data classified as Natural Science and represents in vivo experiments? *</p>
                    <div>
                      <label>
                        <input type="radio" name="natural_science_in_vivo" value=1 required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="natural_science_in_vivo" value=0 required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>Is the data classified as Natural Science and represents in vitro experiments? *</p>
                    <div>
                      <label>
                        <input type="radio" name="natural_science_in_vitro" value=1 required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="natural_science_in_vitro" value=0 required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>Published Dataset? *</p>
                    <div>
                      <label>
                        <input type="radio" name="published_dataset" value=1 required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="published_dataset" value=0 required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>IRB? *</p>
                    <div>
                      <label>
                        <input type="radio" name="irb" value=1 required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="irb" value=0 required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>Data Dictionary? *</p>
                    <div>
                      <label>
                        <input type="radio" name="data_dictionary" value=1 required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="data_dictionary" value=0 required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>Dataset related to publication? *</p>
                    <div>
                      <label>
                        <input type="radio" name="dataset_publication" value=1 required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="dataset_publication" value=0 required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>Do you want to make a submit your data to the database or make a record of your data? *</p>
                    <div>
                      <label>
                        <input type="radio" name="free_download" value=1 required> Submit data into the database for sharing
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="free_download" value=0 required> Record metadata only, contributors must contact you to access data
                    </div>
                  </div>
                  <p>By checking this box I am confirming that I am providing a ReadMe file with my data (submit or contact)*</p>
                  <input type="checkbox" id="agree_terms" name="agree_terms" required>
                  <label for="agree_terms">I agree</label>

                  <input type="submit" name="submitMeta" value="Submit">
                </form>
              </div>

              <div class="upload-file" style="<?php echo $metaSubmitted?'display: initial;':'display: none;'; ?>">
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