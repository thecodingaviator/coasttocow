<?php
include "utils/config.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C3 | Record</title>

  <link rel="stylesheet" href="utils/css/dashboard-common.css">
  <link rel="stylesheet" href="utils/css/explore_dash.css">
</head>

<body>
  <div class="wrapper-background">
    <p> </p>
  </div>
  <div class="wrapper">
    <?php include "navbar.php"; ?>
    <div class="content-wrapper">
      <div class="content">
        <div class="scrollable-content">
          <h1>Record</h1>
          <p>Make a record of your data and optionally to upload for C3 contributors to access.  If you have DariyOne PDFs to upload, click DairyOne Data.  If you would like to make a record or upload other data, click C3 Research Data and fill out the record form.</p>
          <div class="button-grid-2">
            <div class="dash-button">
              <a href="record_DO.php"><i><img src="utils/icons/dairyOne_logo.png" alt="DairyOne Icon"></i>DairyOne
                Data</a>
            </div>
            <div class="dash-button">
              <a href="record_RD.php"><i><img src="utils/icons/magnifying_glass.svg " alt="Explore Icon"></i>C3 Research
                Data</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>