<?php
session_start();
require_once __DIR__ . '/../includes/connection.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id'] ?? null;

if ($id) {
    try {
      
        $stmt = $pdo->prepare("DELETE FROM books WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Book deleted successfully.'];
    } catch (PDOException $e) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Failed to delete book: ' . $e->getMessage()];
    }
}

header('Location: list.php');
exit;
?>