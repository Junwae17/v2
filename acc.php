<?php

require 'koneksi.php';

$id = $_GET['id'];

if (!$id) {
    header('location: logout.php');
}

$query = mysqli_query($koneksi, "UPDATE transaksi SET
                                status = 'acc'
                                WHERE idtransaksi = '$id'");

if (mysqli_affected_rows($koneksi) > 0) {
    echo "
        <script>
            alert('Transaksi Accepted')
            document.location.href = 'orders.php'
        </script>
    ";
}
