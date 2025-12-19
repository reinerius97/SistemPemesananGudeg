<?php

namespace App\Controllers\Admin;

use App\Models\PesananModel;
use App\Models\DetailPesananModel;
use App\Models\PelangganModel;
use App\Models\MenuModel;
use App\Models\StatusPesananModel;
use App\Models\MetodePembayaranModel;
use App\Models\BuktiPembayaranModel;
use CodeIgniter\RESTful\ResourceController;

class AdminOrderController extends ResourceController
{
    protected $pesananModel;
    protected $detailPesananModel;
    protected $pelangganModel;
    protected $menuModel;
    protected $statusModel;
    protected $metodeModel;
    protected $buktiModel;

    public function __construct()
    {
        $this->pesananModel        = new PesananModel();
        $this->detailPesananModel  = new DetailPesananModel();
        $this->pelangganModel      = new PelangganModel();
        $this->menuModel           = new MenuModel();
        $this->statusModel         = new StatusPesananModel();
        $this->metodeModel         = new MetodePembayaranModel();
        $this->buktiModel          = new BuktiPembayaranModel();
    }

    // =====================================================================
    // LIST PESANAN
    // =====================================================================
    public function index()
    {
        $data = [
            'pesanan'  => $this->getOrdersWithItems(),
            'statuses' => $this->statusModel->findAll()
        ];

        return view('admin/orders', $data);
    }

    // =====================================================================
    // FILTER
    // =====================================================================
    public function filter()
    {
        $statusId = $this->request->getGet('status_id');
        $pesanan  = $this->getOrdersWithItems($statusId);

        $html = '';

        foreach ($pesanan as $order) {
            $itemCount = array_sum(array_column($order['items'], 'jumlah'));

            $html .= view('admin/orders_card', [
                'order'     => $order,
                'itemCount' => $itemCount,
            ]);
        }

        return $this->response->setJSON(['html' => $html]);
    }

    // =====================================================================
    // UPDATE STATUS
    // =====================================================================
    public function updateStatus($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ]);
        }

        $json      = $this->request->getJSON();
        $status_id = $json->status_id ?? null;

        if (!$status_id || !$this->statusModel->find($status_id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Status tidak valid'
            ]);
        }

        $updated = $this->pesananModel->update($id, [
            'status_pesanan_id' => $status_id
        ]);

        return $this->response->setJSON(['success' => (bool)$updated]);
    }

    // =====================================================================
    // QUERY PESANAN LENGKAP
    // =====================================================================
    private function getOrdersWithItems($statusId = null)
    {
        $builder = $this->pesananModel->builder()
            ->select("
                pesanan.*,
                pelanggan.nama_pelanggan,
                pelanggan.no_telepon,
                
                status_pesanan.nama_status AS status_pesanan_nama,
                metode_pembayaran.nama_metode AS metode_nama,

                bukti_pembayaran.file_path AS bukti_path,
                bukti_pembayaran.status_verifikasi AS verifikasi_status
            ")
            ->join('pelanggan', 'pelanggan.id = pesanan.pelanggan_id', 'left')
            ->join('status_pesanan', 'status_pesanan.id = pesanan.status_pesanan_id', 'left')
            ->join('metode_pembayaran', 'metode_pembayaran.id = pesanan.metode_pembayaran_id', 'left')
            ->join('bukti_pembayaran', 'bukti_pembayaran.id = pesanan.bukti_pembayaran_id', 'left');

        if (!empty($statusId)) {
            $builder->where('pesanan.status_pesanan_id', $statusId);
        }

        $pesanan = $builder
            ->orderBy('pesanan.created_at', 'DESC')
            ->get()
            ->getResultArray();

        // Ambil item untuk setiap pesanan
        foreach ($pesanan as &$order) {

            $order['items'] = $this->detailPesananModel
                ->select("
                    detail_pesanan.jumlah,
                    detail_pesanan.subtotal,
                    menu.nama_menu AS menu_name,
                    menu.harga AS menu_price,
                    menu.gambar AS gambar
                ")
                ->join('menu', 'menu.id = detail_pesanan.menu_id', 'left')
                ->where('detail_pesanan.pesanan_id', $order['id'])
                ->findAll();
        }

        return $pesanan;
    }

    
    public function updateVerifikasi($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false]);
        }

        $json = $this->request->getJSON();
        $status = $json->verifikasi_status ?? 'Menunggu';

        // Update status verifikasi di tabel bukti_pembayaran
        $updated = $this->buktiModel
            ->where('id', function($builder) use ($id) {
                $builder->select('bukti_pembayaran_id')
                        ->from('pesanan')
                        ->where('id', $id);
            })
            ->set(['status_verifikasi' => $status])
            ->update();

        return $this->response->setJSON(['success' => (bool)$updated]);
    }

}
