<?php include 'auth.php'; ?>
<?php include '_header.php'; ?>
<h2>Ping Server</h2>
<form><input name="target"><button>Ping!</button></form>
<?php
if (!isset($_GET['target'])) {
    die("Missing parameter.");
}
    $target = $_GET['target'];
    // Perbaikan XSS: Gunakan htmlspecialchars saat menampilkan input
    echo "<h3>Ping Result for: " . htmlspecialchars($target) . "</h3>";
    
    // Perbaikan Command Injection (sudah benar)
    $safe_target = escapeshellarg($target);
    $output = shell_exec("ping -c 2 " . $safe_target);
    echo "<pre>" . htmlspecialchars($output) . "</pre>";

?>
<?php include '_footer.php'; ?>
