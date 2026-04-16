<?php
// Include the database connection file
require_once("dbConnection.php");

// Get id parameter value from URL
$id_buku = $_GET['id_buku'];

// Delete row from the database table
$result = mysqli_query($mysqli, "DELETE FROM buku WHERE id_buku = $id_buku");

// Redirect to the main display page (index.php in our case)
header("Location:index.php");
