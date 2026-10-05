<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: add.php");
  exit();
}

$nama    = trim($_POST['nama'] ?? '');
$email   = trim($_POST['email'] ?? '');
$telepon = trim($_POST['telepon'] ?? '');
$alamat  = trim($_POST['alamat'] ?? '');

if (empty($nama) || empty($email) || empty($telepon) || empty($alamat)) {
  $_SESSION['flash_error'] = "Semua field wajib diisi.";
  header("Location: add.php");
  exit();
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $_SESSION['flash_error'] = "Format email tidak valid.";
  header("Location: add.php");
  exit();
}

if (!isset($_SESSION['members'])) {
  $_SESSION['members'] = [];
}

$new_id = empty($_SESSION['members']) ? 1 : max(array_column($_SESSION['members'], 'id')) + 1;

$_SESSION['members'][] = [
  'id'      => $new_id,
  'nama'    => $nama,
  'email'   => $email,
  'telepon' => $telepon,
  'alamat'  => $alamat
];

$_SESSION['flash_success'] = "Member berhasil ditambahkan!";
header("Location: list.php");
exit();