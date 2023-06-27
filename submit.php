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


  <script type="text/javascript">
    // Update the following constants with your service account information
    const SERVICE_ACCOUNT_EMAIL = '<?php echo $service_email; ?>';
    const KEY_FILE_PATH = '<?php echo $service_keyfile; ?>';

    let gapiInited = false;

    document.getElementById('file_input').addEventListener('change', handleFileSelection);

    /**
     * Handle file selection.
     */
    function handleFileSelection() {
      const fileInput = document.getElementById('file_input');
      const file = fileInput.files[0];
      if (file) {
        handleFileUpload(file);
      }
    }

    /**
     * Upload file to Drive.
     */
    async function uploadFile(file, folderId) {
      const formData = new FormData();
      formData.append('file', file);

      const response = await fetch(`/upload-file.php?folderId=${folderId}`, {
        method: 'POST',
        body: formData,
      });

      const data = await response.json();
      if (data.success) {
        console.log('File uploaded successfully. File ID:', data.fileId);
      } else {
        console.error('Error uploading file:', data.error);
      }
    }

    /**
     * Handle file upload.
     */
    function handleFileUpload() {
      const folderSelection = document.querySelector('input[name="folder_selection"]:checked');
      let folderId;

      if (folderSelection) {
        const value = folderSelection.value;
        if (value === 'analysis') {
          folderId = '<?php echo $analysis_folder_id; ?>';
        } else if (value === 'macro') {
          folderId = '<?php echo $macro_folder_id; ?>';
        } else if (value === 'fatty_acids') {
          folderId = '<?php echo $fatty_acids_folder_id; ?>';
        }
      }

      if (!folderId) {
        console.error('Please select a folder.');
        return;
      }

      const fileInput = document.getElementById('file_input');
      const file = fileInput.files[0];
      if (file) {
        uploadFile(file, folderId);
      }
    }
  </script>
</body>

</html>
