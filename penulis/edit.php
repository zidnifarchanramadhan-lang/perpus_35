<?php
// Include the database connection file
require_once("../dbConnection.php");

// Get id from URL parameter
$id_penulis = $_GET['id_penulis'];

// Select data associated with this particular id
$result = mysqli_query($mysqli, "SELECT * FROM penulis WHERE id_penulis = $id_penulis");

// Fetch the next row of a result set as an associative array
$resultData = mysqli_fetch_assoc($result);

$id_penulis = $resultData['id_penulis'];
$nama_penulis = $resultData['nama_penulis'];
$biodata = $resultData['biodata'];

?>
<html>
<head>	
	<title>Edit Penulis</title>
</head>
<link rel="stylesheet" href="../style1.css">

<body>
    <h2>Edit Penulis</h2>
    <p>
	    <a href="index.php">Home</a>
    </p>
	
	<form name="edit" method="post" action="editAction.php">
		<table width="100%" border="0">
			<tr> 
				<td>Id Penulis</td>
				<td>
					<input type="text" value="<?php echo $id_penulis; ?>" readonly>
					<input type="hidden" name="id_penulis" value="<?php echo $id_penulis; ?>">
				</td>
			</tr>
			<tr> 
				<td>Nama Penulis</td>
				<td><input type="text" name="nama_penulis" value="<?php echo $nama_penulis; ?>"></td>
			</tr>
			<tr> 
				<td>Biodata</td>
				<td><textarea name="biodata" rows="4" cols="21"><?php echo $biodata; ?></textarea></td>
			</tr>
			
			<tr>
				<td><input type="hidden" name="id_penulis" value=<?php echo $id_penulis; ?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
