<?= $this->include('layouts/header') ?>

<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-6">

        <!-- TITLE -->
        <h2 class="text-3xl md:text-4xl font-bold text-secondary text-center mb-12">
            Hubungi Kami
        </h2>

        <div class="bg-white shadow-md rounded-xl p-8 md:p-10 grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

            <!-- LEFT: Contact Info -->
            <div>
                <h3 class="text-2xl font-semibold text-secondary mb-6">Informasi Kontak</h3>

                <ul class="space-y-4 text-gray-700">
                    <li class="flex items-start gap-3">
                        <span class="text-primary text-xl mt-1"><i class="fas fa-map-marker-alt"></i></span>
                        <span>
                            <strong>Alamat:</strong><br>
                            Jl. Joglo Raya Ruko No.117A 9, RT.9/RW.6, Joglo, Kec. Kembangan, Kota Jakarta Barat,  
                            Daerah Khusus Ibukota Jakarta 11640
                        </span>
                    </li>

                    <li class="flex items-start gap-3">
                        <span class="text-primary text-xl mt-1"><i class="fas fa-phone"></i></span>
                        <span>
                            <strong>Telepon:</strong><br>
                            <a href="https://wa.me/6282113670969" target="_blank" class="text-primary hover:underline">
                                0821-1367-0969
                            </a>
                        </span>
                    </li>

                    <li class="flex items-start gap-3">
                        <span class="text-primary text-xl mt-1"><i class="fas fa-envelope"></i></span>
                        <span>
                            <strong>Email:</strong><br>
                            <a href="mailto:info@gudegdiajeng.com" class="text-primary hover:underline">
                                info@gudegdiajeng.com
                            </a>
                        </span>
                    </li>

                    <li class="flex items-start gap-3">
                        <span class="text-primary text-xl mt-1"><i class="fas fa-clock"></i></span>
                        <span>
                            <strong>Jam Operasional:</strong><br>
                            08:00 – 21:00 WIB
                        </span>
                    </li>
                </ul>

                <!-- CTA Buttons -->
                <div class="mt-8 flex gap-3 flex-wrap">
                    <a href="https://wa.me/6282113670969" 
                       class="bg-green-600 text-white px-5 py-3 rounded-full hover:bg-green-700 transition shadow">
                        <i class="fab fa-whatsapp mr-2"></i> Chat via WhatsApp
                    </a>

                    <a href="mailto:info@gudegdiajeng.com" 
                       class="bg-primary text-white px-5 py-3 rounded-full hover:bg-orange-600 transition shadow">
                        <i class="fas fa-envelope mr-2"></i> Kirim Email
                    </a>
                </div>
            </div>

            <!-- RIGHT: MAP -->
            <div class="rounded-xl overflow-hidden shadow-lg h-72 md:h-full">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.4506278438304!2d106.7350639!3d-6.205863099999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f73f2b29fa2f%3A0xdcf09e8d60d7b02!2sGudeg%20Diajeng!5e0!3m2!1sid!2sid!4v1736090000000!5m2!1sid!2sid"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy">
                </iframe>
            </div>

        </div>
    </div>
</section>

<?= $this->include('layouts/footer') ?>
