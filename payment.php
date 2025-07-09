<?php
session_start();
require_once 'midtrans_config.php'; // file config Midtrans (isi serverKey + clientKey)
include 'db.php'; // koneksi ke database

header('Content-Type: application/json');

// Ambil data dari form
$riot_id  = $_POST['riot_id'] ?? '';
$amount   = (int)($_POST['amount'] ?? 0);
$phone    = $_POST['phone'] ?? '';
$quantity = (int)($_POST['quantity'] ?? 1);
$produk   = $_POST['produk'] ?? 'Valorant VP';

// Ambil email & username dari session
$email_user = $_SESSION['user'] ?? 'guest@example.com';
$username   = $_SESSION['user'] ?? 'guest';

if (!$riot_id || !$amount || !$phone) {
  echo json_encode(['error' => 'Data tidak lengkap']);
  exit;
}

// Buat order_id unik
$order_id = 'VALO-' . time() . rand(100, 999);

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO transaksi (user, produk, jumlah, total, order_id, status) 
                        VALUES (?, ?, ?, ?, ?, 'Pending')");
$stmt->bind_param("ssiss", $username, $produk, $quantity, $amount, $order_id);
$stmt->execute();

// Siapkan parameter Snap Midtrans
$params = [
  'transaction_details' => [
    'order_id'     => $order_id,
    'gross_amount' => $amount
  ],
  'item_details' => [[
    'id'       => 'vp',
    'price'    => $amount,
    'quantity' => $quantity,
    'name'     => $produk
  ]],
  'customer_details' => [
    'first_name' => $riot_id,
    'email'      => $email_user,
    'phone'      => $phone
  ]
];

// Dapatkan Snap Token
try {
  $snapToken = \Midtrans\Snap::getSnapToken($params);
  echo json_encode(['snap_token' => $snapToken]);
} catch (Exception $e) {
  echo json_encode(['error' => $e->getMessage()]);
}
