<?php include 'auth.php'; ?>
<?php include '_header.php'; ?>
<h2>Wiki Search</h2>
<form><input name="q"><button>Search</button></form>
<?php
if (isset($_GET['q'])) {
    $q = $_GET['q'];
    
    $stmt = $GLOBALS['PDO']->prepare("SELECT * FROM articles WHERE title LIKE ?");
    $stmt->execute(['%' . $q . '%']);
    $res = $stmt;

    foreach ($res as $row) {
        echo "<li>" . htmlspecialchars($row['title']) . ": " . htmlspecialchars($row['body']) . "</li>";
    }
}
?>
<?php include '_footer.php'; ?>