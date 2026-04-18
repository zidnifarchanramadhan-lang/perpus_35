<html>
<head>
	<title>Tambah Kategori</title>
</head>
<link rel="stylesheet" href="../style1.css">

<body>
	
	<h2>Tambah Kategori</h2>
	<p>
		<button onclick="history.back()">← Back</button>
	</p>

	<form action="addAction.php" method="post" name="add">
		<table width="100%" border="0">
		
			<tr> 
				<td>Nama Kategori</td>
				<td><input type="text" name="nama_kategori" required></td>
			</tr>
			<tr> 
				<td></td>
				<td><input type="submit" name="submit" value="Simpan"></td>
			</tr>
		</table>
	</form>
</body>
</html>

