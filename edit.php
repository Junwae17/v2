<?php

require 'koneksi.php';
session_start();

$id = $_GET['idproduk'];

if (!$id) {
    header('location: logout.php');
}

$user = $_SESSION['username'];

if (!$user) {
    echo "
        <script>
            alert('Harap Login Terlebih Dahulu')
            document.location.href = 'login.php'
        </script>
    ";
}

$sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$user'");
$level = mysqli_fetch_assoc($sql)['level'];

if ($level == 'member') {
    echo "
        <script>
            alert('Anda tidak dapat mengakses halaman ini!!!')
            document.location.href = 'index.php'
        </script>
    ";
}

$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE idproduk = '$id'");
foreach ($query as $data) {
    $id = $data['idproduk'];
    $gambar = $data['gambarproduk'];
    $nama = $data['namaproduk'];
    $stok = $data['stokproduk'];
    $harga = $data['hargaproduk'];
    $deskripsi = $data['deskripsiproduk'];
}

if (isset($_POST['submit'])) {
    if (edit($_POST) > 0) {
        echo "
            <script>
                alert('Produk berhasil diubah')
                document.location.href = 'admin.php'
            </script>
        ";
    } else {
        echo "
        <script>
            alert('Produk gagal diubah')
            document.location.href = 'admin.php'
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
                        <a class="nav-link" href="#">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <h1 class="title">Edit Product</h1>

    <div class="title">
        <table border="3">
            <thead>
                <th colspan="2">
                    <center>
                        <img src="img/<?= $gambar; ?>" alt="<?= $nama; ?>">
                    </center>
                </th>
            </thead>
            <tbody>
                <form action="" method="post" enctype="multipart/form-data">
                    <tr>
                        <td>
                            Gambar Produk
                        </td>
                        <td>
                            <input type="file" name="gambar">
                            <input type="hidden" name="gambarlama" value="<?= $gambar ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Nama Produk</td>
                        <td>
                            <input type="hidden" name="idproduk" value="<?= $id; ?>">
                            <input type="text" name="namaproduk" value="<?= $nama; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Stok Produk</td>
                        <td><input type="number" name="stokproduk" value="<?= $stok; ?>"></td>
                    </tr>
                    <tr>
                        <td>Harga Produk</td>
                        <td><input type="number" name="hargaproduk" value="<?= $harga; ?>"></td>
                    </tr>
                    <tr>
                        <td>Deskripsi Produk</td>
                        <td><textarea name="deskripsi" rows="3"><?= $deskripsi; ?></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <center>
                                <button type="submit" name="submit">Edit</button>
                            </center>
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>

</html>