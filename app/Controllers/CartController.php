<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\DetailMenuModel;
use App\Models\PelangganModel;
use App\Models\PesananModel;
use App\Models\DetailPesananModel;
use App\Models\BuktiPembayaranModel;
use CodeIgniter\RESTful\ResourceController;

class CartController extends ResourceController
{
    protected $menuModel;
    protected $detailMenuModel;
    protected $pelangganModel;
    protected $pesananModel;
    protected $detailPesananModel;
    protected $buktiPembayaranModel;
    protected $db;

    public function __construct()
    {
        $this->menuModel            = new MenuModel();
        $this->detailMenuModel      = new DetailMenuModel();
        $this->pelangganModel       = new PelangganModel();
        $this->pesananModel         = new PesananModel();
        $this->detailPesananModel   = new DetailPesananModel();
        $this->buktiPembayaranModel = new BuktiPembayaranModel();
        $this->db = \Config\Database::connect();
    }

    private function hitungJarakKm($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon/2) * sin($dLon/2);

        return $R * (2 * atan2(sqrt($a), sqrt(1-$a)));
    }


    // =======================================
    // 🔥 NEW: Fungsi hitung jarak (KM)
    // =======================================
   




    // =======================
    // TAMPILKAN KERANJANG
    // =======================
    public function index()
    {
        $cart = session()->get('cart') ?? [];
        $total = 0;

        foreach ($cart as $menuId => $item) {

            $menu = $this->menuModel->find($menuId);
            $detail = $this->detailMenuModel->where('menu_id', $menuId)->first();

            if (!$menu || !$detail) {
                unset($cart[$menuId]);
                continue;
            }

            $item['nama_menu']     = $menu['nama_menu'];
            $item['gambar']        = $menu['gambar'];
            $item['stok_tersedia'] = $detail['stok'];

            $total += $item['price'] * $item['quantity'];

            $cart[$menuId] = $item;
        }

        session()->set('cart', $cart);

        return view('cart/index', [
            'cart' => $cart,
            'total' => $total
        ]);
    }


    // =======================
    // TAMBAH KE KERANJANG
    // =======================
    public function add()
    {
        $menuId = $this->request->getPost('menu_id');
        $qty    = (int)($this->request->getPost('qty') ?? 1);

        $menu   = $this->menuModel->find($menuId);
        $detail = $this->detailMenuModel->where('menu_id', $menuId)->first();

        if (!$menu || !$detail) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan.');
        }

        if ($detail['stok'] < $qty) {
            return redirect()->back()->with('error', 'Stok tidak cukup! Tersedia: ' . $detail['stok']);
        }

        $cart = session()->get('cart') ?? [];
        $currentQty = $cart[$menuId]['quantity'] ?? 0;

        if ($currentQty + $qty > $detail['stok']) {
            return redirect()->back()->with('error', 'Jumlah melebihi stok tersedia!');
        }

        $cart[$menuId] = [
            'nama_menu' => $menu['nama_menu'],
            'price'     => $menu['harga'],
            'gambar'    => $menu['gambar'],
            'quantity'  => $currentQty + $qty,
        ];

        session()->set('cart', $cart);
        return redirect()->back()->with('success', 'Ditambahkan ke keranjang!');
    }


    // =======================
    // UPDATE JUMLAH AJAX
    // =======================
    public function update($id = null)
    {
        $menuId = $this->request->getPost('menu_id');
        $quantity = (int)$this->request->getPost('quantity');

        $detail = $this->detailMenuModel->where('menu_id', $menuId)->first();

        if (!$detail || $quantity < 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Jumlah tidak valid']);
        }

        if ($detail['stok'] < $quantity) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Stok tidak cukup! Tersedia: ' . $detail['stok']
            ]);
        }

        $cart = session()->get('cart') ?? [];

        if (!isset($cart[$menuId])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Item tidak ada']);
        }

        $cart[$menuId]['quantity'] = $quantity;
        session()->set('cart', $cart);

        $subtotal = $cart[$menuId]['price'] * $quantity;
        $grandTotal = array_reduce($cart, fn($c, $i) => $c + ($i['price'] * $i['quantity']), 0);

        return $this->response->setJSON([
            'success'     => true,
            'quantity'    => $quantity,
            'subtotal'    => 'Rp ' . number_format($subtotal),
            'grand_total' => 'Rp ' . number_format($grandTotal)
        ]);
    }


    // =======================
    // HAPUS ITEM
    // =======================
    public function remove()
    {
        $menuId = $this->request->getPost('menu_id');
        $cart = session()->get('cart') ?? [];

        unset($cart[$menuId]);
        session()->set('cart', $cart);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true]);
        }

        return redirect()->to('/cart')->with('success', 'Item dihapus');
    }


    // =======================
    // HALAMAN CHECKOUT
    // =======================
    public function checkout()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'pelanggan') {
            return redirect()->to('/auth/login')->with('error', 'Silakan login');
        }

        $cart = session()->get('cart') ?? [];
        if (empty($cart)) {
            return redirect()->to('/cart')->with('error', 'Keranjang kosong');
        }

        foreach ($cart as $menuId => $item) {
            $detail = $this->detailMenuModel->where('menu_id', $menuId)->first();
            if (!$detail || $detail['stok'] < $item['quantity']) {
                return redirect()->to('/cart')->with('error', 'Stok menu tidak cukup');
            }
        }

        $subtotal = array_reduce($cart, fn($c, $i) => $c + ($i['price'] * $i['quantity']), 0);

        return view('cart/checkout', [
            'pelanggan' => $this->pelangganModel->find(session()->get('user_id')),
            'cart'      => $cart,
            'subtotal'  => $subtotal,
            'shipping'  => 5000,
            'total'     => $subtotal + 5000,
        ]);
    }


    // =======================
    // PROSES CHECKOUT
    // =======================
    public function processCheckout()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/auth/login');
    }

    // ============================================
    // 🔥 Terima Latitude & Longitude dari form
    // ============================================
    $lat = $this->request->getPost('latitude');
    $lon = $this->request->getPost('longitude');

    if (!$lat || !$lon) {
        return redirect()->back()->with('errors', [
            'location' => 'Silakan tekan tombol "Gunakan Lokasi Saya" terlebih dahulu.'
        ]);
    }

    // ============================================
    // 🔥 Hitung jarak pelanggan → toko menggunakan Haversine
    // ============================================
    $storeLat = -6.221010; 
    $storeLon = 106.721068;;

    $jarakKm = $this->hitungJarakKm($storeLat, $storeLon, $lat, $lon);
    $jarakBulatan = ceil($jarakKm);

    // ============================================
    // 🔥 Hitung ongkir
    // 0–1 km = GRATIS
    // Tiap 1 km tambahan = +1000
    // ============================================
    $ongkir = 0;
    if ($jarakBulatan > 1) {
        $ongkir = ($jarakBulatan - 1) * 1000;
    }

    $pelangganId = session()->get('user_id');
    $cart = session()->get('cart') ?? [];

    if (empty($cart)) {
        return redirect()->to('/cart')->with('error', 'Keranjang kosong');
    }

    // ============================================
    // UPLOAD BUKTI PEMBAYARAN
    // ============================================
    $file = $this->request->getFile('bukti_pembayaran');

    if (!$file || !$file->isValid()) {
        return redirect()->back()->with('errors', [
            'bukti_pembayaran' => 'Wajib upload bukti pembayaran'
        ]);
    }

    $newName = $file->getRandomName();
    $file->move(FCPATH . 'uploads/bukti', $newName);

    // Simpan bukti pembayaran
    $buktiId = $this->buktiPembayaranModel->insert([
        'pelanggan_id'      => $pelangganId,
        'file_path'         => 'uploads/bukti/' . $newName,
        'status_verifikasi' => 'Menunggu'
    ]);

    // ============================================
    // HITUNG SUBTOTAL
    // ============================================
    $subtotal = array_reduce($cart, fn($c, $i) => $c + ($i['price'] * $i['quantity']), 0);

    // TOTAL = subtotal + ongkir
    $totalHarga = $subtotal + $ongkir;

    // ============================================
    // SIMPAN PESANAN
    // ============================================
    $pesananId = $this->pesananModel->insert([
        'pelanggan_id'        => $pelangganId,
        'subtotal'            => $subtotal,
        'ongkir'              => $ongkir,
        'total_harga'         => $totalHarga,
        'jarak_km'            => $jarakBulatan,     // SIMPAN JARAK
        'latitude'            => $lat,
        'longitude'           => $lon,
        'alamat_pengiriman'   => $this->pelangganModel->find($pelangganId)['alamat'],

        'status_pesanan_id'   => 1,
        'metode_pembayaran_id'=> 1,
        'bukti_pembayaran_id' => $buktiId,
    ]);

    // ============================================
    // SIMPAN DETAIL PESANAN + KURANGI STOK
    // ============================================
    foreach ($cart as $menuId => $item) {
        $this->detailPesananModel->insert([
            'pesanan_id' => $pesananId,
            'menu_id'    => $menuId,
            'jumlah'     => $item['quantity'],
            'subtotal'   => $item['price'] * $item['quantity'],
        ]);

        $this->detailMenuModel
            ->where('menu_id', $menuId)
            ->set('stok', 'stok - ' . $item['quantity'], false)
            ->update();
    }

    session()->remove('cart');

    return redirect()->to('/cart/success/' . $pesananId)
        ->with('success', 'Pesanan berhasil dibuat!');
}



    // =======================
    // HALAMAN SUKSES
    // =======================
    public function success($pesananId)
    {
        $pesanan = $this->pesananModel->find($pesananId);

        return view('cart/success', [
            'pesanan' => $pesanan
        ]);
    }
}
