<?= $this->include('layouts/header') ?>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">

        <h2 class="text-3xl font-bold text-secondary mb-8">Laporan Penjualan</h2>

        <!-- ===== RINGKASAN ===== -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

            <!-- Total Pesanan -->
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Pesanan</p>
                    <p class="text-2xl font-bold summary-value">
                        <?= number_format($summary['total_orders']) ?>
                    </p>
                </div>
            </div>

            <!-- Pendapatan Kotor -->
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Pendapatan Kotor</p>
                    <p class="text-2xl font-bold summary-value">
                        Rp <?= number_format($summary['gross_revenue'], 0) ?>
                    </p>
                </div>
            </div>

            <!-- Ongkir -->
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="fas fa-truck text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Ongkos Kirim</p>
                    <p class="text-2xl font-bold summary-value">
                        Rp <?= number_format($summary['shipping_total'], 0) ?>
                    </p>
                </div>
            </div>

            <!-- Pendapatan Bersih -->
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <i class="fas fa-coins text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Pendapatan Bersih</p>
                    <p class="text-2xl font-bold summary-value">
                        Rp <?= number_format($summary['net_revenue'], 0) ?>
                    </p>
                </div>
            </div>

        </div>

        <!-- ===== GRAFIK ===== -->
        <div class="bg-white p-6 rounded-xl shadow-md mb-10">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <h3 class="text-xl font-semibold text-gray-800">Grafik Penjualan</h3>

                <div class="flex gap-2 flex-wrap">
                    <button data-period="today" onclick="filterReport('today')" 
                        class="filter-btn px-4 py-2 text-sm rounded-lg bg-gray-100 hover:bg-gray-200">
                        Hari Ini
                    </button>

                    <button data-period="week" onclick="filterReport('week')" 
                        class="filter-btn px-4 py-2 text-sm rounded-lg bg-gray-100 hover:bg-gray-200">
                        7 Hari
                    </button>

                    <button data-period="month" onclick="filterReport('month')" 
                        class="filter-btn px-4 py-2 text-sm rounded-lg bg-gray-100 hover:bg-gray-200">
                        Bulan Ini
                    </button>

                    <input type="date" id="start_date" class="px-3 py-2 text-sm border rounded-lg">
                    <input type="date" id="end_date" class="px-3 py-2 text-sm border rounded-lg">

                    <button data-period="custom" onclick="filterReport('custom')" 
                        class="filter-btn px-4 py-2 text-sm rounded-lg bg-gray-100 hover:bg-gray-200">
                        Cari
                    </button>
                </div>
            </div>

            <div style="height:420px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- ===== DETAIL PENJUALAN ===== -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Detail Penjualan</h3>

                <div class="flex gap-2">
                    <button onclick="exportPDF()" class="px-4 py-2 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600 flex items-center">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </button>
                    <button onclick="exportExcel()" class="px-4 py-2 text-sm bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center">
                        <i class="fas fa-file-excel mr-1"></i> Excel
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto mt-4 rounded-lg border border-gray-200">
                <table id="salesTable" class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">ID</th>
                            <th class="p-3 text-left">Tanggal</th>
                            <th class="p-3 text-left">Pelanggan</th>
                            <th class="p-3 text-left">Item</th>
                            <th class="p-3 text-left">Detail Menu</th>

                            <th class="p-3 text-right">Subtotal</th>
                            <th class="p-3 text-right">Ongkir</th>
                            <th class="p-3 text-right">Total</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Pembayaran</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($sales as $sale): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="p-3">#<?= $sale['id'] ?></td>
                            <td class="p-3"><?= date('d/m/Y H:i', strtotime($sale['created_at'])) ?></td>
                            <td class="p-3"><?= esc($sale['name']) ?></td>
                            <td class="p-3"><?= $sale['item_count'] ?> item</td>
                            <td class="p-3"><?= esc($sale['items']) ?></td>

                            <td class="p-3 text-right">Rp <?= number_format($sale['subtotal']) ?></td>
                            <td class="p-3 text-right">Rp <?= number_format($sale['shipping']) ?></td>
                            <td class="p-3 text-right font-bold">Rp <?= number_format($sale['total']) ?></td>
                            <td class="p-3">
                                <span class="px-3 py-1 text-xs rounded-full text-white font-medium
                                    <?= $sale['status'] === 'Diproses' ? 'bg-blue-500' :
                                        ($sale['status'] === 'Pengiriman' ? 'bg-yellow-600' :
                                        ($sale['status'] === 'Selesai' ? 'bg-green-600' : 'bg-red-600')) ?>">
                                    <?= $sale['status'] ?>
                                </span>
                            </td>
                            <td class="p-3"><?= $sale['payment'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</section>

<style>
    .filter-btn.active {
    background-color: #f97316 !important; /* oranye */
    color: white !important;
}
#salesTable tbody tr:nth-child(even) { background: #fafafa; }
</style>

<!-- ===== SCRIPTS ===== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf-autotable"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

<script>
let salesChart;

/* -------------------------
   RENDER CHART
--------------------------*/
function renderChart(data) {
    const ctx = document.getElementById('salesChart').getContext('2d');

    if (salesChart) salesChart.destroy();

    salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Penjualan (Rp)',
                data: data.values,
                backgroundColor: 'rgba(237,137,54,.85)',
                borderColor: '#d97706',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    ticks: {
                        callback: v => 'Rp ' + v.toLocaleString('id-ID')
                    }
                }
            }
        }
    });
}

renderChart(<?= json_encode($chart) ?>);


/* -------------------------
   FILTER REPORT
--------------------------*/
function filterReport(period) {
    setActiveButton(period);
    
    const start = document.getElementById('start_date').value;
    const end   = document.getElementById('end_date').value;

    if (period === 'custom') {
        if (!start || !end) {
            alert("Silakan pilih tanggal mulai & akhir");
            return;
        }
    }

    const url = `<?= base_url('admin/report/filter') ?>?period=${period}`
              + (period === 'custom' ? `&start=${start}&end=${end}` : '');

    fetch(url)
        .then(r => r.json())
        .then(data => {
            renderChart(data.chart);
            updateTable(data.sales);
            updateSummary(data.summary);
        });
}

/* -------------------------
   UPDATE SUMMARY
--------------------------*/
function updateSummary(summary) {
    const list = document.querySelectorAll('.summary-value');
    const vals = [
        summary.total_orders,
        summary.gross_revenue,
        summary.shipping_total,
        summary.net_revenue
    ];

    list.forEach((el, i) => {
        el.textContent = i === 0
            ? vals[i]
            : 'Rp ' + Number(vals[i]).toLocaleString('id-ID');
    });
}

/* -------------------------
   UPDATE TABLE
--------------------------*/
function updateTable(sales) {
    const tbody = document.querySelector('#salesTable tbody');
    tbody.innerHTML = '';

    sales.forEach(s => {
        let tgl = new Date(s.created_at.replace(" ", "T"));

        tbody.innerHTML += `
            <tr class="hover:bg-gray-50">
                <td class="p-3">#${s.id}</td>
                <td class="p-3">${tgl.toLocaleString('id-ID')}</td>
                <td class="p-3">${s.name}</td>
                <td class="p-3">${s.item_count} item</td>
                <td class="p-3">${s.items}</td>

                <td class="p-3 text-right">Rp ${Number(s.subtotal).toLocaleString('id-ID')}</td>
                <td class="p-3 text-right">Rp ${Number(s.shipping).toLocaleString('id-ID')}</td>
                <td class="p-3 text-right font-bold">Rp ${Number(s.total).toLocaleString('id-ID')}</td>
                <td class="p-3">
                    <span class="px-3 py-1 text-xs rounded-full text-white font-medium ${
                        s.status === 'Diproses' ? 'bg-blue-500' :
                        s.status === 'Pengiriman' ? 'bg-yellow-600' :
                        s.status === 'Selesai' ? 'bg-green-600' : 'bg-red-600'
                    }">
                        ${s.status}
                    </span>
                </td>
                <td class="p-3">${s.payment}</td>
            </tr>
        `;
    });
}

/* -------------------------
   EXPORT PDF & EXCEL
--------------------------*/
function exportPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'pt');

    doc.text('Laporan Penjualan Gudeg Diajeng', 40, 40);
    doc.autoTable({
        html: '#salesTable',
        startY: 60,
        styles: { fontSize: 9, cellPadding: 3 },
        headStyles: { fillColor: [237, 137, 54] }
    });

    doc.save('laporan-penjualan.pdf');
}

function exportExcel() {
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.table_to_sheet(document.getElementById('salesTable'));
    XLSX.utils.book_append_sheet(wb, ws, 'Laporan');
    XLSX.writeFile(wb, 'laporan-penjualan.xlsx');
}

function setActiveButton(period) {
    const buttons = document.querySelectorAll('.filter-btn');

    buttons.forEach(btn => {
        if (btn.dataset.period === period) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
}

</script>

<?= $this->include('layouts/footer') ?>
