<?php
// Include the database connection file
require_once("../dbConnection.php");

if (isset($_POST['update'])) {
	// Escape special characters in a string for use in an SQL statement
	$id_penulis = mysqli_real_escape_string($mysqli, $_POST['id_penulis']);
	$nama_penulis = mysqli_real_escape_string($mysqli, $_POST['nama_penulis']);
	$biodata = mysqli_real_escape_string($mysqli, $_POST['biodata']);	
	
	// Check for empty fields
	if (empty($nama_penulis) || empty($biodata)) {
		if (empty($nama_penulis)) {
			echo "<font color='red'>Nama penulis kosong !</font><br/>";
		}
		
		if (empty($biodata)) {
			echo "<font color='red'>Biodata kosong !</font><br/>";
		}
		
		
	} else {
		// Update the database table
		$result = mysqli_query($mysqli, "UPDATE penulis SET `nama_penulis` = '$nama_penulis', `biodata` = '$biodata' WHERE `id_penulis` = $id_penulis");
		
		header("Location: index.php");
		exit();
	}
}
