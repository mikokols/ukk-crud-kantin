<?php
include 'config.php';
$id = $_GET['id'];

//menyimpan data pembeli dari tabel pembelian
$data = $conn->query("SELECT * FROM pembelian WHERE id=$id")->fetch_assoc();
//menyimpan data makanan dari tabel makanan
$makanan = $conn->query("SELECT * FROM makanan WHERE id={$data['makanan_id']}")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //Mengambil jumlah pembelian baru yang diketik oleh user 
    $jumlahBaru = $_POST['jumlah'];
    // menghitung total harga dan makanan
  $totalBaru = $jumlahBaru * $makanan['harga'];

  // Hitung stok kembali
  $selisih = $jumlahBaru - $data['jumlah'];
  $stokBaru = $makanan['stok'] - $selisih;

  if ($stokBaru >= 0) {
    // update stok baru
    $conn->query("UPDATE makanan SET stok=$stokBaru WHERE id={$makanan['id']}");
    // update data  pembelian
    $conn->query("UPDATE pembelian SET jumlah=$jumlahBaru, total=$totalBaru WHERE id=$id");
    header("Location: index.php#buy");
  } else {
    echo "<p>Stok tidak cukup untuk update.</p>";
  }
}
?>

<h2>Edit Pesanan</h2>
<form method="post">
  <p>Menu: <?= $makanan['menu']; ?></p>
  <p>Harga: Rp<?= $makanan['harga']; ?></p>
  <div>
    <label>Jumlah Baru:</label>
    <input type="number" name="jumlah" value="<?= $data['jumlah']; ?>" min="1">
  </div>
  <button type="submit">Update</button>
</form>