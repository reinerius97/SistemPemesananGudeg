<?= $this->include('layouts/header') ?>

<section class="py-12 max-w-2xl mx-auto">
    <a href="<?= base_url('admin/menu') ?>" 
       class="text-primary hover:underline mb-4 inline-block">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>

    <h2 class="text-3xl font-bold text-secondary mb-8">Edit Menu</h2>

    <!-- ERROR MESSAGE -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-inside list-disc">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- FORM EDIT -->
    <form method="post" 
          action="<?= base_url('admin/menu/update/' . $menu['id']) ?>" 
          enctype="multipart/form-data" 
          class="bg-white p-8 rounded-xl shadow-lg">
        <?= csrf_field() ?>

        <!-- NAMA MENU -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Nama Menu</label>
            <input type="text" 
                   name="nama_menu" 
                   value="<?= old('nama_menu', $menu['nama_menu']) ?>" 
                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary" 
                   required>
        </div>

        <!-- KATEGORI MENU -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Kategori Menu</label>

            <select name="kategori_id"
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                    required>
                <option value="" disabled>Pilih Kategori</option>

                <?php foreach ($kategories as $k): ?>
                    <option value="<?= $k['id'] ?>"
                        <?= old('kategori_id', $menu['kategori_id']) == $k['id'] ? 'selected' : '' ?>>
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
                   value="<?= old('harga', $menu['harga']) ?>" 
                   min="1000"
                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary" 
                   required>
        </div>

        <!-- DESKRIPSI -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
            <textarea name="deskripsi"
                      rows="3"
                      class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary"
                      placeholder="Tulis deskripsi menu..."><?= old('deskripsi', $menu['deskripsi']) ?></textarea>
        </div>

        <!-- KOMPOSISI -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Komposisi</label>
            <textarea name="komposisi"
                      rows="3"
                      class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary"
                      placeholder="Isi komposisi bahan..."><?= old('komposisi', $menu['komposisi']) ?></textarea>
        </div>

        <!-- STOK -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Stok Saat Ini</label>
            <input type="number" 
                   name="stok" 
                   value="<?= old('stok', $menu['stok']) ?>" 
                   min="0"
                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary" 
                   required>
        </div>

        <!-- GAMBAR -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Gambar Menu (Opsional)</label>
            <input type="file" 
                   name="gambar" 
                   accept="image/*"
                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary
                          file:mr-4 file:py-2 file:px-4 file:rounded-full file:bg-primary file:text-white hover:file:bg-orange-600">

            <?php if ($menu['gambar']): ?>
                <div class="mt-3">
                    <p class="text-sm text-gray-600 mb-1">Gambar saat ini:</p>
                    <img src="<?= base_url('uploads/menu/' . $menu['gambar']) ?>" 
                         class="w-32 h-32 object-cover rounded-lg shadow">
                </div>
            <?php endif; ?>

            <p class="text-sm text-gray-500 mt-2">Maks 2MB, format JPG/PNG.</p>
        </div>

        <!-- BUTTON -->
        <div class="flex gap-3 mt-6">
            <button type="submit" 
                    class="flex-1 bg-primary text-white py-3 rounded-full hover:bg-orange-600 transition">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>

            <a href="<?= base_url('admin/menu') ?>" 
               class="flex-1 text-center py-3 border border-gray-300 rounded-full hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
    </form>
</section>

<?= $this->include('layouts/footer') ?>
