<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: add.php");
  exit();
}

$judul    = trim($_POST['judul'] ?? '');
$penulis  = trim($_POST['penulis'] ?? '');
$tahun    = trim($_POST['tahun'] ?? '');
$penerbit = trim($_POST['penerbit'] ?? '');
$isbn     = trim($_POST['isbn'] ?? '');

$_SESSION['old_input'] = $_POST;

if (empty($judul) || empty($penulis) || empty($tahun) || empty($penerbit)) {
  $_SESSION['flash_error'] = "Semua field bertanda bintang wajib diisi.";
  header("Location: add.php");
  exit();
}

$current_year = (int)date('Y');
if (!ctype_digit($tahun) || strlen($tahun) !== 4 || (int)$tahun > $current_year || (int)$tahun < 1000) {
  $_SESSION['flash_error'] = "Tahun terbit harus 4 digit angka dan tidak lebih dari $current_year.";
  header("Location: add.php");
  exit();
}

if (!empty($isbn) && !preg_match('/^[0-9\-]+$/', $isbn)) {
  $_SESSION['flash_error'] = "Format ISBN tidak valid! Hanya boleh berisi angka dan tanda hubung (-).";
  header("Location: add.php");
  exit();
}

$query = "INSERT INTO books (judul, penulis, tahun, penerbit) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
  $tahun_int = (int)$tahun;
  mysqli_stmt_bind_param($stmt, "ssis", $judul, $penulis, $tahun_int, $penerbit);

  if (mysqli_stmt_execute($stmt)) {
    unset($_SESSION['old_input']);
    $_SESSION['flash_success'] = "Buku berhasil disimpan ke database!";
    mysqli_stmt_close($stmt);
    header("Location: list.php");
    exit();
  } else {
    $_SESSION['flash_error'] = "Gagal menyimpan buku: " . mysqli_error($conn);
  }
  mysqli_stmt_close($stmt);
} else {
  $_SESSION['flash_error'] = "Kesalahan query: " . mysqli_error($conn);
}

header("Location: add.php");
exit();