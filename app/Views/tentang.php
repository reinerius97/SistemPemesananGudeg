<?= $this->include('layouts/header') ?>

<section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-bold text-secondary text-center mb-10">Tentang Gudeg Diajeng</h2>

        <div class="bg-white rounded-xl shadow-sm p-6 md:p-10 grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
            <!-- LEFT: logo / image -->
            <div class="flex justify-center md:justify-start">
                <div class="w-56 h-56 md:w-64 md:h-64 rounded-xl overflow-hidden shadow-lg bg-white flex items-center justify-center">
                    <img src="<?= base_url('uploads/logo.png') ?>" alt="Logo Gudeg Diajeng" class="w-full h-full object-contain">
                </div>
            </div>

            <!-- RIGHT: content (span 2 columns on md) -->
            <div class="md:col-span-2">
                <p class="text-gray-700 leading-relaxed mb-4">
                    Gudeg Diajeng berdiri sejak tahun 2019 sebagai usaha keluarga yang berawal dari kecintaan terhadap kuliner tradisional khas Yogyakarta. 
                    Dengan resep turun-temurun yang dipadukan sentuhan modern, kami menghadirkan gudeg Jogja yang autentik: manis, gurih, dan kaya rempah.
                </p>

                <p class="text-gray-700 leading-relaxed mb-4">
                    Sejak awal kami berkomitmen menjaga kualitas dan konsistensi rasa melalui bahan pilihan dan proses pengolahan yang higienis. Beberapa komitmen utama kami:
                </p>

                <ul class="space-y-2 mb-6">
                    <li class="flex items-start gap-3">
                        <span class="text-green-600 mt-1"><i class="fas fa-check-circle"></i></span>
                        <span class="text-gray-700">Nangka muda pilihan yang dimasak perlahan hingga meresap sempurna.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-600 mt-1"><i class="fas fa-check-circle"></i></span>
                        <span class="text-gray-700">Bumbu rempah alami tanpa bahan tambahan berbahaya.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-600 mt-1"><i class="fas fa-check-circle"></i></span>
                        <span class="text-gray-700">Ayam dan lauk pendamping berkualitas, serta sambal goreng krecek yang dimasak penuh perhatian.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-600 mt-1"><i class="fas fa-check-circle"></i></span>
                        <span class="text-gray-700">Standar kebersihan tinggi agar setiap pesanan aman dan layak konsumsi.</span>
                    </li>
                </ul>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    

                    <div>
                        <h4 class="text-lg font-semibold text-secondary mb-2">Nilai & Visi</h4>
                        <ul class="list-disc pl-5 text-gray-700 space-y-1">
                            <li>Menghadirkan cita rasa autentik Jogja ke lebih banyak orang</li>
                            <li>Menjadi brand lokal terpercaya karena kualitas & konsistensi</li>
                        </ul>
                    </div>
                </div>

                <h4 class="text-lg font-semibold text-secondary mb-2">Misi Kami</h4>
                <ul class="list-disc pl-5 text-gray-700 space-y-1 mb-6">
                    <li>Menjaga keaslian rasa gudeg tradisional</li>
                    <li>Mendukung petani dan UMKM lokal untuk bahan baku berkualitas</li>
                    <li>Menyediakan pelayanan ramah dan berorientasi pada kepuasan pelanggan</li>
                    <li>Berinovasi pada penyajian, kemasan, dan pengalaman pemesanan</li>
                </ul>

                <p class="text-gray-700 mb-6">
                    Dengan ribuan pelanggan yang telah menikmati sajian kami sejak 2019, Gudeg Diajeng berkomitmen terus menjadi bagian dari momen istimewa Anda.
                    Terima kasih atas kepercayaan Anda — mari ciptakan kenangan kuliner Jogja bersama!
                </p>

                <!-- CTA -->
                <div class="flex gap-3 flex-wrap">
                    <a href="<?= base_url('menu') ?>" class="inline-block px-5 py-3 rounded-full bg-primary text-white font-semibold shadow hover:bg-orange-600 transition">
                        Pesan Sekarang
                    </a>

                    <a href="<?= base_url('kontak') ?>" class="inline-block px-5 py-3 rounded-full border border-gray-200 text-gray-700 font-medium hover:bg-gray-100 transition">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('layouts/footer') ?>
