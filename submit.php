<?php
include "config.php";

if (isset($_POST['submit'])) {

  $datasetName = $_POST['dataset_name'];
  $datasetDescription = $_POST['dataset_description'];
  $contactEmail = $_POST['contact_email'];
  $contactFirstName = $_POST['contact_first_name'];
  $contactLastName = $_POST['contact_last_name'];
  $institution = $_POST['institution'];
  $databaseLocation = $_POST['database_location'];
  $githubLocation = $_POST['github_location'];
  $otherLocation = $_POST['other_location'];
  $irb = isset($_POST['irb']) ? 1 : 0;
  $readme = $_POST['readme'];
  $dataDictionary = $_POST['data_dictionary'];
  $notes = $_POST['notes'];

  $sql = "INSERT INTO `C3DataMaster`(`dataset_name_short`, `dataset_description`, `dataset_primary_contact_email`, 
            `dataset_primary_contact_first_name`, `dataset_primary_contact_last_name`, `dataset_institution`, 
            `dataset_location_database`, `dataset_location_github`, `dataset_location_other`, `dataset_IRB`, 
            `dataset_README`, `datset_data_dictionary`, `dataset_notes`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);
  $result = $stmt->execute([
    $datasetName,
    $datasetDescription,
    $contactEmail,
    $contactFirstName,
    $contactLastName,
    $institution,
    $databaseLocation,
    $githubLocation,
    $otherLocation,
    $irb,
    $readme,
    $dataDictionary,
    $notes
  ]);

  if ($result) {
    header("Location: submit.php");
  } else {
    $error = '<p>Error submitting the dataset. Please try again.</p>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C3 | Submit</title>

  <link rel="stylesheet" href="css/dashboard-common.css">
  <link rel="stylesheet" href="css/submit.css">
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
        <form action="" method="POST">
          <div class="parent">
            <div class="div-1">
              <label for="dataset_name"></label>
              <input type="text" id="dataset_name" name="dataset_name" required placeholder="Dataset name"><br>
            </div>

            <div class="div-2">
              <label for="dataset_description"></label>
              <textarea id="dataset_description" name="dataset_description" required
                placeholder="Dataset description"></textarea><br>
            </div>

            <div class="div-3">
              <label for="contact_email"></label>
              <input type="email" id="contact_email" name="contact_email" required
                placeholder="Primary contact email"><br>
            </div>

            <div class="div-4">
              <label for="contact_first_name"></label>
              <input type="text" id="contact_first_name" name="contact_first_name" required
                placeholder="Primary contact first name"><br>
            </div>

            <div class="div-5">
              <label for="contact_last_name"></label>
              <input type="text" id="contact_last_name" name="contact_last_name" required
                placeholder="Primary contact last name"><br>
            </div>

            <div class="div-6">
              <label for="institution"></label>
              <input type="text" id="institution" name="institution" required placeholder="Institution"><br>
            </div>

            <div class="div-7">
              <label for="irb">IRB:</label>&ensp;
              <input type="checkbox" id="irb" name="irb"><br>
            </div>

            <div class="div-8">
            <label for="database_location"></label>
              <input type="text" id="database_location" name="database_location" required
                placeholder="Database location"><br>
            </div>

            <div class="div-9">
              <label for="other_location"></label>
              <input type="text" id="other_location" name="other_location" placeholder="Other location"><br>
            </div>

            <div class="div-10">
            <label for="github_location"></label>
              <input type="text" id="github_location" name="github_location" placeholder="GitHub location"><br>
            </div>

            <div class="div-11">
              <label for="readme"></label>
              <input type="text" id="readme" name="readme" placeholder="README location"><br>
            </div>

            <div class="div-12">
              <textarea type="text" name="data_dictionary" placeholder="Data dictionary"></textarea><br>
            </div>

            <div class="div-13">
              <label for="notes"></label>
              <textarea id="notes" name="notes" placeholder="Notes"></textarea><br>
            </div>

            <div class="div-14">
              <input type="submit" name="submit" value="Submit Dataset">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>