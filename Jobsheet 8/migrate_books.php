<?php
require_once __DIR__ . '/includes/connection.php';

$jsonFile = __DIR__ . '/data/book.json';

if (!file_exists($jsonFile)) {
    die("File JSON tidak ditemukan.");
}

$jsonData = file_get_contents($jsonFile);
$books = json_decode($jsonData, true);

$stmt = $pdo->prepare("INSERT INTO books (title, author, year, isbn, stock, category) VALUES (:title, :author, :year, :isbn, :stock, :category)");

$count = 0;
foreach ($books as $b) {
    $stmt->execute([
        'title'    => $b['title'] ?? 'Tanpa Judul',
        'author'   => $b['author'] ?? 'Anonim',
        'year'     => (int)($b['year'] ?? 2026),
        'isbn'     => $b['isbn'] ?? null,
        'stock'    => (int)($b['stok'] ?? $b['stock'] ?? 0),
        'category' => $b['kategori'] ?? $b['category'] ?? 'Umum'
    ]);
    $count++;
}

echo "Berhasil memigrasikan $count data buku dari JSON ke PostgreSQL!";