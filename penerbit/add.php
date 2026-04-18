<html>
<head>
	<title>Tambah Penerbit</title>
</head>
<link rel="stylesheet" href="../style1.css">

<body>
	<h2>Tambah Penerbit</h2>
	<p>
		<button onclick="history.back()">← Back</button>
	</p>

	<form action="addAction.php" method="post" name="add">
		<table width="100%" border="0">

			<tr> 
				<td>Nama Penerbit</td>
				<td><input type="text" name="nama_penerbit" required></td>
			</tr>
			<tr> 
				<td>Alamat</td>
				<td><textarea name="alamat" rows="4" cols="21" required></textarea>></textarea></td>
			</tr>
			
			<tr> 
				<td></td>
				<td><input type="submit" name="submit" value="Simpan"></td>
			</tr>
		</table>
	</form>
</body>
</html>

