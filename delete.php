<?php

require 'koneksi.php';

$id = $_GET['idproduk'];

if (!$id) {
    header('location: logout.php');
}

$query = mysqli_query($koneksi, "DELETE FROM produk WHERE idproduk = '$id'");

if (mysqli_affected_rows($koneksi) > 0) {
    echo "
        <script>
            alert('produk berhasil dihapus!')
            document.location.href = 'admin.php'
        </script>
    ";
}
