<html>
<head>
	<title>Tambah Buku</title>
</head>
<link rel="stylesheet" href="style1.css">
<body>
<div class="from">
	<h2>Tambah Buku</h2>
	<p>
		<a href="index.php">back</a>
	</p>

	<form action="addAction.php" method="post" name="add">
		<table width="100%" border="0">
			<tr> 
				<td>Judul</td>
				<td><input type="text" name="judul"required></td>
			</tr>
			<tr> 
				<td>ISBN</td>
				<td><input type="text" name="isbn"required></td>
			</tr>
			<tr> 
				<td>Tahun Terbit</td>
				<td><input type="text" name="tahun_terbit"required></td>
			</tr>
			<tr> 
				<td>Halaman</td>
				<td><input type="text" name="halaman"required></td>
			</tr>
			<tr> 
				<td>Ringkasan</td>
				<td><textarea name="ringkasan" rows="4" cols="21"required></textarea></td>
			</tr>
			<tr> 
    <td>Penulis</td>
    <td>
        <select name="id_penulis">
            <option value="">-- Pilih --</option>
            <?php
            include "dbConnection.php";
            $penulis = mysqli_query($mysqli, "SELECT * FROM penulis");
            while ($p = mysqli_fetch_assoc($penulis)) {
                echo "<option value='".$p['id_penulis']."'>".$p['nama_penulis']."</option>";
            }
            ?>
        </select>
    </td>
</tr>

<tr> 
    <td>Kategori</td>
    <td>
        <select name="id_kategori" >
            <option value="">-- Pilih --</option>
            <?php
            include "dbConnection.php";
            $kategori = mysqli_query($mysqli, "SELECT * FROM kategori");
            while ($p = mysqli_fetch_assoc($kategori)) {
                echo "<option value='".$p['id_kategori']."'>".$p['nama_kategori']."</option>";
            }
            ?>
        </select>
    </td>
</tr>

<tr> 
    <td>Penerbit</td>
    <td>
        <select name="id_penerbit" >
            <option value="">-- Pilih --</option>
            <?php
            include "dbConnection.php";
            $penerbit = mysqli_query($mysqli, "SELECT * FROM penerbit");
            while ($p = mysqli_fetch_assoc($penerbit)) {
                echo "<option value='".$p['id_penerbit']."'>".$p['nama_penerbit']."</option>";
            }
            ?>
        </select>
    </td>
</tr>

			<tr> 
				<td></td>
				<td><input type="submit" name="submit" value="Simpan"></td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>

