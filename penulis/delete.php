<?php
// Include the database connection file
require_once("../dbConnection.php");

// Get id parameter value from URL
$id_penulis = $_GET['id_penulis'];

// Delete row from the database table
$result = mysqli_query($mysqli, "DELETE FROM penulis WHERE id_penulis = $id_penulis");

// Redirect to the main display page (index.php in our case)
header("Location:index.php");
