<?php
include 'auth.php';

// AMBIL DATA DARI SESSION YANG AMAN, BUKAN DARI COOKIE
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$username = $_SESSION['user'] ?? 'Guest'; // Ambil username dari session

$msg = ""; // Inisialisasi variabel pesan

// jika admin, boleh hapus user lain
if ($isAdmin && isset($_POST['delete_user'])) {
    $target = $_POST['delete_user'];

    // Perbaikan SQL Injection untuk operasi DELETE (sudah benar)
    $stmt = $GLOBALS['PDO']->prepare("DELETE FROM users WHERE username=?");
    $stmt->execute([$target]);

    // Perbaikan XSS untuk pesan sukses (sudah benar)
    $msg = "<p style='color:green'>User <b>" . htmlspecialchars($target) . "</b> berhasil dihapus!</p>";
}

include '_header.php';
?>
<h2>Profile Page</h2>
<p>User: <?php echo htmlspecialchars($username); ?>, Role: <?php echo $isAdmin ? "Admin" : "User"; ?></p>

<?php if ($isAdmin): ?>
  <h3>Admin Panel</h3>
  <form method="post">
    <label>Delete user:
      <select name="delete_user">
        <?php
        // Menggunakan query yang aman untuk menampilkan daftar pengguna
        $users = $GLOBALS['PDO']->query("SELECT username FROM users");
        foreach ($users as $u) {
            // Pastikan admin tidak bisa menghapus dirinya sendiri
            if ($u['username'] !== $username) {
                echo "<option value='" . htmlspecialchars($u['username']) . "'>" . htmlspecialchars($u['username']) . "</option>";
            }
        }
        ?>
      </select>
    </label>
    <button type="submit">Delete</button>
  </form>
  <?php if (!empty($msg)) echo $msg; ?>
<?php else: ?>
  <p style="color:red">You are a regular user. You do not have admin panel access.</p>
<?php endif; ?>

<?php include '_footer.php'; ?>