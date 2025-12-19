<?php
namespace App\Controllers;

use App\Models\AdminModel;

class FixAdmin extends \App\Controllers\BaseController
{
    public function index()
    {
        $adminModel = new AdminModel();
        
        $email = 'admin@example.com';
        $newPassword = 'admin123'; // password yang kamu mau

        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

        $adminModel->where('email', $email)->set(['password' => $hashed])->update();

        echo "Password admin@example.com berhasil di-hash!<br>";
        echo "Password baru: <strong>$newPassword</strong><br>";
        echo "Hash: $hashed";
    }
}