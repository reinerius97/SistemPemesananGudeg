<?= $this->include('layouts/header') ?>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-4 md:mb-0">Riwayat Pesanan</h2>
            <a href="<?= base_url('menu') ?>" 
               class="inline-flex items-center bg-primary text-white px-6 py-3 rounded-full hover:bg-orange-600 transition font-medium text-lg shadow-md">
                <i class="fas fa-utensils mr-2"></i> Pesan Lagi
            </a>
        </div>

        <?php if (empty($orders)): ?>

            <div class="bg-white p-12 md:p-16 rounded-xl shadow-lg text-center">
                <i class="fas fa-shopping-bag text-7xl text-gray-300 mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-700 mb-3">Belum Ada Pesanan</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    Yuk, pesan menu favorit Anda!
                </p>
                <a href="<?= base_url('menu') ?>" 
                   class="inline-flex items-center bg-primary text-white px-8 py-4 rounded-full hover:bg-orange-600 transition font-bold text-lg shadow-lg">
                    <i class="fas fa-utensils mr-3"></i> Lihat Menu
                </a>
            </div>

        <?php else: ?>

            <div class="space-y-6">

                <?php foreach ($orders as $order): ?>
                    <?php
                        $itemCount   = $order['item_count'];
                        $items       = $order['item_summary'];

                        $statusPesanan = $order['status_pesanan_nama'];
                        $verifStatus   = $order['verifikasi_status'] ?? 'Menunggu';

                        $colorVerif = [
                            'Menunggu' => 'bg-yellow-500',
                            'Diterima' => 'bg-green-600',
                            'Ditolak'  => 'bg-red-600',
                        ][$verifStatus];

                        $metodeBayar = $order['metode_nama'] ?? '-';
                        $buktiPath   = $order['bukti_path'] ?? null;

                        // Baru: ongkir & jarak
                        $ongkir   = $order['ongkir'] ?? 0;
                        $jarakKm  = $order['jarak_km'] ?? 0;
                    ?>

                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300">

                        <div class="p-6 md:p-8">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                                <!-- INFO UTAMA -->
                                <div class="flex-1">

                                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-4">
                                        <h3 class="text-xl font-bold text-gray-800">
                                            Pesanan #<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?>
                                        </h3>

                                        <!-- STATUS PESANAN -->
                                        <span class="px-4 py-1.5 rounded-full text-xs font-bold text-white
                                            <?= $statusPesanan === 'Diproses' ? 'bg-blue-600' : 
                                               ($statusPesanan === 'Pengiriman' ? 'bg-yellow-600' : 
                                               ($statusPesanan === 'Selesai' ? 'bg-green-600' : 'bg-gray-600')) ?>">
                                            <?= esc($statusPesanan) ?>
                                        </span>

                                        <!-- STATUS VERIFIKASI -->
                                        
                                    </div>

                                    <!-- DETAIL KECIL -->
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm text-gray-600">

                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                                            <?= date('d M Y', strtotime($order['created_at'])) ?>
                                            <span class="ml-1 text-gray-400">
                                                <?= date('H:i', strtotime($order['created_at'])) ?> WIB
                                            </span>
                                        </div>

                                        <div class="flex items-center">
                                            <i class="fas fa-box mr-2 text-primary"></i>
                                            <?= $itemCount ?> item
                                        </div>

                                        <div class="flex items-center">
                                            <i class="fas fa-qrcode mr-2 text-primary"></i>
                                            <?= esc($metodeBayar) ?>
                                        </div>

                                        <!-- BARU: Distance -->
                                        <div class="flex items-center">
                                            <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                                            <?= number_format($jarakKm, 1) ?> km
                                        </div>

                                        <!-- BARU: Dynamic Ongkir -->
                                        <div class="flex items-center">
                                            <i class="fas fa-truck mr-2 text-primary"></i>
                                            Ongkir: Rp <?= number_format($ongkir) ?>
                                        </div>

                                    </div>

                                </div>

                                <!-- TOTAL & AKSI -->
                                <div class="text-right">
                                    <p class="text-sm text-gray-500 mb-1">Total Pesanan</p>
                                    <p class="text-3xl font-bold text-primary">
                                        Rp <?= number_format($order['total_harga']) ?>
                                    </p>

                                    <div class="mt-4 space-x-2">
                                        <a href="<?= base_url('orders/detail/' . $order['id']) ?>"
                                           class="inline-flex items-center bg-primary text-white px-5 py-2.5 rounded-full hover:bg-orange-600 transition font-medium text-sm shadow-md">
                                            <i class="fas fa-eye mr-2"></i> Lihat Detail
                                        </a>

                                        <?php if ($buktiPath): ?>
                                            
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FOOTER ITEM SUMMARY -->
                        <div class="border-t border-gray-100 bg-gray-50 px-6 py-4">
                            <div class="flex flex-wrap items-center gap-3">

                                <?php foreach ($items as $index => $item): ?>
                                    <?php if ($index < 3): ?>
                                        <div class="flex items-center gap-2">
                                            <?php if (!empty($item['gambar'])): ?>
                                                <img src="<?= base_url('uploads/menu/' . $item['gambar']) ?>"
                                                     class="w-10 h-10 object-cover rounded-lg shadow-sm">
                                            <?php else: ?>
                                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-utensils text-gray-400 text-xs"></i>
                                                </div>
                                            <?php endif; ?>

                                            <span class="text-sm text-gray-700">
                                                <?= esc($item['nama_menu']) ?> 
                                                <span class="text-gray-500">x<?= $item['jumlah'] ?></span>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($index == 2 && count($items) > 3): ?>
                                        <span class="text-sm text-gray-500 font-medium">
                                            +<?= count($items) - 3 ?> item lain
                                        </span>
                                    <?php endif; ?>

                                <?php endforeach; ?>

                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-10 flex justify-center">
                <?= $pager->links('orders', 'default_template') ?>
            </div>

        <?php endif; ?>
    </div>
</section>

<?= $this->include('layouts/footer') ?>
