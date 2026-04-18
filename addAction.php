<?php
require_once("dbConnection.php");

if (isset($_POST['submit'])) {
    $judul        = mysqli_real_escape_string($mysqli, $_POST['judul']);
    $isbn         = mysqli_real_escape_string($mysqli, $_POST['isbn']);
    $tahun_terbit = mysqli_real_escape_string($mysqli, $_POST['tahun_terbit']);
    $halaman      = mysqli_real_escape_string($mysqli, $_POST['halaman']);
    $ringkasan    = mysqli_real_escape_string($mysqli, $_POST['ringkasan']);

    $id_penulis   = $_POST['id_penulis'] ?? '';
    $id_kategori  = $_POST['id_kategori'] ?? '';
    $id_penerbit  = $_POST['id_penerbit'] ?? '';

    // Validasi
    if (
        empty($judul) || empty($isbn) || empty($tahun_terbit) ||
        empty($halaman) || empty($ringkasan) ||
        empty($id_penulis) || empty($id_kategori) || empty($id_penerbit)
    ) {

        if (empty($id_penulis)) echo "<font color='red'>Penulis harus dipilih.</font><br>";
        if (empty($id_kategori)) echo "<font color='red'>Kategori harus dipilih.</font><br>";
        if (empty($id_penerbit)) echo "<font color='red'>Penerbit harus dipilih.</font><br>";

        echo "<br><a href='javascript:self.history.back();'>Kembali</a>";
        exit();
    }

    // Insert ke database
    $result = mysqli_query($mysqli,
        "INSERT INTO buku
        (judul, isbn, tahun_terbit, halaman, ringkasan, id_penulis, id_kategori, id_penerbit)
        VALUES
        ('$judul', '$isbn', '$tahun_terbit', '$halaman', '$ringkasan', '$id_penulis', '$id_kategori', '$id_penerbit')"
    );

    header("Location: index.php");
    exit();
}
?>
