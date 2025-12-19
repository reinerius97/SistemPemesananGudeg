<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\PelangganModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    protected $adminModel;
    protected $pelangganModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->pelangganModel = new PelangganModel();
    }

    // 1. LOGIN PAGE
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectBasedOnRole();
        }
        return view('auth/login');
    }

    // 2. PROSES LOGIN (ADMIN / PELANGGAN)
    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Cek di admin
        $admin = $this->adminModel->where('email', $email)->first();
        if ($admin && password_verify($password, $admin['password'])) {
            session()->set([
                'isLoggedIn' => true,
                'user_id'    => $admin['id'],
                'nama'       => $admin['nama'],
                'email'      => $admin['email'],
                'role'       => 'admin'
            ]);
            return redirect()->to('/admin/dashboard');
        }

        // Cek di pelanggan
        $pelanggan = $this->pelangganModel->where('email', $email)->first();
        if ($pelanggan && password_verify($password, $pelanggan['password'])) {
            session()->set([
                'isLoggedIn' => true,
                'user_id'    => $pelanggan['id'],
                'nama'       => $pelanggan['nama_pelanggan'],
                'email'      => $pelanggan['email'],
                'role'       => 'pelanggan'
            ]);
            return redirect()->to('/');
        }

        return redirect()->back()->with('error', 'Email atau password salah.');
    }

    // 3. REGISTER PAGE
    public function register()
    {
        return view('auth/register');
    }

    // 4. PROSES REGISTER (HANYA PELANGGAN)
    public function attemptRegister()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[pelanggan.email]',
            'phone'    => 'required|numeric|min_length[10]|max_length[15]|is_unique[pelanggan.no_telepon]',
            'address'  => 'required|min_length[10]',
            'password' => 'required|min_length[6]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $pelangganId = $this->pelangganModel->insert([
            'nama_pelanggan' => $this->request->getPost('name'),
            'email'          => $this->request->getPost('email'),
            'no_telepon'     => $this->request->getPost('phone'),
            'alamat'         => $this->request->getPost('address'),
            'password'       => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        ]);

        if (!$pelangganId) {
            return redirect()->back()->with('error', 'Gagal mendaftar. Coba lagi.');
        }

        // LOGIN OTOMATIS
        session()->set([
            'isLoggedIn'     => true,
            'user_id'        => $pelangganId,           // UBAH DARI pelanggan_id
            'nama_pelanggan' => $this->request->getPost('name'),  // atau nama_pelanggan
            'email'          => $this->request->getPost('email'),
            'role'           => 'pelanggan'
        ]);

        return redirect()->to('/')->with('success', 'Selamat datang! Akun berhasil dibuat.');
    }

    // 5. LOGOUT
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Anda telah logout.');
    }

    // Helper: Redirect berdasarkan role
    private function redirectBasedOnRole()
    {
        $role = session()->get('role');
        return $role === 'admin' 
            ? redirect()->to('/admin/dashboard') 
            : redirect()->to('/');
    }
}