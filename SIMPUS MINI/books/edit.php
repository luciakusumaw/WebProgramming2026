<?php
$page_title = "Edit Book";
include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

$id = $_GET['id'] ?? null;

if (!$id || !ctype_digit($id)) {
  $_SESSION['flash_error'] = "ID buku tidak valid.";
  header("Location: list.php");
  exit();
}

$query = "SELECT id, judul, penulis, tahun, penerbit FROM books WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
$buku = null;

if ($stmt) {
  $id_int = (int)$id;
  mysqli_stmt_bind_param($stmt, "i", $id_int);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $buku = mysqli_fetch_assoc($result);
  mysqli_stmt_close($stmt);
}

if (!$buku) {
  $_SESSION['flash_error'] = "Buku tidak ditemukan.";
  header("Location: list.php");
  exit();
}
?>

<h2>Edit Book</h2>

<?php if (isset($_SESSION['flash_error'])): ?>
  <div class="flash flash-error">
    <?php 
      echo htmlspecialchars($_SESSION['flash_error']); 
      unset($_SESSION['flash_error']);
    ?>
  </div>
<?php endif; ?>

<form action="proses_edit.php" method="POST" class="form-container">
  <input type="hidden" name="id" value="<?php echo htmlspecialchars($buku['id']); ?>">

  <div class="form-group">
    <label for="judul">Book Title</label>
    <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($buku['judul']); ?>" required>
  </div>

  <div class="form-group">
    <label for="penulis">Author</label>
    <input type="text" id="penulis" name="penulis" value="<?php echo htmlspecialchars($buku['penulis']); ?>" required>
  </div>

  <div class="form-group">
    <label for="tahun">Year of Publication</label>
    <input type="number" id="tahun" name="tahun" value="<?php echo htmlspecialchars($buku['tahun']); ?>" required>
  </div>

  <div class="form-group">
    <label for="penerbit">Publisher</label>
    <input type="text" id="penerbit" name="penerbit" value="<?php echo htmlspecialchars($buku['penerbit']); ?>" required>
  </div>

  <button type="submit" class="btn btn-primary">Update Book</button>
  <a href="list.php" class="btn btn-secondary">Cancel</a>
</form>

<?php
include __DIR__ . '/../includes/footer.php';
?>