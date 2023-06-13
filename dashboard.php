<?php
include "config.php";

$error = "";
$num_results = "";

if (isset($_POST['submit'])) {
    $searchValue = $_POST['search_value'];
    $num_results = "";
    $tableOutput = "";

    $query = "SELECT * FROM C3DataMaster $searchValue";
    // substring to remove the AND clause
    $query = substr($query, 0, -4);
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $num_results = "<div class='results-container'><p>" . count($result) . " result(s) found</p></div>";

    if ($result) {
        $tableOutput = "<table>";
        $tableOutput .= "<tr><th>Name</th><th>Description</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Institution</th><th>Location</th><th>GitHub Location</th><th>Other Location</th><th>IRB</th><th>README</th><th>Data Dictionary</th><th>Notes</th></tr>";

        foreach ($result as $row) {
            $tableOutput .= "<tr>";
            $tableOutput .= "<td>" . $row['dataset_name_short'] . "</td>";
            $tableOutput .= "<td><p>" . $row['dataset_description'] . "</p></td>";
            $tableOutput .= "<td>" . $row['dataset_primary_contact_email'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_primary_contact_first_name'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_primary_contact_last_name'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_institution'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_location_database'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_location_github'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_location_other'] . "</td>";
            $tableOutput .= "<td>" . ($row['dataset_IRB'] == '0' ? 'No' : 'Yes') . "</td>";
            $tableOutput .= "<td>" . $row['dataset_README'] . "</td>";
            $tableOutput .= "<td>" . $row['datset_data_dictionary'] . "</td>";
            $tableOutput .= "<td>" . $row['dataset_notes'] . "</td>";
            $tableOutput .= "</tr>";
        }

        $tableOutput .= "</table>";

        // Clear the search field
        $_POST['search_value'] = "";
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
                <div class="scrollable-content">
                    <div class="dashboard-top">
                        <h1>Data Dashboard</h1>
                        <?php if (!empty($num_results)): ?>
                            <?php echo $num_results; ?>
                        <?php endif; ?>
                    </div>

                    <form action="" method="POST">
                        <div class="search-div">
                            <div class="div1">
                                <select name="search_field" id="search_field" required>
                                    <option value="dataset_description">Description</option>
                                    <option value="dataset_name_short">Dataset Name</option>
                                    <option value="dataset_primary_contact_email">Email</option>
                                    <option value="dataset_primary_contact_first_name">First Name</option>
                                    <option value="dataset_primary_contact_last_name">Last Name</option>
                                    <option value="dataset_institution">Institution</option>
                                    <option value="dataset_location_database">Database Location</option>
                                    <option value="dataset_location_github">GitHub Location</option>
                                    <option value="dataset_location_other">Other Location</option>
                                    <option value="dataset_IRB">IRB</option>
                                    <option value="dataset_README">README</option>
                                    <option value="datset_data_dictionary">Data Dictionary</option>
                                    <option value="dataset_notes">Notes</option>
                                </select>
                            </div>
                            <div class="div2">
                                <input type="text" name="search_options" id="search_options" placeholder="Value">
                            </div>
                            <div class="div3">
                                <button type="button" id="add-search-option">Insert</button>
                            </div>
                            <div class="div4">
                                <input type="text" name="search_value" id="search_value" value="WHERE " required>
                            </div>
                            <div class="div5">
                                <input type="submit" name="submit" value="Search">
                            </div>
                        </div>
                    </form>

                    <?php echo $tableOutput; ?>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("add-search-option").addEventListener("click", function() {
            var searchField = document.getElementById("search_field");
            var searchOptions = document.getElementById("search_options");
            var searchValue = document.getElementById("search_value");

            // construct SQL query
            searchValue.value += searchField.value + " = '" + searchOptions.value + "' AND ";
        });
    </script>
</body>

</html>