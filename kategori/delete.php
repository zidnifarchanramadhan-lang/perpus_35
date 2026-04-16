<?php
// Include the database connection file
require_once("../dbConnection.php");

// Get id parameter value from URL
$id_kategori = $_GET['id_kategori'];

// Delete row from the database table
$result = mysqli_query($mysqli, "DELETE FROM kategori WHERE id_kategori = $id_kategori");

// Redirect to the main display page (index.php in our case)
header("Location:index.php");
