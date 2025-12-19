<?= $this->include('layouts/header') ?>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <h2 class="text-3xl font-bold text-secondary">Kelola Pesanan</h2>

            <!-- FILTER STATUS -->
            
        </div>

        <!-- LIST PESANAN -->
        <div id="orders-container" class="space-y-4">

            <?php foreach ($pesanan as $order): ?>
                <?php 
                    $items = $order['items'] ?? [];
                    $itemCount = array_sum(array_column($items, 'jumlah'));

                    $pembayaran = $order['verifikasi_status'] ?? 'Menunggu';
                    $colorPay = [
                        'Menunggu' => 'text-yellow-600',
                        'Diterima' => 'text-green-600',
                        'Ditolak'  => 'text-red-600'
                    ][$pembayaran];
                ?>

                <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition"
                     data-status-id="<?= $order['status_pesanan_id'] ?>">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        
                        <!-- KIRI -->
                        <div class="flex-1">
                            <div class="flex items-center gap-3">
                                <h3 class="font-bold text-lg">#<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></h3>

                                <!-- BADGE STATUS -->
                                <span class="px-3 py-1 rounded-full text-xs font-medium text-white status-badge
                                    <?= $order['status_pesanan_id'] == 1 ? 'bg-blue-600' : '' ?>
                                    <?= $order['status_pesanan_id'] == 2 ? 'bg-yellow-500' : '' ?>
                                    <?= $order['status_pesanan_id'] == 3 ? 'bg-green-600' : '' ?>
                                    <?= $order['status_pesanan_id'] == 4 ? 'bg-red-600' : '' ?>"
                                    data-current="<?= $order['status_pesanan_id'] ?>">
                                    <?= esc($order['status_pesanan_nama']) ?>
                                </span>
                            </div>

                            <div class="text-sm text-gray-600 mt-1 space-y-1">
                                <p><i class="fas fa-calendar mr-1"></i> <?= date('d M Y, H:i', strtotime($order['created_at'])) ?></p>
                                <p><i class="fas fa-user mr-1"></i> <?= esc($order['nama_pelanggan']) ?></p>
                                <p><i class="fas fa-box mr-1"></i> <?= $itemCount ?> item</p>

                                <!-- ONGKIR + JARAK -->
                                <p>
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    Ongkir: <span class="font-semibold">Rp <?= number_format($order['ongkir']) ?></span>
                                    <?php if (!empty($order['jarak_km'])): ?>
                                        <span class="text-xs text-gray-500">(<?= round($order['jarak_km'], 2) ?> km)</span>
                                    <?php endif; ?>
                                </p>

                                <!-- STATUS PEMBAYARAN -->
                                <p>
                                    <i class="fas fa-money-check mr-1"></i>
                                    Pembayaran:
                                    <span class="font-bold <?= $colorPay ?>">
                                        <?= esc($pembayaran) ?>
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- KANAN -->
                        <div class="text-right">

                            <p class="text-2xl font-bold text-primary">
                                Rp <?= number_format($order['total_harga'], 0) ?>
                            </p>

                            <!-- DROPDOWN STATUS -->
                            <select onchange="updateStatus(<?= $order['id'] ?>, this)" 
                                    class="mt-2 px-3 py-1 text-sm border rounded-lg focus:outline-none focus:border-primary">

                                <?php foreach ($statuses as $st): ?>
                                    <option value="<?= $st['id'] ?>" 
                                        <?= $order['status_pesanan_id'] == $st['id'] ? 'selected' : '' ?>>
                                        <?= esc($st['nama_status']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <!-- LIHAT BUKTI PEMBAYARAN -->
                            <?php if (!empty($order['bukti_path'])): ?>
                                <a href="<?= base_url($order['bukti_path']) ?>" 
                                   target="_blank"
                                   class="block text-blue-600 text-sm mt-3 hover:underline">
                                    <i class="fas fa-image mr-1"></i> Lihat Bukti
                                </a>
                            <?php endif; ?>

                            <!-- DROPDOWN VERIFIKASI PEMBAYARAN -->
                            <select onchange="updateVerifikasi(<?= $order['id'] ?>, this)"
                                    class="mt-2 px-3 py-1 text-sm border rounded-lg focus:outline-none focus:border-green-600">

                                <option value="Menunggu" <?= $pembayaran == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                                <option value="Diterima" <?= $pembayaran == 'Diterima' ? 'selected' : '' ?>>Diterima</option>
                                <option value="Ditolak"  <?= $pembayaran == 'Ditolak'  ? 'selected' : '' ?>>Ditolak</option>
                            </select>

                        </div>
                    </div>

                    <!-- RINGKASAN ITEM -->
                    <?php if (!empty($items)): ?>
                        <div class="mt-3 pt-3 border-t text-xs text-gray-600 flex flex-wrap gap-2">
                            <?php foreach ($items as $i => $item): ?>
                                <span><?= esc($item['menu_name']) ?> x<?= $item['jumlah'] ?></span>
                                <?= $i < count($items) - 1 ? '•' : '' ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endforeach; ?>
        </div>

        <!-- EMPTY -->
        <?php if (empty($pesanan)): ?>
            <div class="bg-white p-12 rounded-xl shadow-md text-center">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Belum ada pesanan</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<meta name="csrf-token" content="<?= csrf_hash() ?>">

<script>
    function updateStatus(orderId, select) {
        const newStatusId = select.value;
        const card = select.closest('[data-status-id]');
        const badge = card.querySelector('.status-badge');
        const oldStatusId = badge.dataset.current;

        fetch(`<?= base_url('admin/orders/update-status') ?>/${orderId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            },
            body: JSON.stringify({ status_id: newStatusId })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {

                badge.dataset.current = newStatusId;
                card.dataset.statusId = newStatusId;
                
                const selectedText = select.options[select.selectedIndex].text;
                badge.textContent = selectedText;

                badge.className =
                    "px-3 py-1 rounded-full text-xs font-medium text-white status-badge " +
                    (newStatusId == 1 ? "bg-blue-600" :
                     newStatusId == 2 ? "bg-yellow-500" :
                     newStatusId == 3 ? "bg-green-600" :
                                        "bg-red-600");

                showToast("Status diperbarui!", "success");
            } else {
                select.value = oldStatusId;
                showToast("Gagal update status", "error");
            }
        })
        .catch(() => {
            select.value = oldStatusId;
            showToast("Error jaringan", "error");
        });
    }

    function filterOrders() {
        const statusId = document.getElementById('status_filter').value;

        fetch(`<?= base_url('admin/orders/filter') ?>?status_id=${statusId}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('orders-container').innerHTML = data.html;
            });
    }

    function showToast(msg, type) {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white font-medium shadow-lg z-50 
            ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;

        toast.textContent = msg;
        document.body.appendChild(toast);

        setTimeout(() => toast.remove(), 2500);
    }

    function updateVerifikasi(orderId, select) {
        const newStatus = select.value;

        fetch(`<?= base_url('admin/orders/update-verifikasi') ?>/${orderId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            },
            body: JSON.stringify({ verifikasi_status: newStatus })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast("Status verifikasi diperbarui!", "success");
            } else {
                showToast("Gagal mengubah status verifikasi", "error");
            }
        })
        .catch(() => {
            showToast("Terjadi kesalahan jaringan", "error");
        });
    }

</script>



<?= $this->include('layouts/footer') ?>
