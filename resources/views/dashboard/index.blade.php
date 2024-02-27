@extends('dashboard.master')
@section('header')
@endsection

@section('content')


<!-- End Content -->



<!-- Content -->
<div class="content container-fluid" style="margin-top: -17rem;">

    <div class="card mb-3 mb-lg-5">
        <!-- Header -->
        <div class="card-header card-header-content-between">
            @if($user->email_verified_at !== null)
            <span class="badge bg-warning text-dark">

                <i class="bi-exclamation-triangle-fill me-1"></i>
                Unverified
            </span>

            @else
            <h4 class="card-header-title">Verified <i class="bi-patch-check-fill text-primary" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="This report is based on 100% of sessions."></i></h4>
            @endif
            <br>

            <!-- Dropdown -->
            <a href='/createwaybill' class='btn btn-primary'>Create Waybill</a>
            <!-- End Dropdown -->
        </div>
        <!-- End Header -->

        <!-- Body -->
        <div class="card-body">
            <div class="row col-sm-divider">
                <div class="col-sm-3 bg-soft-primary p-2 rounded" style='border-left:3px solid blue'>
                    <!-- Stats -->
                    <div class="d-lg-flex align-items-md-center">
                        <div class="flex-shrink-0">
                            <i class="bi-person fs-1 text-primary"></i>
                        </div>

                        <div class="flex-grow-1 ms-lg-3">
                            <a href='/my-waybills' class="d-block fs-6">Incoming Waybills</a>
                            <div class="d-flex align-items-center">
                                <h3 class="mb-0">{{ number_format($waybills) }}</h3>
                                {{-- <span class="badge bg-soft-success text-success ms-2">
                                    <i class="bi-graph-up"></i> 12.5%
                                </span> --}}
                            </div>
                        </div>
                    </div>
                    <!-- End Stats -->
                </div>

                <div class="col-sm-3">
                    <!-- Stats -->
                    <div class="d-lg-flex align-items-md-center">
                        <div class="flex-shrink-0">
                            <i class="bi-clock-history fs-1 text-primary"></i>
                        </div>

                        <div class="flex-grow-1 ms-lg-3">
                            <a href='/my-waybills' class="d-block fs-6"> Waybills</a>
                            <div class="d--flex align-items-center">
                                <h3 class="mb-0">{{ number_format($waybills) }}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- End Stats -->
                </div>

                <div class="col-sm-3 bg-soft-primary p-2 rounded" style='border-left:3px solid blue'>
                    <!-- Stats -->
                    <div class="d-lg-flex align-items-md-center">
                        <div class="flex-shrink-0">
                            <i class="bi-files-alt fs-1 text-primary"></i>
                        </div>

                        <div class="flex-grow-1 ms-lg-3">
                            <a href='/activities' class="d-block fs-6">Activities</a>
                            <div class="d--flex align-items-center">
                                <h3 class="mb-0">{{ $activities }}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- End Stats -->
                </div>

                <div class="col-sm-3">
                    <!-- Stats -->
                    <div class="d-lg-flex align-items-md-center">
                        <div class="flex-shrink-0">
                            <i class="bi-pie-chart fs-1 text-primary"></i>
                        </div>

                        <div class="flex-grow-1 ms-lg-3">
                            <a href='/transactions' class="d-block fs-6">Transactions</a>
                            <div class="d--flex align-items-center">
                                <h3 class="mb-0">{{ number_format(count($transactions)) }}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- End Stats -->
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Body -->

    </div>

    <div class="row">


        <div class="col-lg-12 mb-3 ">
            <!-- Card -->
            <div class="shadow-lg card">
              
                <!-- Body -->
               
                    <div class="card">
                        <!-- Header -->
                        <div class="card-header">
                            <div class="row justify-content-between align-items-center flex-grow-1">
                                <div class="col-12 col-md">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-header-title">Transactions</h5>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <!-- Filter -->
                                    <form>
                                        <!-- Search -->
                                        <div class="input-group input-group-merge input-group-flush">
                                            <div class="input-group-prepend input-group-text">
                                                <i class="bi-search"></i>
                                            </div>
                                            <input id="datatableWithSearchInput" type="search" class="form-control"
                                                placeholder="Search users" aria-label="Search users">
                                        </div>
                                        <!-- End Search -->
                                    </form>
                                    <!-- End Filter -->
                                </div>
                            </div>
                        </div>
                        <!-- End Header -->

                        <!-- Table -->
                        <div class="table-responsive datatable-custom">
                            <table
                                class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                data-hs-datatables-options='{
                                         "order": [],
                                         "search": "#datatableWithSearchInput",
                                         "isResponsive": false,
                                         "isShowPaging": false,
                                         "pagination": "datatableWithSearchPagination"
                                       }'>
                                <thead class="thead-light">
                                    <tr>
                                        <th>Title</th>
                                        <th>Amount</th>
                                        <th>Country</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($transactions as $tranx)
                                    <tr>
                                        <td>
                                            <a class="d-flex align-items-center" href="../user-profile.html">
                                                <div class="avatar avatar-soft-primary avatar-circle">
                                                    <span class="avatar-initials">A</span>
                                                </div>
                                                <div class="ms-3">
                                                    <span class="d-block h5 text-inherit mb-0">{{ $tranx->title }}</span>
                                                   
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                          
                                            <span class="d-block fs-5">NGN{{ number_format($tranx->amount) }}</span>
                                        </td>
                                        <td>Nigeria</td>
                                        <td>
                                            <span class="legend-indicator bg-success"></span>Success
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table -->

                        <!-- Footer -->
                        <div class="card-footer">
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center justify-content-sm-end">
                                <nav id="datatableWithSearchPagination" aria-label="Activity pagination"></nav>
                            </div>
                            <!-- End Pagination -->
                        </div>
                        <!-- End Footer -->
                    </div>
              
            </div>
            <!-- End Card -->
        </div>
    </div>
    <!-- End Row -->

    <!-- Card -->

    <!-- End Card -->


    <!-- End Card -->
</div>
<!-- End Content -->

<!-- Footer -->


@endsection

@section('script')

<script>
    $(document).ready(function() {
    var oTable = $('.datatable').DataTable({
            ordering: false,
            searching: false
            });   


            $('#searchTable').on('keyup', function() {
              oTable.search(this.value).draw();
            });

            var clipboard = new ClipboardJS('.copy-btn');

        clipboard.on('success', function (e) {
            e.clearSelection();
            var btn = e.trigger;
            btn.innerHTML = 'Copied!';
                    setTimeout(function () {
                        btn.innerHTML = '<i class="bi-clipboard"></i>';
                    }, 2000); // Reset to 'Copy' after 2 seconds
        });
        
        clipboard.on('error', function (e) {
            console.error('Action:', e.action);
            console.error('Trigger:', e.trigger);
        });
  })
</script>
@endsection