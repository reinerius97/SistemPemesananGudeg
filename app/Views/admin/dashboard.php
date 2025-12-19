<?= $this->include('layouts/header') ?>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">

        <!-- TITLE + FILTER -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <h2 class="text-3xl font-bold text-secondary">Dashboard Admin</h2>

            <div class="flex flex-wrap gap-2 mt-4 md:mt-0">
                <button onclick="filterDashboard('month')" 
                        class="px-4 py-2 text-sm rounded-lg bg-primary text-white hover:bg-orange-600 transition">
                    Bulan Ini
                </button>

                <input type="date" id="start_date" class="px-3 py-2 text-sm border rounded-lg">
                <input type="date" id="end_date" class="px-3 py-2 text-sm border rounded-lg">

                <button onclick="filterDashboard('custom')" 
                        class="px-4 py-2 text-sm rounded-lg bg-gray-100 hover:bg-gray-200 transition">
                    Cari
                </button>
            </div>
        </div>

        <!-- SUMMARY CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">

            <!-- Total Pesanan -->
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center">
                <i class="fas fa-box text-4xl text-primary mr-4"></i>
                <div>
                    <h3 class="text-xl font-semibold text-secondary">Total Pesanan</h3>
                    <p class="text-2xl font-bold" id="total-orders"><?= esc($total_orders ?? 0) ?> Pesanan</p>
                </div>
            </div>

            <!-- Pendapatan -->
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center">
                <i class="fas fa-money-bill-wave text-4xl text-primary mr-4"></i>
                <div>
                    <h3 class="text-xl font-semibold text-secondary">Total Pendapatan</h3>
                    <p class="text-2xl font-bold" id="total-revenue">Rp <?= number_format($total_revenue ?? 0, 0) ?></p>
                </div>
            </div>

            <!-- Recent Count -->
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center">
                <i class="fas fa-clock text-4xl text-primary mr-4"></i>
                <div>
                    <h3 class="text-xl font-semibold text-secondary">Pesanan Terbaru</h3>
                    <p class="text-2xl font-bold" id="recent-count"><?= esc($recent_count ?? 0) ?></p>
                </div>
            </div>

        </div>

        <!-- RECENT ORDERS LIST -->
        <div class="bg-white p-6 rounded-xl shadow-md mb-8">
            <h3 class="text-xl font-bold text-secondary mb-4">5 Pesanan Terbaru</h3>

            <div id="recent-orders-list">

                <?php foreach ($recent_orders as $order): ?>
                    <div class="flex justify-between items-center py-3 border-b last:border-0">
                        
                        <!-- LEFT -->
                        <div>
                            <p class="font-semibold">
                                #<?= $order['id'] ?> - <?= esc($order['nama_pelanggan'] ?? $order['name'] ?? 'Tidak Diketahui') ?>
                            </p>
                            <p class="text-sm text-gray-600">
                                <?= date('d M Y H:i', strtotime($order['created_at'])) ?>
                            </p>
                        </div>

                        <!-- RIGHT -->
                        <div class="text-right">
                            <p class="font-bold">
                                Rp <?= number_format($order['total_harga'] ?? 0) ?>
                            </p>

                            <?php 
                                $status = $order['status_pesanan_nama'] ?? 'Tidak diketahui';
                                $class = 'bg-gray-200 text-gray-800';

                                if ($status === 'Diproses')  $class = 'bg-blue-100 text-blue-800';
                                if ($status === 'Pengiriman') $class = 'bg-yellow-100 text-yellow-800';
                                if ($status === 'Selesai')   $class = 'bg-green-100 text-green-800';
                            ?>

                            <span class="inline-block px-3 py-1 text-xs rounded-full <?= $class ?>">
                                <?= esc($status) ?>
                            </span>
                        </div>

                    </div>
                <?php endforeach; ?>

            </div>
        </div>

        <!-- SHORTCUTS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <a href="/admin/menu" 
               class="bg-primary text-white p-6 rounded-xl shadow-md hover:bg-orange-600 transition text-center">
                <i class="fas fa-utensils text-4xl mb-2"></i>
                <h3 class="text-xl font-bold">Kelola Menu</h3>
            </a>

            <a href="/admin/orders" 
               class="bg-primary text-white p-6 rounded-xl shadow-md hover:bg-orange-600 transition text-center">
                <i class="fas fa-box-open text-4xl mb-2"></i>
                <h3 class="text-xl font-bold">Kelola Pesanan</h3>
            </a>

            <a href="/admin/report" 
               class="bg-primary text-white p-6 rounded-xl shadow-md hover:bg-orange-600 transition text-center">
                <i class="fas fa-chart-bar text-4xl mb-2"></i>
                <h3 class="text-xl font-bold">Laporan Penjualan</h3>
            </a>

        </div>

    </div>
</section>


<!-- SCRIPT FILTER DASHBOARD -->
<script>
function filterDashboard(period) {
    let start = document.getElementById('start_date').value;
    let end   = document.getElementById('end_date').value;

    let url = `<?= base_url('admin/dashboard/filter') ?>?period=${period}`;
    if (period === 'custom') {
        url += `&start=${start}&end=${end}`;
    }

    fetch(url)
        .then(r => r.json())
        .then(data => {

            // Update summary
            document.getElementById('total-orders').textContent =
                (data.total_orders ?? 0) + ' Pesanan';

            document.getElementById('total-revenue').textContent =
                'Rp ' + Number(data.total_revenue ?? 0).toLocaleString('id-ID');

            document.getElementById('recent-count').textContent =
                (data.recent_count ?? 0);

            // Update recent orders list
            let list = document.getElementById('recent-orders-list');
            list.innerHTML = '';

            (data.recent_orders || []).forEach(order => {

                // safe fallback untuk nama pelanggan (tergantung naming dari controller)
                const pelangganNama = order.nama_pelanggan || order.name || order.pelanggan_nama || 'Tidak Diketahui';

                let status = order.status_pesanan_nama || 'Tidak diketahui';
                let statusClass = 'bg-gray-200 text-gray-800';

                if (status === 'Diproses')    statusClass = 'bg-blue-100 text-blue-800';
                if (status === 'Pengiriman')  statusClass = 'bg-yellow-100 text-yellow-800';
                if (status === 'Selesai')     statusClass = 'bg-green-100 text-green-800';

                list.innerHTML += `
                    <div class="flex justify-between items-center py-3 border-b last:border-0">
                        <div>
                            <p class="font-semibold">#${order.id} - ${pelangganNama}</p>
                            <p class="text-sm text-gray-600">
                                ${new Date(order.created_at).toLocaleString('id-ID')}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="font-bold">Rp ${Number(order.total_harga ?? 0).toLocaleString('id-ID')}</p>

                            <span class="inline-block px-3 py-1 text-xs rounded-full ${statusClass}">
                                ${status}
                            </span>
                        </div>
                    </div>
                `;
            });

        })
        .catch(err => console.error(err));
}
</script>

<?= $this->include('layouts/footer') ?>
