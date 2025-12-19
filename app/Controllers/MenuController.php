<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\DetailMenuModel;
use App\Models\KategoriMenuModel; // 🔹 TAMBAHAN
use CodeIgniter\RESTful\ResourceController;

class MenuController extends ResourceController
{
    protected $menuModel;
    protected $detailMenuModel;
    protected $kategoriMenuModel; // 🔹 TAMBAHAN

    public function __construct()
    {
        $this->menuModel        = new MenuModel();
        $this->detailMenuModel  = new DetailMenuModel();
        $this->kategoriMenuModel = new KategoriMenuModel(); // 🔹
    }

    /**
     * LIST MENU + SEARCH + FILTER KATEGORI
     */
    public function index()
    {
        $search   = $this->request->getGet('search');
        $kategori = $this->request->getGet('kategori'); // 🔹

        // JOIN menu + detail_menu + kategori_menu
        $query = $this->menuModel
            ->select('
                menu.*,
                detail_menu.stok,
                detail_menu.status_tersedia,
                kategori_menu.nama_kategori
            ')
            ->join('detail_menu', 'detail_menu.menu_id = menu.id', 'left')
            ->join('kategori_menu', 'kategori_menu.id = menu.kategori_id', 'left');

        // 🔍 Filter search
        if (!empty($search)) {
            $query->like('menu.nama_menu', $search);
        }

        // 🧩 Filter kategori
        if (!empty($kategori)) {
            $query->where('menu.kategori_id', $kategori);
        }

        $data = [
            'menus'     => $query->orderBy('menu.nama_menu', 'ASC')->paginate(12),
            'pager'     => $this->menuModel->pager,
            'search'    => $search,
            'kategori'  => $kategori,
            'kategories'=> $this->kategoriMenuModel->findAll(), // 🔹 untuk submenu
        ];

        return view('menu/index', $data);
    }

    /**
     * DETAIL MENU (TIDAK PERLU DIUBAH)
     */
    public function detail($id)
    {
        $menu = $this->menuModel->find($id);

        if (!$menu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $detail = $this->detailMenuModel
            ->where('menu_id', $id)
            ->first();

        return view('menu/detail', [
            'menu'   => $menu,
            'detail' => $detail
        ]);
    }
}
