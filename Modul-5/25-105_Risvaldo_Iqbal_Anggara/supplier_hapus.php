<?php

include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit("Metode permintaan tidak diizinkan.");
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    http_response_code(400);
    exit("ID supplier tidak valid.");
}

$stmt = mysqli_prepare($koneksi, "DELETE FROM supplier WHERE id = ?");
if (!$stmt) {
    http_response_code(500);
    exit("Gagal menyiapkan penghapusan data supplier: " . htmlspecialchars(mysqli_error($koneksi), ENT_QUOTES, 'UTF-8'));
}

mysqli_stmt_bind_param($stmt, "i", $id);

if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    exit("Gagal menghapus data supplier: " . htmlspecialchars(mysqli_stmt_error($stmt), ENT_QUOTES, 'UTF-8'));
}

mysqli_stmt_close($stmt);
header("Location: supplier.php");
exit;
