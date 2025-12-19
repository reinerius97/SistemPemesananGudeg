<?= $this->include('layouts/header') ?>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-8 text-center">Keranjang Belanja</h2>

        <?php if (empty($cart)): ?>
            <!-- KERANJANG KOSONG -->
            <div class="bg-white p-8 md:p-12 rounded-xl shadow-md text-center">
                <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-6"></i>
                <p class="text-xl text-gray-600 mb-3">Keranjang Anda Kosong</p>
                <p class="text-gray-500 mb-6">Yuk, tambahkan menu favorit Anda!</p>
                <a href="<?= base_url('menu') ?>" 
                   class="inline-block bg-primary text-white px-8 py-3 rounded-full hover:bg-orange-600 transition font-medium text-lg">
                    Lihat Menu
                </a>
            </div>

        <?php else: ?>
            <!-- KERANJANG ISI -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="p-4 text-left font-semibold">Menu</th>
                                <th class="p-4 text-center font-semibold">Harga</th>
                                <th class="p-4 text-center font-semibold">Jumlah</th>
                                <th class="p-4 text-center font-semibold">Subtotal</th>
                                <th class="p-4 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($cart as $id => $item): ?>
                                <?php 
                                    $stokTersedia = $item['stok_tersedia'] ?? 0;
                                    $isHabis = $stokTersedia < $item['quantity'];
                                ?>
                                <tr class="border-b hover:bg-gray-50 transition <?= $isHabis ? 'bg-red-50' : '' ?>" 
                                    data-menu-id="<?= $id ?>">

                                    <!-- GAMBAR + NAMA -->
                                    <td class="p-4">
                                        <div class="flex items-center space-x-3">
                                            <?php if (!empty($item['gambar'])): ?>
                                                <img src="<?= base_url('uploads/menu/' . $item['gambar']) ?>"
                                                     class="w-12 h-12 object-cover rounded-lg shadow-sm">
                                            <?php else: ?>
                                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-utensils text-gray-400"></i>
                                                </div>
                                            <?php endif; ?>

                                            <div>
                                                <p class="font-medium text-secondary"><?= esc($item['nama_menu']) ?></p>
                                                <?php if ($isHabis): ?>
                                                    <p class="text-xs text-red-600 font-semibold mt-1">
                                                        Stok hanya <?= $stokTersedia ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- HARGA -->
                                    <td class="p-4 text-center">
                                        Rp <?= number_format($item['price']) ?>
                                    </td>

                                    <!-- JUMLAH -->
                                    <td class="p-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button type="button"
                                                    class="qty-minus w-9 h-9 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition disabled:opacity-50"
                                                    data-id="<?= $id ?>"
                                                    <?= $item['quantity'] <= 1 ? 'disabled' : '' ?>>
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>

                                            <input type="number"
                                                   class="qty-input w-16 text-center border rounded-lg px-2 py-1 font-medium"
                                                   value="<?= $item['quantity'] ?>"
                                                   min="1"
                                                   max="<?= $stokTersedia ?>"
                                                   readonly>

                                            <button type="button"
                                                    class="qty-plus w-9 h-9 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition disabled:opacity-50"
                                                    data-id="<?= $id ?>"
                                                    <?= $item['quantity'] >= $stokTersedia ? 'disabled' : '' ?>>
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </div>
                                    </td>

                                    <!-- SUBTOTAL -->
                                    <td class="p-4 text-center font-semibold">
                                        Rp <span class="subtotal"><?= number_format($item['price'] * $item['quantity']) ?></span>
                                    </td>

                                    <!-- HAPUS -->
                                    <td class="p-4 text-center">
                                        <button type="button"
                                                onclick="removeItem(<?= $id ?>)"
                                                class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash text-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>

                <!-- TOTAL & CHECKOUT -->
                <div class="p-6 bg-gray-50 border-t">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <p class="text-xl font-bold">
                            Total: <span id="grand-total">Rp <?= number_format($total) ?></span>
                        </p>

                        <a href="<?= base_url('cart/checkout') ?>"
                           class="bg-primary text-white px-8 py-3 rounded-full hover:bg-orange-600 transition font-medium text-lg flex items-center space-x-2">
                            <i class="fas fa-credit-card"></i>
                            <span>Lanjut ke Checkout</span>
                        </a>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </div>
</section>


<!-- CSRF -->
<meta name="csrf-token" content="<?= csrf_hash() ?>">
<script>
document.addEventListener('DOMContentLoaded', function () {

    const csrfName = '<?= csrf_token() ?>';
    const csrfHash = document.querySelector('meta[name="csrf-token"]').content;

    // ================== UPDATE QTY ==================
    function updateCart(id, qty) {
        fetch('<?= base_url('cart/update') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                [csrfName]: csrfHash,
                'menu_id': id,
                'quantity': qty
            })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                const row = document.querySelector(`tr[data-menu-id="${id}"]`);
                row.querySelector('.subtotal').textContent = res.subtotal;
                document.getElementById('grand-total').textContent = res.grand_total;
            } else {
                alert(res.message);
                location.reload();
            }
        });
    }

    // EVENT TOMBOL TAMBAH
    document.querySelectorAll('.qty-plus').forEach(btn => {
        btn.onclick = () => {
            const id = btn.dataset.id;
            const input = btn.parentElement.querySelector('.qty-input');
            updateCart(id, parseInt(input.value) + 1);
        };
    });

    // EVENT TOMBOL KURANG
    document.querySelectorAll('.qty-minus').forEach(btn => {
        btn.onclick = () => {
            const id = btn.dataset.id;
            const input = btn.parentElement.querySelector('.qty-input');
            if (parseInt(input.value) > 1)
                updateCart(id, parseInt(input.value) - 1);
        };
    });

    // ================== REMOVE ITEM ==================
    window.removeItem = (id) => {
        if (!confirm('Hapus item ini?')) return;

        fetch('<?= base_url('cart/remove') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                [csrfName]: csrfHash,
                'menu_id': id
            })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                document.querySelector(`tr[data-menu-id="${id}"]`).remove();
                if (document.querySelectorAll('tbody tr').length === 0)
                    location.reload();
            }
        });
    };

});
</script>

<?= $this->include('layouts/footer') ?>
