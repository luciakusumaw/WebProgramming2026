<?php
$page_title = "Member List";
include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

$query = "SELECT id, nama, email, telepon, alamat FROM members ORDER BY id DESC";
$result = mysqli_query($conn, $query);

$member_list = [];
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $member_list[] = $row;
  }
}
?>

<div class="page-header">
  <h2>Member List (Database)</h2>
  <a href="add.php" class="btn btn-primary">+ Add Member</a>
</div>

<?php if (isset($_SESSION['flash_success'])): ?>
  <div class="flash flash-success">
    <?php 
      echo htmlspecialchars($_SESSION['flash_success']); 
      unset($_SESSION['flash_success']);
    ?>
  </div>
<?php endif; ?>

<?php if (isset($_SESSION['flash_error'])): ?>
  <div class="flash flash-error">
    <?php 
      echo htmlspecialchars($_SESSION['flash_error']); 
      unset($_SESSION['flash_error']);
    ?>
  </div>
<?php endif; ?>

<?php if (empty($member_list)): ?>
  <p class="empty-state">Belum ada data anggota di database. Klik "+ Add Member" untuk menambahkan.</p>
<?php else: ?>
  <table class="data-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($member_list as $m): ?>
        <tr>
          <td><?php echo htmlspecialchars($m['id']); ?></td>
          <td><?php echo htmlspecialchars($m['nama']); ?></td>
          <td><?php echo htmlspecialchars($m['email']); ?></td>
          <td><?php echo htmlspecialchars($m['telepon']); ?></td>
          <td><?php echo htmlspecialchars($m['alamat']); ?></td>
          <td>
            <a href="edit.php?id=<?php echo urlencode($m['id']); ?>" class="btn btn-sm btn-secondary">Edit</a>
            <a href="hapus.php?id=<?php echo urlencode($m['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus anggota ini?');">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php
include __DIR__ . '/../includes/footer.php';
?>