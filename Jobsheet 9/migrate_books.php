<?php
require_once __DIR__ . '/includes/connection.php';

$jsonFile = __DIR__ . '/../jobsheet-06/data/books.json';
if (!file_exists($jsonFile)) {
    $jsonFile = __DIR__ . '/data/books.json';
}

if (!file_exists($jsonFile)) {
    die("File books.json tidak ditemukan! Periksa kembali lokasi foldernya.");
}

$jsonData = file_get_contents($jsonFile);
$books = json_decode($jsonData, true);

if (empty($books)) {
    die("Data JSON kosong atau format tidak valid.");
}

$stmt = $pdo->prepare(
    "INSERT INTO books (title, author, year, isbn, stock, category)
     VALUES (:title, :author, :year, :isbn, :stock, :category)"
);

$migratedCount = 0;
foreach ($books as $book) {
    $stmt->execute([
        'title'    => $book['title'] ?? $book['judul'] ?? '',
        'author'   => $book['author'] ?? $book['penulis'] ?? '',
        'year'     => (int)($book['year'] ?? $book['tahun'] ?? 2026),
        'isbn'     => $book['isbn'] ?? null,
        'stock'    => (int)($book['stock'] ?? $book['stok'] ?? 0),
        'category' => $book['category'] ?? $book['kategori'] ?? null
    ]);
    $migratedCount++;
}

echo "<h3>Migrasi Berhasil!</h3>";
echo "<p>Sebanyak <strong>$migratedCount</strong> data buku berhasil dipindahkan dari file JSON ke database PostgreSQL.</p>";
echo "<p><a href='books/list.php'>Lihat Book List</a></p>";