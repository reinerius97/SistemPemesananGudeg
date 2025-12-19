<?= $this->include('layouts/header') ?>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-8 text-center">Checkout Pesanan</h2>

        <!-- FLASH MESSAGES -->
        <?php if (session('errors')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside space-y-1">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <?= session('success') ?>
            </div>
        <?php endif; ?>

        
        <form method="post" 
            action="<?= base_url('cart/processCheckout') ?>"
            id="checkout-form"
            enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- KOLOM KIRI: DATA PELANGGAN + CATATAN -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- DATA PELANGGAN -->
                    <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-xl font-bold text-gray-800 flex items-center">
                                <i class="fas fa-user mr-3 text-primary"></i> Informasi Pengiriman
                            </h4>
                            
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-500">Nama Penerima</p>
                                <p class="font-semibold text-lg"><?= esc($pelanggan['nama_pelanggan']) ?></p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">No. Telepon</p>
                                <p class="font-semibold">
                                    <a href="tel:<?= esc($pelanggan['no_telepon']) ?>" 
                                       class="text-primary hover:underline">
                                        <?= esc($pelanggan['no_telepon']) ?>
                                    </a>
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-semibold"><?= esc($pelanggan['email'] ?? '-') ?></p>
                            </div>

                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-500">Alamat Lengkap</p>
                                <p class="font-medium leading-relaxed"><?= nl2br(esc($pelanggan['alamat'])) ?></p>
                            </div>
                            <!-- TOMBOL AMBIL LOKASI GPS -->
                            <div class="md:col-span-2 mt-4">
                                <button type="button" 
                                        onclick="getLocation()" 
                                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-orange-600 transition">
                                    Gunakan Lokasi Saya
                                </button>

                                <!-- HIDDEN INPUT UNTUK LAT/LONG -->
                                <input type="hidden" id="latitude" name="latitude">
                                <input type="hidden" id="longitude" name="longitude">

                                <p id="gps-status" class="text-sm text-gray-500 mt-2"></p>
                            </div>

                        </div>
                    </div>

                    <!-- CATATAN PESANAN -->
                    <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">
                        <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-sticky-note mr-3 text-primary"></i> Catatan Pesanan (Opsional)
                        </h4>
                        <textarea 
                            name="notes" 
                            rows="3" 
                            class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition" 
                            placeholder="Contoh: Tolong antar ke lantai 2, ketuk pintu keras"
                        ><?= esc(old('notes')) ?></textarea>
                    </div>
                </div>

                <!-- KOLOM KANAN: RINGKASAN -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg sticky top-6">
                        <h4 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-receipt mr-3 text-primary"></i> Ringkasan Pesanan
                        </h4>

                        <!-- DAFTAR MENU -->
                        <div class="max-h-64 overflow-y-auto mb-6 space-y-3">
                            <?php foreach ($cart as $id => $item): ?>
                                <?php 
                                    $stokTersedia = $item['stok_tersedia'] ?? 0;
                                    $isHabis = $stokTersedia < $item['quantity'];
                                ?>
                                <div class="flex items-start space-x-3 p-3 rounded-lg <?= $isHabis ? 'bg-red-50 border border-red-200' : '' ?>">
                                    <?php if (!empty($item['gambar'])): ?>
                                        <img src="<?= base_url('uploads/menu/' . $item['gambar']) ?>" 
                                             alt="<?= esc($item['nama_menu']) ?>" 
                                             class="w-12 h-12 object-cover rounded-lg shadow-sm">
                                    <?php else: ?>
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-utensils text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>

                                    <div class="flex-1">
                                        <p class="font-medium text-sm text-gray-800 line-clamp-2">
                                            <?= esc($item['nama_menu']) ?> 
                                            <span class="text-xs text-gray-500">x<?= $item['quantity'] ?></span>
                                        </p>
                                        <?php if ($isHabis): ?>
                                            <p class="text-xs text-red-600 font-semibold mt-1">
                                                Stok hanya <?= $stokTersedia ?>
                                            </p>
                                        <?php endif; ?>
                                        <p class="text-sm font-semibold text-primary mt-1">
                                            Rp <?= number_format($item['price'] * $item['quantity']) ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- TOTAL -->
                        <div class="border-t pt-4 space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>Rp <?= number_format($subtotal) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Ongkos Kirim</span>
                                <span id="shipping-cost">Rp 0</span>
                                
                            </div>
                            <div class="flex justify-between text-lg font-bold text-gray-800 border-t pt-3">
                                <span>Total</span>
                                <span class="text-primary" id="total-price">Rp <?= number_format($subtotal) ?></span>
                            </div>
                        </div>

                        <!-- METODE PEMBAYARAN -->
                        <h4 class="text-lg font-bold text-gray-800 mt-6 mb-4 flex items-center">
                            <i class="fas fa-credit-card mr-3 text-primary"></i> Pembayaran via QRIS
                        </h4>

                        <div class="bg-orange-50 border-2 border-orange-200 rounded-xl p-6 text-center">
                            <p class="text-gray-700 mb-4 font-medium">
                                Scan QRIS di bawah ini untuk melakukan pembayaran
                            </p>

                            <!-- GAMBAR QRIS -->
                            <div class="inline-block p-5  rounded-xl shadow-lg">
                                <img src="<?= base_url('uploads/qris1.jpg') ?>" 
                                    alt="QRIS Gudeg Diajeng" 
                                    class="w-64 h-64 object-contain">
                            </div>

                            
                        </div>

                        <!-- UPLOAD BUKTI TRANSFER -->
                        <div class="mt-6 bg-red-50 border border-red-300 rounded-xl p-5">
                            <label for="bukti_pembayaran" class="block text-sm font-bold text-red-800 mb-3">
                                Upload Bukti Transfer
                            </label>
                            <input type="file" 
                                name="bukti_pembayaran" 
                                id="bukti_pembayaran"
                                accept="image/*" 
                                required
                                class="w-full px-4 py-3 border-2 border-dashed border-red-300 rounded-lg text-sm
                                        file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                                        file:text-sm file:font-semibold file:bg-red-600 file:text-white
                                        hover:file:bg-red-700 cursor-pointer">

                            <p class="text-xs text-gray-600 mt-3">
                                Format: JPG/PNG, maksimal 2MB. Pastikan nominal dan nama pengirim terlihat jelas.
                            </p>

                            <?php if (session('errors.bukti_pembayaran')): ?>
                                <p class="mt-2 text-xs text-red-600 font-medium">
                                    <?= esc(session('errors.bukti_pembayaran')) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                      

                        <!-- TOMBOL KONFIRMASI -->
                        <button 
                            type="submit" 
                            id="submit-btn"
                            class="w-full mt-8 bg-gradient-to-r from-orange-500 to-red-600 text-white font-bold py-5 rounded-full hover:from-orange-600 hover:to-red-700 transition transform hover:scale-105 flex items-center justify-center text-lg shadow-xl">
                            <i class="fas fa-paper-plane mr-3"></i>
                            <span id="btn-text">Konfirmasi & Upload Bukti</span>
                            <span id="btn-loading" class="hidden ml-2">
                                <i class="fas fa-spinner fa-spin"></i> Memproses...
                            </span>
                        </button>

                        <p class="mt-4 text-xs text-center text-gray-500 leading-relaxed">
                            Dengan menekan tombol di atas, Anda menyatakan telah melakukan pembayaran via QRIS<br>
                            dan bersedia menunggu verifikasi dari admin (maksimal 1x24 jam).
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- JS: LOADING -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('checkout-form');
    const submitBtn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const btnLoading = document.getElementById('btn-loading');

    form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        btnText.classList.add('hidden');
        btnLoading.classList.remove('hidden');
    });
});
</script>
<script>
const storeLat = -6.221010;  
const storeLon = 106.721068;


// Fungsi Haversine
function hitungJarakKm(lat1, lon1, lat2, lon2) {
    const R = 6371; 
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLon/2) * Math.sin(dLon/2);
    return R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)));
}

function getLocation() {
    if (!navigator.geolocation) {
        alert("Browser Anda tidak mendukung GPS");
        return;
    }

    navigator.geolocation.getCurrentPosition(function(pos) {

        const lat = pos.coords.latitude;
        const lon = pos.coords.longitude;

        // masukkan ke hidden form
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lon;

        // hitung jarak
        const jarak = hitungJarakKm(storeLat, storeLon, lat, lon);
        const jarakBulatan = Math.ceil(jarak); // pembulatan ke atas

        // hitung ongkir
        let ongkir = 0;
        if (jarakBulatan > 1) {
            ongkir = (jarakBulatan - 1) * 1000;
        }

        // tampilkan ongkir
        document.getElementById('shipping-cost').textContent = 
            "Rp " + ongkir.toLocaleString('id-ID');

        // hitung total baru
        const subtotal = <?= $subtotal ?>;
        const totalBaru = subtotal + ongkir;

        document.getElementById('total-price').textContent =
            "Rp " + totalBaru.toLocaleString('id-ID');

        alert("Lokasi berhasil diambil! Jarak: " + jarakBulatan + " km | Ongkir: Rp " + ongkir);

    }, function(err) {
        alert("Gagal mengambil lokasi. Pastikan GPS aktif.");
    });
}
</script>



<?= $this->include('layouts/footer') ?>