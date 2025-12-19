<?= $this->include('layouts/header') ?>

<section class="py-12 max-w-2xl mx-auto">
    <a href="<?= base_url('admin/menu') ?>" 
       class="text-primary hover:underline mb-4 inline-block">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>

    <h2 class="text-3xl font-bold text-secondary mb-8">Tambah Menu Baru</h2>

    <!-- ERROR MESSAGE -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- SUCCESS MESSAGE -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- FORM TAMBAH MENU -->
    <form method="post" 
          action="<?= base_url('admin/menu') ?>" 
          enctype="multipart/form-data" 
          class="bg-white p-8 rounded-xl shadow-lg">
        <?= csrf_field() ?>

        <!-- NAMA MENU -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Nama Menu</label>
            <input type="text" 
                   name="nama_menu" 
                   value="<?= old('nama_menu') ?>" 
                   class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" 
                   placeholder="Contoh: Nasi Gudeg Komplit" 
                   required>
        </div>

        <!-- KATEGORI MENU -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">
                Kategori Menu
            </label>

            <select name="kategori_id"
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                    required>
                <option value="" disabled selected>Pilih Kategori</option>


                <?php foreach ($kategories as $k): ?>
                    <option value="<?= $k['id'] ?>"
                        <?= old('kategori_id') == $k['id'] ? 'selected' : '' ?>>
                        <?= esc($k['nama_kategori']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>


        <!-- HARGA -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Harga (Rp)</label>
            <input type="number" 
                   name="harga" 
                   value="<?= old('harga') ?>" 
                   min="1000" 
                   class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" 
                   placeholder="25000" 
                   required>
        </div>

        <!-- DESKRIPSI -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
            <textarea name="deskripsi"
                      rows="3"
                      class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary"
                      placeholder="Tulis deskripsi menu..."
            ><?= old('deskripsi') ?></textarea>
        </div>

        <!-- KOMPOSISI -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Komposisi</label>
            <textarea name="komposisi"
                      rows="3"
                      class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary"
                      placeholder="Contoh: Nangka muda, telur, ayam opor..."
            ><?= old('komposisi') ?></textarea>
        </div>

        <!-- STOK -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Stok Awal</label>
            <input type="number" 
                   name="stok" 
                   value="<?= old('stok', '0') ?>" 
                   min="0" 
                   class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" 
                   placeholder="10" 
                   required>
        </div>

        <!-- GAMBAR -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Gambar Menu</label>
            <input type="file" 
                   name="gambar" 
                   accept="image/*"
                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary file:mr-4 file:py-2 file:px-4 file:rounded-full file:bg-primary file:text-white hover:file:bg-orange-600">
            <p class="text-sm text-gray-500 mt-2">Maksimal 2MB, format JPG/PNG.</p>
        </div>

        <!-- TOMBOL -->
        <div class="flex gap-3">
            <button type="submit" 
                    class="flex-1 bg-primary text-white py-3 rounded-full hover:bg-orange-600 transition font-medium">
                <i class="fas fa-plus mr-2"></i> Tambah Menu
            </button>
            <a href="<?= base_url('admin/menu') ?>" 
               class="flex-1 text-center py-3 border border-gray-300 rounded-full hover:bg-gray-50 transition font-medium">
                Batal
            </a>
        </div>
    </form>
</section>

<?= $this->include('layouts/footer') ?>
