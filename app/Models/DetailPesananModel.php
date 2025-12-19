<?php
namespace App\Models;

use CodeIgniter\Model;

class DetailPesananModel extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pesanan_id', 'menu_id', 'jumlah', 'subtotal', 'catatan_item'];

    // Ambil item + nama menu
    public function getItems($pesanan_id)
    {
        return $this->select('detail_pesanan.*, menu.nama_menu, menu.harga')
                    ->join('menu', 'menu.id = detail_pesanan.menu_id')
                    ->where('pesanan_id', $pesanan_id)
                    ->findAll();
    }
}