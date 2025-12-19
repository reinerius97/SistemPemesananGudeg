<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriMenuModel extends Model
{
    protected $table = 'kategori_menu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_kategori'];
}
