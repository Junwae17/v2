<?php

error_reporting(0);
session_start();
require 'koneksi.php';

$username = $_SESSION['username'];
$sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
foreach ($sql as $usr) {
    $level = $usr['level'];
    $user = $usr['username'];
    $iduser = $usr['id'];
}
$idproduk = $_GET['id'];

$produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE idproduk = '$idproduk'");

if ($level == 'admin') {
    header('location: admin.php');
}

if (!$username) {
    echo "
        <script>
            alert('Harap Login Terlebih Dahulu')
            document.location.href = 'login.php'
        </script>
    ";
}

if (isset($_POST['co'])) {
    if (checkout($_POST) > 0) {
        echo "
            <script>
                alert('transaksi berhasil')
                document.location.href = 'index.php'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('transaksi gagal')
                document.location.href = 'index.php'
            </script>
        ";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        body {
            background-color: grey;
        }

        .title {
            padding-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        td,
        th {
            border: 3px solid black;
        }

        table {
            background-color: white;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">E-Commerce</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <?php
                    if (isset($username)) {
                        echo '
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                ';
                    } else {
                        echo '
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                ';
                    }
                    ?>

                </ul>
            </div>
        </div>
    </nav>

    <h1 class="title">Order Form</h1>

    <div class="title">
        <table border="3">
            <thead>
                <th colspan="6">
                    <center>
                        Informasi Produk
                    </center>
                </th>
            </thead>
            <thead>
                <th>No</th>
                <th>Gambar Produk</th>
                <th>Nama Produk</th>
                <th>Harga Produk</th>
                <th>Kuantitas</th>
            </thead>
            <form action="" method="POST">
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($produk as $data) {
                    ?>
                        <tr>
                            <td>
                                <?= $no++; ?>
                                <input type="hidden" name="idproduk" value="<?= $idproduk; ?>">
                            </td>
                            <td><img src="img/<?= $data['gambarproduk']; ?>" alt="<?= $data['namaproduk']; ?>" width="200"></td>
                            <td><?= $data['namaproduk']; ?></td>
                            <td>Rp<?= $data['hargaproduk']; ?></td>
                            <td>
                                <input type="number" name="kuantitas" value="1" min="1" max="<?= $data['stokproduk']; ?>" required>
                                <input type="hidden" name="stok" value="<?= $data['stokproduk']; ?>">
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
        </table>
    </div>

    <div class="title">
        <table border="3" style="margin-bottom: 50px;">
            <thead>
                <th colspan="6">
                    <center>
                        Informasi Customer
                    </center>
                </th>
            </thead>
            <tbody>
                <tr>
                    <td>Account Pembeli</td>
                    <td> : </td>
                    <td>
                        <input type="text" name="user" value="<?= $user; ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td>Alamat Pembeli</td>
                    <td> : </td>
                    <td>
                        <textarea name="alamat" cols="30" rows="5"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Nomor Telepon Pembeli</td>
                    <td> : </td>
                    <td>
                        <input type="number" name="nomor">
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <th colspan="3">
                    <center>
                        <button type="submit" name="co">Checkout</button>
                    </center>
                </th>
            </tfoot>
            </form>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>

</html>