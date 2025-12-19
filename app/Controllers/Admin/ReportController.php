<?php

namespace App\Controllers\Admin;

use App\Models\PesananModel;
use App\Models\DetailPesananModel;
use App\Models\PelangganModel;
use CodeIgniter\RESTful\ResourceController;

class ReportController extends ResourceController
{
    protected $pesananModel;
    protected $detailPesananModel;
    protected $pelangganModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->detailPesananModel = new DetailPesananModel();
        $this->pelangganModel = new PelangganModel();
    }

    /**
     * HALAMAN LAPORAN AWAL
     */
    public function index()
    {
        $data = $this->getReportData("month");
        return view('admin/report', $data);
    }

    /**
     * FILTER VIA AJAX
     */
    public function filter()
    {
        $period = $this->request->getGet('period') ?? 'month';
        $start  = $this->request->getGet('start');
        $end    = $this->request->getGet('end');

        return $this->response->setJSON(
            $this->getReportData($period, $start, $end)
        );
    }

    /**
     * AMBIL LAPORAN UTAMA (summary + detail + grafik)
     */
    private function getReportData($period, $start = null, $end = null)
    {
        $builder = $this->pesananModel
            ->select("
                pesanan.*,
                pelanggan.nama_pelanggan AS name,
                status_pesanan.nama_status AS status_name,
                bukti_pembayaran.status_verifikasi AS verifikasi_status
            ")
            ->join("pelanggan", "pelanggan.id = pesanan.pelanggan_id", "left")
            ->join("status_pesanan", "status_pesanan.id = pesanan.status_pesanan_id", "left")
            ->join("bukti_pembayaran", "bukti_pembayaran.id = pesanan.bukti_pembayaran_id", "left");

        // FILTER PERIODE
        if ($period === 'today') {
            $builder->where("DATE(pesanan.created_at)", date("Y-m-d"));
        } elseif ($period === 'week') {
            // 7 hari terakhir (termasuk hari ini)
            $builder->where("pesanan.created_at >=", date("Y-m-d", strtotime("-6 days")));
        } elseif ($period === 'month') {
            $builder->where("MONTH(pesanan.created_at)", date("m"))
                    ->where("YEAR(pesanan.created_at)", date("Y"));
        } elseif ($period === 'custom' && $start && $end) {
            // Validasi sederhana: pastikan start <= end
            if (strtotime($start) > strtotime($end)) {
                // kembalikan data kosong atau Anda bisa swap
                $tmp = $start; $start = $end; $end = $tmp;
            }
            $builder->where("DATE(pesanan.created_at) >=", $start)
                    ->where("DATE(pesanan.created_at) <=", $end);
        }

        $pesanan = $builder
            ->orderBy("pesanan.created_at", "DESC")
            ->findAll();

        // ============================
        // SUMMARY
        // ============================
        $totalOrders   = count($pesanan);
        $grossRevenue  = array_sum(array_column($pesanan, 'total_harga'));
        $shippingTotal = array_sum(array_column($pesanan, 'ongkir'));
        $netRevenue    = $grossRevenue - $shippingTotal;

        $summary = [
            'total_orders'   => $totalOrders,
            'gross_revenue'  => $grossRevenue,
            'shipping_total' => $shippingTotal,
            'net_revenue'    => $netRevenue,
        ];

        // ============================
        // CHART DATA (pass start/end)
        // ============================
        $chart = $this->buildChartData($period, $pesanan, $start, $end);

        // ============================
        // TABEL DETAIL PENJUALAN
        // ============================
        $sales = $this->buildSalesDetail($pesanan);

        return [
            'summary' => $summary,
            'chart'   => $chart,
            'sales'   => $sales,
        ];
    }

    /**
     * GRAFIK
     *
     * - today  : per jam (24 bar)
     * - week   : per hari 7 hari terakhir
     * - month  : grup per bulan (M Y)
     * - custom : per hari antara start..end
     */
    private function buildChartData($period, $pesanan, $start = null, $end = null)
    {
        // HELPERS
        $fmtDay = function($ts) {
            return date("d M Y", $ts); // contoh: 01 Nov 2025
        };

        // ===== TODAY => per jam (sama dengan sebelumnya) =====
        if ($period === 'today') {
            $labels = [];
            $values = [];

            for ($h = 0; $h < 24; $h++) {
                $hour = str_pad($h, 2, '0', STR_PAD_LEFT) . ":00";
                $labels[] = $hour;
                $values[$hour] = 0;
            }

            foreach ($pesanan as $order) {
                $h = date("H:00", strtotime($order['created_at']));
                $values[$h] += $order['total_harga'];
            }

            return [
                'labels' => array_keys($values),
                'values' => array_values($values)
            ];
        }

        // ===== WEEK => per hari (7 hari terakhir, termasuk hari tanpa order) =====
        if ($period === 'week') {
            $labels = [];
            $values = [];

            // buat range 7 hari terakhir (termasuk hari ini)
            for ($i = 6; $i >= 0; $i--) {
                $ts = strtotime("-{$i} days");
                $key = $fmtDay($ts);
                $labels[] = $key;
                $values[$key] = 0;
            }

            foreach ($pesanan as $order) {
                $key = date("d M Y", strtotime($order['created_at']));
                if (isset($values[$key])) {
                    $values[$key] += $order['total_harga'];
                }
            }

            return [
                'labels' => $labels,
                'values' => array_values($values)
            ];
        }

        // ===== MONTH => per hari dari tgl 1 sampai hari ini =====
        if ($period === 'month') {
            $labels = [];
            $values = [];

            // mulai hari 1 bulan ini
            $year = date('Y');
            $month = date('m');
            $startTs = strtotime("$year-$month-01");
            $endTs   = strtotime('today'); // sampai hari ini

            // loop per hari
            for ($ts = $startTs; $ts <= $endTs; $ts = strtotime('+1 day', $ts)) {
                $key = $fmtDay($ts);
                $labels[] = $key;
                $values[$key] = 0;
            }

            foreach ($pesanan as $order) {
                $key = date("d M Y", strtotime($order['created_at']));
                if (isset($values[$key])) {
                    $values[$key] += $order['total_harga'];
                }
            }

            return [
                'labels' => $labels,
                'values' => array_values($values)
            ];
        }

        // ===== CUSTOM => per hari antara $start .. $end (jika diberikan) =====
        if ($period === 'custom' && $start && $end) {
            $labels = [];
            $values = [];

            $startTs = strtotime($start);
            $endTs   = strtotime($end);

            // safety: jika start > end, tukar
            if ($startTs > $endTs) {
                $tmp = $startTs; $startTs = $endTs; $endTs = $tmp;
            }

            for ($ts = $startTs; $ts <= $endTs; $ts = strtotime('+1 day', $ts)) {
                $key = $fmtDay($ts);
                $labels[] = $key;
                $values[$key] = 0;
            }

            foreach ($pesanan as $order) {
                $key = date("d M Y", strtotime($order['created_at']));
                if (isset($values[$key])) {
                    $values[$key] += $order['total_harga'];
                }
            }

            return [
                'labels' => $labels,
                'values' => array_values($values)
            ];
        }

        // fallback: jika tidak cocok, kembalikan grouping per bulan seperti sebelumnya
        $group = [];
        foreach ($pesanan as $order) {
            $key = date("M Y", strtotime($order['created_at']));
            $group[$key] = ($group[$key] ?? 0) + $order['total_harga'];
        }

        return [
            'labels' => array_keys($group),
            'values' => array_values($group)
        ];
    }

    /**
     * DETAIL PENJUALAN UNTUK TABEL
     */
    private function buildSalesDetail($pesanan)
    {
        $sales = [];

        foreach ($pesanan as $order) {

            // Ambil detail item
            $items = $this->detailPesananModel
                ->select("detail_pesanan.jumlah, menu.nama_menu")
                ->join('menu', 'menu.id = detail_pesanan.menu_id', 'left')
                ->where('detail_pesanan.pesanan_id', $order['id'])
                ->findAll();

            // Format: Ayam Bakar x1, Gudeg Telur x2 (atau '-' jika kosong)
            $itemList = '-';
            if (!empty($items)) {
                $itemList = implode(', ', array_map(function($it){
                    return ($it['nama_menu'] ?? '-') . " x" . ($it['jumlah'] ?? 0);
                }, $items));
            }

            // jumlah item = total quantity (sum jumlah)
            $itemCount = !empty($items) ? array_sum(array_column($items, 'jumlah')) : 0;

            $sales[] = [
                'id'         => $order['id'],
                'created_at' => $order['created_at'],
                'name'       => $order['name'],
                'item_count' => $itemCount,
                'items'      => $itemList,
                'subtotal'   => (float)$order['subtotal'],
                'shipping'   => (float)$order['ongkir'],
                'total'      => (float)$order['total_harga'],
                'status'     => $order['status_name'] ?? 'Tidak Diketahui',
                'payment'    => $order['verifikasi_status'] ?? 'Menunggu',
            ];
        }

        return $sales;
    }

}
