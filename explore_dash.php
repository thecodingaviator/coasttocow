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
                            <a href="explore.php"><i><img src="utils/icons/dairyOne_logo.png" alt="DairyOne Icon"></i>Explore DairyOne Data</a>
                        </div>
                        <div class="dash-button">
                            <a href="other_data.php"><i><img src="utils/icons/magnifying_glass.svg " alt="Explore Icon"></i>Placeholder</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
