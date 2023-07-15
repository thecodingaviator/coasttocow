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