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
        <h1>Readme Form</h1>
        <div class="dataset-submission">
          <div class="enter-data">
            <form id="readme-form" action="" method="POST">
              <h2>Readme Dataset Submission Form</h2>
              <p><em>* Indicates required question</em></p>

              <!-- General Information -->
              <label for="creation_date">Creation Date (mm-yyyy) *</label>
              <input type="month" id="creation_date" name="creation_date" required>

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
              <!-- Doesn't work correctly yet -->
              <label for="primary_contact">Primary Contact Name and Email *</label>
              <div id="primary_contact_container">
                <label for="author1">Author 1:</label>
                <input type="text" id="primary_contact" class="primary_contact" name="primary_contact" required>
              </div>
              <button type="button" id="add-author-btn">Add Another Author</button>

              <!-- Title/Sub-title -->
              <label for="title">Title/Sub-title *</label>
              <input type="text" id="title" name="title" required>

              <!-- Creators/Authors and Institutions -->
              <label for="creators">Creators/Authors Institutions *</label>
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
                <input type="checkbox" id="wolfesNeckCenter" name="creators" value="Wolfe’s Neck Center"> Wolfe’s Neck
                Center
              </label><br>

              <!-- Acknowledgements -->
              <label for="acknowledgements">Acknowledgements</label>
              <textarea id="acknowledgements" name="acknowledgements" rows="4" required></textarea>


              <!-- Data Usage Agreement -->
              <label for="data_usage_agreement">Data Usage Agreement *</label>
              <textarea id="data_usage_agreement" name="data_usage_agreement" rows="4" required></textarea>

              <!-- Associated Keywords -->
              <label for="keywords">Associated Keywords *</label>
              <input type="text" id="keywords" name="keywords" required>

              <!-- Licensed Data -->
              <label for="licensed_data">Licensed Data (Y/N) *</label>
              <select id="licensed_data" name="licensed_data" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>

              <!-- Methodological Information -->
              <!-- <label for="methodology">Methodological Information *</label>
              <textarea id="methodology" name="methodology" rows="6" required></textarea> -->

              <!-- Data and File(s) Overview -->
              <label for="data_overview">Data and File(s) Overview *</label>
              <textarea id="data_overview" name="data_overview" rows="6" required></textarea>

              <!-- Sharing and Access Information -->
              <label for="sharing_access_info">Sharing and Access Information</label>
              <textarea id="sharing_access_info" name="sharing_access_info" rows="4"></textarea>

              <!-- Links to Publications -->
              <label for="publications_links">Links to Publications That Cite or Use the Data</label>
              <input type="text" id="publications_links" name="publications_links">

              <!-- IRB and Other Compliance -->
              <label for="irb_compliance">IRB Compliance (Y/N)</label>
              <select id="irb_compliance" name="irb_compliance">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>

              <!-- Dataset Change Log -->
              <label for="change_log">Dataset Change Log</label>
              <textarea id="change_log" name="change_log" rows="4"></textarea>

              <!-- Data and File Overview -->
              <label for="data_file_overview">Data and File Overview</label>
              <textarea id="data_file_overview" name="data_file_overview" rows="6"></textarea>

              <!-- File Names and Formats -->
              <label for="file_names_formats">File Names and Formats</label>
              <input type="text" id="file_names_formats" name="file_names_formats">

              <!-- Methodological Information -->
               <!--THIS NEEDS TO BE eXPANDED TO more FIELDS. -->
              <label for="methodological_info">Methodological Information</label>
              <textarea id="methodological_info" name="methodological_info" rows="6"></textarea>
              <!--  INclude: tech for creation  -->
              <!-- sample_collection_procedure -->
              <!-- environmental or experimental conditions for collection -->
              <!-- other info about how data was collected or obtained -->
              <!-- cleaned data? -->
              <!-- description on how data was cleaned / prepared for submission-->
              <!-- QA procedures -->
              <!-- key analytical methods -->
              <!-- key softwares -->
              <!-- key software addresses (where is software from) -->
              <!-- other software information -->
              <!-- dataset_change log -->
          

              <!-- File Information -->
              <!-- file names -->
              <!-- nameing conventions -->
              <!-- file_creation_date -->
              <!-- file_description -->
              <!-- units of measurement -->
              <!-- abbreviations used -->
              <!-- description of abbreviations used -->
              <!-- variables description -->
              <!-- dependencies to use data -->
              <!-- other_information -->

              <!-- Additional Information -->
              <label for="additional_info">Additional Information</label>
              <textarea id="additional_info" name="additional_info" rows="4"></textarea>

              <input type="submit" name="submitReadme" value="Submit">
          </div>
        </div>
      </div>
      <script src="utils/js/readme.js"></script>
</body>

</html>