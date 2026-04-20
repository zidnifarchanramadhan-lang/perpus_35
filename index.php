<?php
require_once("dbConnection.php");

$limit = 2;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;
$keyword = isset($_GET['search']) ? $_GET['search'] : "";

$where = "";
if ($keyword != "") {
    $kw = mysqli_real_escape_string($mysqli, $keyword);
    $where = "WHERE 
        buku.judul LIKE '%$kw%' OR 
        penerbit.nama_penerbit LIKE '%$kw%' OR 
        penulis.nama_penulis LIKE '%$kw%' OR 
        kategori.nama_kategori LIKE '%$kw%' OR 
        buku.tahun_terbit LIKE '%$kw%'";
}

$count = mysqli_query($mysqli,
    "SELECT COUNT(*) AS total 
     FROM buku 
     LEFT JOIN penerbit  ON buku.id_penerbit  = penerbit.id_penerbit
     LEFT JOIN penulis   ON buku.id_penulis   = penulis.id_penulis
     LEFT JOIN kategori  ON buku.id_kategori  = kategori.id_kategori
     $where"
);
$total      = mysqli_fetch_assoc($count)['total'];
$total_page = ceil($total / $limit);

$result = mysqli_query($mysqli,
    "SELECT buku.*, penerbit.nama_penerbit, penulis.nama_penulis, kategori.nama_kategori,
            ROUND(AVG(u.rating),1) AS avg_rating,
            COUNT(u.id_ulasan)     AS jml_ulasan
     FROM buku
     LEFT JOIN penerbit  ON buku.id_penerbit  = penerbit.id_penerbit
     LEFT JOIN penulis   ON buku.id_penulis   = penulis.id_penulis
     LEFT JOIN kategori  ON buku.id_kategori  = kategori.id_kategori
     LEFT JOIN ulasan u  ON buku.id_buku      = u.id_buku
     $where
     GROUP BY buku.id_buku
     ORDER BY buku.id_buku DESC
     LIMIT $start, $limit"
);

$prev = ($page > 1) ? $page - 1 : 1;
$next = ($page < $total_page) ? $page + 1 : $total_page;

$msg  = isset($_GET['msg'])  ? $_GET['msg']  : "";
$type = isset($_GET['type']) ? $_GET['type'] : "success";
?>
<!DOCTYPE html>
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
    <div class="hero-content">
        <h1>Selamat Datang di Aplikasi Katalog Buku</h1>
        <p>Kelola data Buku, Penulis, Kategori dan Penerbit dengan mudah.</p>
    </div>
</div>

<div class="top-bar">
    <a href="add.php" class="btn-add">+ Tambah Buku</a>
    <form method="GET" class="form-search">
        <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($keyword) ?>">
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
        <th>Rating</th>
        <th>Action</th>
    </tr>

    <?php while ($res = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= htmlspecialchars($res['judul']) ?></td>
        <td><?= htmlspecialchars($res['nama_penulis']) ?></td>
        <td><?= htmlspecialchars($res['nama_penerbit']) ?></td>
        <td><?= $res['tahun_terbit'] ?></td>
        <td><?= htmlspecialchars($res['nama_kategori']) ?></td>
        <td><?= htmlspecialchars(substr($res['ringkasan'], 0, 70)) ?>...</td>
        <td class="td-rating">
            <?php if ($res['avg_rating'] > 0): ?>
                <div class="star-display">
                    <?php for ($s = 1; $s <= 5; $s++) echo ($s <= round($res['avg_rating'])) ? '★' : '☆'; ?>
                </div>
                <small><?= number_format($res['avg_rating'], 1) ?> (<?= $res['jml_ulasan'] ?>)</small>
            <?php else: ?>
                <span class="no-rating">Belum ada</span>
            <?php endif; ?>
        </td>
        <td class="td-action">
            <a class="btn-ulasan" href="ulasan.php?id_buku=<?= $res['id_buku'] ?>">⭐ Ulasan</a>
            <a class="edit" href="edit.php?id_buku=<?= $res['id_buku'] ?>">Edit</a>
            <a class="delete"
               href="delete.php?id_buku=<?= $res['id_buku'] ?>"
               onclick="return confirm('Yakin ingin hapus?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<div class="pagination-wrapper">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $prev ?>&search=<?= urlencode($keyword) ?>" class="pagination-btn">Previous</a>
    <?php else: ?>
        <a class="pagination-btn disabled">Previous</a>
    <?php endif; ?>

    <span class="page-info">Halaman <?= $page ?> dari <?= max($total_page,1) ?></span>

    <?php if ($page < $total_page): ?>
        <a href="?page=<?= $next ?>&search=<?= urlencode($keyword) ?>" class="pagination-btn">Next</a>
    <?php else: ?>
        <a class="pagination-btn disabled">Next</a>
    <?php endif; ?>
</div>

<!-- TOAST NOTIFIKASI -->
<?php if ($msg != ""): ?>
<div id="toast" class="toast <?= $type ?>"><?= htmlspecialchars($msg) ?></div>
<script>
window.addEventListener('load', function(){
    var t = document.getElementById('toast');
    if(t){ setTimeout(()=>t.classList.add('show'),100); setTimeout(()=>t.classList.remove('show'),3500); }
});
</script>
<?php endif; ?>

</body>
</html>
