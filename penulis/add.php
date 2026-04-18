<html>
<head>
	<title>Tambah Penulis</title>
</head>
<link rel="stylesheet" href="../style1.css">

<body>
	<h2>Tambah Penulis</h2>
	<p>
		<button onclick="history.back()">← Back</button>
	</p>

	<form action="addAction.php" method="post" name="add">
		<table width="100%" border="0">
			<tr> 
				<td>Nama Penulis</td>
				<td><input type="text" name="nama_penulis"required></td>
			</tr>
			<tr> 
				<td>Biodata</td>
				<td><textarea name="biodata" rows="4" cols="21"required></textarea></td>
			</tr>
			
			<tr> 
				<td></td>
				<td><input type="submit" name="submit" value="Simpan"></td>
			</tr>
		</table>
	</form>
</body>
</html>

