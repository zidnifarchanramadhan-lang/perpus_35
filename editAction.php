<?php
// Include the database connection file
require_once("dbConnection.php");

if (isset($_POST['update'])) {
	// Escape special characters in a string for use in an SQL statement
	$id_buku = mysqli_real_escape_string($mysqli, $_POST['id_buku']);
	$judul = mysqli_real_escape_string($mysqli, $_POST['judul']);
	$isbn = mysqli_real_escape_string($mysqli, $_POST['isbn']);
	$tahun_terbit = mysqli_real_escape_string($mysqli, $_POST['tahun_terbit']);	
	$halaman = mysqli_real_escape_string($mysqli, $_POST['halaman']);
	$ringkasan = mysqli_real_escape_string($mysqli, $_POST['ringkasan']);
	$id_penulis = mysqli_real_escape_string($mysqli, $_POST['id_penulis']);
	$id_kategori = mysqli_real_escape_string($mysqli, $_POST['id_kategori']);
	$id_penerbit = mysqli_real_escape_string($mysqli, $_POST['id_penerbit']);
	
	// Check for empty fields
	if (empty($judul) || empty($isbn) || empty($tahun_terbit) || empty($halaman) || empty($ringkasan) || empty($id_penulis) || empty($id_kategori) || empty($id_penerbit)) {
		if (empty($judul)) {
			echo "<font color='red'>Judul buku kosong !</font><br/>";
		}
		
		if (empty($isbn)) {
			echo "<font color='red'>ISBN kosong !</font><br/>";
		}
		
		if (empty($tahun_terbit)) {
			echo "<font color='red'>Tahun terbit kosong !</font><br/>";
		}

		if (empty($halaman)) {
			echo "<font color='red'>Halaman terbit kosong !</font><br/>";
		}

		if (empty($ringkasan)) {
			echo "<font color='red'>Ringkasan terbit kosong !</font><br/>";
		}

		if (empty($id_penulis)) {
			echo "<font color='red'>Penulis kosong !</font><br/>";
		}

		if (empty($id_kategori)) {
			echo "<font color='red'>Kategori terbit kosong !</font><br/>";
		}

		if (empty($id_penerbit)) {
			echo "<font color='red'>Penerbit kosong !</font><br/>";
		}
	} else {
		// Update the database table
		$result = mysqli_query($mysqli, "UPDATE buku SET `judul` = '$judul', `isbn` = '$isbn', `tahun_terbit` = '$tahun_terbit' , `halaman` = '$halaman' , `ringkasan` = '$ringkasan' , `id_penulis` = '$id_penulis' , `id_kategori` = '$id_kategori' , `id_penerbit` = '$id_penerbit' WHERE `id_buku` = $id_buku");
		
		header("Location: index.php");
		exit();
	}
}
