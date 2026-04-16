<?php
// Include the database connection file
require_once("../dbConnection.php");

// Get id from URL parameter
$id_penerbit = $_GET['id_penerbit'];

// Select data associated with this particular id
$result = mysqli_query($mysqli, "SELECT * FROM penerbit WHERE id_penerbit = $id_penerbit");

// Fetch the next row of a result set as an associative array
$resultData = mysqli_fetch_assoc($result);
$id_penerbit = $resultData['id_penerbit'];
$nama_penerbit = $resultData['nama_penerbit'];
$alamat = $resultData['alamat'];

?>
<html>
<head>	
	<title>Edit Penerbit</title>
</head>
<link rel="stylesheet" href="../style1.css">

<body>
    <h2>Edit Penerbit</h2>
    <p>
	    <a href="index.php">Home</a>
    </p>
	
	<form name="edit" method="post" action="editAction.php">
		<table width="100%" border="0">
			<tr> 
				<td>Id Penerbit</td>
				<td>
					<input type="text" value="<?php echo $id_penerbit; ?>" readonly>
					<input type="hidden" name="id_penerbit" value="<?php echo $id_penerbit; ?>">
				</td>
			</tr>
			<tr> 
				<td>Nama Penerbit</td>
				<td><input type="text" name="nama_penerbit" value="<?php echo $nama_penerbit; ?>"></td>
			</tr>
			<tr> 
				<td>Alamat</td>
				<td><textarea name="alamat" rows="4" cols="21"><?php echo $alamat; ?></textarea></td>
			</tr>
			
			<tr>
				<td><input type="hidden" name="id_penerbit" value=<?php echo $id_penerbit; ?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
