<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\DetailMenuModel;

class Home extends BaseController
{
    public function index()
    {
        $menuModel = new MenuModel();
        $detailMenuModel = new DetailMenuModel();

        // JOIN MENU + DETAIL_MENU
        $menus = $menuModel
            ->select('menu.*, detail_menu.stok, detail_menu.status_tersedia')
            ->join('detail_menu', 'detail_menu.menu_id = menu.id', 'left')
            ->findAll(3); // tampilkan 3 menu spesial
        
        return view('home', [
            'menus' => $menus
        ]);
    }

    public function promo()
    {
        // Dummy promos from HTML
        $data['promos'] = [
            ['name' => 'Promo Gudeg Komplit', 'desc' => 'Dapatkan Gudeg Komplit hanya Rp 20.000 untuk pembelian minimal 2 porsi!', 'price' => 20000],
            ['name' => 'Tempe Bacem Gratis', 'desc' => 'Dapatkan 1 Tempe Bacem gratis untuk setiap transaksi minimal Rp 50.000.', 'price' => 50000],
            ['name' => 'Paket Hemat Keluarga', 'desc' => 'Pesan Paket Gudeg Keluarga untuk 4 orang, hemat hingga Rp 15.000!', 'price' => 85000],
        ];
        return view('promo', $data);
    }

    public function tentang()
    {
        return view('tentang');
    }

    public function kontak()
    {
        return view('kontak');
    }
}