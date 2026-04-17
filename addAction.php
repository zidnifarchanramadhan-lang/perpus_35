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

    if (
        empty($judul) || empty($isbn) || empty($tahun_terbit) ||
        empty($halaman) || empty($ringkasan) ||
        empty($id_penulis) || empty($id_kategori) || empty($id_penerbit)
    ) {
        $pesan = "";
        if (empty($judul)) $pesan .= "<li>• Judul Buku</li>";
        if (empty($isbn)) $pesan .= "<li>• ISBN</li>";
        if (empty($tahun_terbit)) $pesan .= "<li>• Tahun Terbit</li>";
        if (empty($halaman)) $pesan .= "<li>• Halaman</li>";
        if (empty($ringkasan)) $pesan .= "<li>• Ringkasan</li>";
        if (empty($id_penulis)) $pesan .= "<li>• Penulis</li>";
        if (empty($id_kategori)) $pesan .= "<li>• Kategori</li>";
        if (empty($id_penerbit)) $pesan .= "<li>• Penerbit</li>";

        echo "
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { background: #f0f0f0; font-family: Arial, sans-serif; }
            .modal-overlay {
                position: fixed;
                top: 0; left: 0;
                width: 100%; height: 100%;
                background: rgba(0,0,0,0.4);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            }
            .modal-box {
                background: white;
                border-radius: 16px;
                padding: 40px 35px;
                max-width: 420px;
                width: 90%;
                text-align: center;
                box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            }
            .modal-icon { font-size: 52px; margin-bottom: 10px; }
            .modal-box h2 { color: #e74c3c; font-size: 22px; margin-bottom: 8px; }
            .modal-box p { color: #555; font-size: 14px; margin-bottom: 16px; }
            .modal-box ul {
                text-align: left;
                background: #fff5f5;
                border-left: 4px solid #e74c3c;
                padding: 12px 12px 12px 32px;
                border-radius: 8px;
                color: #e74c3c;
                margin-bottom: 24px;
                list-style: none;
            }
            .modal-box ul li { margin: 5px 0; font-size: 14px; }
            .btn-kembali {
                background: #e74c3c;
                color: white;
                border: none;
                padding: 13px 32px;
                border-radius: 10px;
                font-size: 15px;
                font-weight: bold;
                cursor: pointer;
                transition: 0.3s;
            }
            .btn-kembali:hover { background: #c0392b; }
        </style>

        <div class='modal-overlay'>
            <div class='modal-box'>
                <div class='modal-icon'>⚠️</div>
                <h2>Form Belum Lengkap!</h2>
                <p>Harap isi semua field berikut sebelum menyimpan:</p>
                <ul>$pesan</ul>
                <button class='btn-kembali' onclick='history.back()'>Kembali &amp; Isi Form</button>
            </div>
        </div>
        ";
        exit();
    }

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