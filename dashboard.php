<?php
include "config.php";

$error = "";
$num_results = "";
$tableOutput = "";

if (isset($_POST['submit'])) {
    $searchValue = $_POST['search_value'];
    $searchTable = $_POST['search_table'];

    $query = "SELECT * FROM $searchTable $searchValue";
    // if there is an AND clause at the end, remove it
    if (substr($query, -4) == "AND ") {
        $query = substr($query, 0, -4);
    }
    // if there is a WHERE clause at the end, remove it
    if (substr($query, -6) == "WHERE ") {
        $query = substr($query, 0, -6);
    }
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $num_results = "<div class='results-container'><p>" . count($result) . " result(s) found</p></div>";

    if ($result) {
        $tableOutput .= '<table>';
        $tableOutput .= '<thead>';
        $tableOutput .= '<tr>';

        // Generate table headers
        foreach ($result[0] as $columnName => $value) {
            $tableOutput .= '<th>' . $columnName . '</th>';
        }

        $tableOutput .= '</tr>';
        $tableOutput .= '</thead>';
        $tableOutput .= '<tbody>';

        // Generate table rows
        foreach ($result as $row) {
            $tableOutput .= '<tr>';

            foreach ($row as $value) {
                $tableOutput .= '<td>' . $value . '</td>';
            }

            $tableOutput .= '</tr>';
        }

        $tableOutput .= '</tbody>';
        $tableOutput .= '</table>';
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
                    <div class="sticky-top">
                        <div class="dashboard-top">
                            <h1>Data Dashboard</h1>
                            <?php if (!empty($num_results)): ?>
                                <?php echo $num_results; ?>
                            <?php endif; ?>
                        </div>
                        <form action="" method="POST">
                            <div class="search-div">
                                <div class="div1">
                                    <select name="search_table" id="search_table" required>
                                        <option value="C3DataMaster">DataMaster</option>
                                        <option value="C3AnalysisGrain">AnalysisGrain</option>
                                        <option value="C3AnalysisDryAE">AnalysisDryAE</option>
                                        <option value="C3AnalysisManure">AnalysisManure</option>
                                        <option value="C3AnalysisOther">AnalysisOther</option>
                                        <option value="C3AnalysisTMR">AnalysisTMR</option>
                                        <option value="C3AnalysisUnrecognized">AnalysisUnrecognized</option>
                                        <option value="C3Macro">Macro</option>
                                        <option value="C3TFA">TFA</option>
                                    </select>
                                </div>
                                <div class="div2">
                                    <select name="search_field" id="search_field" required>
                                        <option value='dataset_description'>dataset_description</option>
                                        <option value='dataset_name_short'>dataset_name_short</option>
                                        <option value='dataset_primary_contact_email'>dataset_primary_contact_email
                                        </option>
                                        <option value='dataset_primary_contact_first_name'>
                                            dataset_primary_contact_first_name</option>
                                        <option value='dataset_primary_contact_last_name'>
                                            dataset_primary_contact_last_name</option>
                                        <option value='dataset_institution'>dataset_institution</option>
                                        <option value='dataset_location_database'>dataset_location_database</option>
                                        <option value='dataset_location_github'>dataset_location_github</option>
                                        <option value='dataset_location_other'>dataset_location_other</option>
                                        <option value='dataset_IRB'>dataset_IRB</option>
                                        <option value='dataset_README'>dataset_README</option>
                                        <option value='datset_data_dictionary'>datset_data_dictionary</option>
                                        <option value='dataset_notes'>dataset_notes</option>
                                    </select>
                                </div>
                                <div class="div3">
                                    <input type="text" name="search_options" id="search_options" placeholder="Value">
                                </div>
                                <div class="div4">
                                    <button type="button" id="add-search-option">Insert</button>
                                </div>
                                <div class="div5">
                                    <input type="text" name="search_value" id="search_value" value="WHERE " required>
                                </div>
                                <div class="div6">
                                    <input type="submit" name="submit" value="Search">
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php echo $tableOutput; ?>

                </div>
            </div>
        </div>
    </div>

    <script>
        function updateTable(e) {
            var searchTable = e.value;
            var searchFieldSelect = document.getElementById("search_field");

            // Make an AJAX request to fetch new select options
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var options = xhr.responseText;
                    searchFieldSelect.innerHTML = options;
                }
            };

            xhr.open("GET", "utils/getFields.php?searchTable=" + searchTable, true);
            xhr.send();
        }

        document.getElementById("add-search-option").addEventListener("click", function () {
            var searchField = document.getElementById("search_field");
            var searchOptions = document.getElementById("search_options");
            var searchValue = document.getElementById("search_value");

            if (searchOptions.value == "") {
                return;
            }

            // construct SQL query
            // if searchoptions is a number or SQL operator like >, treat it such
            // else, treat it as a string
            var searchOptionsValue = searchOptions.value;
            var searchOptionsValueIsNumber = !isNaN(searchOptionsValue);

            if (searchOptionsValueIsNumber) {
                searchValue.value += searchField.value + " = " + searchOptionsValue + " AND ";
            } else {
                searchValue.value += searchField.value + " '" + searchOptionsValue + "' AND ";
            }
        });

        document.getElementById("search_table").addEventListener("change", function () {
            updateTable(document.getElementById("search_table"));
        });
        document.addEventListener("load", function () {
            updateTable(document.getElementById("search_table"));
        });
    </script>
</body>

</html>