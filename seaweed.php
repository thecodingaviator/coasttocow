<?php
// File: seaweed.php
// Authors: Gordon Doore, Parth Parth
// Last modified: 07/24/2023
// Purpose: Page for seaweed ID tracking
include "utils/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C3 | Seaweed ID</title>

  <link rel="stylesheet" href="utils/css/dashboard-common.css">
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
        <div class="scrollable-content">
          <h1>Seaweed ID</h1>
          <p>This page is still under construction... 👷🏻‍♂️</p>
        </div>
      </div>
    </div>
  </div>
</body>

</html>