<?= $this->include('layouts/header') ?>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        
        <!-- HEADER -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-secondary">Kelola Menu</h2>
            <a href="<?= base_url('admin/menu/create') ?>" 
               class="bg-primary text-white px-6 py-3 rounded-full hover:bg-orange-600 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Menu
            </a>
        </div>

        <!-- SEARCH -->
        <form method="get" class="mb-6">
            <div class="flex gap-2 max-w-md">
                <input type="text" 
                       name="search" 
                       value="<?= $search ?? '' ?>" 
                       placeholder="Cari nama menu..." 
                       class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-orange-600">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <!-- TABLE -->
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 text-left">Gambar</th>
                        <th class="p-4 text-left">Nama Menu</th>
                        <th class="p-4 text-right">Harga</th>
                        <th class="p-4 text-center">Stok</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (empty($menus)): ?>
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">
                            <i class="fas fa-utensils text-4xl mb-2"></i>
                            <p>Belum ada menu</p>
                        </td>
                    </tr>
                <?php else: ?>

                    <?php foreach ($menus as $menu): ?>
                    <tr class="hover:bg-gray-50 transition">

                        <!-- GAMBAR -->
                        <td class="p-4">
                            <?php if ($menu['gambar']): ?>
                                <img src="<?= base_url('uploads/menu/' . $menu['gambar']) ?>" 
                                     class="w-12 h-12 object-cover rounded">
                            <?php else: ?>
                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                        </td>

                        <!-- NAMA MENU -->
                        <td class="p-4 font-medium"><?= esc($menu['nama_menu']) ?></td>

                        <!-- HARGA -->
                        <td class="p-4 text-right">Rp <?= number_format($menu['harga']) ?></td>

                        <!-- STOK -->
                        <td class="p-4 text-center">
                            <span class="px-2 py-1 text-xs font-bold
                                <?= ($menu['stok'] ?? 0) > 0 ? 'bg-green-100 text-green-800' 
                                                            : 'bg-red-100 text-red-800' ?>">
                                <?= $menu['stok'] ?? 0 ?>
                            </span>
                        </td>

                        <!-- STATUS TERSEDIA -->
                        <td class="p-4 text-center">
                            <span class="px-2 py-1 text-xs rounded-full font-medium
                                <?= ($menu['status_tersedia'] === 'Tersedia') ? 
                                    'bg-green-100 text-green-800' : 
                                    'bg-red-100 text-red-800' ?>">
                                <?= esc($menu['status_tersedia'] ?? 'Habis') ?>
                            </span>
                        </td>

                        <!-- AKSI -->
                        <td class="p-4 text-center space-x-2">
                            
                            <!-- EDIT -->
                            <a href="<?= base_url('admin/menu/edit/' . $menu['id']) ?>" 
                               class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- DELETE -->
                            <form method="post" 
                                  action="<?= base_url('admin/menu/delete/' . $menu['id']) ?>"
                                  style="display:inline"
                                  onsubmit="return confirm('Hapus <?= esc($menu['nama_menu']) ?>?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </td>

                    </tr>
                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <?php if (isset($pager)): ?>
            <div class="mt-6 flex justify-center">
                <?= $pager->links('menu', 'default_template') ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<?= $this->include('layouts/footer') ?>
