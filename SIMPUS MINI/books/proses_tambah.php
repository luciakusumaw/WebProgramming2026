<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: add.php");
  exit();
}

$judul    = trim($_POST['judul'] ?? '');
$penulis  = trim($_POST['penulis'] ?? '');
$tahun    = trim($_POST['tahun'] ?? '');
$penerbit = trim($_POST['penerbit'] ?? '');

$_SESSION['old_input'] = $_POST;

if (empty($judul) || empty($penulis) || empty($tahun) || empty($penerbit)) {
  $_SESSION['flash_error'] = "Semua field wajib diisi.";
  header("Location: add.php");
  exit();
}

$current_year = (int)date('Y');
if (!ctype_digit($tahun) || strlen($tahun) !== 4 || (int)$tahun > $current_year) {
  $_SESSION['flash_error'] = "Tahun harus berupa 4 digit angka dan tidak lebih dari $current_year.";
  header("Location: add.php");
  exit();
}

if (!isset($_SESSION['buku'])) {
  $_SESSION['buku'] = [];
}

$new_id = empty($_SESSION['buku']) ? 1 : max(array_column($_SESSION['buku'], 'id')) + 1;

$_SESSION['buku'][] = [
  'id'       => $new_id,
  'judul'    => $judul,
  'penulis'  => $penulis,
  'tahun'    => (int)$tahun,
  'penerbit' => $penerbit
];


unset($_SESSION['old_input']);

$_SESSION['flash_success'] = "Buku berhasil ditambahkan!";
header("Location: list.php");
exit();