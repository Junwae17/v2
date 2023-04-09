<?php

error_reporting(0);
session_start();
require 'koneksi.php';

$username = $_SESSION['username'];
$sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
$level = mysqli_fetch_assoc($sql)['level'];

$produk = mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN produk ON transaksi.produk =  produk.idproduk INNER JOIN user ON transaksi.user = user.username WHERE status NOT LIKE 'K'");

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
            alert('Anda tidak dapat mengakses halaman ini!!!')
            document.location.href = 'index.php'
        </script>
    ";
}

if (isset($_POST['save'])) {
    if (updatecart($_POST) > 0) {
        header('location: cart.php');
    }
}

if (isset($_POST['checkout'])) {
    if (checkout($_POST) > 0) {
        echo "
            <script>
                alert('transaksi berhasil')
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

    <h1 class="title">Orders</h1>

    <div class="title">
        <table border="3" style="margin-bottom: 50px;">
            <thead>
                <th>No</th>
                <th>Akun Customers</th>
                <th>Gambar Produk</th>
                <th>Nama Produk</th>
                <th>Harga Produk</th>
                <th>Kuantitas</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($produk as $data) {
                ?>
                    <form action="" method="post">
                        <tr>
                            <td>
                                <?= $no++; ?>
                                <input type="hidden" name="idtransaksi[]" value="<?= $data['idtransaksi']; ?>">
                                <input type="hidden" name="produk" value="<?= $data['idproduk']; ?>">
                                <input type="hidden" name="user" value="<?= $username; ?>">
                            </td>
                            <td><?= $data['user']; ?></td>
                            <td><img src="img/<?= $data['gambarproduk']; ?>" alt="<?= $data['namaproduk']; ?>" width="200"></td>
                            <td><?= $data['namaproduk']; ?></td>
                            <td>Rp<?= $data['hargaproduk']; ?></td>
                            <td><input type="number" name="kuantitas" value="<?= $data['jumlah']; ?>" readonly></td>
                            <td><?= $data['hargaproduk'] * $data['jumlah']; ?></td>
                            <td>

                                <?php

                                if ($data['status'] === 'acc') {
                                    echo "<h3 style='color: green;'>Accepted</h3>";
                                } elseif ($data['status'] === 'reject') {
                                    echo "<h3 style='color: red;'>Rejected</h3>";
                                } else {
                                    echo '
                                    <button>
                                        <a href="acc.php?id=' . $data['idtransaksi'] . '" style="color: black; text-decoration: none;">Accept</a>
                                    </button>
                                    <button>
                                        <a href="reject.php?id=' . $data['idtransaksi'] . '" style="color: black; text-decoration: none;">Reject</a>
                                    </button>
                                    ';
                                }

                                ?>


                            </td>
                        </tr>

                    <?php } ?>
            </tbody>
            </form>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>

</html>