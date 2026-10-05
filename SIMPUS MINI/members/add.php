<?php
$page_title = "Add Member";
include __DIR__ . '/../includes/header.php';
?>

<h2>Add New Member</h2>

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
    <label for="nama">Full Name</label>
    <input type="text" id="nama" name="nama" required>
  </div>

  <div class="form-group">
    <label for="email">Email Address</label>
    <input type="email" id="email" name="email" required>
  </div>

  <div class="form-group">
    <label for="telepon">Phone Number</label>
    <input type="text" id="telepon" name="telepon" required>
  </div>

  <div class="form-group">
    <label for="alamat">Address</label>
    <textarea id="alamat" name="alamat" rows="3" required></textarea>
  </div>

  <button type="submit" class="btn btn-primary">Save Member</button>
  <a href="list.php" class="btn btn-secondary">Cancel</a>
</form>

<?php
include __DIR__ . '/../includes/footer.php';
?>