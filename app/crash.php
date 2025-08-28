<?php
$factor = $_GET['factor'] ?? 1;

// $factor adalah angka untuk mencegah error pembagian
if (is_numeric($factor) && $factor != 0) {
    $result = 100 / $factor;
} else {
    // Jika input tidak valid, atur nilai default
    $factor = 1;
    $result = 100;
}

//htmlspecialchars untuk menampilkan data dengan aman
echo "100 / " . htmlspecialchars($factor) . " = " . htmlspecialchars($result);
?>