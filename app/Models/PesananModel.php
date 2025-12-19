<?php
namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'pelanggan_id',
        'admin_id',
        'tanggal_pesanan',
        'subtotal',
        'ongkir',
        'total_harga',
        'alamat_pengiriman',
        'catatan',
        'status_pesanan_id',
        'metode_pembayaran_id',
        'bukti_pembayaran_id',

        'latitude',
        'longitude',
        'jarak_km',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
