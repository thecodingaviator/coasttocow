<?php include "utils/config.php";

session_start();

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
  <link rel="stylesheet" href="utils/css/submit.css">
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
        <h1>Submit a Dataset</h1>
        <div class="dataset-submission">
          <div class="enter-data">
            <div class="dataset-submission">
              <div class="enter-data">
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
                    <p>Readme? *</p>
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

                  <label for="link_data_set">Link to Data Set</label>
                  <input type="text" id="link_data_set" name="link_data_set">

                  <label for="link_readme">Link to README</label>
                  <input type="text" id="link_readme" name="link_readme">

                  <label for="link_github">Link to GitHub</label>
                  <input type="text" id="link_github" name="link_github">

                  <label for="link_data_dictionary">Link to Data Dictionary</label>
                  <input type="text" id="link_data_dictionary" name="link_data_dictionary">

                  <p>Legal Text</p>

                  <input type="checkbox" id="agree_terms" name="agree_terms" required>
                  <label for="agree_terms">By checking the box, you are agreeing to the text above in full *</label>

                  <input type="submit" name="submitMeta" value="Submit">
                </form>
              </div>

              <div class="upload-file">
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