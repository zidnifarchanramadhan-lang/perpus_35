<?php
// Include the database connection file
require_once("../dbConnection.php");

if (isset($_POST['update'])) {
	// Escape special characters in a string for use in an SQL statement
	$id_penerbit = mysqli_real_escape_string($mysqli, $_POST['id_penerbit']);
	$nama_penerbit = mysqli_real_escape_string($mysqli, $_POST['nama_penerbit']);
	$alamat = mysqli_real_escape_string($mysqli, $_POST['alamat']);	
	
	// Check for empty fields
	if (empty($nama_penerbit) || empty($alamat)) {
		if (empty($nama_penerbit)) {
			echo "<font color='red'>Nama penulis kosong !</font><br/>";
		}
		
		if (empty($alamat)) {
			echo "<font color='red'>Alamat kosong !</font><br/>";
		}
		
		
	} else {
		// Update the database table
		$result = mysqli_query($mysqli, "UPDATE penerbit SET `nama_penerbit` = '$nama_penerbit', `alamat` = '$alamat' WHERE `id_penerbit` = $id_penerbit");
		
		header("Location: index.php");
		exit();
	}
}
