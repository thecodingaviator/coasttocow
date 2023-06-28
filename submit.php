<?php include "utils/config.php"; ?>

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
          <div class="enter-data">

          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="utils/js/submit.js"></script>
</body>

</html>
