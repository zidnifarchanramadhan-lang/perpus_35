<?php
require_once("../dbConnection.php");

$limit = 2;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$keyword = isset($_GET['search']) ? $_GET['search'] : "";
$where = "";
if ($keyword != "") {
    $where = "WHERE nama_penulis LIKE '%$keyword%' 
              OR biodata LIKE '%$keyword%'";
}

$count = mysqli_query($mysqli, 
    "SELECT COUNT(*) AS total FROM penulis $where"
);

$total = mysqli_fetch_assoc($count)['total'];
$total_page = ceil($total / $limit);

$result = mysqli_query($mysqli, 
    "SELECT * FROM penulis $where ORDER BY id_penulis DESC LIMIT $start, $limit"
);

$jumlah_data = mysqli_num_rows($result);

$prev = ($page > 1) ? $page - 1 : 1;
$next = ($page < $total_page) ? $page + 1 : $total_page;
?>

<html>
<head>	
	<title>Penulis</title>
	<link rel="stylesheet" href="../style.css">
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="nav-container">
        <div class="logo">📚 Aplikasi Katalog Buku</div>

        <div class="menu">
            <a href="../index.php">Home</a>
            <a href="../kategori">Kategori</a>
            <a href="../penerbit">Penerbit</a>
            <a class="active" href="index.php">Penulis</a>
        </div>
    </div>
</div>

<h3>Daftar Penulis</h3>

<div class="top-bar">
    <a href="add.php" class="btn-add">+ Tambah</a>

    <form method="GET" class="form-search">
        <input type="text" name="search" placeholder="Search..." value="<?= $keyword ?>">
        <button type="submit">Cari</button>
    </form>
</div>

<table class="table-book">
    <tr>
        <th>Nama Penulis</th>
        <th>Biodata</th>
        <th>Action</th>
    </tr>

    <?php while ($res = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $res['nama_penulis'] ?></td>
            <td><?= $res['biodata'] ?></td>
            <td>
                <a class="edit" href="edit.php?id_penulis=<?= $res['id_penulis'] ?>">Edit</a>
                &nbsp;|&nbsp;
                <a class="delete" href="delete.php?id_penulis=<?= $res['id_penulis'] ?>" 
                    onclick="return confirm('Yakin ingin menghapus?')">
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
