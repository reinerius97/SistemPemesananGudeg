<?php

namespace App\Controllers\Admin;

use App\Models\PesananModel;
use CodeIgniter\RESTful\ResourceController;

class DashboardController extends ResourceController
{
    protected $pesananModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
    }

    public function index()
    {
        $data = $this->getDashboardData('month');
        return view('admin/dashboard', $data);
    }

    public function filter()
    {
        $period = $this->request->getGet('period') ?? 'month';
        $start  = $this->request->getGet('start');
        $end    = $this->request->getGet('end');

        $data = $this->getDashboardData($period, $start, $end);

        // kirimkan JSON yang konsisten
        return $this->response->setJSON([
            'total_orders'  => (int) $data['total_orders'],
            'total_revenue' => (int) $data['total_revenue'],
            'recent_count'  => (int) $data['recent_count'],
            'recent_orders' => $data['recent_orders'],
        ]);
    }

    private function getDashboardData($period, $start = null, $end = null)
    {
        // SUMMARY
        $builder = $this->pesananModel->builder();
        $this->applyDateFilter($builder, $period, $start, $end);

        $summaryRow = $builder
            ->select('COUNT(*) as total_orders, COALESCE(SUM(pesanan.total_harga),0) as total_revenue')
            ->get()
            ->getRowArray();

        $totalOrders  = isset($summaryRow['total_orders']) ? (int)$summaryRow['total_orders'] : 0;
        $totalRevenue = isset($summaryRow['total_revenue']) ? (int)$summaryRow['total_revenue'] : 0;

        // RECENT ORDERS (5)
        $builder = $this->pesananModel->builder();
        $this->applyDateFilter($builder, $period, $start, $end);

        // pastikan meng-SELECT nama_pelanggan dan juga alias name supaya view yg berbeda aman
        $recentRows = $builder
            ->select('
                pesanan.id,
                pesanan.total_harga,
                pesanan.created_at,
                pesanan.status_pesanan_id,
                status_pesanan.nama_status AS status_pesanan_nama,
                pelanggan.nama_pelanggan AS nama_pelanggan,
                pelanggan.nama_pelanggan AS name
            ')
            ->join('pelanggan', 'pelanggan.id = pesanan.pelanggan_id', 'left')
            ->join('status_pesanan', 'status_pesanan.id = pesanan.status_pesanan_id', 'left')
            ->orderBy('pesanan.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // Normalisasi setiap row supaya view tidak menemukan key yg hilang
        $recent = [];
        foreach ($recentRows as $r) {
            $customer = $r['nama_pelanggan'] ?? $r['name'] ?? 'Tidak Diketahui';

            $recent[] = [
                'id' => $r['id'],
                // maintain original format created_at for view; view bisa formatnya sendiri
                'created_at' => $r['created_at'],
                'nama_pelanggan' => $customer,
                'name' => $customer,
                'total_harga' => (int) ($r['total_harga'] ?? 0),
                'status_pesanan_id' => (int) ($r['status_pesanan_id'] ?? 0),
                'status_pesanan_nama' => $r['status_pesanan_nama'] ?? 'Tidak Diketahui',
            ];
        }

        return [
            'total_orders'   => $totalOrders,
            'total_revenue'  => $totalRevenue,
            'recent_orders'  => $recent,
            'recent_count'   => count($recent),
        ];
    }

    private function applyDateFilter($builder, $period, $start, $end)
    {
        switch ($period) {

            case 'today':
                $builder->where('DATE(pesanan.created_at)', date('Y-m-d'));
                break;

            case 'week':
                $builder->where('pesanan.created_at >=', date('Y-m-d', strtotime('-7 days')));
                break;

            case 'month':
                // filter dari tgl 1 bulan ini sampai hari ini (lebih representatif untuk "Bulan Ini")
                $firstOfMonth = date('Y-m-01');
                $today = date('Y-m-d');
                $builder->where("DATE(pesanan.created_at) >=", $firstOfMonth)
                        ->where("DATE(pesanan.created_at) <=", $today);
                break;

            case 'custom':
                if ($start && $end) {
                    $builder->where('DATE(pesanan.created_at) >=', $start);
                    $builder->where('DATE(pesanan.created_at) <=', $end);
                }
                break;

            default:
                // fallback: same as month
                $builder->where("MONTH(pesanan.created_at)", date('m'))
                        ->where("YEAR(pesanan.created_at)", date('Y'));
                break;
        }
    }
}
