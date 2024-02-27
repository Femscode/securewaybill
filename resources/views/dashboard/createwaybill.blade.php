@extends('dashboard.master')
@section('content')
<div class="content container-fluid" style="margin-top: -17rem;">



    <div class="flex-row-fluid ml-lg-8">
        <!--begin::Card-->
        <div class="card card-custom">
            <!--begin::Header-->
            <form class="form" method='post' action='{{ route("savewaybill") }}' enctype="multipart/form-data">@csrf
                <div class="card-header py-3">
                    <div class="card-title align-items-start flex-column">
                        <h3 class="card-label font-weight-bolder text-dark">Create Waybill</h3>
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
                                <input id='client_id' type="text" name='client_id'
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
                    <div class="form-group row mb-4" id='clientdetails' style='display:none'>
                        <div class="form-group row m-2">
                            <h6 class="col-md-3">Client Details</h6>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center bg-soft-primary rounded p-5">
                                    <!--begin::Icon-->
                                    <span class="svg-icon svg-icon-info mr-5">
                                        <span class="svg-icon svg-icon-lg">
                                            <!--begin::Svg Icon | path:/metronic/theme/html/demo2/dist/assets/media/svg/icons/General/Attachment2.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path
                                                        d="M11.7573593,15.2426407 L8.75735931,15.2426407 C8.20507456,15.2426407 7.75735931,15.6903559 7.75735931,16.2426407 C7.75735931,16.7949254 8.20507456,17.2426407 8.75735931,17.2426407 L11.7573593,17.2426407 L11.7573593,18.2426407 C11.7573593,19.3472102 10.8619288,20.2426407 9.75735931,20.2426407 L5.75735931,20.2426407 C4.65278981,20.2426407 3.75735931,19.3472102 3.75735931,18.2426407 L3.75735931,14.2426407 C3.75735931,13.1380712 4.65278981,12.2426407 5.75735931,12.2426407 L9.75735931,12.2426407 C10.8619288,12.2426407 11.7573593,13.1380712 11.7573593,14.2426407 L11.7573593,15.2426407 Z"
                                                        fill="#000000" opacity="0.3"
                                                        transform="translate(7.757359, 16.242641) rotate(-45.000000) translate(-7.757359, -16.242641)">
                                                    </path>
                                                    <path
                                                        d="M12.2426407,8.75735931 L15.2426407,8.75735931 C15.7949254,8.75735931 16.2426407,8.30964406 16.2426407,7.75735931 C16.2426407,7.20507456 15.7949254,6.75735931 15.2426407,6.75735931 L12.2426407,6.75735931 L12.2426407,5.75735931 C12.2426407,4.65278981 13.1380712,3.75735931 14.2426407,3.75735931 L18.2426407,3.75735931 C19.3472102,3.75735931 20.2426407,4.65278981 20.2426407,5.75735931 L20.2426407,9.75735931 C20.2426407,10.8619288 19.3472102,11.7573593 18.2426407,11.7573593 L14.2426407,11.7573593 C13.1380712,11.7573593 12.2426407,10.8619288 12.2426407,9.75735931 L12.2426407,8.75735931 Z"
                                                        fill="#000000"
                                                        transform="translate(16.242641, 7.757359) rotate(-45.000000) translate(-16.242641, -7.757359)">
                                                    </path>
                                                    <path
                                                        d="M5.89339828,3.42893219 C6.44568303,3.42893219 6.89339828,3.87664744 6.89339828,4.42893219 L6.89339828,6.42893219 C6.89339828,6.98121694 6.44568303,7.42893219 5.89339828,7.42893219 C5.34111353,7.42893219 4.89339828,6.98121694 4.89339828,6.42893219 L4.89339828,4.42893219 C4.89339828,3.87664744 5.34111353,3.42893219 5.89339828,3.42893219 Z M11.4289322,5.13603897 C11.8194565,5.52656326 11.8194565,6.15972824 11.4289322,6.55025253 L10.0147186,7.96446609 C9.62419433,8.35499039 8.99102936,8.35499039 8.60050506,7.96446609 C8.20998077,7.5739418 8.20998077,6.94077682 8.60050506,6.55025253 L10.0147186,5.13603897 C10.4052429,4.74551468 11.0384079,4.74551468 11.4289322,5.13603897 Z M0.600505063,5.13603897 C0.991029355,4.74551468 1.62419433,4.74551468 2.01471863,5.13603897 L3.42893219,6.55025253 C3.81945648,6.94077682 3.81945648,7.5739418 3.42893219,7.96446609 C3.0384079,8.35499039 2.40524292,8.35499039 2.01471863,7.96446609 L0.600505063,6.55025253 C0.209980772,6.15972824 0.209980772,5.52656326 0.600505063,5.13603897 Z"
                                                        fill="#000000" opacity="0.3"
                                                        transform="translate(6.014719, 5.843146) rotate(-45.000000) translate(-6.014719, -5.843146)">
                                                    </path>
                                                    <path
                                                        d="M17.9142136,15.4497475 C18.4664983,15.4497475 18.9142136,15.8974627 18.9142136,16.4497475 L18.9142136,18.4497475 C18.9142136,19.0020322 18.4664983,19.4497475 17.9142136,19.4497475 C17.3619288,19.4497475 16.9142136,19.0020322 16.9142136,18.4497475 L16.9142136,16.4497475 C16.9142136,15.8974627 17.3619288,15.4497475 17.9142136,15.4497475 Z M23.4497475,17.1568542 C23.8402718,17.5473785 23.8402718,18.1805435 23.4497475,18.5710678 L22.0355339,19.9852814 C21.6450096,20.3758057 21.0118446,20.3758057 20.6213203,19.9852814 C20.2307961,19.5947571 20.2307961,18.9615921 20.6213203,18.5710678 L22.0355339,17.1568542 C22.4260582,16.76633 23.0592232,16.76633 23.4497475,17.1568542 Z M12.6213203,17.1568542 C13.0118446,16.76633 13.6450096,16.76633 14.0355339,17.1568542 L15.4497475,18.5710678 C15.8402718,18.9615921 15.8402718,19.5947571 15.4497475,19.9852814 C15.0592232,20.3758057 14.4260582,20.3758057 14.0355339,19.9852814 L12.6213203,18.5710678 C12.2307961,18.1805435 12.2307961,17.5473785 12.6213203,17.1568542 Z"
                                                        fill="#000000" opacity="0.3"
                                                        transform="translate(18.035534, 17.863961) scale(1, -1) rotate(45.000000) translate(-18.035534, -17.863961)">
                                                    </path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    <!--end::Icon-->
                                    <!--begin::Title-->
                                    <div class="d-flex flex-column flex-grow-1 mr-2">
                                        <span class="text-info font-weight-bold">Client Fullname</span>
                                        <a id='client_name' href="#"
                                            class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">
                                        </a>
                                    </div>
                                    <div class="d-flex flex-column flex-grow-1 mr-2">
                                        <span class="text-info font-weight-bold">Client Phone Number</span>
                                        <a id='client_phonenumber' href="#"
                                            class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">

                                            <span style="color: red"> plan_status </span></a>
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
                                    <input name='product_name' class="form-control form-control-lg form-control-solid"
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
                                <input id='amount' name='subtotal' type="number" class="form-control form-control-lg form-control-solid"
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
                            <div style='text-align:left;border:2px dotted blue'
                                class="p-4 rounded bg-soft-primary font-weight-bold text-left">
                                <b>Subtotal: </b><span id='subtotal'>0</span>
                                <br><b>Securing Charge: </b><span id='charges'>0</span>
                                <br><b>Total Amount: </b><span id='totalamount'>0</span>
                                <input name='charges' type='hidden' id='chargehidden' />
                                <input name='amount' type='hidden' id='totalamounthidden' /><br><br>
                                Mode Of Payment : 
                                <input required class="form-check-input" name='paymentmode' type='radio' value='Transfer' checked>Instant Transfer
                                <input required class="form-check-input" name='paymentmode' type='radio' value='Card'>Credit Card

                            </div>

                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-xl-3 col-lg-3 col-form-label"></label>
                        <div class="col-lg-9 col-xl-6">
                            <button type="submit" class="btn btn-primary font-weight-bold btn-sm">Proceed To Make
                                Payment</button>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
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