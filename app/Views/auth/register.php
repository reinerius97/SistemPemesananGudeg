<?= $this->include('layouts/header') ?>

<section class="py-12 max-w-md mx-auto">
    <h2 class="text-3xl font-bold text-secondary mb-8 text-center">Daftar Akun Baru</h2>

    <!-- ERROR MESSAGE -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- SUCCESS MESSAGE -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- FORM REGISTER -->
    <form method="post" action="<?= base_url('auth/register') ?>" class="bg-white p-6 rounded-lg shadow-md">
        <?= csrf_field() ?>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nama</label>
            <input type="text" 
                   name="name" 
                   value="<?= old('name') ?>" 
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:border-primary" 
                   required>
                   <?php if (session('errors.name')): ?>
                        <p class="mt-1 text-xs text-red-600"><?= session('errors.name') ?></p>
                    <?php endif; ?>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Email</label>
            <input type="email" 
                   name="email" 
                   value="<?= old('email') ?>" 
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:border-primary" 
                   required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                No. Telepon <span class="text-red-500">*</span>
            </label>
            <input type="text" name="phone" value="<?= old('phone') ?>" 
                class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-primary" 
                placeholder="081234567890" required>
            <?php if (session('errors.phone')): ?>
                <p class="mt-1 text-xs text-red-600"><?= session('errors.phone') ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Alamat Lengkap <span class="text-red-500">*</span>
            </label>
            <textarea name="address" rows="3" 
                    class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-primary" 
                    placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota" required><?= old('address') ?></textarea>
            <?php if (session('errors.address')): ?>
                <p class="mt-1 text-xs text-red-600"><?= session('errors.address') ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Password</label>
            <input type="password" 
                   name="password" 
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:border-primary" 
                   required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Konfirmasi Password</label>
            <input type="password" 
                   name="password_confirm" 
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:border-primary" 
                   required>
        </div>

        <button type="submit" 
                class="bg-primary text-white px-6 py-3 rounded-full hover:bg-orange-600 transition w-full">
            Daftar
        </button>
    </form>

    <p class="text-center mt-6 text-sm text-gray-600">
        Sudah punya akun? 
        <a href="<?= base_url('auth/login') ?>" class="text-primary hover:underline">Login di sini</a>
    </p>
</section>

<?= $this->include('layouts/footer') ?>