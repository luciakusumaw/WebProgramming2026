<?php
session_start();
require_once __DIR__ . '/../includes/connection.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);


$perPage = 10;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['keyword'] ?? '');


if ($keyword !== '') {
    $kw = '%' . $keyword . '%';
    
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM books WHERE title ILIKE :kw1 OR author ILIKE :kw2");
    $hitung->execute(['kw1' => $kw, 'kw2' => $kw]);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM books WHERE title ILIKE :kw1 OR author ILIKE :kw2 ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw1', $kw);
    $stmt->bindValue('kw2', $kw);
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM books ORDER BY id DESC LIMIT :limit OFFSET :offset");
}

$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalPages = max(1, (int) ceil($totalRows / $perPage));
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

            <?php if ($flash): ?>
                <div class="flash flash-<?= $flash['type'] ?>">
                    <?= htmlspecialchars($flash['message']) ?>
                </div>
            <?php endif; ?>

            <div class="search-box">
                <form method="GET" action="list.php">
                    <label for="keyword">Search Book Title or Author</label>
                    <input type="text" name="keyword" id="keyword" placeholder="Type title or author..." value="<?= htmlspecialchars($keyword) ?>">
                    <button type="submit" style="margin-top: 0.5rem; padding: 0.4rem 1rem; background-color: #1d5b8a; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Search</button>
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
                                    <!-- Tombol Edit dengan kotak warna kuning/oranye -->
                                    <a href="edit.php?id=<?= $book['id'] ?>" class="btn-edit" style="background-color: #f0ad4e; color: #fff; padding: 0.35rem 0.7rem; border-radius: 4px; text-decoration: none; font-size: 0.85rem; display: inline-block;">Edit</a>
                                    
                                    <!-- Form Tombol Delete yang aman (POST) -->
                                    <form class="form-hapus" method="POST" action="hapus.php" style="display: inline;">
                                        <input type="hidden" name="id" value="<?= $book['id'] ?>">
                                        <button type="submit" class="btn-hapus" style="background-color: #d9534f; color: #fff; border: none; padding: 0.35rem 0.7rem; border-radius: 4px; cursor: pointer; font-size: 0.85rem;">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <nav class="pagination" style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="list.php?page=<?= $i ?><?= $keyword !== '' ? '&keyword=' . urlencode($keyword) : '' ?>" class="<?= $i === $page ? 'active' : '' ?>" style="padding: 0.4rem 0.75rem; border: 1px solid #cdd4da; border-radius: 4px; background-color: <?= $i === $page ? '#1d5b8a' : '#fff' ?>; color: <?= $i === $page ? '#fff' : '#1d5b8a' ?>; text-decoration: none;"><?= $i ?></a>
                <?php endfor; ?>
            </nav>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 SIMPUS-Mini</p>
    </footer>

    <script src="../assets/js/app.js"></script>
</body>
</html>