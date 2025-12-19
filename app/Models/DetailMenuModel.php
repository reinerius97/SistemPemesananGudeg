<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailMenuModel extends Model
{
    protected $table = 'detail_menu';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'menu_id',
        'deskripsi',
        'komposisi',
        'stok',
        'status_tersedia'
    ];

    protected $useTimestamps = false;
}
