<?php
$page_title = "Edit Member";
include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

$id = $_GET['id'] ?? null;

if (!$id || !ctype_digit($id)) {
  $_SESSION['flash_error'] = "ID anggota tidak valid.";
  header("Location: list.php");
  exit();
}

$query = "SELECT id, nama, email, telepon, alamat FROM members WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
$member = null;

if ($stmt) {
  $id_int = (int)$id;
  mysqli_stmt_bind_param($stmt, "i", $id_int);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $member = mysqli_fetch_assoc($result);
  mysqli_stmt_close($stmt);
}

if (!$member) {
  $_SESSION['flash_error'] = "Anggota tidak ditemukan.";
  header("Location: list.php");
  exit();
}
?>

<h2>Edit Member</h2>

<?php if (isset($_SESSION['flash_error'])): ?>
  <div class="flash flash-error">
    <?php 
      echo htmlspecialchars($_SESSION['flash_error']); 
      unset($_SESSION['flash_error']);
    ?>
  </div>
<?php endif; ?>

<form action="proses_edit.php" method="POST" class="form-container">
  <input type="hidden" name="id" value="<?php echo htmlspecialchars($member['id']); ?>">

  <div class="form-group">
    <label for="nama">Full Name</label>
    <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($member['nama']); ?>" required>
  </div>

  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($member['email']); ?>" required>
  </div>

  <div class="form-group">
    <label for="telepon">Phone Number</label>
    <input type="text" id="telepon" name="telepon" value="<?php echo htmlspecialchars($member['telepon']); ?>" required>
  </div>

  <div class="form-group">
    <label for="alamat">Address</label>
    <textarea id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($member['alamat']); ?></textarea>
  </div>

  <button type="submit" class="btn btn-primary">Update Member</button>
  <a href="list.php" class="btn btn-secondary">Cancel</a>
</form>

<?php
include __DIR__ . '/../includes/footer.php';
?>