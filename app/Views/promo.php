<?= $this->include('layouts/header') ?>

<section class="py-12">
    <h2 class="text-3xl font-bold text-secondary text-center mb-8">Promo Spesial Gudeg Diajeng</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php foreach ($promos as $promo): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl hover:scale-105 transition-transform duration-300">
                <div class="p-4">
                    <h3 class="text-xl font-semibold text-secondary"><?= esc($promo['name']) ?></h3>
                    <p class="text-gray-600"><?= esc($promo['desc']) ?></p>
                    <p class="text-primary font-bold">Rp <?= number_format($promo['price'], 0) ?></p>
                    <a href="/menu" class="mt-4 block bg-primary text-white text-center py-2 rounded hover:bg-orange-600 transition">Pesan Sekarang</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?= $this->include('layouts/footer') ?>