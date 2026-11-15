<?php
include "koneksi.php";

// Mengecek format tanggal Y-m-d
function tanggal_valid($tanggal)
{
    $d = DateTime::createFromFormat('Y-m-d', $tanggal);
    return $d && $d->format('Y-m-d') === $tanggal;
}

// Menentukan rentang tanggal default dari data transaksi
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

// Menukar posisi jika rentang terbalik
if ($tanggal_mulai > $tanggal_selesai) {
    $tmp = $tanggal_mulai;
    $tanggal_mulai = $tanggal_selesai;
    $tanggal_selesai = $tmp;
}

// Rekapitulasi penjualan per hari
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

$rows = [];
$labels = [];
$data_grafik = [];

while ($row = mysqli_fetch_assoc($hasil_rekap)) {
    $rows[] = $row;
    $labels[] = date('d-m-Y', strtotime($row['waktu_transaksi']));
    $data_grafik[] = (int) $row['total_pendapatan'];
}

// Ringkasan periode
$stmt = mysqli_prepare($koneksi, "
    SELECT COUNT(DISTINCT pelanggan_id) AS jumlah_pelanggan,
           COALESCE(SUM(total), 0) AS total_pendapatan
    FROM transaksi
    WHERE waktu_transaksi BETWEEN ? AND ?
");

mysqli_stmt_bind_param($stmt, "ss", $tanggal_mulai, $tanggal_selesai);
mysqli_stmt_execute($stmt);

$ringkasan = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<a href="transaksi.php">← Kembali ke Transaksi</a>

<h1>Laporan Penjualan</h1>

<div class="no-print">
    <form method="GET" action="laporan_penjualan.php">

        <label>Tanggal Mulai:</label>
        <input type="date" name="tanggal_mulai"
               value="<?= htmlspecialchars($tanggal_mulai); ?>" required>

        <label>Tanggal Selesai:</label>
        <input type="date" name="tanggal_selesai"
               value="<?= htmlspecialchars($tanggal_selesai); ?>" required>

        <button type="submit">Tampilkan</button>

    </form>

    <br>

    <button type="button" onclick="window.print()">Cetak (Print)</button>

    <a href="export_excel.php?tanggal_mulai=<?= urlencode($tanggal_mulai); ?>&tanggal_selesai=<?= urlencode($tanggal_selesai); ?>">
        <button type="button">Ekspor Excel</button>
    </a>

    <br><br>
</div>

<h2>Grafik Tren Pendapatan per Hari</h2>

<p>
    Periode: <b><?= date('d-m-Y', strtotime($tanggal_mulai)); ?></b>
    s.d. <b><?= date('d-m-Y', strtotime($tanggal_selesai)); ?></b>
</p>

<div>
    <canvas id="grafikPenjualan"></canvas>
</div>

<h2>Tabel Rekapitulasi Penjualan Harian</h2>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Total Pendapatan</th>
        <th>Tanggal Transaksi</th>
    </tr>

    <?php if (count($rows) > 0) { ?>

        <?php $no = 1; ?>
        <?php foreach ($rows as $row) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td>
                Rp <?= number_format($row['total_pendapatan'], 0, ',', '.'); ?>
            </td>
            <td>
                <?= date('d-m-Y', strtotime($row['waktu_transaksi'])); ?>
            </td>
        </tr>
        <?php } ?>

    <?php } else { ?>

        <tr>
            <td colspan="3">Tidak ada transaksi pada periode ini.</td>
        </tr>

    <?php } ?>
</table>

<br>

<h2>Ringkasan</h2>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Jumlah Pelanggan Unik</th>
        <th>Total Pendapatan Keseluruhan</th>
    </tr>
    <tr>
        <td><?= $ringkasan['jumlah_pelanggan']; ?></td>
        <td>
            Rp <?= number_format($ringkasan['total_pendapatan'], 0, ',', '.'); ?>
        </td>
    </tr>
</table>

<script>
    const ctx = document.getElementById('grafikPenjualan');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels); ?>,
            datasets: [{
                label: 'Total Pendapatan',
                data: <?= json_encode($data_grafik); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                },
                title: {
                    display: true,
                    text: 'Tren Total Pendapatan per Hari'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal Transaksi'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Pendapatan (Rp)'
                    },
                    ticks: {
                        callback: function (value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>
