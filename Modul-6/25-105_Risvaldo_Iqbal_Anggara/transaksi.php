
<?php
include "koneksi.php";

$query = mysqli_query($koneksi, "
    SELECT transaksi.*, pelanggan.nama AS nama_pelanggan
    FROM transaksi
    JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
    ORDER BY transaksi.id ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi</title>
</head>
<body>

<h2>Data Master Transaksi</h2>

        <a href="barang.php" class="secondary">Data Barang</a>
<br>
<br>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Tanggal Transaksi</th>
        <th>Pelanggan</th>
        <th>Keterangan</th>
        <th>Total</th>
        <th>Aksi</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($query)) { ?>
    <tr>
        <td><?= $row['id']; ?></td>
        <td><?= $row['waktu_transaksi']; ?></td>
        <td><?= htmlspecialchars($row['nama_pelanggan']); ?></td>
        <td><?= htmlspecialchars($row['keterangan'] ?? ''); ?></td>
        <td>Rp <?= number_format($row['total'], 0, ',', '.'); ?></td>
        <td>
            <a href="detail_transaksi.php?id=<?= $row['id']; ?>">
                Lihat Detail
            </a>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
</html>
