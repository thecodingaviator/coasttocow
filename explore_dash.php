<?php
include "utils/config.php";

// Retrieve data from MySQL database
$query = "SELECT Components, AVG(AsFed) AS AverageAsFed, AVG(DM) AS AverageDM FROM C3AnalysisTMR GROUP BY Components";
$stmt = $conn->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <div class="button-grid-2">
                        <div class="dash-button">
                            <a href="explore.php"><i><img src="utils/icons/dairyOne_logo.png" alt="DairyOne Icon"></i>DairyOne Data</a>
                        </div>
                        <div class="dash-button">
                            <a href="other_data.php"><i><img src="utils/icons/magnifying_glass.svg " alt="Explore Icon"></i>C3 Research Data</a>
                        </div>
                    </div>
                    <div class="new-section">
                        <header>
                            <h2>Contextual Information</h2>
                        </header>
                        <p>This section provides context for the chart.</p>
                    </div>
                    <div class="chart-container">
                        <header>
                            <h2>Average DairyOne AsFed and DM by Component Type From AnalysisTMR</h2>
                        </header>
                        <canvas id="myChart"></canvas>
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
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($data, 'Components')); ?>,
                datasets: [{
                    label: 'Average AsFed',
                    data: <?php echo json_encode(array_column($data, 'AverageAsFed')); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Average DM',
                    data: <?php echo json_encode(array_column($data, 'AverageDM')); ?>,
                    backgroundColor: 'rgba(38, 70, 156, 0.2)',
                    borderColor: 'rgba(38, 70, 156, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                // Customizethe chart options as per your requirement
            }
        });
    </script>
</body>

</html>
