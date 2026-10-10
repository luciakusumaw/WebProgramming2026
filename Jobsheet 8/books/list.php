<?php
require_once __DIR__ . '/../includes/connection.php';

$keyword = $_GET['keyword'] ?? '';
if ($keyword !== '') {
    $stmt = $pdo->prepare("SELECT * FROM books WHERE title ILIKE :keyword ORDER BY id DESC");
    $stmt->execute(['keyword' => '%' . $keyword . '%']);
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $books = $pdo->query("SELECT * FROM books ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Book List</title>
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
            <h2>Book List</h2>

            <div class="search-box">
                <form method="GET" action="">
                    <label for="keyword">Search Book Title</label>
                    <input type="text" name="keyword" id="keyword" placeholder="Type book title..." value="<?= htmlspecialchars($keyword) ?>">
                </form>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Year</th>
                            <th>Stock</th>
                            <th>Tanggal Ditambahkan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($books)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center;">No book data yet. Please add one via the "Add Book" menu.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($books as $book): ?>
                            <tr>
                                <td><?= htmlspecialchars($book['title']) ?></td>
                                <td><?= htmlspecialchars($book['author']) ?></td>
                                <td><?= $book['year'] ?></td>
                                <td><?= $book['stock'] ?></td>
                                <td><?= $book['tanggal_ditambahkan'] ?? '-' ?></td>
                                <td>
                                    <button type="button" onclick="window.location.href='edit.php?id=<?= $book['id'] ?>'">Edit</button>
                                    <button type="button" onclick="if(confirm('Yakin ingin menghapus?')) window.location.href='delete.php?id=<?= $book['id'] ?>'">Delete</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 SIMPUS-Mini</p>
    </footer>
</body>
</html>