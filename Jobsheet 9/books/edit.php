<?php
session_start();
require_once __DIR__ . '/../includes/connection.php';

// 1. Get the ID from the URL ($_GET['id'])
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

// 2. Fetch the existing book data from PostgreSQL
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = :id");
$stmt->execute(['id' => $id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    header('Location: list.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <h1>SIMPUS - Mini</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="list.php">Book List</a></li>
                <li><a href="add.php">Add Book</a></li>
                <li><a href="../members/list.php">Member List</a></li>
                <li><a href="../members/add.php">Add Member</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Edit Book</h2>
            
            <form method="post" action="process_edit.php" onsubmit="return confirm('Apakah Anda yakin ingin memperbarui data buku ini?');">
                
                <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">
                
                <p>
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
                </p>
                <p>
                    <label for="author">Author</label>
                    <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
                </p>
                <p>
                    <label for="year">Year</label>
                    <input type="number" id="year" name="year" value="<?= htmlspecialchars($book['year']) ?>" required>
                </p>
                <p>
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn'] ?? '') ?>">
                </p>
                <p>
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" value="<?= htmlspecialchars($book['stock']) ?>" required>
                </p>
                <p>
                    <label for="category">Category</label>
                    <select id="category" name="category">
                        <?php foreach (['fiction' => 'Fiction', 'non-fiction' => 'Non-Fiction', 'reference' => 'Reference'] as $value => $label): ?>
                            <option value="<?= $value ?>" <?= ($book['category'] ?? '') === $value ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <button type="submit">Update Book</button>
                    <a href="list.php" style="margin-left: 10px;">Cancel</a>
                </p>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 SIMPUS-Mini</p>
    </footer>
</body>
</html>