<?php
include "utils/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C3 | Templates</title>

  <link rel="stylesheet" href="css/dashboard-common.css">
  <link rel="stylesheet" href="css/templates.css">
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
        <h1>Templates</h1>
        <div class="card-container">
          <div class="card">
            <div class="card-content">
              <a href="pdfs/sample1.pdf" download>
                <img src="images/pdf-icon.png" alt="PDF Icon">
                <p>Template 1</p>
              </a>
            </div>
          </div>
          <div class="card">
            <div class="card-content">
              <a href="pdfs/sample2.pdf" download>
                <img src="images/pdf-icon.png" alt="PDF Icon">
                <p>Template 2</p>
              </a>
            </div>
          </div>
          <!-- Add more cards for other templates -->
        </div>
      </div>
    </div>
  </div>
</body>

</html>
