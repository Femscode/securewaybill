@extends('super.master')

@section('header')
@endsection

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Container-->
    <div id="kt_app_content" class="app-content  flex-column-fluid ">
        <!--begin::Profile Account Information-->
        <div class="row">
           
            <!--begin::Content-->
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h5 class="card-label">All Transactions
                            </h5>
                        </div>
                     
                    </div>
                    <div class="card-body">
                       
                        <table class="datatable table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Amount</th>
                                  
                                    <th scope="col">Type</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $key => $tranx)

                                <tr>

                                    <td>{{ $tranx->reference }}<br><span class='text-danger'>{{ $tranx->user->name ?? ""}}</span><br><span class='text-success'>{{ $tranx->user->brand->brand_name ?? "Big Pel" }}</span></td>
                                    <td>{{ $tranx->description }}</td>
                                    <td>₦{{ number_format($tranx->amount) }}</td>
                                  
                                    <td>{{ $tranx->type }}</td>
                                    <td>
                                        {{ Date('d-m-Y H:i',strtotime($tranx->created_at)) }}
                                        @if($tranx->status == 1)
                                        <span class='p-1 bg-success text-white'>Success</span>
                                        @elseif($tranx->status == 2)
                                        <span class='p-1 bg-warning'>Pending</span>
                                        @else
                                        <span class='p-1 bg-danger text-white'>Failed</span>
                                        @endif
                                    
                                    </td>
                                    <td>
                                        @if($tranx->status == 2)
                                        <a href='/approve_withdraw/{{ $tranx->uid ?? "" }}' onclick='return confirm("Are you sure you want to approve this transaction")' class='btn btn-warning btn-sm'>Approve Withdrawal</a>
                                        @elseif($tranx->status == 1)
                                        <a href='/revert_withdraw/{{ $tranx->uid ?? "" }}' onclick='return confirm("Are you sure you want to disapprove this transaction")' class='btn btn-danger btn-sm'>Dissaprove Withdrawal</a>
                                        @endif
                                        <a href='https://wa.me/{{ substr($tranx->user->phone ?? "09058744473", 1) }}' class='btn btn-success btn-sm'>Message</a>
                                        <a href='/print_transaction_receipt/{{ $tranx->id }}' class='btn btn-info btn-sm'>Print</a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Profile Account Information-->
    </div>
    <!--end::Container-->
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        var oTable = $('.datatable').DataTable({
            ordering: false,
            searching: true
            });   
            $('#searchTable').on('keyup', function() {
              oTable.search(this.value).draw();
            });

        @if (session('message'))
        Swal.fire('Success!',"{{ session('message') }}",'success');
    @endif
        
    })

</script>
@endsection