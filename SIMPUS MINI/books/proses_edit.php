<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: list.php");
  exit();
}

$id       = trim($_POST['id'] ?? '');
$judul    = trim($_POST['judul'] ?? '');
$penulis  = trim($_POST['penulis'] ?? '');
$tahun    = trim($_POST['tahun'] ?? '');
$penerbit = trim($_POST['penerbit'] ?? '');

if (empty($id) || !ctype_digit($id)) {
  $_SESSION['flash_error'] = "ID buku tidak valid.";
  header("Location: list.php");
  exit();
}

if (empty($judul) || empty($penulis) || empty($tahun) || empty($penerbit)) {
  $_SESSION['flash_error'] = "Semua field wajib diisi.";
  header("Location: edit.php?id=" . urlencode($id));
  exit();
}

$current_year = (int)date('Y');
if (!ctype_digit($tahun) || strlen($tahun) !== 4 || (int)$tahun > $current_year) {
  $_SESSION['flash_error'] = "Tahun harus berupa 4 digit angka dan tidak lebih dari $current_year.";
  header("Location: edit.php?id=" . urlencode($id));
  exit();
}

$query = "UPDATE books SET judul = ?, penulis = ?, tahun = ?, penerbit = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
  $tahun_int = (int)$tahun;
  $id_int    = (int)$id;
  mysqli_stmt_bind_param($stmt, "ssisi", $judul, $penulis, $tahun_int, $penerbit, $id_int);

  if (mysqli_stmt_execute($stmt)) {
    $_SESSION['flash_success'] = "Buku berhasil diperbarui!";
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