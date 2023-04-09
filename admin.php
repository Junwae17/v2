<?php
session_start();
require 'koneksi.php';

$username = $_SESSION['username'];
$sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
$level = mysqli_fetch_assoc($sql)['level'];

if (!$username) {
    echo "
        <script>
            alert('Harap Login Terlebih Dahulu')
            document.location.href = 'login.php'
        </script>
    ";
}

if ($level == 'member') {
    echo "
        <script>
            alert('maaf anda bukan admin!!!')
            document.location.href = 'index.php'
        </script>
    ";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add.php">Add Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <h1 class="title">Halo, Selamat Datang Admin</h1>

    <div class="title">
        <table border="3">
            <thead>
                <th>No</th>
                <th>Gambar Produk</th>
                <th>Nama Produk</th>
                <th>Stok Produk</th>
                <th>Harga Produk</th>
                <th>Deskripsi Produk</th>
                <th>Aksi</th>
            </thead>

            <?php

            $no = 1;
            $sql = mysqli_query($koneksi, "SELECT * FROM produk");

            ?>

            <tbody>
                <?php foreach ($sql as $data) { ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><img src="img/<?= $data['gambarproduk']; ?>" alt="<?= $data['namaproduk']; ?>" width="200"></td>
                        <td><?= $data['namaproduk']; ?></td>
                        <td><?= $data['stokproduk']; ?></td>
                        <td>Rp<?= $data['hargaproduk']; ?></td>
                        <td><?= $data['deskripsiproduk']; ?></td>
                        <td>
                            <button><a href="edit.php?idproduk=<?= $data['idproduk']; ?>" style="color: black; text-decoration: none;">Edit</a></button>
                            <button><a href="delete.php?idproduk=<?= $data['idproduk']; ?>" style="color: black; text-decoration: none;">Delete</a></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>

</html>