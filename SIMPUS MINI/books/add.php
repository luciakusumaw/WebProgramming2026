<?php
$page_title = "Add Book";
include __DIR__ . '/../includes/header.php';

$old = $_SESSION['old_input'] ?? [];
unset($_SESSION['old_input']);
?>

<h2>Add New Book</h2>

<?php if (isset($_SESSION['flash_error'])): ?>
  <div class="flash flash-error">
    <?php 
      echo htmlspecialchars($_SESSION['flash_error']); 
      unset($_SESSION['flash_error']);
    ?>
  </div>
<?php endif; ?>

<form action="proses_tambah.php" method="POST" class="form-container">
  <div class="form-group">
    <label for="judul">Book Title *</label>
    <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($old['judul'] ?? ''); ?>" required>
  </div>

  <div class="form-group">
    <label for="penulis">Author *</label>
    <input type="text" id="penulis" name="penulis" value="<?php echo htmlspecialchars($old['penulis'] ?? ''); ?>" required>
  </div>

  <div class="form-group">
    <label for="tahun">Year of Publication *</label>
    <input type="number" id="tahun" name="tahun" value="<?php echo htmlspecialchars($old['tahun'] ?? ''); ?>" required>
  </div>

  <div class="form-group">
    <label for="penerbit">Publisher *</label>
    <input type="text" id="penerbit" name="penerbit" value="<?php echo htmlspecialchars($old['penerbit'] ?? ''); ?>" required>
  </div>

  <div class="form-group">
    <label for="isbn">ISBN (Optional)</label>
    <input type="text" id="isbn" name="isbn" placeholder="Contoh: 978-602-03-8829-8" value="<?php echo htmlspecialchars($old['isbn'] ?? ''); ?>">
    <small>Hanya boleh angka dan tanda hubung (-)</small>
  </div>

  <button type="submit" class="btn btn-primary">Save Book</button>
  <a href="list.php" class="btn btn-secondary">Cancel</a>
</form>

<?php
include __DIR__ . '/../includes/footer.php';
?>