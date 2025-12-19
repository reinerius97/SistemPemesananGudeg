<?= $this->include('layouts/header') ?>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4">

        <a href="<?= base_url('orders/history') ?>" 
           class="inline-flex items-center text-primary hover:text-orange-600 mb-6 transition text-sm font-medium">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat
        </a>

        <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-8">
            Detail Pesanan #<?= sprintf('%05d', $order['id']) ?>
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- ========================= -->
            <!-- KOLOM KIRI -->
            <!-- ========================= -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Informasi Pengiriman -->
                <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-truck text-primary mr-3"></i> Informasi Pengiriman
                    </h3>

                    <div class="space-y-4 text-gray-700">
                        <div>
                            <p class="text-sm text-gray-500">Nama Penerima</p>
                            <p class="font-semibold text-lg"><?= esc($order['nama_pelanggan']) ?></p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">No. Telepon</p>
                            <p class="font-semibold">
                                <a href="tel:<?= esc($order['no_telepon']) ?>" 
                                   class="text-primary hover:underline">
                                    <?= esc($order['no_telepon']) ?>
                                </a>
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Alamat Lengkap</p>
                            <p class="font-medium leading-relaxed"><?= nl2br(esc($order['alamat_pengiriman'])) ?></p>
                        </div>

                        <!-- Tambahkan Jarak -->
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                            Jarak: <span class="font-semibold ml-1">
                                <?= number_format($order['jarak_km'], 1) ?> km
                            </span>
                        </div>

                        <?php if (!empty($order['catatan'])): ?>
                        <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm font-medium text-yellow-800 flex items-center">
                                <i class="fas fa-sticky-note mr-2"></i> Catatan Pesanan:
                            </p>
                            <p class="mt-2 text-gray-700"><?= esc($order['catatan']) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Items Pesanan -->
                <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-utensils text-primary mr-3"></i> Items Pesanan
                    </h3>

                    <div class="space-y-4">
                        <?php foreach ($items as $item): ?>
                        <div class="flex items-center justify-between py-4 border-b last:border-0">
                            <div class="flex items-center space-x-4">

                                <?php if (!empty($item['gambar'])): ?>
                                    <img src="<?= base_url('uploads/menu/' . $item['gambar']) ?>"
                                         class="w-16 h-16 object-cover rounded-lg shadow-sm">
                                <?php else: ?>
                                    <div class="w-16 h-16 bg-gray-200 flex items-center justify-center rounded-lg">
                                        <i class="fas fa-utensils text-gray-400"></i>
                                    </div>
                                <?php endif; ?>

                                <div>
                                    <p class="font-medium text-gray-800"><?= esc($item['nama_menu']) ?></p>
                                    <p class="text-sm text-gray-500">
                                        Rp <?= number_format($item['harga']) ?> × <?= $item['jumlah'] ?>
                                    </p>
                                </div>
                            </div>

                            <p class="font-bold text-primary">
                                Rp <?= number_format($item['subtotal']) ?>
                            </p>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Ringkasan Total -->
                    <div class="mt-6 pt-6 border-t space-y-3 text-lg">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp <?= number_format($order['subtotal']) ?></span>
                        </div>

                        <div class="flex justify-between">
                            <span>Ongkos Kirim</span>
                            <span>Rp <?= number_format($order['ongkir']) ?></span>
                        </div>

                        <div class="flex justify-between font-bold text-xl border-t pt-4 text-primary">
                            <span>Total Pembayaran</span>
                            <span>Rp <?= number_format($order['total_harga']) ?></span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ========================= -->
            <!-- KOLOM KANAN -->
            <!-- ========================= -->
            <div class="space-y-6">

                <!-- STATUS PESANAN -->
                <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-tasks text-primary mr-3"></i> Status Pesanan
                    </h3>

                    <?php 
                        $st = $order['status_pesanan_nama'];
                        $colorSt = [
                            'Diproses'   => 'bg-blue-600',
                            'Pengiriman' => 'bg-yellow-600',
                            'Selesai'    => 'bg-green-600',
                            'Dibatalkan' => 'bg-red-600'
                        ][$st] ?? 'bg-gray-600';
                    ?>

                    <div class="text-center">
                        <span class="inline-block px-6 py-3 rounded-full text-white font-bold text-lg <?= $colorSt ?>">
                            <?= esc($st) ?>
                        </span>
                        <p class="mt-4 text-sm text-gray-500">
                            <?= date('d F Y, H:i', strtotime($order['created_at'])) ?> WIB
                        </p>
                    </div>
                </div>

                <!-- PEMBAYARAN -->
                <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-qrcode text-primary mr-3"></i> Pembayaran (<?= esc($order['metode_nama']) ?>)
                    </h3>

                    <?php
                        $ver = $order['verifikasi_status'] ?? 'Menunggu';
                        $verColor = [
                            'Menunggu' => 'bg-orange-600',
                            'Diterima' => 'bg-green-600',
                            'Ditolak'  => 'bg-red-600'
                        ][$ver];
                    ?>

                    <div class="mb-6 text-center">
                        <span class="inline-block px-6 py-3 rounded-full text-white font-bold text-lg <?= $verColor ?>">
                            <?= esc($ver) ?>
                        </span>
                    </div>

                    <!-- Bukti Pembayaran -->
                    <?php if (!empty($order['bukti_path'])): ?>
                        <div class="bg-gray-50 rounded-xl p-4 border-2 border-dashed border-gray-300">
                            <p class="text-sm font-medium text-gray-700 mb-3 text-center">Bukti Pembayaran</p>

                            <a href="<?= base_url($order['bukti_path']) ?>" target="_blank">
                                <img src="<?= base_url($order['bukti_path']) ?>" 
                                     class="w-full rounded-lg shadow-md hover:shadow-xl transition">
                            </a>

                            <p class="text-xs text-gray-500 text-center mt-3">
                                Klik gambar untuk memperbesar
                            </p>
                        </div>
                    <?php else: ?>
                        <p class="text-center text-gray-500 text-sm">Bukti pembayaran belum tersedia</p>
                    <?php endif; ?>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/6282113670569?text=Halo%20Admin,%20saya%20mau%20menanyakan%20pesanan%20%23<?= sprintf('%05d', $order['id']) ?>"
                       target="_blank"
                       class="block mt-6 text-center bg-green-600 text-white font-bold py-4 rounded-full hover:bg-green-700 transition shadow-lg">
                       <i class="fab fa-whatsapp text-xl mr-2"></i>
                       Hubungi Admin via WhatsApp
                    </a>

                </div>
            </div>

        </div>
    </div>
</section>

<?= $this->include('layouts/footer') ?>
