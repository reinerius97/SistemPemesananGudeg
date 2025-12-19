<?php


// Ambil password dari input (bisa ganti manual atau tambah form)
$password = 'user123'; // Ganti dengan password Anda, misalnya "admin123"

// Hash password menggunakan algoritma default (bcrypt)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Tampilkan hasil
echo "Password asli: " . $password . "<br>";
echo "Password terhash: " . $hashed_password . "<br>";

// Opsional: Salin hash ini untuk dimasukkan ke database
?>