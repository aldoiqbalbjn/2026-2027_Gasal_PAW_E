<?php

include "koneksi.php";

if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    mysqli_query(
        $koneksi,
        "INSERT INTO supplier (nama, telp, alamat)
         VALUES ('$nama', '$telp', '$alamat')"
    );

    header("Location: supplier.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Supplier</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        h2 {
            color: #2c7da0;
        }

        form {
            width: 500px;
        }

        label {
            display: inline-block;
            width: 100px;
            margin-bottom: 15px;
        }

        input {
            padding: 10px;
            width: 300px;
            margin-bottom: 10px;
        }

        button, a {
            padding: 10px 15px;
            text-decoration: none;
            border: none;
            color: white;
            border-radius: 4px;
        }

        button {
            background-color: #7cb342;
        }

        .batal {
            background-color: #d9534f;
        }
    </style>
</head>

<body>

    <h2>Tambah Data Master Supplier Baru</h2>
    <hr>
    <br>
    <form method="POST">

        <label>Nama</label>
        <input type="text" name="nama" placeholder="Nama" required>
        <br>

        <label>Telp</label>
        <input type="text" name="telp" placeholder="Telp" required>
        <br>

        <label>Alamat</label>
        <input type="text" name="alamat" placeholder="Alamat" required>
        <br><br>

        <button type="submit" name="simpan">
            Simpan
        </button>

        <a href="supplier.php" class="batal">
            Batal
        </a>

    </form>

</body>
</html>