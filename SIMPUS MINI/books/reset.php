<?php
session_start();

unset($_SESSION['buku']);
$_SESSION['flash_success'] = "Semua data buku berhasil direset.";

header("Location: list.php");
exit();