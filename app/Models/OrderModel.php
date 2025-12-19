<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'name', 'phone', 'address', 'notes', 'payment_method', 'subtotal', 'shipping', 'total', 'status', 'created_at'];
    protected $useTimestamps = false;
}