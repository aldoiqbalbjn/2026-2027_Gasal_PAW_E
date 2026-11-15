<?php
include "koneksi.php";

function tanggal_valid($tanggal)
{
    $d = DateTime::createFromFormat('Y-m-d', $tanggal);
    return $d && $d->format('Y-m-d') === $tanggal;
}

$rentang = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT MIN(waktu_transaksi) AS mulai,
           MAX(waktu_transaksi) AS selesai
    FROM transaksi
"));

$default_mulai = !empty($rentang['mulai']) ? $rentang['mulai'] : date('Y-m-01');
$default_selesai = !empty($rentang['selesai']) ? $rentang['selesai'] : date('Y-m-d');

$tanggal_mulai = isset($_GET['tanggal_mulai'])
    ? trim($_GET['tanggal_mulai'])
    : $default_mulai;

$tanggal_selesai = isset($_GET['tanggal_selesai'])
    ? trim($_GET['tanggal_selesai'])
    : $default_selesai;

if (!tanggal_valid($tanggal_mulai)) {
    $tanggal_mulai = $default_mulai;
}

if (!tanggal_valid($tanggal_selesai)) {
    $tanggal_selesai = $default_selesai;
}

if ($tanggal_mulai > $tanggal_selesai) {
    $tmp = $tanggal_mulai;
    $tanggal_mulai = $tanggal_selesai;
    $tanggal_selesai = $tmp;
}

$stmt = mysqli_prepare($koneksi, "
    SELECT waktu_transaksi,
           SUM(total) AS total_pendapatan
    FROM transaksi
    WHERE waktu_transaksi BETWEEN ? AND ?
    GROUP BY waktu_transaksi
    ORDER BY waktu_transaksi ASC
");

mysqli_stmt_bind_param($stmt, "ss", $tanggal_mulai, $tanggal_selesai);
mysqli_stmt_execute($stmt);

$hasil_rekap = mysqli_stmt_get_result($stmt);

$stmt = mysqli_prepare($koneksi, "
    SELECT COUNT(DISTINCT pelanggan_id) AS jumlah_pelanggan,
           COALESCE(SUM(total), 0) AS total_pendapatan
    FROM transaksi
    WHERE waktu_transaksi BETWEEN ? AND ?
");

mysqli_stmt_bind_param($stmt, "ss", $tanggal_mulai, $tanggal_selesai);
mysqli_stmt_execute($stmt);

$ringkasan = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

$nama_file = "laporan_penjualan_" . $tanggal_mulai
    . "_sd_" . $tanggal_selesai . ".xls";

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$nama_file\"");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>

<table border="1">
    <tr>
        <th colspan="3">Laporan Rekapitulasi Penjualan Harian</th>
    </tr>
    <tr>
        <td colspan="3">
            Periode: <?= date('d-m-Y', strtotime($tanggal_mulai)); ?>
            s.d. <?= date('d-m-Y', strtotime($tanggal_selesai)); ?>
        </td>
    </tr>
    <tr>
        <th>No</th>
        <th>Total Pendapatan</th>
        <th>Tanggal Transaksi</th>
    </tr>

    <?php $no = 1; ?>
    <?php while ($row = mysqli_fetch_assoc($hasil_rekap)) { ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $row['total_pendapatan']; ?></td>
        <td><?= date('d-m-Y', strtotime($row['waktu_transaksi'])); ?></td>
    </tr>
    <?php } ?>

</table>

<br>

<table border="1">
    <tr>
        <th>Jumlah Pelanggan Unik</th>
        <th>Total Pendapatan Keseluruhan</th>
    </tr>
    <tr>
        <td><?= $ringkasan['jumlah_pelanggan']; ?></td>
        <td><?= $ringkasan['total_pendapatan']; ?></td>
    </tr>
</table>

</body>
</html>
