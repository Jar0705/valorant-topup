<?php
$host = 'localhost';
$user = 'root'; // ganti jika beda
$pass = '';
$dbname = 'valorant_topup';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
