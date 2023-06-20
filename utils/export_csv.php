<?php
include "config.php";

if (isset($_POST['search_value']) && isset($_POST['search_table'])) {
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

    if ($result) {
        // Output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');

        // Create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // Output the column headings
        fputcsv($output, array_keys($result[0]));

        // Fetch and output each row
        foreach ($result as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }
}
?>
