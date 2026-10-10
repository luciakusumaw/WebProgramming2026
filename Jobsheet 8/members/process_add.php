<?php
session_start();
require_once __DIR__ . '/../includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name      = $_POST['name'] ?? '';
    $memberId  = $_POST['member_id'] ?? '';
    $address   = $_POST['address'] ?? '';
    $phone     = $_POST['phone'] ?? '';

    try {
        $stmt = $pdo->prepare(
            "INSERT INTO members (name, member_id, address, phone)
             VALUES (:name, :member_id, :address, :phone)"
        );
        $stmt->execute([
            'name'      => $name,
            'member_id' => $memberId,
            'address'   => $address,
            'phone'     => $phone
        ]);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Member added successfully.'];
        header('Location: list.php');
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == '23505') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'No. Member sudah dipakai, gunakan nomor lain.'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Terjadi kesalahan database: ' . $e->getMessage()];
        }
        header('Location: add.php');
        exit;
    }
}