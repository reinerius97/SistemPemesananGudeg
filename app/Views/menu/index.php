<?= $this->include('layouts/header') ?>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <!-- JUDUL & DESKRIPSI -->
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-3">Menu Gudeg Diajeng</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Pilih menu favorit Anda dan nikmati kelezatan gudeg autentik khas Jogja
            </p>
        </div>

        <!-- SEARCH BAR -->
        <form method="get" class="mb-10">
            <div class="flex justify-center">
                <div class="relative max-w-md w-full">
                    <input type="text" 
                           name="search" 
                           value="<?= esc($search ?? '') ?>"
                           placeholder="Cari nama menu..." 
                           class="w-full px-5 py-3 pr-12 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <button type="submit" 
                            class="absolute right-1 top-1/2 transform -translate-y-1/2 bg-primary text-white p-2.5 rounded-full hover:bg-orange-600 transition">
                        Search
                    </button>
                </div>
            </div>
        </form>

        <!-- SUBMENU KATEGORI -->
        <?php if (!empty($kategories)): ?>
            <div class="flex flex-wrap justify-center gap-3 mb-10">
                
                <!-- Semua -->
                <a href="<?= base_url('menu') ?>"
                class="px-4 py-2 rounded-full text-sm font-semibold transition
                <?= empty($kategori) 
                        ? 'bg-primary text-white shadow' 
                        : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-100' ?>">
                    Semua
                </a>

                <?php foreach ($kategories as $kat): ?>
                    <a href="<?= base_url('menu?kategori=' . $kat['id']) ?>"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition
                    <?= ($kategori == $kat['id']) 
                            ? 'bg-primary text-white shadow' 
                            : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-100' ?>">
                        <?= esc($kat['nama_kategori']) ?>
                    </a>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>


        <!-- DAFTAR MENU -->
        <?php if (empty($menus)): ?>
            <div class="text-center py-16">
                <i class="fas fa-utensils text-6xl text-gray-300 mb-4"></i>
                <p class="text-xl text-gray-500">Tidak ada menu ditemukan.</p>
                <?php if ($search): ?>
                    <p class="text-sm text-gray-400 mt-2">Coba cari dengan kata kunci lain.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($menus as $menu): ?>
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 
                                <?= ($menu['stok'] ?? 0) == 0 ? 'opacity-75' : '' ?>">
                        
                        <!-- GAMBAR + BADGE HABIS -->
                        <div class="relative">
                            <?php if (!empty($menu['gambar'])): ?>
                                <img src="<?= base_url('uploads/menu/' . $menu['gambar']) ?>" 
                                     alt="<?= esc($menu['nama_menu']) ?>" 
                                     class="w-full h-56 object-cover">
                            <?php else: ?>
                                <div class="bg-gray-200 border-2 border-dashed rounded-t-xl w-full h-56 flex items-center justify-center">
                                    <i class="fas fa-utensils text-4xl text-gray-400"></i>
                                </div>
                            <?php endif; ?>

                            <!-- BADGE HABIS -->
                            <?php if (($menu['stok'] ?? 0) == 0): ?>
                                <div class="absolute top-3 right-3 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                    Habis
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- ISI KARTU -->
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-secondary mb-2 line-clamp-2">
                                <?= esc($menu['nama_menu']) ?>
                            </h3>

                            <!-- HARGA -->
                            <p class="text-2xl font-bold text-primary mb-3">
                                Rp <?= number_format($menu['harga']) ?>
                            </p>

                            <!-- STOK INFO -->
                            <?php if (($menu['stok'] ?? 0) == 0): ?>
                                <p class="text-sm text-red-600 font-semibold mb-4">
                                    Stok: Habis
                                </p>
                            <?php else: ?>
                                <p class="text-sm text-gray-600 mb-4">
                                    Stok: 
                                    <span class="font-medium text-green-600">
                                        <?= $menu['stok'] ?> tersedia
                                    </span>
                                </p>
                            <?php endif; ?>

                            <!-- TOMBOL DETAIL -->
                            <a href="<?= base_url('menu/detail/' . $menu['id']) ?>" 
                               class="<?= ($menu['stok'] ?? 0) == 0 
                                    ? 'bg-gray-400 cursor-not-allowed' 
                                    : 'bg-primary hover:bg-orange-600' ?> 
                                    text-white text-center py-2.5 rounded-lg block transition font-medium text-sm">
                                <?= ($menu['stok'] ?? 0) == 0 ? 'Habis' : 'Beli' ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- PAGINATION -->
            <div class="mt-12 flex justify-center">
                <nav aria-label="Pagination">
                    <?= $pager->links() ?>
                </nav>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
/* Styling untuk mempercantik pagination default CodeIgniter */
.pagination {
    display: inline-flex;
    gap: 0.5rem;
    padding: 0;
    margin: 0;
    list-style: none;
    align-items: center;
}

/* link / span di dalam li */
.pagination li a,
.pagination li span {
    display: inline-block;
    padding: 0.45rem 0.75rem;
    border-radius: 0.5rem;
    border: 1px solid #e6e6e6;
    background: #ffffff;
    color: #374151; /* gray-700 */
    text-decoration: none;
    font-weight: 600;
    box-shadow: 0 1px 2px rgba(15,23,42,0.04);
}

/* hover effect untuk tautan */
.pagination li a:hover {
    background: #f97316; /* orange-500 */
    color: #fff;
    transform: translateY(-2px);
    transition: all 0.12s ease;
}

/* aktif */
.pagination li.active span,
.pagination li.active a {
    background: #f97316;
    color: #fff;
    border-color: #f97316;
}

/* disabled look */
.pagination li.disabled span,
.pagination li.disabled a {
    opacity: 0.5;
    cursor: default;
}

/* prev/next small icons spacing tweak */
.pagination li:first-child a,
.pagination li:last-child a {
    padding-left: 0.6rem;
    padding-right: 0.6rem;
}
</style>

<?= $this->include('layouts/footer') ?>
