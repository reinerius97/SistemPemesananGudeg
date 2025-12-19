<?= $this->include('layouts/header') ?>

<!-- Hero Section - Opsi A (background-image, tampilkan seluruh gambar) -->
<section class="relative bg-no-repeat bg-center bg-contain min-h-screen md:min-h-[80vh] flex items-center justify-center text-white"
         style="background-image: url('<?= base_url('uploads/image.png') ?>'); background-color:#0f2f1f;">
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 text-center px-4 max-w-3xl mx-auto">
        <h1 class="text-4xl md:text-6xl font-bold mb-4 animate-fade-in">Gudeg Diajeng</h1>
        <p class="text-lg md:text-xl mb-6"></p>
        <a href="<?= base_url('menu') ?>" 
           class="inline-block bg-primary text-white px-8 py-3 rounded-full hover:bg-orange-600 transition text-lg font-medium">
            Pesan Sekarang
        </a>
    </div>
</section>


<!-- Menu Spesial -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-secondary text-center mb-4">Menu Spesial Kami</h2>
        <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
            Nikmati kelezatan gudeg dengan resep turun-temurun yang telah membuat pelanggan kami ketagihan
        </p>

        <?php if (empty($menus)): ?>
            <div class="text-center py-12">
                <p class="text-gray-500">Belum ada menu tersedia saat ini.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($menus as $menu): ?>
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300">

                        <!-- GAMBAR -->
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
                            <?php if ($menu['stok'] == 0): ?>
                                <div class="absolute top-3 right-3 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    Habis
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- ISI KARTU -->
                        <div class="p-5">
                            <h3 class="text-xl font-bold text-secondary mb-2"><?= esc($menu['nama_menu']) ?></h3>
                            <p class="text-2xl font-bold text-primary mb-3">
                                Rp <?= number_format($menu['harga']) ?>
                            </p>

                            <!-- INFO STOK -->
                            <p class="text-sm text-gray-600 mb-4">
                                Stok:
                                <span class="font-medium <?= $menu['stok'] > 0 ? 'text-green-600' : 'text-red-600' ?>">
                                    <?= $menu['stok'] > 0 ? $menu['stok'] . ' tersedia' : 'Habis' ?>
                                </span>
                            </p>

                            <!-- TOMBOL -->
                            <a href="<?= base_url('menu/detail/' . $menu['id']) ?>" 
                               class="<?= $menu['stok'] == 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-primary hover:bg-orange-600' ?> 
                                        text-white text-center py-2.5 rounded-lg block transition font-medium">
                                <?= $menu['stok'] == 0 ? 'Habis' : 'Beli' ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- LIHAT SEMUA MENU -->
        <div class="text-center mt-12">
            <a href="<?= base_url('menu') ?>" 
               class="inline-block border-2 border-primary text-primary px-8 py-3 rounded-full hover:bg-primary hover:text-white transition font-medium">
                Lihat Semua Menu
            </a>
        </div>
    </div>
</section>

<!-- Tentang Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <img src="<?= base_url('uploads/gdeg.webp') ?>" alt="Tentang Gudeg Diajeng" class="rounded-xl shadow-lg w-full object-cover h-96">
        <div>
            <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-6">Tentang Gudeg Diajeng</h2>
            <p class="text-gray-600 mb-4 leading-relaxed">
                Gudeg Diajeng berdiri sejak tahun 2019 sebagai usaha keluarga yang berawal dari kecintaan akan kuliner tradisional khas Yogyakarta. Dengan resep turun-temurun yang dipadukan dengan sentuhan modern, Gudeg Diajeng menghadirkan cita rasa autentik gudeg Jogja yang manis, gurih, dan kaya rempah.
            </p>
            <p class="text-gray-600 mb-4 leading-relaxed">
                Sejak awal berdirinya, Gudeg Diajeng berkomitmen untuk menyajikan hidangan yang tidak hanya lezat, tetapi juga sehat dan berkualitas. Semua bahan dipilih dengan cermat: nangka muda segar, bumbu alami, santan pilihan, hingga lauk pendamping seperti ayam bacem, telur pindang, dan sambal goreng krecek yang dimasak dengan penuh perhatian.
            </p>
            <p class="text-gray-600 mb-6 leading-relaxed">
                Dalam perjalanannya, Gudeg Diajeng terus berkembang menjadi pilihan favorit masyarakat, baik untuk santap keluarga, acara spesial, maupun pesanan dalam jumlah besar. Dengan pelayanan ramah dan cita rasa yang konsisten, sejak 2019 hingga kini Gudeg Diajeng selalu menjadi bagian dari kenangan manis kuliner Jogja yang tak terlupakan.
            </p>
            <a href="<?= base_url('tentang') ?>" 
               class="inline-block bg-primary text-white px-8 py-3 rounded-full hover:bg-orange-600 transition font-medium">
                Selengkapnya
            </a>
        </div>
    </div>
</section>

<?= $this->include('layouts/footer') ?>
