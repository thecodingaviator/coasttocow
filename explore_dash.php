<?php
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
          <p>Use the explore page to view and download available data within the Coast to Cow to Consumer Grant. Click DairyOne Data to explore available data from DairyOne trials. Click C3 Research Data to explore all other data related to the project. </p>
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
              <canvas id="myChart"></canvas>
            </div>
            <!-- <div class="chart-container">
              <header>
                <h2>Chart 2</h2>
              </header>
              <canvas id="chart2"></canvas>
            </div>
            <div class="chart-container">
              <header>
                <h2>Chart 3</h2>
              </header>
              <canvas id="chart3"></canvas>
            </div>
            <div class="chart-container">
              <header>
                <h2>Chart 4</h2>
              </header>
              <canvas id="chart4"></canvas>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Create a new chart using Chart.js library
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
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
        legend: {
          labels: {
            generateLabels: function (chart) {
              var data = chart.data;
              if (data.labels.length && data.datasets.length) {
                return data.labels.map(function (label, i) {
                  var meta = chart.getDatasetMeta(0);
                  var ds = data.datasets[0];
                  var arc = meta.data[i];
                  var customLabel = label + ' (' + ds.data[i] + ')';
                  var arcOpts = chart.options.elements.arc;
                  var fill = Chart.helpers.getValueAtIndexOrDefault;

                  var arcBackgroundColor = fill(arc.custom && arc.custom.backgroundColor, arcOpts.backgroundColor, i, data.length);
                  var arcBorderColor = fill(arc.custom && arc.custom.borderColor, arcOpts.borderColor, i, data.length);
                  var borderWidth = fill(arc.custom && arc.custom.borderWidth, arcOpts.borderWidth, i, data.length);

                  return {
                    text: customLabel,
                    fillStyle: arcBackgroundColor,
                    strokeStyle: arcBorderColor,
                    lineWidth: borderWidth,
                    hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
                    index: i
                  };
                });
              }
              return [];
            }
          }
        }
      }
    });
  </script>
</body>

</html>
