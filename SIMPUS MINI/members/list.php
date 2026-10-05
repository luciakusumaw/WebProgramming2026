<?php
$page_title = "Member List";
include __DIR__ . '/../includes/header.php';

$member_list = $_SESSION['members'] ?? [];
?>

<div class="page-header">
  <h2>Member List</h2>
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

<?php if (empty($member_list)): ?>
  <p class="empty-state">No members available in the session. Click "+ Add Member" to add one.</p>
<?php else: ?>
  <table class="data-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($member_list as $member): ?>
        <tr>
          <td><?php echo htmlspecialchars($member['id']); ?></td>
          <td><?php echo htmlspecialchars($member['nama']); ?></td>
          <td><?php echo htmlspecialchars($member['email']); ?></td>
          <td><?php echo htmlspecialchars($member['telepon']); ?></td>
          <td><?php echo htmlspecialchars($member['alamat']); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php
include __DIR__ . '/../includes/footer.php';
?>