
<?php
include "koneksi.php";

$query = mysqli_query($koneksi, "
    SELECT barang.*,
           supplier.nama AS nama_supplier,
           (
               SELECT COUNT(*)
               FROM transaksi_detail
               WHERE transaksi_detail.barang_id = barang.id
           ) AS jumlah_pemakaian
    FROM barang
    JOIN supplier ON barang.supplier_id = supplier.id
    ORDER BY barang.id ASC
");

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}

$pesan = $_GET['pesan'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h1>Data Barang</h1>

    <div class="nav">
        <a href="transaksi.php" class="secondary">Data Transaksi</a>
    </div>

    <?php if ($pesan == 'terhapus') { ?>
        <div class="alert">
            Barang berhasil dihapus!
        </div>
    <?php } ?>

    <?php if ($pesan == 'digunakan') { ?>
        <div class="alert error">
            Barang tidak dapat dihapus karena masih digunakan pada transaksi!
        </div>
    <?php } ?>

    <?php if ($pesan == 'gagal') { ?>
        <div class="alert error">
            Barang gagal dihapus!
        </div>
    <?php } ?>

    <div class="card">

        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Supplier</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($query)) { ?>

            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['kode_barang']); ?></td>
                <td><?= htmlspecialchars($row['nama_barang']); ?></td>
                <td>
                    Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                </td>
                <td><?= $row['stok']; ?></td>
                <td><?= htmlspecialchars($row['nama_supplier']); ?></td>

                <td>
                    <?php if ($row['jumlah_pemakaian'] > 0) { ?>
                        <span style="color:red;">
                            Sudah digunakan
                        </span>
                    <?php } else { ?>
                        <span style="color:green;">
                            Belum digunakan
                        </span>
                    <?php } ?>
                </td>

                <td>
                    <?php if ($row['jumlah_pemakaian'] == 0) { ?>

                        <form action="hapus_barang.php"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus barang ini?');">

                            <input type="hidden"
                                   name="barang_id"
                                   value="<?= $row['id']; ?>">

                            <button class="btn danger" type="submit">
                                Hapus
                            </button>

                        </form>

                    <?php } else { ?>

                        <button class="btn secondary" disabled>
                            Tidak bisa dihapus
                        </button>

                    <?php } ?>
                </td>
            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>
