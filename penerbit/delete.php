<?php
// Include the database connection file
require_once("../dbConnection.php");

// Get id parameter value from URL
$id_penerbit = $_GET['id_penerbit'];

// Delete row from the database table
$result = mysqli_query($mysqli, "DELETE FROM penerbit WHERE id_penerbit = $id_penerbit");

// Redirect to the main display page (index.php in our case)
header("Location:index.php");
