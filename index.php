<?php
session_start();
$isLogin = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Top Up Valorant - AbahTopup</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://app.sandbox.midtrans.com/snap/snap.js"
          data-client-key="Mid-client-G_eLugz8Bc9tndFC"></script>
  <style>
    body {
      background: #1f1f1f;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
    }
    .section-title {
      background: #8f7454;
      color: #fff;
      padding: .5rem 1rem;
      border-radius: .375rem .375rem 0 0;
    }
    .section-box {
      background: #3b3f45;
      border-radius: .5rem;
      margin-bottom: 1rem;
      overflow: hidden;
    }
    .card {
      background: #5a5f66;
      padding: 1rem;
      border-radius: .5rem;
      color: #c9a77d;
    }
  </style>
</head>
<body class="px-4 py-6 relative">

<!-- ================= LOGIN / LOGOUT BUTTON + RIWAYAT ================= -->
<div class="absolute top-4 left-4 z-50 flex items-center space-x-2">
  <?php if ($isLogin): ?>
    <span class="mr-2 text-sm">👤 <?= htmlspecialchars($_SESSION['user']); ?></span>
    
    <!-- Tombol Riwayat -->
    <a href="riwayat.php"
       class="bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded text-white font-semibold">
      Riwayat
    </a>

    <!-- Tombol Logout -->
    <a href="logout.php"
       class="bg-red-600 hover:bg-red-500 px-4 py-2 rounded text-white font-semibold">
      Logout
    </a>
  <?php else: ?>
    <!-- Tombol Login -->
    <a href="auth.php"
       class="bg-[#a67c52] hover:bg-[#c9a77d] text-white font-semibold text-sm px-5 py-2 rounded-full shadow-md transition flex items-center space-x-2">
      <span>🔐</span>
      <span>Login / Daftar</span>
    </a>
  <?php endif; ?>
</div>

<!-- ================= BANNER HEADER ================= -->
<section class="relative w-full mb-6 mt-16">
  <img src="assets/banner.jpg" alt="Banner Valorant"
       class="w-full object-cover h-[260px] sm:h-[320px] md:h-[400px] rounded">
  <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 to-transparent p-4 flex items-center">
    <img src="assets/game-thumb.png" alt="Valorant Logo"
         class="w-20 h-20 rounded-lg mr-4 border border-white">
    <div>
      <h2 class="text-2xl font-bold text-white">VALORANT</h2>
      <p class="text-sm text-gray-300">Riot Games</p>
      <div class="flex gap-4 mt-2 text-sm text-white">
        <div class="flex items-center gap-1">⚡ Proses Cepat</div>
        <div class="flex items-center gap-1">💬 Layanan 24/7</div>
        <div class="flex items-center gap-1">🔒 Pembayaran Aman</div>
      </div>
    </div>
  </div>
</section>

<!-- ================= FORM ================= -->
<div class="section-box">
  <div class="section-title">1 &nbsp; Masukkan Data Akun</div>
  <div class="p-4">
    <label class="block mb-2">Valorant ID</label>
    <input id="riot_id" type="text" placeholder="Masukkan Valorant ID"
           class="w-full p-2 rounded bg-gray-600 text-white outline-none focus:ring focus:ring-yellow-400">
  </div>
</div>

<div class="section-box">
  <div class="section-title">2 &nbsp; Pilih Nominal</div>
  <div class="p-4">
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
      <label class="card cursor-pointer hover:brightness-110 transition">
        <input type="radio" name="amount" value="56843" class="hidden">
        <div class="text-sm font-bold">475 Points</div>
        <div class="text-lg">Rp 56.843</div>
        <div class="text-xs mt-2 bg-green-700 rounded px-2 py-1 inline-block text-white">🚀 Instan</div>
      </label>
      <label class="card cursor-pointer hover:brightness-110 transition">
        <input type="radio" name="amount" value="113685" class="hidden">
        <div class="text-sm font-bold">950 Points</div>
        <div class="text-lg">Rp 113.685</div>
        <div class="text-xs mt-2 bg-green-700 rounded px-2 py-1 inline-block text-white">🚀 Instan</div>
      </label>
      <label class="card cursor-pointer hover:brightness-110 transition">
        <input type="radio" name="amount" value="170528" class="hidden">
        <div class="text-sm font-bold">1475 Points</div>
        <div class="text-lg">Rp 170.528</div>
        <div class="text-xs mt-2 bg-green-700 rounded px-2 py-1 inline-block text-white">🚀 Instan</div>
      </label>
    </div>
  </div>
</div>

<div class="section-box">
  <div class="section-title">3 &nbsp; Masukkan Jumlah Pembelian</div>
  <div class="p-4 flex items-center space-x-2">
    <input type="number" id="quantity" min="1" value="1"
           class="flex-1 p-2 rounded bg-gray-600 text-white outline-none">
    <button onclick="document.getElementById('quantity').stepUp(); updateTotal();"
            class="bg-yellow-600 px-3 py-2 rounded text-white">+</button>
    <button onclick="document.getElementById('quantity').stepDown(); updateTotal();"
            class="bg-gray-700 px-3 py-2 rounded text-white">−</button>
  </div>
</div>

<div class="section-box">
  <div class="section-title">4 &nbsp; Detail Kontak</div>
  <div class="p-4">
    <label class="block mb-2">No. WhatsApp</label>
    <div class="flex items-center bg-gray-600 rounded overflow-hidden">
      <span class="px-3">🇮🇩</span>
      <span class="bg-gray-700 px-2">+62</span>
      <input type="tel" id="phone" class="flex-1 p-2 bg-gray-600 text-white outline-none">
    </div>
    <p class="text-xs mt-2 text-gray-300">* Untuk konfirmasi jika ada kendala</p>
  </div>
</div>

<div class="section-box">
  <div class="section-title">5 &nbsp; Kode Promo</div>
  <div class="p-4 space-y-3">
    <div class="flex space-x-2">
      <input type="text" id="promo" placeholder="Opsional"
             class="flex-1 p-2 rounded bg-gray-600 text-white outline-none">
      <button onclick="updateTotal()" class="bg-yellow-700 px-4 rounded text-white">Gunakan</button>
    </div>
    <div id="summary" class="text-sm text-white space-y-1">
      <p>Total: <span id="totalHarga">Rp -</span></p>
      <p id="diskonText" class="text-green-400 hidden">🎉 Diskon 5% kode "mantap" diterapkan</p>
    </div>
  </div>
</div>

<div class="mt-6 text-center">
  <button onclick="submitPayment()"
          class="bg-red-600 px-8 py-3 rounded text-white text-lg font-semibold hover:bg-red-700 transition">
    🔥 Bayar Sekarang
  </button>
</div>

<!-- ================= PETUNJUK ================= -->
<div class="mt-8 max-w-2xl mx-auto text-sm text-gray-300 leading-relaxed">
  <h3 class="text-lg font-semibold text-white mb-2">📌 Cara Top-Up:</h3>
  <ol class="list-decimal ml-5 space-y-1">
    <li>Masukkan ID Valorant kamu dengan benar</li>
    <li>Pilih jumlah poin yang ingin dibeli</li>
    <li>Masukkan jumlah pembelian (misal: 2x 475 VP)</li>
    <li>Isi nomor WhatsApp untuk konfirmasi</li>
    <li>(Opsional) Masukkan kode promo, contoh: <code>mantap</code></li>
    <li>Tekan tombol "Bayar Sekarang" dan selesaikan pembayaran</li>
    <li>Item akan masuk otomatis dalam beberapa menit 🚀</li>
  </ol>
</div>

<script>
  function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR'
    }).format(angka);
  }

  function updateTotal() {
    const sel = document.querySelector('input[name="amount"]:checked');
    const promo = document.getElementById('promo').value.trim().toLowerCase();
    const quantity = parseInt(document.getElementById('quantity').value) || 1;

    if (!sel) return;

    let harga = parseInt(sel.value);
    let total = harga * quantity;
    let diskon = 0;

    const diskonText = document.getElementById('diskonText');
    if (promo === 'mantap') {
      diskon = total * 0.05;
      total -= diskon;
      diskonText.classList.remove('hidden');
    } else {
      diskonText.classList.add('hidden');
    }

    document.getElementById('totalHarga').textContent = formatRupiah(total);
  }

  document.querySelectorAll('input[name="amount"], #quantity').forEach(el => {
    el.addEventListener('input', updateTotal);
    el.addEventListener('change', updateTotal);
  });

  async function submitPayment() {
    const riot_id = document.getElementById('riot_id').value.trim();
    const sel = document.querySelector('input[name="amount"]:checked');
    const quantity = parseInt(document.getElementById('quantity').value);
    const phone = document.getElementById('phone').value.trim();
    const promo = document.getElementById('promo').value.trim().toLowerCase();

    if (!riot_id || !sel) {
      alert('Isi Valorant ID & pilih nominal.');
      return;
    }

    let harga = parseInt(sel.value);
    let total = harga * quantity;

    if (promo === 'mantap') {
      total -= Math.floor(total * 0.05);
    }

    const form = new FormData();
    form.append('riot_id', riot_id);
    form.append('amount', total);
    form.append('phone', phone);

    const res = await fetch('payment.php', {
      method: 'POST',
      body: form
    });

    const data = await res.json();

    if (data.snap_token) {
      snap.pay(data.snap_token);
    } else {
      alert('Gagal: ' + (data.error || 'Terjadi kesalahan'));
    }
  }

  window.addEventListener('DOMContentLoaded', updateTotal);
</script>
<!-- ================= FLOATING BANTUAN DENGAN SVG ================= -->
<div id="bantuan-container" class="fixed bottom-6 right-6 z-50 text-right">
  <!-- Tombol Utama -->
  <button onclick="toggleHelp()"
          class="flex items-center gap-2 bg-yellow-600 hover:bg-yellow-500 text-white px-4 py-2 rounded-full shadow-lg transition transform hover:scale-105"
          title="Butuh Bantuan?">
    <!-- SVG Icon Customer Service -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M2.25 12a9.75 9.75 0 0119.5 0v.75a2.25 2.25 0 01-2.25 2.25H17.1c-.315 0-.582.21-.645.518l-.375 1.876a.75.75 0 01-1.476.018l-.365-1.458a.75.75 0 00-.728-.561H9.75a.75.75 0 00-.728.561l-.365 1.458a.75.75 0 01-1.476-.018l-.375-1.876A.656.656 0 016.9 15H4.5A2.25 2.25 0 012.25 12.75V12z" />
    </svg>
    <!-- Teks -->
    <span class="font-medium hidden sm:inline">Butuh Bantuan?</span>
  </button>

  <!-- Tombol WhatsApp -->
  <a id="wa-button"
     href="https://wa.me/6289614247391?text=Halo%20Admin,%20saya%20butuh%20bantuan%20top-up%20Valorant"
     target="_blank"
     class="mt-3 inline-block bg-green-600 text-white text-sm px-4 py-2 rounded-full shadow-md opacity-0 pointer-events-none translate-y-4 transition-all duration-300">
     💬 Chat WhatsApp
  </a>
</div>

<!-- Script Toggle -->
<script>
  function toggleHelp() {
    const waBtn = document.getElementById('wa-button');
    const isVisible = waBtn.classList.contains('opacity-100');

    if (isVisible) {
      waBtn.classList.remove('opacity-100', 'translate-y-0');
      waBtn.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
    } else {
      waBtn.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
      waBtn.classList.add('opacity-100', 'translate-y-0');
    }
  }
</script>

</body>
</html>
