<?php include "utils/config.php";
//File: readme.php
//Authors: Gordon Doore, Parth Parth
//Last modified: 11/28/2023
//Purpose: Readme form for submitting data to SQL db

/**
 * Inserts a new record into the `C3ReadMeAT` table in the database using the data from a form submission.
 *
 * @param MySQLi $conn The MySQLi connection object to the database.
 * @param array $post_data The array of form data to be inserted into the database.
 * @param string $user_id The user's id.
 * @return string $error The error message, if any error occurred while inserting the data into the database. Empty if no errors occurred.
 *
 * @throws PDOException If there is an error executing the SQL statement.
 */
function fieldsToReadMeATSQL($conn, $post_data, $user_id)
{
  $error = "";
  // Retrieve variables from session
  $title = $post_data['title'];
  $acknowledgements = $post_data['acknowledgements'];
  $data_usage_agreement = $post_data['data_usage_agreement'];
  $keywords = $post_data['keywords'];
  $licensed_data = $post_data['licensed_data'];
  $data_overview = $post_data['data_overview'];
  // $sharing_access_info = $post_data['sharing_access_info'];
  $publications_links = $post_data['publications_links'];
  $iacuc_compliance = $post_data['iacuc_compliance'];
  $data_links = $post_data['data_links'];
  $ancillary_relationships = $post_data['ancillary_relationships'];
  $github_link = $post_data['github_link'];
  $num_files = $post_data['num_files'];
  $creation_date = $post_data['creation_date'];
  $change_log = $post_data['change_log'];
  $tech_for_creation = $post_data['tech_for_creation'];
  $sample_collection_procedure = $post_data['sample_collection_procedure'];
  $collection_conditions = $post_data['collection_conditions'];
  $other_collection = $post_data['other_collection'];
  // $cleaned_data = $post_data['cleaned_data'];
  $cleaning_methods = $post_data['cleaning_methods'];
  $qa_procedures = $post_data['qa_procedures'];
  $key_analytic_methods = $post_data['key_analytic_methods'];
  $key_softwares = $post_data['key_softwares'];
  $key_software_address = $post_data['key_software_address'];
  $other_software_info = $post_data['other_software_info'];
  $naming_conventions = $post_data['naming_conventions'];
  $abbreviations_used = $post_data['abbreviations_used'];
  $variables_used = $post_data['variables_used'];
  $dependencies = $post_data['dependencies'];
  $additional_info = $post_data['additional_info'];
  $subcommittee = $post_data['subcommittee'];
  $primary_contact = $post_data['primary_contact'];
  $primary_email = $post_data['primary_contact_email'];
  $secondary_contact = $post_data['secondary_contact'];
  $secondary_email = $post_data['secondary_contact_email'];
  $other_contact = $post_data['other_contact'];
  $other_email = $post_data['other_contact_email'];
  $creators = $post_data['creators'];
  $file_desc = $post_data['file_desc'];
  $use_agreement = $post_data['use_agreement'];
  $use_agreement_link = $post_data['use_agreement_link'];

  //prepare query
  $sql = "INSERT INTO `C3ReadMeAT` (`creation_date`,`subcommittee`,`primary_contact`,`primary_email`,`secondary_contact`,`secondary_email`,
  `other_contact`,`other_email`,`title_subtitle`,`institution`,
  `acknow`,`data_usage_agreement`,`keywords`,`licensed_data`,`iacuc`,`alternate_available_link`,`ancillary_link`,
  `publication_link`,`external_use_agreement`,`external_use_agreement_source`,`github_link`,`technology_for_creation`,`sample_collection_procedure`,`conditions_collection`,
  `data_collection_other`,`cleaning_desc`,`qa_procedures`,`key_analytical_methods`,`key_softwares`,`key_software_address`,
  `other_software_information`,`dataset_change_log`,`num_files_readme`,`naming_conventions`,`file_description`,
  `abbreviations_definition`,`variables_description`,`dependencies`,`other_information`) 
  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
  $stmt = $conn->prepare($sql);

  try {
    $stmt->execute([
      //variables
      $creation_date,
      $subcommittee,
      $primary_contact,
      $primary_email,
      $secondary_contact,
      $secondary_email,
      $other_contact,
      $other_email,
      $title,
      $creators,
      $acknowledgements,
      $data_usage_agreement,
      $keywords,
      $licensed_data,
      $iacuc_compliance,
      $data_links,
      $ancillary_relationships,
      $publications_links,
      $use_agreement,
      $use_agreement_link,
      $github_link,
      $tech_for_creation,
      $sample_collection_procedure,
      $collection_conditions,
      $other_collection,
      $cleaning_methods,
      $qa_procedures,
      $key_analytic_methods,
      $key_softwares,
      $key_software_address,
      $other_software_info,
      $change_log,
      $num_files,
      $naming_conventions,
      $file_desc,
      $abbreviations_used,
      $variables_used,
      $dependencies,
      $additional_info
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
$metaSubmitted= false;

$user_id = $_SESSION['user_id'];
$U_Id = substr($user_id, 2);

$sql = "SELECT * FROM C3SignUp WHERE U_Id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$U_Id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
  $email = $user['Email'];
  $_SESSION['email'] = $email;
  $last_name = $user['LastName'];
  $first_name = $user['FirstName'];
}

if (isset($_POST['submitReadme'])) {
  // Call your PHP function here
  fieldsToReadMeATSQL($conn, $_POST, $user_id);
  $metaSubmitted = true;
  $_SESSION['update'][] = "Sucessfully Recorded Metadata. An email will be sent to you to confirm this submission";
  $_SESSION['update'][] = $error;
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
  <title>C3 | Readme</title>

  <link rel="stylesheet" href="utils/css/dashboard-common.css">
  <link rel="stylesheet" href="utils/css/readme.css">
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
    <?php include "loader.php"; ?>
    <?php include "navbar.php"; ?>
    <div class="content-wrapper">
      <div class="content">
        <h1>Readme Form</h1>
        <div class="dataset-submission" style="<?php echo $metaSubmitted ? 'display: none;' : ''; ?>">
          <div class="enter-data">
            <form id="readme-form" action="" method="POST">
              <p><em>* Indicates a required question</em></p>
              <!-- General Information -->
              <label for="creation_date">Creation Date (mm-dd-yyyy) *</label>
              <input type="date" id="creation_date" name="creation_date" value="<?php echo date("Y-m-d") ?>" required>

              <!-- Subcommittee(s) -->
              <label for="subcommittee">C3 Subcommittee(s) *</label>
              <select id="subcommittee" name="subcommittee" required>
                <option value="Algal Characteristics">Algal Characteristics</option>
                <option value="Milk Yield/Quality & Animal Wellness">Milk Yield/Quality & Animal Wellness</option>
                <option value="Natural Resources">Natural Resources</option>
                <option value="Social/Environmental Implications">Social/Environmental Implications</option>
                <option value="Life Cycle Assessment">Life Cycle Assessment</option>
                <option value="Extension & Education">Extension & Education</option>
                <option value="Database">Database</option>
              </select>

              <!-- Primary Contact -->
              <div id="contacts">
                <div class="contact">
                  <label for="primary_contact">Primary Contact Name and Email *</label>
                  <input type="text" id="primary_contact" name="primary_contact[]" required>
                  <input type="text" id="primary_contact_email" name="primary_contact_email[]" required>
                </div>
              </div>

              <button id="add_contact">Add another contact</button>

              <label for="data_sect">Data Subgroup (Impacts the Questions Asked Later)</label>
                    <!-- select one of our three different data Subgroups from dropdown-->
                    <select id="data_sect" name="data_sect" required>
                        <option value = "" disabled selected>Select a Data Subgroup</option>
                        <option value="animalTrials">Animal Trials</option>
                        <option value="socialScience">Social Science</option>
                        <option value="other">Other</option>
                    </select>

              <!-- Base your readme on an existing table: -->
              <label for="selected_title">Base your readme on an existing table:</label>
              <select id="selected_title" name="selected_title">
                <option value="None">None</option>
                <?php
                $sql = "SELECT title_subtitle FROM C3ReadMeAT";
                $result = $conn->query($sql);

                if ($result) {
                  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row["title_subtitle"] . "'>" . $row["title_subtitle"] . "</option>";
                  }
                }
                ?>
                <input type="button" id="fill_from_title" value="Fill">

                <!-- Title/Sub-title FOR SOME REASON THIS DOESN'T SHOW UP-->
                <label for="title">Title/Subtitle *</label>
                <input type="text" id="title" name="title" required>

                <!-- Creators -->
                <div id="creators_container">

                  <label for="creators">Creators/Author *</label>
                  <input type="text" id="creators" name="creators" required>

                  <!-- Author ORCIDs -->
                  <label for="creators">Creators/Author ORCID</label>
                  <input type="text" id="orcids" name="orcids">
                
                </div>

                <button id="add_creator">Add Another Creator/Author</button>

                <!-- Creators/Authors and Institutions -->
                <label for="creators">Creators/Authors Institutions (check all that apply) *</label>
                <label for="colbyCollege">
                  <input type="checkbox" id="colbyCollege" name="creators" value="Colby College"> Colby College
                </label><br>

                <label for="bigelowLaboratory">
                  <input type="checkbox" id="bigelowLaboratory" name="creators"
                    value="Bigelow Laboratory for Ocean Sciences"> Bigelow Laboratory for Ocean Sciences
                </label><br>

                <label for="universityOfVermont">
                  <input type="checkbox" id="universityOfVermont" name="creators" value="University of Vermont">
                  University of Vermont
                </label><br>

                <label for="universityOfNewHampshire">
                  <input type="checkbox" id="universityOfNewHampshire" name="creators"
                    value="University of New Hampshire"> University of New Hampshire
                </label><br>

                <label for="clarksonUniversity">
                  <input type="checkbox" id="clarksonUniversity" name="creators" value="Clarkson University"> Clarkson
                  University
                </label><br>

                <label for="syracuseUniversity">
                  <input type="checkbox" id="syracuseUniversity" name="creators" value="Syracuse University"> Syracuse
                  University
                </label><br>

                <label for="williamHMinerInstitute">
                  <input type="checkbox" id="williamHMinerInstitute" name="creators" value="William H. Miner Institute">
                  William H. Miner Institute
                </label><br>

                <label for="cornellCooperativeExtension">
                  <input type="checkbox" id="cornellCooperativeExtension" name="creators"
                    value="Cornell Cooperative Extension"> Cornell Cooperative Extension
                </label><br>

                <label for="wolfesNeckCenter">
                  <input type="checkbox" id="wolfesNeckCenter" name="creators" value="Wolfe's Neck Center"> Wolfe's Neck
                  Center
                </label><br>
                    
                <!-- Acknowledgements -->
                <label for="acknowledgements">Acknowledgements  (Funding and People)</label>
                <textarea id="acknowledgements" name="acknowledgements" rows="4" required></textarea>
                
                <div class = "variable questions" id = "variable_questions">
                    
                </div>

                <input type="submit" name="submitReadme" value="Submit">
              </form>
           </div>
        </div>
        <div class="upload-file" style="<?php echo $metaSubmitted ? 'display: initial;' : 'display: none;'; ?>">
          <form id="upload_form" enctype="multipart/form-data" method = "POST">
                <input type="file" id="file_input" name="file_input">
                <div>
                  <label>
                    <input type="radio" name="folder_selection" value="research" required > Confirm you wish to upload research data
                  </label>
                </div>
                <input type="button" value="Upload" onclick="handleFileUpload()">
              </form>
         </div>
      </div>
    </div>
  </div>
      <script src="utils/js/readme.js"></script>
      <script>
        // event listener for when 'data_sect' dropdown is changed
        document.getElementById("data_sect").addEventListener("change", function() {
            // get the input value from the dropdown
            var inputElementId = "data_sect";
            // get the id of the variable questions div
            var variableQuestionsId = "variable_questions";
            //call questionSets and handle the returned Promise
            questionSets().then(questionSet => {
                //call updateQuestionsBasedOnInput
                updateQuestionsBasedOnInput(variableQuestionsId, questionSet);
            }).catch(error => console.error('Error:', error));
        });
      </script>
      <script src="utils/js/submit.js"></script>
    </body>
</html>