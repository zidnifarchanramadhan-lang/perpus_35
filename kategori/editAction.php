<?php
// Include the database connection file
require_once("../dbConnection.php");

if (isset($_POST['update'])) {
	// Escape special characters in a string for use in an SQL statement
	$id_kategori = mysqli_real_escape_string($mysqli, $_POST['id_kategori']);
	$nama_kategori = mysqli_real_escape_string($mysqli, $_POST['nama_kategori']);
	
	// Check for empty fields
	if (empty($nama_kategori)) {
		if (empty($nama_kategori)) {
			echo "<font color='red'>Nama kategori kosong !</font><br/>";
		}
		
		
	} else {
		// Update the database table
		$result = mysqli_query($mysqli, "UPDATE kategori SET `nama_kategori` = '$nama_kategori' WHERE `id_kategori` = $id_kategori");
		
		header("Location: index.php");
		exit();
	}
}
