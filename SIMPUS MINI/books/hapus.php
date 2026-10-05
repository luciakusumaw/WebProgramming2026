<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$id = $_GET['id'] ?? null;

if (!$id || !ctype_digit($id)) {
  $_SESSION['flash_error'] = "ID buku tidak valid.";
  header("Location: list.php");
  exit();
}

$query = "DELETE FROM books WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
  $id_int = (int)$id;
  mysqli_stmt_bind_param($stmt, "i", $id_int);

  if (mysqli_stmt_execute($stmt)) {
    $_SESSION['flash_success'] = "Buku berhasil dihapus!";
  } else {
    $_SESSION['flash_error'] = "Gagal menghapus data: " . mysqli_error($conn);
  }
  mysqli_stmt_close($stmt);
} else {
  $_SESSION['flash_error'] = "Kesalahan query: " . mysqli_error($conn);
}

header("Location: list.php");
exit();