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
                            <h5 class="card-label">Waybill Transactions
                            </h5>
                        </div>

                    </div>
                    <div class="card-body">

                        <table class="datatable table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Client</th>
                                  
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($waybills as $key => $waybill)

                                <tr>

                                    <td>{{ $waybill->reference }}<br>
                                        <span class='text-danger'>{{ $waybill->product_name ?? ""}} (₦{{ number_format($waybill->totalamount) }})</span>
                                        
                                    </td>
                                    <td>
                                        <span class='text-success'>
                                            Client :
                                            @if($user->id == $waybill->client_id)
                                            {{ $waybill->self->name ?? "No name" }}
                                            @else
                                            {{ $waybill->client->name }}
                                            @endif
                                        </span>
                                    </td>
                                    

                                    <td>
                                        {{ Date('d-m-Y H:i',strtotime($waybill->created_at)) }}<br>
                                        @if($waybill->status == 0)
                                        <span class='badge bg-warning text-dark rounded-pill ms-1'>Waybill yet to be
                                          paid</span>
                                        @elseif($waybill->status == 1)
                                        <span class='badge bg-success text-dark rounded-pill ms-1'>Waybill Paid</span>
                                        @elseif($waybill->status == 2)
                                        <span class='badge bg-warning text-dark rounded-pill ms-1'>Waybill Sent</span>
                                        @else
                                        <span class='badge bg-success text-dark rounded-pill ms-1'>Waybill Received</span>
                                        @endif

                                    </td>
                                    <td>
                                      
                                        <a href='https://wa.me/{{ substr($waybill->user->phone ?? "09058744473", 1) }}'
                                            class='btn btn-primary btn-sm'>Message Owner</a>
                                        <a href='https://wa.me/{{ substr($waybill->client->phone ?? "09058744473", 1) }}'
                                            class='btn btn-success btn-sm'>Message Client</a>
                                        <a href='/{{ $waybill->reference }}'
                                            class='btn btn-secondary btn-sm'>Activities</a>
                                       
                                        <a href='/print_transaction_receipt/{{ $waybill->id }}'
                                            class='btn btn-info btn-sm'>Print</a>
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