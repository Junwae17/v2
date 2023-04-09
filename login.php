<?php

session_start();
require 'koneksi.php';

if (isset($_SESSION['username'])) {
    header('location: index.php');
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");
    $row = mysqli_fetch_assoc($sql);

    if (mysqli_num_rows($sql) > 0) {
        if ($row['level'] == 'member') {
            $_SESSION['username'] = $row['username'];
            echo '
                <script>
                    alert("Login Berhasil!!!")
                    document.location.href = "index.php"
                </script>
            ';
        } elseif ($row['level'] == 'admin') {
            $_SESSION['username'] = $row['username'];
            echo '
                <script>
                    alert("Login Berhasil!!!")
                    document.location.href = "admin.php"
                </script>
            ';
        }
    } else {
        echo '
            <script>
                alert("Login Gagal!!!")
                document.location.href = "login.php"
            </script>
        ';
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
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="title">
        <table border="3">
            <thead>
                <th colspan="2">Login</th>
            </thead>
            <tbody>
                <form action="" method="post">
                    <tr>
                        <td>Username</td>
                        <td><input type="text" name="username" placeholder="Masukkan username"></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type="text" name="password" placeholder="Masukkan password"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <center>
                                <button type="submit" name="submit">Login</button>
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