<?php
include "utils/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C3 | Explore</title>

  <link rel="stylesheet" href="utils/css/dashboard-common.css">
  <link rel="stylesheet" href="utils/css/explore.css">
  <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>
</head>

<body>
  <div class="error-div">
    <p id="error-message">
    </p>
  </div>
  <div class="wrapper-background">
    <p> </p>
  </div>
  <div class="wrapper">
    <div id="downloadModal" class="modal">
      <div class="modal-content">
        <p>Data Disclaimer: I agree to use this data responsibly crediting all C3 team members who have generated it, and will cite USDA AFRI Sustainable Agriculture Systems Program as a funding source in any publication that utilizes this data set. I will seriously consider including data generators as authors on any manuscripts to be developed.</p>
        <button id="confirmDownload">Confirm Download</button>
        <button id="exitModal">X</button>
      </div>
    </div>

    <?php include "navbar.php"; ?>
    <div class="content-wrapper">
      <div class="content">
        <div class="scrollable-content">
          <div class="sticky-top">
            <div class="dashboard-top">
              <h1>DairyOne Explorer</h1>
              <p class="results-container"></p>
            </div>
            <form action="" id="searchForm" method="POST">
              <div class="search-div">
                <select name="search_table" id="search_table" required>
                  <option value="C3DataMasterTest">DataMasterTest</option>
                </select>
                <input type="submit" name="submit" value="Search">
                <button type="button" name="download" id="download-csv">Download CSV</button>
                <br>
              </div>
            </form>
          </div>
          <p>The purpose of the data master is to provide a comprehensive listing of datasets generated from C3 research. Some of these datasets can be downloaded from the C3 Database, while others can only be accessed by contacting the primary researcher.</p>
          <div id="my-grid" class="ag-theme-alpine" style="display: none;"></div>
        </div>
      </div>
    </div>
  </div>

  <script src="utils/js/explore.js"></script>
</body>

</html>