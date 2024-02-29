@extends('dashboard.master')
@section('header')
@endsection

@section('content')
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
                                    <h6>ACTIONS</h6>
                                </li>

                                <li><a class="dropdown-item" href="/createwaybill">Create Waybill</a></li><br>
                                <li><a class="dropdown-item" href="/my-waybills">View Waybills</a></li>
                        
                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Waybills</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ number_format($waybills) }}</h6>
                                    <a href='/createwaybill' class="text-primary small pt-1 fw-bold">Create Waybill→</a>
                                    <a href='/my-waybills' class="text-primary small pt-1 fw-bold">View Waybills→</a>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">


                        <div class="card-body">
                            <h5 class="card-title">Transactions</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-table"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ number_format(count($transactions)) }}</h6>
                                    <a href='/transactions' class="text-success small pt-1 fw-bold">View
                                        transactions→</a>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->


                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Recent Transactions <span>| Today</span></h5>

                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>

                                        <th scope="col">Details</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $tranx)
                                    <tr>

                                        <td><b>{{ $tranx->title }}</b><br>{{ Str::limit($tranx->description,35) }}<br><a href='/viewmore/{{ $tranx->uid }}'>View more</a></td>
                                        <td>NGN{{ number_format($tranx->amount) }}</td>
                                        <td>
                                            <span class="badge bg-success">Approved</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div><!-- End Recent Sales -->

            </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

            <!-- Recent Activity -->
            <div class="card">
                <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>

                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                </div>

                <div class="card-body">
                    <h5 class="card-title">Recent Activity</h5>

                    <div class="activity">
                        @foreach($activities as $act)

                        <div class="activity-item d-flex">
                            <div class="activite-label">{{ \Carbon\Carbon::parse($act->created_at)->diffForHumans() }}
                            </div>
                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                            <div class="activity-content">
                               <a href="#" class="fw-bold text-dark">{{ $act->title }}</a><br>{{ $act->description }}                            </div>
                        </div><!-- End activity item-->
                        @endforeach


                    </div>

                </div>
            </div><!-- End Recent Activity -->


        </div><!-- End Right side columns -->

    </div>
</section>
@endsection

@section('script')
@endsection