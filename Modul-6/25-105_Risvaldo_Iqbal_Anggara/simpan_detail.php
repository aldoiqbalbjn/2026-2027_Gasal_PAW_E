
<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: transaksi.php");
    exit;
}

$transaksi_id = (int) $_POST['transaksi_id'];
$barang_id = (int) $_POST['barang_id'];
$qty = (int) $_POST['qty'];

if ($transaksi_id <= 0 || $barang_id <= 0 || $qty <= 0) {
    die("Input tidak valid!");
}

mysqli_begin_transaction($koneksi);

try {

    // 1. Mengambil harga barang dari database
    $stmt = mysqli_prepare($koneksi,
        "SELECT harga FROM barang WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $barang_id);
    mysqli_stmt_execute($stmt);

    $barang = mysqli_fetch_assoc(
        mysqli_stmt_get_result($stmt)
    );

    if (!$barang) {
        throw new Exception("Barang tidak ditemukan!");
    }

    $harga = $barang['harga'];

    // 2. Memeriksa barang yang sudah dimasukkan
    $stmt = mysqli_prepare($koneksi, "
        SELECT barang_id
        FROM transaksi_detail
        WHERE transaksi_id = ? AND barang_id = ?
    ");

    mysqli_stmt_bind_param(
        $stmt, "ii", $transaksi_id, $barang_id
    );

    mysqli_stmt_execute($stmt);

    if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) > 0) {
        throw new Exception("Barang sudah ada dalam transaksi!");
    }

    $stmt = mysqli_prepare($koneksi, "
        INSERT INTO transaksi_detail
        (transaksi_id, barang_id, harga, qty)
        VALUES (?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param(
        $stmt, "iiii",
        $transaksi_id, $barang_id, $harga, $qty
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Gagal menyimpan detail transaksi!");
    }

    $stmt = mysqli_prepare($koneksi, "
        UPDATE transaksi
        SET total = (
            SELECT COALESCE(SUM(harga * qty), 0)
            FROM transaksi_detail
            WHERE transaksi_id = ?
        )
        WHERE id = ?
    ");

    mysqli_stmt_bind_param(
        $stmt, "ii",
        $transaksi_id, $transaksi_id
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Gagal memperbarui total!");
    }

    mysqli_commit($koneksi);

    header("Location: detail_transaksi.php?id=" . $transaksi_id);
    exit;

} catch (Exception $e) {

    mysqli_rollback($koneksi);

    die("Terjadi kesalahan: " .
        htmlspecialchars($e->getMessage()));
}
?>
