<?php
require_once("dbConnection.php");

if (isset($_POST['submit_ulasan'])) {
    $id_buku       = (int)$_POST['id_buku'];
    $nama_reviewer = mysqli_real_escape_string($mysqli, trim($_POST['nama_reviewer']));
    $rating        = (int)$_POST['rating'];
    $ulasan        = mysqli_real_escape_string($mysqli, trim($_POST['ulasan']));

    if (empty($nama_reviewer) || empty($ulasan) || $rating < 1 || $rating > 5) {
        header("Location:ulasan.php?id_buku=$id_buku&msg=Semua field harus diisi dengan benar&type=error");
        exit();
    }

    $q = mysqli_query($mysqli,
        "INSERT INTO ulasan (id_buku, nama_reviewer, rating, ulasan)
         VALUES ($id_buku, '$nama_reviewer', $rating, '$ulasan')"
    );

    if ($q) {
        header("Location:ulasan.php?id_buku=$id_buku&msg=Ulasan berhasil ditambahkan&type=success");
    } else {
        header("Location:ulasan.php?id_buku=$id_buku&msg=Gagal menambahkan ulasan&type=error");
    }
    exit();
}
header("Location:index.php");
