<?php
$page_title = "Book List";
include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

$query = "SELECT id, judul, penulis, tahun, penerbit FROM books ORDER BY id DESC";
$result = mysqli_query($conn, $query);

$buku_list = [];
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $buku_list[] = $row;
  }
}
?>

<div class="page-header">
  <h2>Book List (Database)</h2>
  <a href="add.php" class="btn btn-primary">+ Add Book</a>
</div>

<?php if (isset($_SESSION['flash_success'])): ?>
  <div class="flash flash-success">
    <?php 
      echo htmlspecialchars($_SESSION['flash_success']); 
      unset($_SESSION['flash_success']);
    ?>
  </div>
<?php endif; ?>

<?php if (empty($buku_list)): ?>
  <p class="empty-state">Belum ada data buku di database. Klik "+ Add Book" untuk menambahkan.</p>
<?php else: ?>
  <table class="data-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Author</th>
        <th>Year</th>
        <th>Publisher</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($buku_list as $buku): ?>
        <tr>
          <td><?php echo htmlspecialchars($buku['id']); ?></td>
          <td><?php echo htmlspecialchars($buku['judul']); ?></td>
          <td><?php echo htmlspecialchars($buku['penulis']); ?></td>
          <td><?php echo htmlspecialchars($buku['tahun']); ?></td>
          <td><?php echo htmlspecialchars($buku['penerbit']); ?></td>
          <td>
            <a href="edit.php?id=<?php echo urlencode($buku['id']); ?>" class="btn btn-sm btn-secondary">Edit</a>
            <a href="hapus.php?id=<?php echo urlencode($buku['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus buku ini?');">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php
include __DIR__ . '/../includes/footer.php';
?>