<?php

namespace App\Models;

use CodeIgniter\Model;

class BuktiPembayaranModel extends Model
{
    protected $table = 'bukti_pembayaran';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'pesanan_id',
        'file_path',
        'upload_at',
        'status_verifikasi'
    ];

    protected $useTimestamps = false;
}
