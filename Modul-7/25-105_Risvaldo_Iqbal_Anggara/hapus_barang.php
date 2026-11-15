
<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: barang.php");
    exit;
}

$barang_id = filter_input(
    INPUT_POST,
    'barang_id',
    FILTER_VALIDATE_INT
);

if (!$barang_id || $barang_id <= 0) {
    header("Location: barang.php?pesan=gagal");
    exit;
}

$stmt = mysqli_prepare($koneksi, "
    SELECT COUNT(*) AS jumlah
    FROM transaksi_detail
    WHERE barang_id = ?
");

mysqli_stmt_bind_param($stmt, "i", $barang_id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_fetch_assoc(
    mysqli_stmt_get_result($stmt)
);

if ($hasil['jumlah'] > 0) {

    header("Location: barang.php?pesan=digunakan");
    exit;

}

$stmt = mysqli_prepare($koneksi, "
    DELETE FROM barang
    WHERE id = ?
");

mysqli_stmt_bind_param($stmt, "i", $barang_id);

if (mysqli_stmt_execute($stmt) &&
    mysqli_stmt_affected_rows($stmt) > 0) {

    header("Location: barang.php?pesan=terhapus");

} else {

    header("Location: barang.php?pesan=gagal");

}

exit;
?>
