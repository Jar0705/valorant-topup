<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: auth.php');
  exit;
}

include 'db.php';

$username = $_SESSION['user'];

// Ambil transaksi berdasarkan user login
$sql = "SELECT * FROM transaksi WHERE user = ? ORDER BY tanggal DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Riwayat Transaksi - AbahTopup</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white px-4 py-6 font-sans">

<div class="max-w-5xl mx-auto">
  <h1 class="text-3xl font-bold mb-6">📜 Riwayat Transaksi</h1>

  <div class="mb-6 flex justify-between items-center">
    <div>👤 Login sebagai: <strong><?= htmlspecialchars($username) ?></strong></div>
    <a href="index.php" class="bg-yellow-600 hover:bg-yellow-500 text-white px-4 py-2 rounded">⬅️ Kembali</a>
  </div>

  <?php if ($result->num_rows > 0): ?>
    <div class="overflow-x-auto">
      <table class="w-full text-left border border-gray-700">
        <thead class="bg-gray-800 text-sm uppercase">
          <tr>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Produk</th>
            <th class="p-3">Jumlah</th>
            <th class="p-3">Total</th>
            <th class="p-3">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="border-t border-gray-700 hover:bg-gray-800 transition">
              <td class="p-3"><?= $row['tanggal'] ?></td>
              <td class="p-3"><?= htmlspecialchars($row['produk']) ?></td>
              <td class="p-3"><?= $row['jumlah'] ?></td>
              <td class="p-3">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
              <td class="p-3">
                <span class="<?= $row['status'] === 'Sukses' ? 'text-green-400' : ($row['status'] === 'Pending' ? 'text-yellow-400' : 'text-red-400') ?>">
                  <?= $row['status'] ?>
                </span>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-gray-400">Belum ada transaksi untuk akun ini.</p>
  <?php endif; ?>

</div>

</body>
</html>
