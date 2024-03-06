@extends('dashboard.master')
@section('content')


    <div class="flex-row-fluid ml-lg-8">
        <!--begin::Card-->
        <div class="card card-custom">
            <!--begin::Header-->
            <form class="form" method='post' action='/paywaybill' enctype="multipart/form-data">@csrf
                <div class="card-header py-3">
                    <div class="card-title align-items-start flex-column">
                        <h3 class="card-label font-weight-bolder text-dark">Pay A Waybill</h3>
                    </div>

                </div>
                <!--end::Header-->
                <!--begin::Form-->

                <div class="card-body">
                    <!--begin::Heading-->

                    <!--begin::Form Group-->

                    <!--begin::Form Group-->
                    <div class="form-group row mb-4">
                        <label class="col-xl-3 col-lg-3 col-form-label">Client ID</label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="input-group input-group-lg input-group-solid">
                                <div class="input-group-prepend">
                                    <span class="form-control-lg input-group-text bg-soft-primary">
                                        <i class="bi-person-badge"></i>
                                    </span>
                                </div>
                                <input readonly id='client_id' value='{{ $waybill->client->username }}' type="text" name='client_id'
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Input client ID" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4" id='clienterrordetails' style='display:none'>
                        <div class="form-group row m-2">
                            <h6 class="col-md-3">Client Details</h6>
                            <div class="col-md-6">
                                <div class='alert alert-danger'>
                                    <h3>Client Not Found</h3>
                                    <p>Your client is not on our database, tell your client to also register an account
                                        with us!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4" id='clientdetails'>
                        <div class="form-group row m-2">
                            <h6 class="col-md-3"></h6>
                            <div class="col-md-6">
                                <div style='border-left:5px solid #004085;background-color:#cce5ff;color:#004085' class="d-flex align-items-center bg-soft-primary rounded p-2">
                                    <!--begin::Icon-->
                                   
                                    <!--end::Icon-->
                                    <!--begin::Title-->
                                    <div class="d-flex flex-column flex-grow-1 mr-2">
                                        <span>Client Name</span>
                                        <a id='client_name' href="#"
                                            class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">
                                            {{ $waybill->client->name }}
                                        </a>
                                    </div>
                                    <div class="d-flex flex-column flex-grow-1 mr-2">
                                        <span>Client Contact</span>
                                        <a id='client_phonenumber' href="https://wa.me/234{{ substr($waybill->client->phone,1) }}"
                                            class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">
                                            {{ $waybill->client->phone }}

                                          </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-xl-3 col-lg-3 col-form-label">Product Name</label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="input-group input-group-lg input-group-solid">
                                <div class="input-group-prepend">
                                    <span class="form-control-lg input-group-text bg-soft-primary">
                                        <i class="bi-cart"></i>
                                    </span>
                                </div>
                                <div class="">
                                    <input readonly value='{{ $waybill->product_name }}' name='product_name' class="form-control form-control-lg form-control-solid"
                                        type="text" placeholder="Iphone XMas" />
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row mb-4">
                        <label class="col-xl-3 col-lg-3 col-form-label">Amount</label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="input-group input-group-lg input-group-solid">
                                <div class="input-group-prepend">
                                    <span class="form-control-lg input-group-text bg-soft-primary">
                                        <i class="bi-bank"></i>
                                    </span>
                                </div>
                                <input readonly value='{{ $waybill->subamount }}' id='amount' name='subtotal' type="number" class="form-control form-control-lg form-control-solid"
                                    placeholder="Input amount to pay" />
                            </div>
                        </div>
                    </div>
                    <!--begin::Form Group-->

                    <!--begin::Form Group-->
                    {{-- <div class="form-group row mb-4 align-items-center">
                        <label class="col-xl-3 col-lg-3 col-form-label">Communication</label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="checkbox-inline">
                                <label class="checkbox">
                                    <input type="checkbox" checked="checked" />
                                    <span></span>Email</label>
                                <label class="checkbox">
                                    <input type="checkbox" checked="checked" />
                                    <span></span>SMS</label>
                                <label class="checkbox">
                                    <input type="checkbox" />
                                    <span></span>Phone</label>
                            </div>
                        </div>
                    </div> --}}
                    <!--begin::Form Group-->
                    <div class="separator separator-dashed my-5"></div>
                    <!--begin::Form Group-->
                    <div class="row">
                        <label class="col-xl-3"></label>
                        <div class="col-lg-9 col-xl-6">
                            <h5 class="font-weight-bold mb-6">Payment:</h5>
                        </div>
                    </div>
                    <!--begin::Form Group-->
                    <div class="form-group row mb-4">
                        <label class="col-xl-3 col-lg-3 col-form-label"></label>
                        <div class="col-lg-9 col-xl-6">
                            <div style='border:1px dashed #004085;background-color:#cce5ff;color:#004085'
                                class="p-4 rounded bg-soft-primary font-weight-bold text-left">
                                <b>Subtotal: </b>₦<span id='subtotal'>{{ number_format($waybill->subamount) }}</span>
                                <br><b>Securing Charge: </b>₦<span id='charges'>{{ number_format($waybill->charges) }}</span>
                                <br><b>Total Amount: </b>₦<span id='totalamount'>{{ number_format($waybill->totalamount) }}</span>
                                <input name='charges' type='hidden' id='chargehidden'  value="{{ $waybill->charges }}" />
                                <input name='amount' type='hidden' id='totalamounthidden'  value="{{ $waybill->totalamount }}" />
                                <input name='waybillId' type='hidden' id='totalamounthidden'  value="{{ $waybill->uid }}" />
                                <br><br>
                                <b>Mode Of Payment</b><br> 
                                <input required class="form-check-input" name='paymentmode' type='radio' value='Transfer' checked>Instant Transfer
                                <input required class="form-check-input" name='paymentmode' type='radio' value='Card'>Credit Card

                            </div>

                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-xl-3 col-lg-3 col-form-label"></label>
                        <div class="col-lg-9 col-xl-6">
                            <button type="submit" style='background:#004085' class="btn btn-primary font-weight-bold btn-sm">Proceed To Make
                                Payment</button>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        @if (session('message'))
        Swal.fire('Success!',"{{ session('message') }}",'success');
    @endif
   @if (session('error'))
        Swal.fire('Incorrect Pin!',"{{ session('error') }}",'error');
    @endif
    $("#client_id").on('input',function() {
        if ($("#client_id").val().length >= 10) {
            Swal.fire({
            title: 'Fetching client details',
            text: 'Please wait...',
        })
        var fd = new FormData();
        $clientid = $("#client_id").val()
       
        fd.append('client_id', $clientid)
        $.ajax({
       type: 'POST',
       data:fd,
       url: "{{route('retrieveclient')}}",
       cache: false,
       contentType: false,
       processData: false,
       success: function(data) {
        Swal.close()
        if(data == false) {
            $("#clienterrordetails").show()
            $("#clientdetails").hide()
        } else {
            $("#clienterrordetails").hide()
            $("#clientdetails").show()
          console.log(data)
          $("#client_name").text(data.name)
          $("#client_phonenumber").text(data.phone)
        }
      
      
       },
       error: function(data) {
        $("#clienterrordetails").show()
           console.log(data)
           Swal.close()
          
        //    Swal.fire('Opps!', 'Something went wrong, please try again later', 'error')
       }
   })
        }

        

    })

    $("#amount").on('input', function() {
    var amount = parseFloat($("#amount").val());
    if (isNaN(amount)) {
        amount = 0;
    }
    if(amount <=100000) {
        var charges = 0.02 * amount;
    } else {
        var charges = 0.01 * amount;
    }
    var totalamount = amount + charges;

    var formattedAmount = formatAsCurrency(amount);
    var formattedCharges = formatAsCurrency(charges);
    var formattedTotalAmount = formatAsCurrency(totalamount);

    $("#subtotal").text(formattedAmount);
    $("#charges").text(formattedCharges);
    $("#totalamount").text(formattedTotalAmount);
    $("#totalamounthidden").val(totalamount) ;
    $("#chargehidden").val(charges) ;
    });

            function formatAsCurrency(number) {
                return number.toLocaleString('en-US', {
                style: 'currency',
                currency: 'NGN'
                });
            }

    })
  
</script>
@endsection