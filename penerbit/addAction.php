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
	$nama_penerbit = mysqli_real_escape_string($mysqli, $_POST['nama_penerbit']);
	$alamat = mysqli_real_escape_string($mysqli, $_POST['alamat']);
	
		
	// Check for empty fields
	if (empty($nama_penerbit) || empty($alamat)) {
		if (empty($nama_penerbit)) {
			echo "<font color='red'>Name penerbit kosong !</font><br/>";
		}
		
		if (empty($alamat)) {
			echo "<font color='red'>Alamat kosong !</font><br/>";
		}
		
		
		
		// Show link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
		// If all the fields are filled (not empty) 

		// Insert data into database
		$result = mysqli_query($mysqli, "INSERT INTO penerbit (`nama_penerbit`, `alamat`) VALUES ('$nama_penerbit', '$alamat')");
		
		header("Location: index.php");
		exit();
	}
}
?>
</body>
</html>
