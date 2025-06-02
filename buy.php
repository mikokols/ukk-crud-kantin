<?php
include 'config.php';
$id = $_POST['menu'];
$jumlah = $_POST['jumlah'];

$data = $conn->query("SELECT * FROM makanan WHERE id=$id")->fetch_assoc();
$total = $jumlah * $data['harga'];
$newStok = $data['stok'] - $jumlah;

if ($newStok >= 0) {
  $conn->query("UPDATE makanan SET stok=$newStok WHERE id=$id");
  $conn->query("INSERT INTO pembelian (makanan_id, jumlah, total) VALUES ($id, $jumlah, $total)");
  echo "<h2>Terima kasih telah membeli!</h2>";
  echo "<p>Total harga: Rp$total</p>";
  echo "<img src='https://upload.wikimedia.org/wikipedia/commons/2/2f/Rickrolling_QR_code.png' alt='QR Code'>";
} else {
  echo "<p>Stok tidak mencukupi.</p>";
}
?>