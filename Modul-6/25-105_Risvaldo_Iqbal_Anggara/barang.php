
<?php
include "koneksi.php";

// PROSES HAPUS BARANG
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hapus'])) {

    $barang_id = (int) $_POST['barang_id'];

    // Cek apakah barang digunakan dalam transaksi_detail
    $cek = mysqli_prepare($koneksi, "
        SELECT COUNT(*) AS jumlah
        FROM transaksi_detail
        WHERE barang_id = ?
    ");

    mysqli_stmt_bind_param($cek, "i", $barang_id);
    mysqli_stmt_execute($cek);

    $hasil = mysqli_fetch_assoc(
        mysqli_stmt_get_result($cek)
    );

    // Jika barang sedang digunakan
    if ($hasil['jumlah'] > 0) {

        echo "<script>
            alert('Barang sedang digunakan pada transaksi dan tidak dapat dihapus!');
            window.location='barang.php';
        </script>";
        exit;

    } else {

        // Jika belum digunakan, hapus barang
        $hapus = mysqli_prepare($koneksi, "
            DELETE FROM barang WHERE id = ?
        ");

        mysqli_stmt_bind_param($hapus, "i", $barang_id);

        if (mysqli_stmt_execute($hapus)) {

            echo "<script>
                alert('Barang berhasil dihapus!');
                window.location='barang.php';
            </script>";
            exit;

        } else {

            echo "<script>
                alert('Barang gagal dihapus!');
                window.location='barang.php';
            </script>";
            exit;

        }
    }
}

// AMBIL DATA BARANG
$query = mysqli_query($koneksi, "
    SELECT barang.*,
           supplier.nama AS nama_supplier
    FROM barang
    JOIN supplier ON barang.supplier_id = supplier.id
    ORDER BY barang.id ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Data Barang</h1>

    <div class="nav">
        <a href="transaksi.php">Data Transaksi</a>
        <a href="barang.php" class="secondary">Data Barang</a>
    </div>

    <div class="card">

        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Supplier</th>
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

                    <form method="POST" action="barang.php"
                        onsubmit="return confirm('Apakah kamu yakin ingin menghapus barang ini?');">

                        <input type="hidden"
                            name="barang_id"
                            value="<?= $row['id']; ?>">

                        <button type="submit"
                            name="hapus"
                            class="btn danger">
                            Hapus
                        </button>

                    </form>

                </td>
            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>
