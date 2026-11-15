
<?php
include "koneksi.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$transaksi = mysqli_query($koneksi, "
    SELECT transaksi.*, pelanggan.nama AS nama_pelanggan
    FROM transaksi
    JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
    WHERE transaksi.id = $id
");

$data_transaksi = mysqli_fetch_assoc($transaksi);

if (!$data_transaksi) {
    die("Transaksi tidak ditemukan!");
}

$detail = mysqli_query($koneksi, "
    SELECT transaksi_detail.*, barang.kode_barang,
           barang.nama_barang
    FROM transaksi_detail
    JOIN barang ON transaksi_detail.barang_id = barang.id
    WHERE transaksi_detail.transaksi_id = $id
");

$barang = mysqli_query($koneksi, "
    SELECT * FROM barang
    WHERE id NOT IN (
        SELECT barang_id
        FROM transaksi_detail
        WHERE transaksi_id = $id
    )
    ORDER BY nama_barang ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
</head>
<body>

<a href="transaksi.php">← Kembali ke Transaksi</a>

<h2>Master Transaksi #<?= $data_transaksi['id']; ?></h2>

<p>
    <b>Tanggal:</b>
    <?= $data_transaksi['waktu_transaksi']; ?>
</p>

<p>
    <b>Pelanggan:</b>
    <?= htmlspecialchars($data_transaksi['nama_pelanggan']); ?>
</p>

<p>
    <b>Total:</b>
    Rp <?= number_format($data_transaksi['total'], 0, ',', '.'); ?>
</p>

<hr>

<h2>Detail Barang Transaksi</h2>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Subtotal</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($detail)) { ?>
    <tr>
        <td><?= htmlspecialchars($row['kode_barang']); ?></td>
        <td><?= htmlspecialchars($row['nama_barang']); ?></td>
        <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
        <td><?= $row['qty']; ?></td>
        <td>
            Rp <?= number_format($row['harga'] * $row['qty'], 0, ',', '.'); ?>
        </td>
    </tr>
    <?php } ?>
</table>

<h2>Tambah Detail Transaksi</h2>

<div class="form-box">

<form action="simpan_detail.php" method="POST">

    <input type="hidden" name="transaksi_id"
           value="<?= $data_transaksi['id']; ?>">

    <label>Pilih Barang:</label><br>

    <select name="barang_id" required>
        <option value="">-- Pilih Barang --</option>

        <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
            <option value="<?= $b['id']; ?>">
                <?= htmlspecialchars($b['kode_barang']); ?>
                - <?= htmlspecialchars($b['nama_barang']); ?>
                (Rp <?= number_format($b['harga'], 0, ',', '.'); ?>)
            </option>
        <?php } ?>

    </select>

    <br>

    <label>Jumlah Barang (Qty):</label><br>
    <input type="number" name="qty" min="1" required>

    <br>

    <button type="submit">Simpan Detail</button>

</form>

</div>

</body>
</html>
