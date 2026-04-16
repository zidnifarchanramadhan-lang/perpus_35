<?php
require_once("dbConnection.php");

$limit = 2;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;
$keyword = isset($_GET['search']) ? $_GET['search'] : "";

$where = "";
if ($keyword != "") {
    $where = "WHERE 
        buku.judul LIKE '%$keyword%' OR 
        penerbit.nama_penerbit LIKE '%$keyword%' OR 
        penulis.nama_penulis LIKE '%$keyword%' OR 
        kategori.nama_kategori LIKE '%$keyword%' OR 
        buku.tahun_terbit LIKE '%$keyword%'";
}

$count = mysqli_query($mysqli, 
    "SELECT COUNT(*) AS total 
     FROM buku 
     LEFT JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit
     LEFT JOIN penulis ON buku.id_penulis = penulis.id_penulis
     LEFT JOIN kategori ON buku.id_kategori = kategori.id_kategori
     $where"
);
$total = mysqli_fetch_assoc($count)['total'];
$total_page = ceil($total / $limit);

$result = mysqli_query($mysqli, 
    "SELECT buku.*, penerbit.nama_penerbit, penulis.nama_penulis, kategori.nama_kategori
     FROM buku
     LEFT JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit
     LEFT JOIN penulis ON buku.id_penulis = penulis.id_penulis
     LEFT JOIN kategori ON buku.id_kategori = kategori.id_kategori
     $where
     ORDER BY buku.id_buku DESC
     LIMIT $start, $limit"
);

$jumlah_data = mysqli_num_rows($result);
$prev = ($page > 1) ? $page - 1 : 1;
$next = ($page < $total_page) ? $page + 1 : $total_page;
?>

<html>
<head>
    <title>Aplikasi Katalog Buku</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<nav class="navbar">
    <div class="nav-container">
        <div class="logo">📚 Aplikasi Katalog Buku</div>
        <div class="menu">
        
            <a href="index.php" class="active">Home</a>
            <a href="kategori">Kategori</a>
            <a href="penerbit">Penerbit</a>
            <a href="penulis">Penulis</a>
        </div>
    </div>
</nav>

<div class="hero">
    <div class="hero-container">
        <h1>Selamat Datang di Aplikasi Katalog Buku Berbasis Website</h1>
        <p>Kelola data Buku, Penulis, Kategori dan Penerbit dengan mudah.</p>
    </div>
</div>

<div class="top-bar">
    <a href="add.php" class="btn-add">+ Tambah Buku</a>

    <form method="GET" class="form-search">
        <input type="text" name="search" placeholder="Search..." value="<?= $keyword ?>">
        <button type="submit">Cari</button>

        
    </form>
</div>

<table class="table-book">
    <tr>
        <th>Judul</th>
        <th>Penulis</th>
        <th>Penerbit</th>
        <th>Tahun</th>
        <th>Kategori</th>
        <th>Ringkasan</th>
        <th>Action</th>
        <th>Waktu</th>
    </tr>

    <?php while ($res = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $res['judul'] ?></td>
            <td><?= $res['nama_penulis'] ?></td>
            <td><?= $res['nama_penerbit'] ?></td>
            <td><?= $res['tahun_terbit'] ?></td>
            <td><?= $res['nama_kategori'] ?></td>
            <td><?= $res['ringkasan'] ?></td>

            <td>
                <a class="edit" href="edit.php?id_buku=<?= $res['id_buku'] ?>">Edit</a> |
                <a class="delete"
                   href="delete.php?id_buku=<?= $res['id_buku'] ?>"
                   onclick="return confirm('Yakin ingin hapus?')">
                   Delete
                </a>
            </td>
        </tr>
    <?php } ?>
</table>
<br>

<div class="pagination-wrapper">
	<?php if ($page > 1): ?>
		<a href="?page=<?= $prev ?>&search=<?= $keyword ?>" class="pagination-btn">
			Previous
		</a>
	<?php else: ?>
		<a class="pagination-btn disabled">Previous</a>
	<?php endif; ?>

    <span class="page-info">Halaman <?= $page ?> dari <?= $total_page ?></span>

	<?php if ($page < $total_page): ?>
    <a href="?page=<?= $next ?>&search=<?= $keyword ?>" class="pagination-btn">
        Next
    </a>
	<?php else: ?>
		<a class="pagination-btn disabled">Next</a>
	<?php endif; ?>

</div>

</body>
</html>
