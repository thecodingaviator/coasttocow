<?php include "utils/config.php";
//File:
//Authors: Gordon Doore, Parth Parth
//Last modified:
//Purpose:


/**
 *
 *
 *
 */

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
        <h1>Record Readme</h1>
        <div class="dataset-submission">
          <div class="enter-data">
            <div class="dataset-submission">
              <div class="enter-data" style="<?php echo $metaSubmitted ? 'display: none;' : ''; ?>">
                <form id="intake-form" action="" method="POST">
                  <h2>C3 Data Master Intake Form</h2>
                  <p><em>* Indicates required question</em></p>

                  <label for="email">Email *</label>
                  <input type="email" id="email" name="email" value="<?php echo $email ?>" required>

                  <label for="primary_last_name">Primary Contact Last Name *</label>
                  <input type="text" id="primary_last_name" name="primary_last_name" value="<?php echo $last_name ?>"
                    required>

                  <label for="primary_first_name">Primary Contact First Name *</label>
                  <input type="text" id="primary_first_name" name="primary_first_name" value="<?php echo $first_name ?>"
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

                  <label for="link_github_repo" class="repo">GitHub Repository Link </label>
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
                        <input type="radio" name="free_download" value=1 required> Submit data into the database for
                        sharing
                      </label>
                    </div>
                    <div>
                      <label>
                        <input type="radio" name="free_download" value=0 required> Record metadata only, contributors
                        must contact you to access data
                    </div>
                  </div>
                  <p>By checking this box I am confirming that I am providing a ReadMe file with my data (submit or
                    contact)*</p>
                  <input type="checkbox" id="agree_terms" name="agree_terms" required>
                  <label for="agree_terms">I agree</label>

                  <input type="submit" name="submitMeta" value="Submit">
                </form>
              </div>

              <div class="upload-file" style="<?php echo $metaSubmitted ? 'display: initial;' : 'display: none;'; ?>">
                <form id="upload_form" enctype="multipart/form-data" method = "POST">
                  <input type="file" id="file_input" name="file_input">
                  <div>
                    <label>
                      <input type="radio" name="folder_selection" value="research" > Confirm you wish to upload research data
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