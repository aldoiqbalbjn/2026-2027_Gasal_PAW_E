<?php

include "koneksi.php";

$query = mysqli_query($koneksi, "SELECT * FROM supplier");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Master Supplier</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        h2 {
            color: #2c7da0;
        }

        .tambah {
            background-color: #7cb342;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            float: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #d9edf7;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .edit {
            background-color: #f0ad4e;
            color: white;
            padding: 7px 10px;
            text-decoration: none;
            border-radius: 4px;
        }

        .hapus {
            background-color: #d9534f;
            color: white;
            padding: 7px 10px;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <h2>Data Master Supplier</h2>

    <a href="tambah_data.php" class="tambah">
        Tambah Data
    </a>

    <table>

        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Tindakan</th>
        </tr>

        <?php
        $no = 1;

        while ($data = mysqli_fetch_assoc($query)) {
        ?>

        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($data['telp'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($data['alamat'], ENT_QUOTES, 'UTF-8'); ?></td>

            <td>
                <a href="supplier_edit.php?id=<?= (int) $data['id']; ?>" class="edit">Edit</a>
                <form method="POST" action="supplier_hapus.php" style="display: inline;"
                    onsubmit="return confirm('anda yakin akan menghapus supplier ini?');">
                    <input type="hidden" name="id" value="<?= (int) $data['id']; ?>">
                    <button type="submit" class="hapus">Hapus</button>
                </form>
            </td>
        </tr>

        <?php
        }
        ?>

    </table>

</body>
</html>