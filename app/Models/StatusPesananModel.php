<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusPesananModel extends Model
{
    protected $table = 'status_pesanan';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama_status',
        'keterangan'
    ];

    protected $useTimestamps = false;
}
