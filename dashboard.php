<?php
include "utils/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C3 | Dashboard</title>

    <link rel="stylesheet" href="css/dashboard-common.css">
    <link rel="stylesheet" href="css/dashboard.css">
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
                    <h1>Dashboard</h1>
                    <div class="button-grid-4">
                        <div class="dash-button">
                            <a href="templates.php"><i><img src="utils/icons/file_lines.svg" alt="Template Icon"></i>Templates</a>
                        </div>
                        <div class="dash-button">
                            <a href="explore.php"><i><img src="utils/icons/magnifying_glass.svg" alt="Explore Icon"></i>Explore</a>
                        </div>
                        <div class="dash-button">
                            <a href="submit.php"><i><img src="utils/icons/paste.svg" alt="Submit Icon"></i>Submit</a>
                        </div>
                        <div class="dash-button">
                            <a href="modify.php"><i><img src="utils/icons/gear.svg" alt="Gear Icon"></i>Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>