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
  $_SESSION['email'] = $email;
  $last_name = $user['LastName'];
  $first_name = $user['FirstName'];
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
    <?php include "loader.php"; ?>
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
                  <input type="button" name = 'file_attach' value="Upload" onclick="handleFileUpload()">
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