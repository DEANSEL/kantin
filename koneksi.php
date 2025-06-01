<?php

$host       ="localhost";
$username   ="root";
$password   ="";
$database   ="kantin2";

$koneksi = new mysqli($host, $username, $password, $database);
if(!$koneksi){
    die("Koneksi Gagal!" . mysqli_connect_error());
}

// pesan

if(isset($_POST['pesan'])) {
  $id = $_POST['menu_id'];
  $jumlah = $_POST['jumlah'];

  $menu = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM menu WHERE id = $id"));

  if ($jumlah > $menu['stok']) {
    echo "
    <script>
        alert('Stok tidak cukup!');
        window.location.href = 'index.php';
    </script>
    ";
  } else {
    $total = $menu['harga'] * $jumlah;
    mysqli_query($koneksi, "UPDATE menu SET stok = stok - $jumlah WHERE id = $id");

    // Setelah pesanan berhasil
    echo "
    <div style='text-align:center; margin-top: 30px;'>
    <p><strong>Scan QR Code untuk melanjutkan pembayaran:</strong></p>
    <img src='img/qr.png' alt='QR Dummy' style='width: 500px;'><br><br>
    <button onclick='selesaiBayar()' class='btn btn-success'>Done</button>
    </div>

    <script>
    function selesaiBayar() {
    alert('Pembayaran berhasil!');
    window.location.href = 'index.php';
    }
    </script>
    ";
    exit;

  }
}

?>