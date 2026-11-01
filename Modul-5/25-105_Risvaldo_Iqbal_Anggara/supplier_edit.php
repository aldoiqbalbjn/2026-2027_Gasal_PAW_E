<?php

include "koneksi.php";

function h($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    http_response_code(400);
    exit("ID supplier tidak valid.");
}

$pesan = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $telp = trim($_POST['telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    if ($nama === '' || $telp === '' || $alamat === '') {
        $pesan = "Semua data wajib diisi.";
    } else {
        $stmt = mysqli_prepare(
            $koneksi,
            "UPDATE supplier SET nama = ?, telp = ?, alamat = ? WHERE id = ?"
        );
        if (!$stmt) {
            http_response_code(500);
            exit("Gagal menyiapkan pembaruan data supplier: " . h(mysqli_error($koneksi)));
        }

        mysqli_stmt_bind_param($stmt, "sssi", $nama, $telp, $alamat, $id);

        if (!mysqli_stmt_execute($stmt)) {
            http_response_code(500);
            exit("Gagal memperbarui data supplier: " . h(mysqli_stmt_error($stmt)));
        }

        mysqli_stmt_close($stmt);
        header("Location: supplier.php");
        exit;
    }

    $data = ['nama' => $nama, 'telp' => $telp, 'alamat' => $alamat];
} else {
    $stmt = mysqli_prepare($koneksi, "SELECT nama, telp, alamat FROM supplier WHERE id = ?");
    if (!$stmt) {
        http_response_code(500);
        exit("Gagal menyiapkan data supplier: " . h(mysqli_error($koneksi)));
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    if (!mysqli_stmt_execute($stmt)) {
        http_response_code(500);
        exit("Gagal mengambil data supplier: " . h(mysqli_stmt_error($stmt)));
    }

    $hasil = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($hasil);
    mysqli_stmt_close($stmt);

    if (!$data) {
        http_response_code(404);
        exit("Data supplier tidak ditemukan.");
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Data Supplier</title>

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

        .pesan {
            color: #d9534f;
        }
    </style>
</head>

<body>
    <h2>Edit Data Supplier</h2>
    <hr>
    <br>
    <?php if ($pesan !== '') { ?>
        <p class="pesan"><?= h($pesan); ?></p>
    <?php } ?>

    <form method="POST">
        <label>Nama</label>
        <input type="text" name="nama" value="<?= h($data['nama']); ?>" required>
        <br>

        <label>Telp</label>
        <input type="text" name="telp" value="<?= h($data['telp']); ?>" required>
        <br>

        <label>Alamat</label>
        <input type="text" name="alamat" value="<?= h($data['alamat']); ?>" required>
        <br><br>

        <button type="submit">Simpan Perubahan</button>
        <a href="supplier.php" class="batal">Batal</a>
    </form>
</body>
</html>
