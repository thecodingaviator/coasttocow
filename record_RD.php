<?php include "utils/config.php";

function fieldsToDataMasterSQL($conn){
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
  $agree_terms = $_POST['agree_terms'];
  $agree_terms = $agree_terms == 'on' ? 'Accepted' : 'Not Accepted';
  $keywords = $_POST['keywords'];
  $num_files_set = $_POST['num_files_set'];
  $file_ext = $_POST['file_ext'];
  $link_github_repo = $_POST['link_github_repo'];

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
    $_SESSION['agree_terms'] = $agree_terms;
    $_SESSION['email'] = $email;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['institution'] = $institution;
    // Save new variables as session variables
    $_SESSION['keywords'] = $keywords;
    $_SESSION['num_files_set'] = $num_files_set;
    $_SESSION['file_ext'] = $file_ext;
    $_SESSION['link_github_repo'] = $link_github_repo;
    $_SESSION['file_id'] = null;
    $_SESSION['file_link'] = null;

    $metaSubmitted = true;
    $error = fieldsToDataMasterSQL($conn);
    $_SESSION['update'][] = "Sucessfully Recorded Metadata. an email will be sent to you to confirm this submission";
    $_SESSION['update'][] = $error;
  }
  if (isset($_POST['free_download']) && $_POST['free_download'] == 'No' && $metaSubmitted) {
    header('Location: confirmation.php');
    exit();
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
                
                  <label class = type_label>Select file extension *</label>
                  <div class = "radio-filetype">
                    <div>
                      <input type="radio" id="pdf" name="file_ext" value=".pdf" required>
                      <label for="pdf">.pdf</label>
                    </div>
                    <div>
                      <input type="radio" id="csv" name="file_ext" value=".csv" required>
                      <label for="csv">.csv</label>
                    </div>
                    <div>
                      <input type="radio" id="docx" name="file_ext" value=".docx" required>
                      <label for="docx">.docx</label>
                    </div>
                    <div>
                      <input type="radio" id="xls" name="file_ext" value=".xls" required>
                      <label for="xls">.xls</label>
                    </div>
                  </div>

                  <label for="link_github_repo">GitHub Repository Link </label>
                  <input type="text" id="link_github_repo" name="link_github_repo">

                  <div>
                    <p>Is the data classified as Social Science data? *</p>
                    <div>
                      <label>
                        <input type="radio" name="social_science_data" value="Yes" required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="social_science_data" value="No" required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>Is the data classified as Natural Science and represents in vivo experiments? *</p>
                    <div>
                      <label>
                        <input type="radio" name="natural_science_in_vivo" value="Yes" required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="natural_science_in_vivo" value="No" required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>Is the data classified as Natural Science and represents in vitro experiments? *</p>
                    <div>
                      <label>
                        <input type="radio" name="natural_science_in_vitro" value="Yes" required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="natural_science_in_vitro" value="No" required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>Is this data Raw Dataset? *</p>
                    <div>
                      <label>
                        <input type="radio" name="raw_dataset" value="Yes" required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="raw_dataset" value="No" required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>Published Dataset? *</p>
                    <div>
                      <label>
                        <input type="radio" name="published_dataset" value="Yes" required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="published_dataset" value="No" required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>ReadMe? *</p>
                    <div>
                      <label>
                        <input type="radio" name="readme" value="Yes" required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="readme" value="No" required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>IRB? *</p>
                    <div>
                      <label>
                        <input type="radio" name="irb" value="Yes" required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="irb" value="No" required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>Data Dictionary? *</p>
                    <div>
                      <label>
                        <input type="radio" name="data_dictionary" value="Yes" required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="data_dictionary" value="No" required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>Dataset related to publication? *</p>
                    <div>
                      <label>
                        <input type="radio" name="dataset_publication" value="Yes" required> Yes
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="dataset_publication" value="No" required> No
                      </label>
                    </div>
                  </div>

                  <div>
                    <p>Do you want to make a submit your data to the database or make a record of your data? *</p>
                    <div>
                      <label>
                        <input type="radio" name="free_download" value="Yes" required> Submit (Open Download to C3 Contributors)
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="free_download" value="No" required> Record (Contributors must contact you to access data)
                      </label>
                    </div>
                  </div>

                  <p>Legal Text</p>

                  <input type="checkbox" id="agree_terms" name="agree_terms" required>
                  <label for="agree_terms">By checking the box, you are agreeing to the text above in full *</label>

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