<?= $this->include('layouts/header') ?>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">

        <!-- KEMBALI -->
        <a href="<?= base_url('menu') ?>" 
           class="inline-flex items-center text-primary hover:underline mb-6 text-lg font-medium">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Menu
        </a>

        <!-- FLASH MESSAGES -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- DETAIL MENU -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white p-6 md:p-8 rounded-xl shadow-lg">

            <!-- GAMBAR -->
            <div class="relative">
                <?php if (!empty($menu['gambar'])): ?>
                    <img src="<?= base_url('uploads/menu/' . $menu['gambar']) ?>" 
                         alt="<?= esc($menu['nama_menu']) ?>" 
                         class="w-full h-96 object-cover rounded-xl shadow-md">
                <?php else: ?>
                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-96 flex items-center justify-center">
                        <i class="fas fa-utensils text-6xl text-gray-400"></i>
                    </div>
                <?php endif; ?>

                <!-- BADGE HABIS -->
                <?php if (($detail['stok'] ?? 0) == 0): ?>
                    <div class="absolute top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                        Habis
                    </div>
                <?php endif; ?>
            </div>

            <!-- INFORMASI MENU -->
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-secondary mb-4">
                    <?= esc($menu['nama_menu']) ?>
                </h1>

                <!-- HARGA -->
                <p class="text-3xl font-bold text-primary mb-6">
                    Rp <?= number_format($menu['harga']) ?>
                </p>

                <!-- STOK -->
                <?php if (($detail['stok'] ?? 0) == 0): ?>
                    <p class="text-lg text-red-600 font-semibold mb-6">
                        <i class="fas fa-times-circle mr-2"></i> Stok: Habis
                    </p>
                <?php else: ?>
                    <p class="text-lg text-green-600 font-medium mb-6">
                        <i class="fas fa-check-circle mr-2"></i> Stok: <?= $detail['stok'] ?> tersedia
                    </p>
                <?php endif; ?>

                <!-- DESKRIPSI -->
                <?php if (!empty($detail['deskripsi'])): ?>
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Deskripsi</h3>
                        <p class="text-gray-700 leading-relaxed"><?= nl2br(esc($detail['deskripsi'])) ?></p>
                    </div>
                <?php endif; ?>

                <!-- KOMPOSISI -->
                <?php if (!empty($detail['komposisi'])): ?>
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Komposisi</h3>
                        <p class="text-gray-700 leading-relaxed"><?= nl2br(esc($detail['komposisi'])) ?></p>
                    </div>
                <?php endif; ?>

                <!-- FORM TAMBAH KERANJANG -->
                <?php if (($detail['stok'] ?? 0) > 0): ?>
                    <form method="post" action="<?= base_url('cart/add') ?>" class="space-y-4">
                        <?= csrf_field() ?>
                        <input type="hidden" name="menu_id" value="<?= $menu['id'] ?>">

                        <!-- QUANTITY -->
                        <div class="flex items-center space-x-3">
                            <span class="text-lg font-medium">Jumlah:</span>
                            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                <button type="button" onclick="decrementQty(this)"
                                        class="w-10 h-10 bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition">
                                    <i class="fas fa-minus text-sm"></i>
                                </button>

                                <input type="number" name="qty" value="1" min="1" max="<?= $detail['stok'] ?>"
                                       class="w-16 text-center py-2 font-medium focus:outline-none" readonly>

                                <button type="button" onclick="incrementQty(this, <?= $detail['stok'] ?>)"
                                        class="w-10 h-10 bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition">
                                    <i class="fas fa-plus text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <!-- TOMBOL -->
                        <button type="submit" 
                                class="w-full md:w-auto bg-primary text-white px-8 py-3 rounded-full hover:bg-orange-600 transition font-medium text-lg flex items-center justify-center space-x-2">
                            <i class="fas fa-cart-plus"></i>
                            <span>Tambah ke Keranjang</span>
                        </button>
                    </form>
                <?php else: ?>
                    <!-- JIKA HABIS -->
                    <div class="bg-gray-100 p-6 rounded-lg text-center">
                        <i class="fas fa-ban text-5xl text-red-500 mb-3"></i>
                        <p class="text-xl font-semibold text-gray-700">Menu ini sedang habis</p>
                        <p class="text-gray-500 mt-2">Silakan cek menu lain atau kembali lagi nanti.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- JS UNTUK INPUT JUMLAH -->
<script>
function incrementQty(button, maxStok) {
    const input = button.parentElement.querySelector('input[name="qty"]');
    let val = parseInt(input.value);
    if (val < maxStok) input.value = val + 1;
}

function decrementQty(button) {
    const input = button.parentElement.querySelector('input[name="qty"]');
    let val = parseInt(input.value);
    if (val > 1) input.value = val - 1;
}
</script>

<?= $this->include('layouts/footer') ?>
