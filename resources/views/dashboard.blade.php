@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="btn btn-sm btn-primary d-none d-sm-inline-block">
            <i class="bi bi-download me-1"></i> Generate Report
        </a>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary h-100">
                <div class="card-body">
                    <div class="row g-0 align-items-center">
                        <div class="col me-2">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">$40,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar3 fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success h-100">
                <div class="card-body">
                    <div class="row g-0 align-items-center">
                        <div class="col me-2">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">$215,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cash-coin fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info h-100">
                <div class="card-body">
                    <div class="row g-0 align-items-center">
                        <div class="col me-2">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Tasks</div>
                            <div class="row g-0 align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 me-3 fw-bold text-gray-800">50%</div>
                                </div>
                                <div class="col">
                                    <div class="progress" style="height: 0.5rem;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-list-check fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning h-100">
                <div class="card-body">
                    <div class="row g-0 align-items-center">
                        <div class="col me-2">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Pending Requests</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">18</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-exclamation-triangle fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0">Earnings Overview</h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 320px;">
                        <canvas id="areaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0">Revenue Sources</h6>
                </div>
                <div class="card-body center">
                    <div style="position: relative; height: 260px;">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="m-0">Projects</h6>
                </div>
                <div class="card-body">
                    @foreach ([['Server Migration', 20, 'danger'], ['Sales Tracking', 40, 'warning'], ['Customer Database', 60, 'info'], ['Payroll App', 80, 'primary'], ['Laravel Integration', 100, 'success']] as [$label, $percent, $color])
                        <h4 class="small fw-bold">{{ $label }} <span class="float-end">{{ $percent }}%</span></h4>
                        <div class="progress mb-4" style="height: 0.5rem;">
                            <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $percent }}%"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="m-0">Illustration</h6>
                </div>
                <div class="card-body text-center py-5">
                    <i class="bi bi-clipboard-data" style="font-size: 6rem; color: var(--sb-primary);"></i>
                    <p class="mt-3 text-gray-600 mb-0">Add your own widgets, tables, or reports to this panel.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        const areaCtx = document.getElementById('areaChart');
        new Chart(areaCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Earnings',
                    data: [1000, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.15)',
                    fill: true,
                    tension: 0.3,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { ticks: { callback: (v) => '$' + v.toLocaleString() } } },
            },
        });

        const pieCtx = document.getElementById('pieChart');
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Direct', 'Social', 'Referral'],
                datasets: [{
                    data: [55, 30, 15],
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                cutout: '70%',
            },
        });
    </script>
@endpush
