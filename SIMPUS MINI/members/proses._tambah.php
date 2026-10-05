<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: add.php");
  exit();
}

$nama    = trim($_POST['nama'] ?? '');
$email   = trim($_POST['email'] ?? '');
$telepon = trim($_POST['telepon'] ?? '');
$alamat  = trim($_POST['alamat'] ?? '');

$_SESSION['old_input'] = $_POST;

if (empty($nama) || empty($email) || empty($telepon) || empty($alamat)) {
  $_SESSION['flash_error'] = "Semua kolom wajib diisi.";
  header("Location: add.php");
  exit();
}

if (strlen($nama) < 3 || !preg_match("/^[a-zA-Z\s'.]+$/", $nama)) {
  $_SESSION['flash_error'] = "Nama harus berupa huruf dan minimal 3 karakter.";
  header("Location: add.php");
  exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $_SESSION['flash_error'] = "Format email tidak valid.";
  header("Location: add.php");
  exit();
}

if (!preg_match('/^[0-9]{10,15}$/', $telepon)) {
  $_SESSION['flash_error'] = "Nomor telepon harus berupa angka antara 10 hingga 15 digit.";
  header("Location: add.php");
  exit();
}

if (strlen($alamat) < 10) {
  $_SESSION['flash_error'] = "Alamat terlalu pendek (minimal 10 karakter).";
  header("Location: add.php");
  exit();
}

$check_query = "SELECT id FROM members WHERE email = ? LIMIT 1";
$check_stmt = mysqli_prepare($conn, $check_query);
if ($check_stmt) {
  mysqli_stmt_bind_param($check_stmt, "s", $email);
  mysqli_stmt_execute($check_stmt);
  mysqli_stmt_store_result($check_stmt);

  if (mysqli_stmt_num_rows($check_stmt) > 0) {
    $_SESSION['flash_error'] = "Email sudah terdaftar, gunakan email lain.";
    mysqli_stmt_close($check_stmt);
    header("Location: add.php");
    exit();
  }
  mysqli_stmt_close($check_stmt);
}

$query = "INSERT INTO members (nama, email, telepon, alamat) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
  mysqli_stmt_bind_param($stmt, "ssss", $nama, $email, $telepon, $alamat);

  if (mysqli_stmt_execute($stmt)) {
    unset($_SESSION['old_input']);
    $_SESSION['flash_success'] = "Anggota berhasil disimpan ke database!";
    mysqli_stmt_close($stmt);
    header("Location: list.php");
    exit();
  } else {
    $_SESSION['flash_error'] = "Gagal menyimpan data: " . mysqli_error($conn);
  }
  mysqli_stmt_close($stmt);
} else {
  $_SESSION['flash_error'] = "Kesalahan query: " . mysqli_error($conn);
}

header("Location: add.php");
exit();