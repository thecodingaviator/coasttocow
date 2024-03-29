<?php
// File: explore_dash.php
// Authors: Gordon Doore, Parth Parth
// Purpose: Dashboard for exploring the data in the database
// Last modified: 07/24/2023

include "utils/config.php";

// Retrieve the number of entries in each table
$tables = [
    'C3AnalysisDryAE',
    'C3AnalysisGrain',
    'C3AnalysisManure',
    'C3AnalysisOther',
    'C3AnalysisTMR',
    'C3AnalysisUnrecognized',
    'C3Macro',
    'C3TFA'
];

$data = [];
foreach ($tables as $table) {
    $query = "SELECT COUNT(*) AS Count FROM $table";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $result['Count'];

    // Remove the "C3" and "C3Analysis" prefixes from the table names
    $tableName = str_replace(['C3', 'Analysis'], '', $table);

    $data[] = [
        'table' => $tableName,
        'count' => $count
    ];
}

// Prepare the data for the chart
$labels = array_column($data, 'table');
$count = array_column($data, 'count');
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C3 | Explore</title>

  <link rel="stylesheet" href="utils/css/dashboard-common.css">
  <link rel="stylesheet" href="utils/css/explore_dash.css">
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
          <h1>Explore</h1>
          <p>Explore the data that has been uploaded to the C3 database.  If you would like to access available DairyOne Data, click DairyOne Data. If you would like to access any other available data, click C3 Research Data.</p>
          <div class="button-grid-2">
            <div class="dash-button">
              <a href="explore_DO.php"><i><img src="utils/icons/dairyOne_logo.png" alt="DairyOne Icon"></i>DairyOne
                Data</a>
            </div>
            <div class="dash-button">
              <a href="explore_RD.php"><i><img src="utils/icons/magnifying_glass.svg " alt="Explore Icon"></i>C3
                Research Data</a>
            </div>
          </div>
          <div class="grid-container">
            <div class="chart-container">
              <header>
                <h2>Database Entry Breakdown</h2>
                <p>Number of entries in each table</p>
              </header>
              <canvas id="myBarChart" width="400" height="300"></canvas>
            </div>
            <!-- <div class="chart-container">
              <header>
                <h2>Second Chart Title</h2>
                <p>Second Chart Description</p>
              </header>
              <canvas id="mySecondChart" width="400" height="300"></canvas>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Create a new chart using Chart.js library
    var ctx = document.getElementById('myBarChart').getContext('2d');
    var chart = new Chart(ctx, {
      type: 'bar', // Change chart type to 'bar'
      data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
          label: 'Number of entries',
          data: <?php echo json_encode($count); ?>,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(233, 30, 99, 0.2)',
            'rgba(33, 150, 243, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(233, 30, 99, 1)',
            'rgba(33, 150, 243, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Number of entries'
            }
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });

    // Create a new chart for the second chart
    var ctx2 = document.getElementById('mySecondChart').getContext('2d');
    var chart2 = new Chart(ctx2, {
      type: 'bar', // Change chart type to 'bar' for the second chart
      data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
          label: 'Number of entries',
          data: <?php echo json_encode($count); ?>, // Replace with data for the second chart
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(233, 30, 99, 0.2)',
            'rgba(33, 150, 243, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(233, 30, 99, 1)',
            'rgba(33, 150, 243, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Number of entries'
            }
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });

</script>

</body>

</html>
