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
                                        <option value="C3DataMaster" <?php if (isset($_POST['search_table']) && $_POST['search_table'] == 'C3DataMaster')
                                            echo 'selected'; ?>>DataMaster
                                        </option>
                                        <option value="C3AnalysisGrain" <?php if (isset($_POST['search_table']) && $_POST['search_table'] == 'C3AnalysisGrain')
                                            echo 'selected'; ?>>AnalysisGrain
                                        </option>
                                        <option value="C3AnalysisDryAE" <?php if (isset($_POST['search_table']) && $_POST['search_table'] == 'C3AnalysisDryAE')
                                            echo 'selected'; ?>>AnalysisDryAE
                                        </option>
                                        <option value="C3AnalysisManure" <?php if (isset($_POST['search_table']) && $_POST['search_table'] == 'C3AnalysisManure')
                                            echo 'selected'; ?>>
                                            AnalysisManure</option>
                                        <option value="C3AnalysisOther" <?php if (isset($_POST['search_table']) && $_POST['search_table'] == 'C3AnalysisOther')
                                            echo 'selected'; ?>>AnalysisOther
                                        </option>
                                        <option value="C3AnalysisTMR" <?php if (isset($_POST['search_table']) && $_POST['search_table'] == 'C3AnalysisTMR')
                                            echo 'selected'; ?>>AnalysisTMR
                                        </option>
                                        <option value="C3AnalysisUnrecognized" <?php if (isset($_POST['search_table']) && $_POST['search_table'] == 'C3AnalysisUnrecognized')
                                            echo 'selected'; ?>>
                                            AnalysisUnrecognized</option>
                                        <option value="C3Macro" <?php if (isset($_POST['search_table']) && $_POST['search_table'] == 'C3Macro')
                                            echo 'selected'; ?>>Macro</option>
                                        <option value="C3TFA" <?php if (isset($_POST['search_table']) && $_POST['search_table'] == 'C3TFA')
                                            echo 'selected'; ?>>TFA</option>
                                    </select>
                                </div>
                                <div class="div2">
                                    <select name="search_field" id="search_field" required>
                                        <option value='dataset_description' <?php if (isset($_POST['search_field']) && $_POST['search_field'] == 'dataset_description')
                                            echo 'selected'; ?>>
                                            dataset_description</option>
                                        <option value='dataset_name_short' <?php if (isset($_POST['search_field']) && $_POST['search_field'] == 'dataset_name_short')
                                            echo 'selected'; ?>>
                                            dataset_name_short</option>
                                        <option value='dataset_primary_contact_email' <?php if (isset($_POST['search_field']) && $_POST['search_field'] == 'dataset_primary_contact_email')
                                            echo 'selected'; ?>>dataset_primary_contact_email</option>
                                        <option value='dataset_primary_contact_first_name' <?php if (isset($_POST['search_field']) && $_POST['search_field'] == 'dataset_primary_contact_first_name')
                                            echo 'selected'; ?>>dataset_primary_contact_first_name</option>
                                        <option value='dataset_primary_contact_last_name' <?php if (isset($_POST['search_field']) && $_POST['search_field'] == 'dataset_primary_contact_last_name')
                                            echo 'selected'; ?>>dataset_primary_contact_last_name</option>
                                        <option value='dataset_institution' <?php if (isset($_POST['search_field']) && $_POST['search_field'] == 'dataset_institution')
                                            echo 'selected'; ?>>
                                            dataset_institution</option>
                                        <option value='dataset_location_database' <?php if (isset($_POST['search_field']) && $_POST['search_field'] == 'dataset_location_database')
                                            echo 'selected'; ?>>
                                            dataset_location_database</option>
                                        <option value='dataset_location_github' <?php if (isset($_POST['search_field']) && $_POST['search_field'] == 'dataset_location_github')
                                            echo 'selected'; ?>>
                                            dataset_location_github</option>
                                        <option value='dataset_location_other' <?php if (isset($_POST['search_field']) && $_POST['search_field'] == 'dataset_location_other')
                                            echo 'selected'; ?>>
                                            dataset_location_other</option>
                                        <option value='dataset_IRB' <?php if (isset($_POST['search_field']) && $_POST['search_field'] == 'dataset_IRB')
                                            echo 'selected'; ?>>dataset_IRB
                                        </option>
                                        <option value='dataset_README' <?php if (isset($_POST['search_field']) && $_POST['search_field'] == 'dataset_README')
                                            echo 'selected'; ?>>dataset_README
                                        </option>
                                        <option value='datset_data_dictionary' <?php if (isset($_POST['search_field']) && $_POST['search_field'] == 'datset_data_dictionary')
                                            echo 'selected'; ?>>
                                            datset_data_dictionary</option>
                                        <option value='dataset_notes' <?php if (isset($_POST['search_field']) && $_POST['search_field'] == 'dataset_notes')
                                            echo 'selected'; ?>>dataset_notes
                                        </option>
                                    </select>
                                </div>
                                <div class="div3">
                                    <input type="text" name="search_options" id="search_options" placeholder="Value"
                                        value="<?php echo isset($_POST['search_options']) ? $_POST['search_options'] : ''; ?>">
                                </div>
                                <div class="div4">
                                    <button type="button" id="add-search-option">Insert</button>
                                </div>
                                <div class="div5">
                                    <input type="text" name="search_value" id="search_value"
                                        value="<?php echo isset($_POST['search_value']) ? $_POST['search_value'] : 'WHERE '; ?>"
                                        required>
                                </div>
                                <div class="div6">
                                    <input type="submit" name="submit" value="Search">
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php echo $tableOutput; ?>
                    <?php echo $query; ?>

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

            if (searchOptions.value === "") {
                return;
            }

            var searchOptionsValue = searchOptions.value.trim();
            var searchOptionsValueIsNumber = !isNaN(searchOptionsValue);

            // Check if searchOptionsValue is a number
            if (searchOptionsValueIsNumber) {
                searchValue.value += searchField.value + " = " + searchOptionsValue + " AND ";
            }
            // Check if searchOptionsValue is a comparison operation
            else if (/^[<>]=?\d+$/.test(searchOptionsValue)) {
                searchValue.value += searchField.value + " " + searchOptionsValue + " AND ";
            }
            // Treat searchOptionsValue as a string
            else {
                searchValue.value += searchField.value + " = '" + searchOptionsValue + "' AND ";
            }
        });

        document.getElementById("search_table").addEventListener("change", function () {
            updateTable(document.getElementById("search_table"));
        });
        document.addEventListener("DOMContentLoaded", function () {
            updateTable(document.getElementById("search_table"));
        });
    </script>
</body>

</html>