<html>
<head>
	<title>Add Data</title>
</head>

<body>
<?php
// Include the database connection file
require_once("../dbConnection.php");

if (isset($_POST['submit'])) {
	// Escape special characters in string for use in SQL statement	
	$nama_kategori = mysqli_real_escape_string($mysqli, $_POST['nama_kategori']);
		
	// Check for empty fields
	if (empty($nama_kategori)) {
		if (empty($nama_kategori)) {
			echo "<font color='red'>Nama Kategori kosong.</font><br/>";
		}
		// Show link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
		// If all the fields are filled (not empty) 

		// Insert data into database
		$result = mysqli_query($mysqli, "INSERT INTO kategori (`nama_kategori`) VALUES ('$nama_kategori')");
		
		header("Location: index.php");
		exit();
	}
}
?>
</body>
</html>
