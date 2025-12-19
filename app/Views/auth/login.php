<?= $this->include('layouts/header') ?>

<section class="py-12 max-w-md mx-auto">
    <h2 class="text-3xl font-bold text-secondary mb-8 text-center">Login</h2>

    <!-- PESAN SUKSES (dari register) -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- PESAN ERROR (dari login gagal) -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- VALIDASI ERROR -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('auth/login') ?>" class="bg-white p-6 rounded-lg shadow-md">
        <?= csrf_field() ?>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-primary" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-primary" required>
        </div>
        <button type="submit" class="bg-primary text-white px-6 py-3 rounded-full hover:bg-orange-600 transition w-full">Masuk</button>
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Belum punya akun? 
                <a href="<?= base_url('auth/register') ?>" class="font-medium text-orange-600 hover:underline">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </form>
</section>

<?= $this->include('layouts/footer') ?>