<?php
include "config.php";

$error = "";
$num_results = "";

if (isset($_POST['submit'])) {
    $searchField = $_POST['search_field'];
    $searchValue = $_POST['search_value'];

    $sql = "SELECT * FROM C3DataMaster WHERE $searchField = :search_value";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':search_value', $searchValue);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $num_results = "<div class='results-container'><p>" . count($result) . " result(s) found</p></div>";

    if ($result) {
        $tableOutput = "<table>";
        $tableOutput .= "<tr><th>Dataset Name</th><th>Description</th><th>Contact Email</th><th>Contact First Name</th><th>Contact Last Name</th><th>Institution</th><th>Database Location</th><th>GitHub Location</th><th>Other Location</th><th>IRB</th><th>README</th><th>Data Dictionary</th><th>Notes</th></tr>";

        foreach ($result as $row) {
            $tableOutput .= "<tr>";
            $tableOutput .= "<td>" . $row['dataset_name_short'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_description'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_primary_contact_email'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_primary_contact_first_name'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_primary_contact_last_name'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_institution'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_location_database'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_location_github'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_location_other'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_IRB'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_README'] . "</td>";
            $tableOutput .= "<td>" . $row['datset_data_dictionary'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_notes'] . "</td>";
            $tableOutput .= "</tr>";
        }

        $tableOutput .= "</table>";
    } else {
        $error = '<p>No results found.</p>';
    }
}
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
                <div class="dashboard-top">
                    <h1>Dashboard</h1>
                    <?php if (!empty($num_results)): ?>
                            <?php echo $num_results; ?>
                    <?php endif; ?>
                </div>

                <form action="" method="POST">
                    <div class="search-div">
                        <select name="search_field" id="search_field">
                            <option value="dataset_description">Description</option>
                            <option value="dataset_name_short">Dataset Name</option>
                            <option value="dataset_primary_contact_email">Contact Email</option>
                            <option value="dataset_primary_contact_first_name">Contact First Name</option>
                            <option value="dataset_primary_contact_last_name">Contact Last Name</option>
                            <option value="dataset_institution">Institution</option>
                            <option value="dataset_location_database">Database Location</option>
                            <option value="dataset_location_github">GitHub Location</option>
                            <option value="dataset_location_other">Other Location</option>
                            <option value="dataset_IRB">IRB</option>
                            <option value="dataset_README">README</option>
                            <option value="datset_data_dictionary">Data Dictionary</option>
                            <option value="dataset_notes">Notes</option>
                        </select>
                        <input type="text" name="search_value" placeholder="Value">
                        <input type="submit" name="submit" value="Search">
                    </div>
                </form>

                <?php echo $tableOutput; ?>

            </div>
        </div>
    </div>
</body>

</html>
