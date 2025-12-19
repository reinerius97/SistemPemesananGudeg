<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gudeg Diajeng - Pesan gudeg online, cepat dan lezat.">

    <title>Gudeg Diajeng</title>

    <!-- FAVICONS: letakkan file di public/ -->
    <!-- contoh: public/favicon.ico, public/favicon-32x32.png, public/apple-touch-icon.png -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

    <meta name="theme-color" content="#ED8936">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Tailwind (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ED8936', // Orange for buttons
                        secondary: '#975A16', // Brown for headers
                        accent: '#38A169', // Green for success
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                    },
                },
            },
        };
    </script>
</head>

<body class="bg-gray-100 font-sans antialiased">
<header class="sticky top-0 z-50 bg-white shadow-md">
    <nav class="container mx-auto px-4 py-4 flex items-center justify-between">
        
        <div class="flex items-center">
            <img src="/uploads/logo.png" alt="Logo Gudeg Diajeng" class="h-12 w-12 rounded-full mr-4">
            <a class="text-3xl font-bold text-secondary" href="/">Gudeg Diajeng</a>
        </div>

        <div class="hidden md:flex space-x-6 text-lg">
            <a class="text-gray-700 hover:text-primary transition" href="/">Beranda</a>
            <a class="text-gray-700 hover:text-primary transition" href="/menu">Menu</a>
            
            <a class="text-gray-700 hover:text-primary transition" href="/tentang">Tentang</a>
            <a class="text-gray-700 hover:text-primary transition" href="/kontak">Kontak</a>
            <?php if (session()->get('role') === 'admin'): ?>
                <a class="text-gray-700 hover:text-primary transition" href="/admin/dashboard">Dashboard Admin</a>
            <?php endif; ?>
        </div>

        <div class="flex items-center space-x-4">
            <a href="/cart" class="text-gray-700 hover:text-primary transition relative">
                <i class="fas fa-shopping-cart text-lg"></i>
                <span class="absolute -top-2 -right-2 bg-primary text-white text-xs rounded-full px-1"><?= count(session()->get('cart') ?? []) ?></span>
            </a>
            <?php if (session()->get('isLoggedIn')): ?>
                <a href="/orders/history" class="text-gray-700 hover:text-primary transition">Riwayat</a>
                <a href="/auth/logout" class="text-gray-700 hover:text-primary transition">Logout</a>
            <?php else: ?>
                <a href="/auth/login" class="text-gray-700 hover:text-primary transition">Login</a>
            <?php endif; ?>

            <form action="/menu" method="get" class="flex">
                <input type="search" name="search" placeholder="Cari Menu" class="border rounded-l px-2 py-2 focus:outline-none focus:border-primary">
                <button type="submit" class="bg-primary text-white rounded-r px-3 py-2">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="md:hidden text-gray-700"><i class="fas fa-bars text-xl"></i></button>
    </nav>
</header>
<main class="container mx-auto px-4 py-8">