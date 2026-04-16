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
	$nama_penulis = mysqli_real_escape_string($mysqli, $_POST['nama_penulis']);
	$biodata = mysqli_real_escape_string($mysqli, $_POST['biodata']);
	
		
	// Check for empty fields
	if (empty($nama_penulis) || empty($biodata)) {
		if (empty($nama_penulis)) {
			echo "<font color='red'>Name penulis kosong !</font><br/>";
		}
		
		if (empty($biodata)) {
			echo "<font color='red'>Biodata kosong !</font><br/>";
		}
		
		
		
		// Show link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
		// If all the fields are filled (not empty) 

		// Insert data into database
		$result = mysqli_query($mysqli, "INSERT INTO penulis (`nama_penulis`, `biodata`) VALUES ('$nama_penulis', '$biodata')");
		
		header("Location: index.php");
		exit();
	}
}
?>
</body>
</html>
