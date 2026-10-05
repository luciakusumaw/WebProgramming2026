<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: list.php");
  exit();
}

$id      = trim($_POST['id'] ?? '');
$nama    = trim($_POST['nama'] ?? '');
$email   = trim($_POST['email'] ?? '');
$telepon = trim($_POST['telepon'] ?? '');
$alamat  = trim($_POST['alamat'] ?? '');

if (empty($id) || !ctype_digit($id)) {
  $_SESSION['flash_error'] = "ID anggota tidak valid.";
  header("Location: list.php");
  exit();
}

if (empty($nama) || empty($email) || empty($telepon) || empty($alamat)) {
  $_SESSION['flash_error'] = "Semua field wajib diisi.";
  header("Location: edit.php?id=" . urlencode($id));
  exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $_SESSION['flash_error'] = "Format email tidak valid.";
  header("Location: edit.php?id=" . urlencode($id));
  exit();
}

if (!preg_match('/^[0-9+\-\s()]{8,20}$/', $telepon)) {
  $_SESSION['flash_error'] = "Nomor telepon harus berupa angka (8-20 karakter).";
  header("Location: edit.php?id=" . urlencode($id));
  exit();
}

$query = "UPDATE members SET nama = ?, email = ?, telepon = ?, alamat = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
  $id_int = (int)$id;
  mysqli_stmt_bind_param($stmt, "ssssi", $nama, $email, $telepon, $alamat, $id_int);

  if (mysqli_stmt_execute($stmt)) {
    $_SESSION['flash_success'] = "Anggota berhasil diperbarui!";
    mysqli_stmt_close($stmt);
    header("Location: list.php");
    exit();
  } else {
    $_SESSION['flash_error'] = "Gagal memperbarui data: " . mysqli_error($conn);
  }
  mysqli_stmt_close($stmt);
} else {
  $_SESSION['flash_error'] = "Kesalahan query: " . mysqli_error($conn);
}

header("Location: edit.php?id=" . urlencode($id));
exit();