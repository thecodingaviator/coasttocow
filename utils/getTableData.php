<?php
// File: getTableData.php
// Authors: Gordon Doore, Parth Parth\
// Purpose: Get data from a table in SQL db for keyword search
// Last modified: 04/05/2023

include "config.php";

$searchTable = $_GET['searchTable'];

$query = "SELECT * FROM " . $searchTable;
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// We'll output the results as a JSON string for easier handling in JavaScript
echo json_encode($result);
?>