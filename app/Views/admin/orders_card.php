<?php
$items = $order['items'] ?? [];
$itemCount = $itemCount ?? 0;
?>

<div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition"
     data-status-id="<?= $order['status_pesanan_id'] ?>">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <!-- KIRI -->
        <div class="flex-1">
            <div class="flex items-center gap-3">
                <h3 class="font-bold text-lg">#<?= $order['id'] ?></h3>

                <!-- STATUS PESANAN BADGE -->
                <span class="px-3 py-1 rounded-full text-xs font-medium text-white status-badge"
                      data-current="<?= $order['status_pesanan_id'] ?>"
                      style="background:
                        <?= $order['status_pesanan_id'] == 1 ? '#2563eb' : '' ?>;
                        <?= $order['status_pesanan_id'] == 2 ? '#facc15' : '' ?>;
                        <?= $order['status_pesanan_id'] == 3 ? '#16a34a' : '' ?>;
                        <?= $order['status_pesanan_id'] == 4 ? '#dc2626' : '' ?>;
                      ">
                    <?= esc($order['status_pesanan_nama']) ?>
                </span>
            </div>

            <div class="text-sm text-gray-600 mt-1 space-y-1">
                <p><i class="fas fa-calendar mr-1"></i>
                    <?= date('d M Y, H:i', strtotime($order['created_at'])) ?>
                </p>

                <p><i class="fas fa-user mr-1"></i>
                    <?= esc($order['nama_pelanggan']) ?>
                </p>

                <p><i class="fas fa-box mr-1"></i>
                    <?= $itemCount ?> item
                </p>

                <!-- STATUS PEMBAYARAN -->
                <p>
                    <i class="fas fa-money-check mr-1"></i>
                    Pembayaran:
                    <span class="font-semibold">
                        <?= $order['verifikasi_pembayaran'] == 'Diterima' ? '✔ Terverifikasi' :
                            ($order['verifikasi_pembayaran'] == 'Ditolak'
                                ? '✖ Ditolak'
                                : '⌛ Menunggu Verifikasi') ?>
                    </span>
                </p>
            </div>
        </div>

        <!-- KANAN -->
        <div class="text-right">

            <p class="text-2xl font-bold text-primary">
                Rp <?= number_format($order['total_harga'], 0) ?>
            </p>

            <!-- DROPDOWN STATUS PESANAN -->
            <select onchange="updateStatus(<?= $order['id'] ?>, this)"
                    class="mt-2 px-3 py-1 text-sm border rounded-lg focus:outline-none focus:border-primary">

                <?php foreach ($statuses as $st): ?>
                    <option value="<?= $st['id'] ?>"
                        <?= $order['status_pesanan_id'] == $st['id'] ? 'selected' : '' ?>>
                        <?= esc($st['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- LINK BUKTI PEMBAYARAN -->
            <?php if (!empty($order['bukti_path'])): ?>
                <a href="<?= base_url($order['bukti_path']) ?>" 
                   target="_blank"
                   class="block text-blue-600 text-sm mt-3 hover:underline">
                    <i class="fas fa-image mr-1"></i> Lihat Bukti
                </a>
            <?php endif; ?>

        </div>
    </div>

    <!-- RINGKASAN ITEM -->
    <?php if (!empty($items)): ?>
        <div class="mt-3 pt-3 border-t text-xs text-gray-500 flex flex-wrap gap-2">
            <?php foreach ($items as $i => $item): ?>
                <span><?= esc($item['menu_name']) ?> x<?= $item['jumlah'] ?></span>
                <?= $i < count($items) - 1 ? '•' : '' ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
