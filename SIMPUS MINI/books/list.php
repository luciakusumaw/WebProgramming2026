<?php
$page_title = "Book List";
include __DIR__ . '/../includes/header.php';

$buku_list = $_SESSION['buku'] ?? [];
?>

<div class="page-header">
  <h2>Book List</h2>
  <div>
    <a href="add.php" class="btn btn-primary">+ Add Book</a>

    <?php if (!empty($buku_list)): ?>
      <a href="reset.php" class="btn btn-danger" onclick="return confirm('Yakin ingin mereset seluruh data buku?');">Reset Data</a>
    <?php endif; ?>
  
  </div>
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
  <p class="empty-state">No books available in the session. Click "+ Add Book" to add one.</p>
<?php else: ?>
  <table class="data-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Author</th>
        <th>Year</th>
        <th>Publisher</th>
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
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php
include __DIR__ . '/../includes/footer.php';
?>