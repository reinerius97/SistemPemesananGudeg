<?= $this->include('layouts/header') ?>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">

        <!-- TITLE -->
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-secondary mb-4">
                Pesanan Berhasil Dibuat!
            </h1>
            <p class="text-lg text-gray-600">
                Terima kasih telah order di 
                <span class="font-bold text-orange-600">Gudeg Diajeng</span>
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- LEFT COLUMN -->
            <div class="lg:col-span-2 space-y-6">

                <!-- ORDER NUMBER -->
                <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                    <p class="text-sm text-gray-500 uppercase tracking-wider mb-2">Nomor Pesanan</p>
                    <p class="text-4xl font-bold text-primary">
                        #<?= sprintf('%05d', $pesanan['id']) ?>
                    </p>
                    <p class="text-sm text-gray-500 mt-3">
                        <?= date('d F Y, H:i', strtotime($pesanan['created_at'])) ?> WIB
                    </p>
                </div>

               

                <!-- WAITING INFO -->
                <div class="bg-orange-50 border-2 border-orange-300 rounded-xl p-8">
                    <h3 class="text-xl font-bold text-orange-700 mb-4">
                        Menunggu Verifikasi Pembayaran
                    </h3>
                    <p class="text-lg text-gray-700 leading-relaxed">
                        Admin akan memverifikasi bukti pembayaran Anda dalam waktu 
                        <span class="font-bold text-orange-600">maksimal 30 menit</span>.
                    </p>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-8 sticky top-6">

                    <h3 class="text-xl font-bold text-gray-800 mb-6">Total Pembayaran</h3>

                    <!-- TOTAL BOX -->
                    <div class="bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-xl p-8 text-center shadow-xl">
                        <p class="text-lg opacity-90">Total yang telah dibayar</p>
                        <p class="text-4xl font-bold mt-3">
                            Rp <?= number_format($pesanan['total_harga']) ?>
                        </p>

                        <!-- Dynamic Ongkir -->
                        <p class="text-sm mt-3 opacity-90">
                            Ongkir: Rp <?= number_format($pesanan['ongkir']) ?>
                        </p>

                        <!-- Jarak -->
                        <p class="text-sm mt-1 opacity-80">
                            Jarak: <?= esc($pesanan['jarak_km']) ?> km
                        </p>
                    </div>

                    <div class="mt-8 space-y-4">
                        <a href="<?= base_url('orders/history') ?>"
                           class="block w-full bg-primary hover:bg-orange-700 text-white font-bold text-lg py-5 rounded-full text-center transition transform hover:scale-105 shadow-lg">
                            <i class="fas fa-list mr-2"></i>
                            Lihat Riwayat Pesanan
                        </a>

                        <a href="<?= base_url('/') ?>"
                           class="block w-full bg-gray-700 hover:bg-gray-800 text-white font-bold text-lg py-5 rounded-full text-center transition transform hover:scale-105 shadow-lg">
                            <i class="fas fa-home mr-2"></i>
                            Kembali ke Beranda
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<?= $this->include('layouts/footer') ?>
