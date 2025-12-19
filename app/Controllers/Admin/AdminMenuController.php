<?php

namespace App\Controllers\Admin;

use App\Models\MenuModel;
use App\Models\DetailMenuModel;
use App\Models\KategoriMenuModel;
use CodeIgniter\RESTful\ResourceController;

class AdminMenuController extends ResourceController
{
    protected $menuModel;
    protected $detailModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
        $this->detailModel = new DetailMenuModel();
        $this->kategoriModel = new KategoriMenuModel();
        
    }

    // ==========================================
    // TAMPILKAN SEMUA MENU
    // ==========================================
    public function index()
    {
        $search = $this->request->getGet('search');

        $builder = $this->menuModel
            ->select('menu.*, kategori_menu.nama_kategori, detail_menu.stok, detail_menu.status_tersedia')
            ->join('kategori_menu', 'kategori_menu.id = menu.kategori_id', 'left')
            ->join('detail_menu', 'detail_menu.menu_id = menu.id', 'left');

        if (!empty($search)) {
            $builder->like('menu.nama_menu', $search);
        }

        $menus = $builder
            ->orderBy('menu.nama_menu', 'ASC')
            ->findAll();

        return view('admin/menu/index', [
            'menus'  => $menus,
            'search' => $search
        ]);
    }

    // ==========================================
    // FORM TAMBAH MENU
    // ==========================================
    public function create()
    {
        return view('admin/menu/create', [
            'kategories' => $this->kategoriModel->orderBy('nama_kategori', 'ASC')->findAll()
        ]);
    }

    // ==========================================
    // SIMPAN MENU BARU
    // ==========================================
    public function store()
    {
        $rules = [
            'nama_menu' => 'required|min_length[3]',
            'kategori_id' => 'required|integer',
            'harga'     => 'required|decimal',
            'stok'      => 'required|integer',
            'gambar'    => 'uploaded[gambar]|is_image[gambar]|max_size[gambar,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload gambar
        $file = $this->request->getFile('gambar');
        $fileName = $file->getRandomName();
        $file->move('uploads/menu', $fileName);

        // Simpan ke tabel menu
        $menuId = $this->menuModel->insert([
            'nama_menu' => $this->request->getPost('nama_menu'),
            'harga'     => $this->request->getPost('harga'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'gambar'    => $fileName
        ]);

        // Simpan ke tabel detail_menu
        $this->detailModel->insert([
            'menu_id'         => $menuId,
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'komposisi'       => $this->request->getPost('komposisi'),
            'stok'            => $this->request->getPost('stok'),
            'status_tersedia' => $this->request->getPost('stok') > 0 ? 'Tersedia' : 'Habis'
        ]);

        return redirect()->to('/admin/menu')->with('success', 'Menu berhasil ditambahkan!');
    }

    // ==========================================
    // FORM EDIT MENU
    // ==========================================
    public function edit($id = null)
    {
        if ($id === null) {
            return redirect()->to('/admin/menu')->with('error', 'Menu tidak ditemukan');
        }

        $menu = $this->menuModel
            ->select('
                menu.*, 
                kategori_menu.nama_kategori,
                detail_menu.deskripsi, 
                detail_menu.komposisi, 
                detail_menu.stok, 
                detail_menu.status_tersedia
            ')
            ->join('kategori_menu', 'kategori_menu.id = menu.kategori_id', 'left')
            ->join('detail_menu', 'detail_menu.menu_id = menu.id', 'left')
            ->where('menu.id', $id)
            ->first();

        if (!$menu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/menu/edit', [
            'menu'       => $menu,
            'kategories' => $this->kategoriModel->findAll()
        ]);

    }

    // ==========================================
    // UPDATE MENU
    // ==========================================
    public function update($id = null)
    {
        if ($id === null) {
            return redirect()->to('/admin/menu')->with('error', 'Menu tidak ditemukan');
        }

        $rules = [
            'nama_menu' => 'required|min_length[3]',
            'harga'     => 'required',
            'stok'      => 'required|integer',
            'gambar'    => 'max_size[gambar,2048]|is_image[gambar]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // =============================
        // AMBIL DATA MENU UTAMA
        // =============================
        $menu = $this->menuModel->find($id);
        if (!$menu) {
            return redirect()->to('/admin/menu')->with('error', 'Menu tidak ditemukan');
        }

        // =============================
        // UPLOAD GAMBAR (OPSIONAL)
        // =============================
        $file = $this->request->getFile('gambar');
        $image = $menu['gambar'];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/menu', $fileName);

            // hapus gambar lama
            if (!empty($menu['gambar']) && file_exists('uploads/menu/'.$menu['gambar'])) {
                unlink('uploads/menu/'.$menu['gambar']);
            }

            $image = $fileName;
        }

        // =============================
        // UPDATE MENU
        // =============================

        $this->menuModel->update($id, [
            'nama_menu' => $this->request->getPost('nama_menu'),
            'harga'     => str_replace(['.', ','], '', $this->request->getPost('harga')),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'gambar'    => $image,
        ]);

        // =============================
        // UPDATE / INSERT detail_menu
        // =============================
        $detail = $this->detailModel->where('menu_id', $id)->first();

        $detailData = [
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'komposisi'       => $this->request->getPost('komposisi'),
            'stok'            => (int)$this->request->getPost('stok'),
            'status_tersedia' => ((int)$this->request->getPost('stok') > 0 ? 'Tersedia' : 'Habis'),
        ];

        if ($detail) {
            // update existing
            $this->detailModel->update($detail['id'], $detailData);
        } else {
            // create new row
            $detailData['menu_id'] = $id;
            $this->detailModel->insert($detailData);
        }

        return redirect()->to('/admin/menu')->with('success', 'Menu berhasil diperbarui!');
    }

    // ==========================================
    // HAPUS MENU
    // ==========================================
    public function delete($id = null)
    {
        if ($id === null) {
            return redirect()->to('/admin/menu')->with('error', 'Menu tidak ditemukan');
        }

        $menu = $this->menuModel->find($id);

        if ($menu) {

            // hapus gambar bila ada
            if (!empty($menu['gambar']) && file_exists('uploads/menu/'.$menu['gambar'])) {
                unlink('uploads/menu/'.$menu['gambar']);
            }

            // hapus detail_menu
            $this->detailModel->where('menu_id', $id)->delete();

            // hapus menu
            $this->menuModel->delete($id);
        }

        return redirect()->to('/admin/menu')->with('success', 'Menu berhasil dihapus!');
    }
}
