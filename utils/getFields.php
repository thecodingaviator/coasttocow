<?php
include "../config.php";

$searchTable = $_GET['searchTable'];

$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'C3_Database' AND TABLE_NAME = :searchTable";
$stmt = $conn->prepare($query);
$stmt->bindParam(':searchTable', $searchTable);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$options = "";
foreach ($result as $row) {
    $options .= "<option value='" . $row['COLUMN_NAME'] . "'>" . $row['COLUMN_NAME'] . "</option>";
}

echo $options;
?>
