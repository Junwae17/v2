<?php

require 'koneksi.php';

$id = $_GET['id'];

if (!$id) {
    header('location: logout.php');
}

$data = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE idtransaksi = '$id'");
foreach ($data as $row) {
    $jmlh = $row['jumlah'];
    $idproduk = $row['produk'];
}

$prdk = mysqli_query($koneksi, "UPDATE produk SET
                                stokproduk = stokproduk + $jmlh
                                WHERE idproduk = '$idproduk'");

$query = mysqli_query($koneksi, "UPDATE transaksi SET
                                status = 'reject'
                                WHERE idtransaksi = '$id'");

if (mysqli_affected_rows($koneksi) > 0) {
    echo "
        <script>
            alert('Transaksi Rejected')
            document.location.href = 'orders.php'
        </script>
    ";
}
