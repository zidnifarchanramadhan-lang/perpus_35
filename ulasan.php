<?php
require_once("dbConnection.php");

if (!isset($_GET['id_buku'])) { header("Location:index.php"); exit(); }

$id_buku = (int)$_GET['id_buku'];

$qBuku = mysqli_query($mysqli,
    "SELECT buku.*, penulis.nama_penulis, kategori.nama_kategori, penerbit.nama_penerbit,
            ROUND(AVG(u.rating),1) AS avg_rating,
            COUNT(u.id_ulasan)     AS jml_ulasan
     FROM buku
     LEFT JOIN penulis   ON buku.id_penulis   = penulis.id_penulis
     LEFT JOIN kategori  ON buku.id_kategori  = kategori.id_kategori
     LEFT JOIN penerbit  ON buku.id_penerbit  = penerbit.id_penerbit
     LEFT JOIN ulasan u  ON buku.id_buku      = u.id_buku
     WHERE buku.id_buku = $id_buku
     GROUP BY buku.id_buku"
);
$buku = mysqli_fetch_assoc($qBuku);
if (!$buku) { header("Location:index.php"); exit(); }

$qUlasan = mysqli_query($mysqli,
    "SELECT * FROM ulasan WHERE id_buku = $id_buku ORDER BY created_at DESC"
);

$msg  = isset($_GET['msg'])  ? $_GET['msg']  : "";
$type = isset($_GET['type']) ? $_GET['type'] : "success";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ulasan - <?= htmlspecialchars($buku['judul']) ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        .ulasan-wrap { width:85%; margin:30px auto 50px auto; }
        .back-link { display:inline-block; margin-bottom:20px; color:#DD9E59; font-weight:600; text-decoration:none; font-size:14px; }
        .back-link:hover { text-decoration:underline; }

        .book-detail-card { background:white; border-radius:14px; padding:24px; margin-bottom:24px; box-shadow:0 4px 18px rgba(0,0,0,0.08); display:flex; gap:24px; align-items:flex-start; }
        .book-cover-icon { font-size:60px; flex-shrink:0; }
        .book-meta { flex:1; }
        .book-meta h2 { color:#6a4c4c; font-size:22px; margin-bottom:10px; text-align:left; }
        .book-meta p { font-size:14px; color:#555; margin-bottom:5px; text-align:left; }
        .ringkasan-text { margin-top:12px; font-size:13px; color:#666; line-height:1.7; border-top:1px solid #f0e8d8; padding-top:10px; text-align:left; }

        .rating-agg-box { text-align:center; min-width:120px; border-left:1px solid #f0e8d8; padding-left:20px; }
        .rating-big-num { font-size:48px; font-weight:700; color:#f5a623; line-height:1; }
        .rating-big-stars { font-size:24px; color:#f5a623; letter-spacing:2px; margin:6px 0; }
        .rating-big-count { font-size:12px; color:#aaa; }
        .rating-empty-msg { font-size:12px; color:#aaa; font-style:italic; line-height:1.7; }

        .ulasan-form-wrap { background:white; border-radius:14px; padding:28px; margin-bottom:24px; box-shadow:0 4px 18px rgba(0,0,0,0.08); }
        .ulasan-form-wrap h3 { color:#6a4c4c; margin-bottom:20px; font-size:18px; text-align:left; }
        .u-form-group { margin-bottom:16px; text-align:left; }
        .u-form-group label { display:block; margin-bottom:6px; font-weight:600; font-size:13px; color:#444; }
        .u-form-group input[type="text"], .u-form-group textarea { width:100%; padding:10px 14px; border:1px solid #ddd; border-radius:8px; font-size:14px; font-family:inherit; box-sizing:border-box; transition:.2s; }
        .u-form-group input:focus, .u-form-group textarea:focus { border-color:#DD9E59; outline:none; }

        .star-picker { display:flex; gap:6px; margin-bottom:6px; }
        .star-picker span { font-size:36px; color:#ddd; cursor:pointer; transition:color .12s,transform .12s; line-height:1; }
        .star-picker span:hover { transform:scale(1.2); color:#f5a623; }
        .star-picker span.on { color:#f5a623; }
        .star-desc { font-size:12px; color:#999; font-style:italic; min-height:18px; margin-bottom:6px; }

        .btn-kirim { background:#DD9E59; color:white; border:none; padding:11px 26px; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; transition:.2s; }
        .btn-kirim:hover { background:#c4854a; }
        .btn-batal { margin-left:14px; color:#888; font-size:13px; text-decoration:none; font-weight:500; }

        .ulasan-list-wrap h3 { color:#6a4c4c; margin-bottom:16px; font-size:18px; text-align:left; }
        .ulasan-kosong { text-align:center; color:#aaa; font-size:13px; font-style:italic; padding:28px; border:1px dashed #ddd; border-radius:10px; }

        .ulasan-card { background:white; border-radius:12px; padding:18px 22px; margin-bottom:14px; box-shadow:0 3px 12px rgba(0,0,0,0.07); }
        .ulasan-card-header { display:flex; align-items:center; gap:12px; margin-bottom:12px; flex-wrap:wrap; }
        .u-avatar { width:42px; height:42px; border-radius:50%; background:#DD9E59; color:white; font-size:18px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .u-info { flex:1; text-align:left; }
        .u-info strong { display:block; font-size:14px; color:#333; }
        .u-stars { font-size:16px; letter-spacing:1px; margin-top:2px; }
        .star-5,.star-4 { color:#f5a623; }
        .star-3 { color:#f0c040; }
        .star-2 { color:#e08030; }
        .star-1 { color:#c0392b; }
        .u-right { display:flex; flex-direction:column; align-items:flex-end; gap:4px; }
        .u-time { font-size:11px; color:#aaa; }
        .u-badge { background:#fff4e6; color:#c4854a; font-size:11px; font-weight:600; padding:2px 8px; border-radius:20px; border:1px solid #f0dcc8; }
        .ulasan-isi { font-size:13px; color:#555; line-height:1.7; padding:10px 14px; background:#fafafa; border-left:3px solid #DD9E59; border-radius:0 6px 6px 0; margin-bottom:10px; text-align:left; }
        .ulasan-card-footer { text-align:right; }
        .btn-hapus-u { font-size:12px; color:#c0392b; text-decoration:none; font-weight:500; cursor:pointer; }
        .btn-hapus-u:hover { text-decoration:underline; }

        .toast { position:fixed; top:20px; right:20px; background:#27ae60; color:white; padding:12px 22px; border-radius:10px; font-weight:600; font-size:14px; box-shadow:0 6px 20px rgba(0,0,0,0.2); opacity:0; transform:translateY(-15px); transition:all .35s ease; z-index:9999; }
        .toast.show { opacity:1; transform:translateY(0); }
        .toast.error { background:#c0392b; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="logo">📚 Aplikasi Katalog Buku</div>
        <div class="menu">
            <a href="index.php">Home</a>
            <a href="kategori">Kategori</a>
            <a href="penerbit">Penerbit</a>
            <a href="penulis">Penulis</a>
        </div>
    </div>
</nav>

<div class="ulasan-wrap">

    <a href="index.php" class="back-link">← Kembali ke Daftar Buku</a>

    <!-- INFO BUKU -->
    <div class="book-detail-card">
        <div class="book-cover-icon">📖</div>
        <div class="book-meta">
            <h2><?= htmlspecialchars($buku['judul']) ?></h2>
            <p><strong>Penulis</strong> : <?= htmlspecialchars($buku['nama_penulis']) ?></p>
            <p><strong>Kategori</strong> : <?= htmlspecialchars($buku['nama_kategori']) ?></p>
            <p><strong>Penerbit</strong> : <?= htmlspecialchars($buku['nama_penerbit']) ?></p>
            <p><strong>Tahun</strong> : <?= $buku['tahun_terbit'] ?> &nbsp;|&nbsp; <strong>Halaman</strong> : <?= $buku['halaman'] ?></p>
            <p><strong>ISBN</strong> : <?= htmlspecialchars($buku['isbn']) ?></p>
            <p class="ringkasan-text"><?= nl2br(htmlspecialchars($buku['ringkasan'])) ?></p>
        </div>
        <div class="rating-agg-box">
            <?php if ($buku['avg_rating'] > 0): ?>
                <div class="rating-big-num"><?= number_format($buku['avg_rating'],1) ?></div>
                <div class="rating-big-stars">
                    <?php for($s=1;$s<=5;$s++) echo ($s<=round($buku['avg_rating']))?'★':'☆'; ?>
                </div>
                <div class="rating-big-count">dari <?= $buku['jml_ulasan'] ?> ulasan</div>
            <?php else: ?>
                <div class="rating-empty-msg">Belum ada rating.<br>Jadilah yang pertama!</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- FORM ULASAN -->
    <div class="ulasan-form-wrap">
        <h3>✏️ Tulis Ulasan</h3>
        <form method="post" action="ulasanAction.php">
            <input type="hidden" name="id_buku" value="<?= $id_buku ?>">

            <div class="u-form-group">
                <label>Nama Kamu</label>
                <input type="text" name="nama_reviewer" placeholder="Masukkan nama kamu" required>
            </div>

            <div class="u-form-group">
                <label>Rating</label>
                <div class="star-picker" id="starPicker">
                    <span onclick="setStar(1)">★</span>
                    <span onclick="setStar(2)">★</span>
                    <span onclick="setStar(3)">★</span>
                    <span onclick="setStar(4)">★</span>
                    <span onclick="setStar(5)">★</span>
                </div>
                <input type="hidden" name="rating" id="inputRating" value="0">
                <div class="star-desc" id="starDesc">Pilih rating di atas</div>
            </div>

            <div class="u-form-group">
                <label>Ulasan</label>
                <textarea name="ulasan" rows="4" placeholder="Ceritakan pengalamanmu membaca buku ini..." required></textarea>
            </div>

            <button type="submit" name="submit_ulasan" class="btn-kirim">Kirim Ulasan</button>
            <a href="index.php" class="btn-batal">Batal</a>
        </form>
    </div>

    <!-- DAFTAR ULASAN -->
    <div class="ulasan-list-wrap">
        <h3>💬 Semua Ulasan (<?= mysqli_num_rows($qUlasan) ?>)</h3>

        <?php if (mysqli_num_rows($qUlasan) == 0): ?>
            <div class="ulasan-kosong">Belum ada ulasan. Yuk tambahkan ulasanmu!</div>
        <?php endif; ?>

        <?php while ($u = mysqli_fetch_assoc($qUlasan)):
            $rv = (int)$u['rating'];
        ?>
        <div class="ulasan-card">
            <div class="ulasan-card-header">
                <div class="u-avatar"><?= strtoupper(substr($u['nama_reviewer'],0,1)) ?></div>
                <div class="u-info">
                    <strong><?= htmlspecialchars($u['nama_reviewer']) ?></strong>
                    <div class="u-stars star-<?= $rv ?>">
                        <?php for($s=1;$s<=5;$s++) echo ($s<=$rv)?'★':'☆'; ?>
                    </div>
                </div>
                <div class="u-right">
                    <span class="u-time">🕐 <?= date('d M Y, H:i', strtotime($u['created_at'])) ?></span>
                    <span class="u-badge">⭐ <?= $rv ?>/5</span>
                </div>
            </div>
            <div class="ulasan-isi"><?= nl2br(htmlspecialchars($u['ulasan'])) ?></div>
            <div class="ulasan-card-footer">
                <a href="#" class="btn-hapus-u" onclick="konfirmasiHapus(<?= $u['id_ulasan'] ?>, <?= $id_buku ?>); return false;">🗑 Hapus</a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

</div>

<?php if ($msg != ""): ?>
<div id="toast" class="toast <?= $type ?>"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<!-- POPUP HAPUS -->
<div id="popupHapus" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:999;align-items:center;justify-content:center;">
    <div style="background:white;border-radius:14px;padding:30px;width:300px;text-align:center;box-shadow:0 10px 30px rgba(0,0,0,0.3);">
        <div style="font-size:40px;margin-bottom:8px;">⚠️</div>
        <h3 style="color:#c0392b;margin-bottom:8px;font-size:16px;">Hapus Ulasan?</h3>
        <p style="color:#666;font-size:13px;margin-bottom:18px;">Ulasan yang dihapus tidak bisa dikembalikan.</p>
        <div style="display:flex;gap:10px;justify-content:center;">
            <button id="btnYaHapus" style="background:#c0392b;color:white;border:none;padding:9px 20px;border-radius:8px;cursor:pointer;font-weight:bold;font-size:13px;">Ya, Hapus</button>
            <button onclick="tutupPopup()" style="background:#eee;border:none;padding:9px 20px;border-radius:8px;cursor:pointer;font-size:13px;">Batal</button>
        </div>
    </div>
</div>

<script>
window.addEventListener('load', function(){
    var t = document.getElementById('toast');
    if(t){ setTimeout(()=>t.classList.add('show'),100); setTimeout(()=>t.classList.remove('show'),3500); }
});

var rLabels = {1:'😞 Buruk',2:'😐 Kurang',3:'🙂 Cukup',4:'😊 Bagus',5:'🤩 Luar biasa!'};
function setStar(n){
    document.getElementById('inputRating').value = n;
    document.querySelectorAll('#starPicker span').forEach(function(s,i){
        s.classList.toggle('on', i < n);
    });
    document.getElementById('starDesc').textContent = rLabels[n] || '';
}

var hapusId = null, hapusBukuId = null;
function konfirmasiHapus(uid, bid){
    hapusId = uid; hapusBukuId = bid;
    document.getElementById('popupHapus').style.display = 'flex';
}
function tutupPopup(){ document.getElementById('popupHapus').style.display = 'none'; }
document.getElementById('btnYaHapus').onclick = function(){
    window.location.href = 'deleteUlasan.php?id_ulasan='+hapusId+'&id_buku='+hapusBukuId;
};
</script>

</body>
</html>
