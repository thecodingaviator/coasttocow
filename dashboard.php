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
                <h1>Dashboard</h1>
                <p>Dashboard content goes here.</p>
            </div>
        </div>
    </div>
</body>

</html>