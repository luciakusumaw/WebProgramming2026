<?php
session_start();
require_once __DIR__ . '/../includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $id       = $_POST['id'] ?? null;
    $title    = $_POST['title'] ?? '';
    $author   = $_POST['author'] ?? '';
    $year     = $_POST['year'] ?? '';
    $isbn     = $_POST['isbn'] ?? null;
    $stock    = $_POST['stock'] ?? 0;
    $category = $_POST['category'] ?? null;

    if (!$id) {
        header('Location: list.php');
        exit;
    }

    try {
     
        $stmt = $pdo->prepare(
            "UPDATE books SET title = :title, author = :author, year = :year, isbn = :isbn, stock = :stock, category = :category 
            WHERE id = :id"
        );
        

        $stmt->execute([
            'title'    => $title,
            'author'   => $author,
            'year'     => (int)$year,
            'isbn'     => $isbn,
            'stock'    => (int)$stock,
            'category' => $category,
            'id'       => $id
        ]);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Book updated successfully.'];
        header('Location: list.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
        header('Location: edit.php?id=' . urlencode($id));
        exit;
    }
} else {
    header('Location: list.php');
    exit;
}
?>