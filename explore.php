<?php
include "utils/config.php";

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
    <title>C3 | Explorer</title>

    <link rel="stylesheet" href="css/dashboard-common.css">
    <link rel="stylesheet" href="css/explore.css">
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
                            <h1>Data Explorer</h1>
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
                                    </select>
                                </div>
                                <div class="div3">
                                    <input type="text" name="search_options" id="search_options"
                                        placeholder="Operator + Value"
                                        pattern="^(=|<>|<|<=|>|>=|LIKE|IN|BETWEEN|IS NULL|IS NOT NULL).+"
                                        value="<?php echo isset($_POST['search_options']) ? $_POST['search_options'] : ''; ?>">
                                </div>
                                <div class="div4">
                                    <button type="button" id="add-search-option">Insert</button>
                                </div>
                                <div class="div5">
                                    <button type="button" id="clear-search-options">Clear</button>
                                </div>
                                <div class="div6">
                                    <button type="button" id="backspace-search-options">Backspace</button>
                                </div>
                                <div class="div7">
                                    <input type="text" name="search_value" id="search_value" readonly
                                        value="<?php echo isset($_POST['search_value']) ? $_POST['search_value'] : 'WHERE '; ?>"
                                        required>
                                </div>
                                <div class="div8">
                                    <input type="submit" name="submit" value="Search">
                                </div>
                                <div class="div9">
    <button type="button" name="download" id="download-csv">Download CSV</button>
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

        // if user clicks 7 times in 5 seconds on #search_value, make it editable
        var searchValue = document.getElementById("search_value");
        var searchValueClicks = 0;
        var searchValueClicksTimeout = null;

        searchValue.addEventListener("click", function () {
            searchValueClicks++;

            if (searchValueClicks === 5) {
                searchValueClicks = 0;
                searchValueClicksTimeout = null;
                searchValue.readOnly = false;
            }

            if (searchValueClicksTimeout === null) {
                searchValueClicksTimeout = setTimeout(function () {
                    searchValueClicks = 0;
                    searchValueClicksTimeout = null;
                }, 5000);
            }
        });

        document.getElementById("add-search-option").addEventListener("click", function () {
            var searchField = document.getElementById("search_field");
            var searchOptions = document.getElementById("search_options");
            var searchValue = document.getElementById("search_value");

            if (searchOptions.value === "") {
                return;
            }

            var searchOptionsValue = searchOptions.value.trim();
            var searchOptionsValueIsNumber = !isNaN(searchOptionsValue);

            searchValue.value += searchField.value + "" + searchOptionsValue + " AND ";

        });

        document.getElementById("clear-search-options").addEventListener("click", function () {
            var searchValue = document.getElementById("search_value");
            searchValue.value = "WHERE ";
        });

        document.getElementById("backspace-search-options").addEventListener("click", function () {
            var searchValue = document.getElementById("search_value");

            if (searchValue.value === "WHERE ") {
                return;
            }

            var searchValueArray = searchValue.value.split(" ");

            if (searchValueArray.length === 2 | searchValueArray.length === 3) {
                searchValue.value = "WHERE ";
                return;
            }

            // else go to last AND and remove it and everything before it till the previous and or WHERE
            var lastAndIndex = searchValue.value.lastIndexOf("AND");
            var previousAndIndex = searchValue.value.lastIndexOf("AND", lastAndIndex - 1);
            var whereIndex = searchValue.value.lastIndexOf("WHERE");

            if (previousAndIndex === -1) {
                searchValue.value = "WHERE ";
                return;
            }

            searchValue.value = searchValue.value.substring(0, previousAndIndex + 3);
        });

        document.getElementById("search_table").addEventListener("change", function () {
            updateTable(document.getElementById("search_table"));
        });
        document.addEventListener("DOMContentLoaded", function () {
            updateTable(document.getElementById("search_table"));
        });

        document.getElementById("download-csv").addEventListener("click", function () {
    var form = document.createElement("form");
    form.method = "POST";
    form.action = "utils/export_csv.php";
    form.style.display = "none";

    var input = document.createElement("input");
    input.name = "search_value";
    input.value = document.getElementById("search_value").value;
    form.appendChild(input);

    var inputTable = document.createElement("input");
    inputTable.name = "search_table";
    inputTable.value = document.getElementById("search_table").value;
    form.appendChild(inputTable);

    document.body.appendChild(form);
    form.submit();
});

    </script>
</body>

</html>