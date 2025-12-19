<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\DetailPesananModel;
use App\Models\MenuModel;
use App\Models\StatusPesananModel;
use App\Models\MetodePembayaranModel;
use App\Models\BuktiPembayaranModel;
use CodeIgniter\RESTful\ResourceController;

class OrderController extends ResourceController
{
    protected $pesananModel;
    protected $detailModel;
    protected $menuModel;
    protected $statusModel;
    protected $metodeModel;
    protected $buktiModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->detailModel  = new DetailPesananModel();
        $this->menuModel    = new MenuModel();
        $this->statusModel  = new StatusPesananModel();
        $this->metodeModel  = new MetodePembayaranModel();
        $this->buktiModel   = new BuktiPembayaranModel();
    }

    /**
     * ==========================================
     *   RIWAYAT PESANAN
     * ==========================================
     */
    public function history()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'pelanggan') {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $pelangganId = session()->get('user_id');

        // Join tabel lengkap (sudah termasuk ongkir, jarak, lat, lon)
        $pesanan = $this->pesananModel
            ->select('
                pesanan.*,
                status_pesanan.nama_status AS status_pesanan_nama,
                metode_pembayaran.nama_metode AS metode_nama,
                bukti_pembayaran.file_path AS bukti_path,
                bukti_pembayaran.status_verifikasi AS verifikasi_status
            ')
            ->join('status_pesanan', 'status_pesanan.id = pesanan.status_pesanan_id', 'left')
            ->join('metode_pembayaran', 'metode_pembayaran.id = pesanan.metode_pembayaran_id', 'left')
            ->join('bukti_pembayaran', 'bukti_pembayaran.id = pesanan.bukti_pembayaran_id', 'left')
            ->where('pesanan.pelanggan_id', $pelangganId)
            ->orderBy('pesanan.created_at', 'DESC')
            ->paginate(10);

        $orders = [];

        foreach ($pesanan as $order) {

            // Hitung jumlah item
            $itemCount = $this->detailModel
                ->where('pesanan_id', $order['id'])
                ->countAllResults();

            // Ambil ringkasan item
            $items = $this->detailModel
                ->select('detail_pesanan.jumlah, menu.nama_menu, menu.gambar')
                ->join('menu', 'menu.id = detail_pesanan.menu_id', 'left')
                ->where('detail_pesanan.pesanan_id', $order['id'])
                ->findAll();

            $orders[] = [
                'id'                => $order['id'],
                'total_harga'       => $order['total_harga'],
                'created_at'        => $order['created_at'],

                'status_pesanan_nama' => $order['status_pesanan_nama'],
                'verifikasi_status'   => $order['verifikasi_status'],
                'bukti_path'          => $order['bukti_path'],
                'metode_nama'         => $order['metode_nama'],

                // Tambahan
                'ongkir'            => $order['ongkir'],
                'jarak_km'          => $order['jarak_km'],
                'latitude'          => $order['latitude'],
                'longitude'         => $order['longitude'],

                'item_count'        => $itemCount,
                'item_summary'      => $items
            ];
        }

        return view('orders/history', [
            'orders' => $orders,
            'pager'  => $this->pesananModel->pager
        ]);
    }


    /**
     * ==========================================
     *   DETAIL PESANAN
     * ==========================================
     */
    public function detail($id = null)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'pelanggan') {
            return redirect()->to('/auth/login');
        }

        $pelangganId = session()->get('user_id');

        // Ambil data pesanan lengkap
        $order = $this->pesananModel
            ->select('
                pesanan.*,
                pelanggan.nama_pelanggan,
                pelanggan.no_telepon,
                status_pesanan.nama_status AS status_pesanan_nama,
                metode_pembayaran.nama_metode AS metode_nama,
                bukti_pembayaran.file_path AS bukti_path,
                bukti_pembayaran.status_verifikasi AS verifikasi_status
            ')
            ->join('pelanggan', 'pelanggan.id = pesanan.pelanggan_id')
            ->join('status_pesanan', 'status_pesanan.id = pesanan.status_pesanan_id', 'left')
            ->join('metode_pembayaran', 'metode_pembayaran.id = pesanan.metode_pembayaran_id', 'left')
            ->join('bukti_pembayaran', 'bukti_pembayaran.id = pesanan.bukti_pembayaran_id', 'left')
            ->where('pesanan.id', $id)
            ->where('pesanan.pelanggan_id', $pelangganId)
            ->first();

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Ambil daftar item pesanan
        $items = $this->detailModel
            ->select('
                detail_pesanan.*,
                menu.nama_menu,
                menu.harga,
                menu.gambar
            ')
            ->join('menu', 'menu.id = detail_pesanan.menu_id')
            ->where('detail_pesanan.pesanan_id', $id)
            ->findAll();

        return view('orders/detail', [
            'order' => $order,
            'items' => $items
        ]);
    }
}
