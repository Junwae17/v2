<?php

$koneksi = mysqli_connect('localhost','root','', 'teslsp1');

if (!$koneksi) {
    echo "koneksi tidak berhasil";
}

function uploadgambar()
{
    $namafile = $_FILES['gambar']['name'];
    $ukuranfile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpname = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo "
            <script>
                alert('Pilih gambar terlebih dahulu')
                document.location.href = 'add.php'
            </script>
        ";

        return false;
    }

    $ekstensiValid = ['jpg', 'png', 'jpeg'];
    $ekstensigambar = explode('.', $namafile);
    $ekstensigambar = strtolower(end($ekstensigambar));

    if (!in_array($ekstensigambar, $ekstensiValid)) {
        echo "
            <script>
                alert('file yang anda upload tidak valid!!!')
            </script>
        ";

        return false;
    }

    if ($ukuranfile > 10000000) {
        echo "
            <script>
                alert('ukuran file terlalu besar')
            </script>
        ";

        return false;
    }

    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensigambar;
    move_uploaded_file($tmpname, 'img/' . $namafilebaru);

    return $namafilebaru;
}

function addproduk()
{
    global $koneksi;

    $gambarproduk = uploadgambar();
    $namaproduk = $_POST['namaproduk'];
    $stokproduk = $_POST['stokproduk'];
    $hargaproduk = $_POST['hargaproduk'];
    $deskripsi = $_POST['deskripsi'];

    $query = mysqli_query($koneksi, "INSERT INTO produk (gambarproduk, namaproduk, stokproduk, hargaproduk, deskripsiproduk) VALUES ('$gambarproduk', '$namaproduk', '$stokproduk', '$hargaproduk', '$deskripsi')");

    return mysqli_affected_rows($koneksi);
}

function edit()
{
    global $koneksi;

    $idproduk = $_POST['idproduk'];
    $namaproduk = $_POST['namaproduk'];
    $stokproduk = $_POST['stokproduk'];
    $hargaproduk = $_POST['hargaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $error = $_FILES['gambar']['error'];

    if ($error === 4) {
        $gambarproduk = $_POST['gambarlama'];
    } else {
        $gambarproduk = uploadgambar();
    }

    $query = mysqli_query($koneksi, "
                        UPDATE produk SET
                        gambarproduk = '$gambarproduk',
                        namaproduk = '$namaproduk',
                        stokproduk = '$stokproduk',
                        hargaproduk = '$hargaproduk',
                        deskripsiproduk = '$deskripsi'
                        WHERE idproduk = '$idproduk'");

    return mysqli_affected_rows($koneksi);
}

function checkout()
{
    global $koneksi;

    $idproduk = $_POST['idproduk'];
    $user = $_POST['user'];
    $jumlah = $_POST['kuantitas'];
    $alamat = $_POST['alamat'];
    $nomor = $_POST['nomor'];
    $stok = $_POST['stok'];
    

    $sql = mysqli_query($koneksi, "INSERT INTO transaksi (user, produk, jumlah, alamatpenerima, nomorhp, status) VALUES ('$user', '$idproduk', '$jumlah', '$alamat', '$nomor', 'P')");

    $prdk = mysqli_query($koneksi, "UPDATE produk SET
                                    stokproduk = stokproduk - $jumlah
                                    WHERE idproduk = '$idproduk'");

    return mysqli_affected_rows($koneksi);
}
