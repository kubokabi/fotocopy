@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
            <div class="row">

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'today']) }}" class="{{ $filter == 'today' ? 'active' : '' }}">Today</a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'month']) }}" class="{{ $filter == 'month' ? 'active' : '' }}">This Month</a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'year']) }}" class="{{ $filter == 'year' ? 'active' : '' }}">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Sales <span>| {{ ucfirst($filter) }}</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>
                                        @if ($totalSales >= 100000)
                                        <h6>99999+</h6>
                                        @else
                                        <h6>{{ $totalSales }}</h6>
                                        @endif
                                    </h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'today']) }}">Today</a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'this_month']) }}">This Month</a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'this_year']) }}">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Revenue <span>| {{ ucfirst(str_replace('_', ' ', $filter)) }}</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $formattedMargin }}</h6>
                                </div>
                            </div>
                        </div>


                    </div>
                </div><!-- End Revenue Card -->

                <!-- Customers Card -->
                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <!-- Filter dropdown -->
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'today']) }}">Today</a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'month']) }}">This Month</a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'year']) }}">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Customers <span>| {{ ucfirst($filter) }}</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>
                                        @if ($totalCustomers >= 100000)
                                        <h6>99999+</h6>
                                        @else
                                        <h6>{{ $totalCustomers }}</h6>
                                        @endif
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Customers Card -->

                <!-- Top Selling -->
                <div class="col-12">
                    <div class="card top-selling overflow-auto">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('dashboard?filter=today') }}">Today</a></li>
                                <li><a class="dropdown-item" href="{{ url('dashboard?filter=month') }}">This Month</a></li>
                                <li><a class="dropdown-item" href="{{ url('dashboard?filter=year') }}">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body pb-0">
                            <h5 class="card-title">Top Selling <span>| {{ ucfirst($filter) }}</span></h5>

                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Sold</th>
                                        <th scope="col">Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topSellingProducts as $product)
                                    <tr>
                                        <td><a href="#" class="text-primary fw-bold">{{ $product->nama_brg }}</a></td>
                                        <td>Rp{{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                                        <td class="fw-bold">{{ $product->terjual }}</td>
                                        <td>Rp{{ number_format($product->total_jual, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
                <!-- End Top Selling -->

                <!-- Reports -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Reports <span>| This Month</span></h5>

                            <!-- Line Chart -->
                            <div id="reportsChart"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    const dates = <?= json_encode($chartData['dates']) ?>;
                                    const sales = <?= json_encode($chartData['sales']) ?>;
                                    const customers = <?= json_encode($chartData['customers']) ?>;
                                    const revenue = <?= json_encode($chartData['revenue']) ?>;

                                    new ApexCharts(document.querySelector("#reportsChart"), {
                                        series: [{
                                            name: 'Sales',
                                            data: sales
                                        }, {
                                            name: 'Revenue',
                                            data: revenue
                                        }, {
                                            name: 'Customers',
                                            data: customers
                                        }],
                                        chart: {
                                            height: 350,
                                            type: 'area',
                                            toolbar: {
                                                show: false
                                            }
                                        },
                                        markers: {
                                            size: 4
                                        },
                                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                        fill: {
                                            type: "gradient",
                                            gradient: {
                                                shadeIntensity: 1,
                                                opacityFrom: 0.3,
                                                opacityTo: 0.4,
                                                stops: [0, 90, 100]
                                            }
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        stroke: {
                                            curve: 'smooth',
                                            width: 2
                                        },
                                        xaxis: {
                                            type: 'datetime',
                                            categories: dates
                                        },
                                        tooltip: {
                                            x: {
                                                format: 'dd/MM/yy'
                                            }
                                        }
                                    }).render();
                                });
                            </script>
                            <!-- End Line Chart -->
                        </div>
                    </div>
                </div>
                <!-- End Reports -->



            </div>
        </div>
        <!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

            <!-- Recent Activity -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Stock Warning</h5>

                    <div class="activity">
                        @foreach($stockWarnings as $warning)
                        <div class="activity-item d-flex">
                            <div class="activite-label">{{ $warning->kd_brg }}</div>
                            <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                            <div class="activity-content">
                                Barang <a href="#" class="fw-bold text-dark">{{ $warning->nama_brg }}</a> telah mencapai {{ $warning->stok <= $warning->stok_min ? 'stok minimum' : 'stok maksimum' }}
                            </div>
                        </div><!-- End activity item-->
                        @endforeach
                    </div>

                </div>
            </div>
            <!-- End Recent Activity -->

        </div><!-- End Right side columns -->

    </div>
</section>
@endsection
