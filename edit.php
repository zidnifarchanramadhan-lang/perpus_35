<?php
// Include the database connection file
require_once("dbConnection.php");

// Get id from URL parameter
$id_buku = $_GET['id_buku'];

// Select data associated with this particular id
$result = mysqli_query($mysqli, "SELECT * FROM buku WHERE id_buku = $id_buku");

// Fetch the next row of a result set as an associative array
$resultData = mysqli_fetch_assoc($result);
$id_buku = $resultData['id_buku'];
$judul = $resultData['judul'];
$isbn = $resultData['isbn'];
$tahun_terbit = $resultData['tahun_terbit'];
$halaman = $resultData['halaman'];
$ringkasan = $resultData['ringkasan'];
$id_penulis = $resultData['id_penulis'];
$id_kategori = $resultData['id_kategori'];
$id_penerbit = $resultData['id_penerbit'];

?>
<html>
<head>	
	<title>Edit Buku</title>
</head>
<link rel="stylesheet" href="style1.css">

<body>
    <h2>Edit Buku</h2>
    <p>
	    <a href="index.php">Home</a>
    </p>
	
	<form name="edit" method="post" action="editAction.php">
		<table width="100%" border="0">
		<tr> 
				<td>Id Buku</td>
				<td>
					<input type="text" value="<?php echo $id_buku; ?>" readonly>
					<input type="hidden" name="id_buku" value="<?php echo $id_buku; ?>">
				</td>
			</tr>
			<tr> 
				<td>Judul</td>
				<td><input type="text" name="judul" value="<?php echo $judul; ?>"></td>
			</tr>
			<tr> 
				<td>ISBN</td>
				<td><input type="text" name="isbn" value="<?php echo $isbn; ?>"></td>
			</tr>
			<tr> 
				<td>Tahun Terbit</td>
				<td><input type="text" name="tahun_terbit" value="<?php echo $tahun_terbit; ?>"></td>
			</tr>
			<tr> 
				<td>Halaman</td>
				<td><input type="text" name="halaman" value="<?php echo $halaman; ?>"></td>
			</tr>
			<tr> 
				<td>ringkasan</td>
				<td><textarea name="ringkasan" rows="4" cols="21"><?php echo $ringkasan; ?></textarea></td>
			</tr>
			<tr> 
				<td>Penulis</td>
				<td> <select name="id_penulis" >
					<?php
					include "dbConnection.php";
					$penulis = mysqli_query($mysqli, "SELECT * FROM penulis");
					while ($p = mysqli_fetch_assoc($penulis)) {
						$selected = ($p['id_penulis'] == $id_penulis) ? "selected" : "";
						echo "<option value='".$p['id_penulis']."' $selected>".$p['nama_penulis']."</option>";
					}
					?></select></td>
			</tr>
			<tr> 
				<td>Kategori</td>
				<td> <select name="id_kategori" >
					<?php
					include "dbConnection.php";
					$kategori = mysqli_query($mysqli, "SELECT * FROM kategori");
					while ($p = mysqli_fetch_assoc($kategori)) {
						$selected = ($p['id_kategori'] == $id_kategori) ? "selected" : "";
						echo "<option value='".$p['id_kategori']."' $selected>".$p['nama_kategori']."</option>";
					}
					?></select></td>
			</tr>
			<tr> 
				<td>Penerbit</td>
				<td> <select name="id_penerbit" >
					<?php
					include "dbConnection.php";
					$penerbit = mysqli_query($mysqli, "SELECT * FROM penerbit");
					while ($p = mysqli_fetch_assoc($penerbit)) {
						$selected = ($p['id_penerbit'] == $id_penerbit) ? "selected" : "";
						echo "<option value='".$p['id_penerbit']."' $selected>".$p['nama_penerbit']."</option>";
					}
					?></select></td>			
					</tr>
			<tr>
				<td><input type="hidden" name="id_buku" value=<?php echo $id_buku; ?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
