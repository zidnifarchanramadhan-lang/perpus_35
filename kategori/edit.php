<?php
// Include the database connection file
require_once("../dbConnection.php");

// Get id from URL parameter
$id_kategori = $_GET['id_kategori'];

// Select data associated with this particular id
$result = mysqli_query($mysqli, "SELECT * FROM kategori WHERE id_kategori = $id_kategori");

// Fetch the next row of a result set as an associative array
$resultData = mysqli_fetch_assoc($result);

$nama_kategori = $resultData['nama_kategori'];
?>
<html>
<head>	
	<title>Edit Kategori</title>
</head>
<link rel="stylesheet" href="../style1.css">

<body>
    <h2>Edit Kategori</h2>
    <p>
	    <a href="index.php">Home</a>
    </p>
	
	<form name="edit" method="post" action="editAction.php">
		<table width="100%" border="0">
			<tr> 
				<td>Id Kategori</td>
				<td>
					<input type="text" value="<?php echo $id_kategori; ?>" readonly>
					<input type="hidden" name="id_kategori" value="<?php echo $id_kategori; ?>">
				</td>
			</tr>
			<tr> 
				<td>Nama Kategori</td>
				<td><input type="text" name="nama_kategori" value="<?php echo $nama_kategori; ?>"></td>
			</tr>
			
			<tr>
				<td><input type="hidden" name="id_kategori" value=<?php echo $id_kategori; ?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
