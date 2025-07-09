<?php
require_once 'midtrans_config.php'; // Midtrans config
include 'db.php';

$notif = json_decode(file_get_contents("php://input"));

if (!$notif || !isset($notif->order_id)) {
  http_response_code(400);
  echo "Invalid payload";
  exit;
}

$order_id = $notif->order_id;
$status_midtrans = $notif->transaction_status;

// Mapping status
$status_map = [
  'settlement' => 'Sukses',
  'capture'    => 'Sukses',
  'pending'    => 'Pending',
  'expire'     => 'Gagal',
  'cancel'     => 'Gagal',
  'deny'       => 'Gagal'
];

$final_status = $status_map[$status_midtrans] ?? 'Pending';

// Update transaksi
$stmt = $conn->prepare("UPDATE transaksi SET status=? WHERE order_id=?");
$stmt->bind_param("ss", $final_status, $order_id);
$stmt->execute();

echo "OK";
