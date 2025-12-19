<?php

namespace App\Models;

use CodeIgniter\Model;

class MetodePembayaranModel extends Model
{
    protected $table = 'metode_pembayaran';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama_metode',
        'deskripsi'
    ];

    protected $useTimestamps = false;
}
