@extends('dashboard.master')
@section('header')
@endsection

<!--begin::Content wrapper-->
@section('content')
<div class="content container-fluid" style="margin-top: -17rem;">

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content  flex-column-fluid ">
        <!--begin::Row-->
        <div class="row g-5 g-xl-8">
            <!--begin::Col-->
            <div class="col-xl-12">

                <!--begin::Misc Widget 1-->
                {{-- <div style='font-size:17px; border-top:10px solid #856404;' class='alert alert-warning'>

                    Join our Whatsapp Community
                    to get first hand update about our services.

                    Click <a href='https://chat.whatsapp.com/Jukoxj54fvS9h51F00vgKu'>here</a> to join.

                </div> --}}

                {{-- <div class='alert alert-warning'>It's the season of joy! 🎉 Spread the festive cheer by hosting
                    lively giveaways of data, airtime, and cash prizes in a very exciting way.</div> --}}


            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-xl-12 justify-content-center ps-xl-12">
                <div class='card p-2 m-2'>

                    <tr>
                        <td>
                            <div style='border-left:3px solid #004085'
                                class="position-relative ps-2 pe-3 py-2  bg-soft-primary rounded">
                                <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-primary">
                                </div>
                                <a href="#" style='color:#004085' class="mb-1 h4 text-hover-primary alert-heading">
                                    <b>{{
                                        $waybill->product_name }} (NGN{{ number_format($waybill->totalamount)
                                        }})</b><br>
                                    Client : @if($user->id == $waybill->client_id)
                                    {{ $waybill->self->name ?? "No name" }}
                                    @else
                                    {{ $waybill->client->name }}
                                    @endif
                                    <br>
                                    <div class="d-flex">

                                        <input id="copy_content_" type="text"
                                            class="form-control form-control-solid me-3 flex-grow-1" name="search"
                                            value="https://securewaybill.com/{{ $waybill->reference }}">

                                        <a class="btn btn-light btn-soft-primary fw-bold flex-shrink-0 copy-btn"
                                            data-clipboard-target="#copy_content_"><i
                                                class='bi-clipboard'></i></a>
                                    </div>

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
                                </a><br>



                                @if($user->id == $waybill->client_id)
                                @if($waybill->status == 0)
                                <p class='alert alert-danger'>Waybill yet to be paid for</p>
                                @elseif($waybill->status == 1)
                                <a onclick='confirm("Are you sure you want to mark this waybill as sent?")'
                                    href='/marksent/{{ $waybill->uid }}' class='btn btn-primary btn-sm'>Mark Sent</a>
                                <a onclick='return confirm("Are you sure you want to cancel the waybill?")'
                                    href='/cancelwaybill/{{ $waybill->uid }}' class='btn btn-danger btn-sm'>Cancel
                                    Waybill</a>

                                @elseif($waybill->status == 2)
                                <p class='alert alert-soft-info'>Waybill sent to client, awaiting client confirmation
                                    recipient</p>
                                <a href='https://wa.me' class='btn btn-primary btn-sm'>Open Dispute</a>
                                @elseif($waybill->status == 3)
                                <p class='alert alert-soft-info'>Waybill received by client. Waybill marked successful!
                                    You
                                    can now <a href='/withdraw/{{ $waybill->uid }}'>Withdraw Funds</a></p>


                                @elseif($waybill->status == 4)
                                <p class='alert alert-soft-info'>Waybill closed, Pending withdrawal
                                </p>


                                @else
                                <p class='alert alert-soft-info'>Withdraw successful, waybill closed!</a></p>



                                @endif



                                @if($waybill->checkcancel($waybill->reference) == 'self')
                                <p class='alert alert-danger'>Waybill has been cancelled by you, waiting for your client
                                    to also approve. You can <a href='message'>message client</a> or <a
                                        href='uncancel'>Uncancel waybill</a> or <a href='opendispute'>open dispute</a>
                                </p>

                                @elseif($waybill->checkcancel($waybill->reference) == 'client')
                                <p class='alert alert-danger'>Waybill has been cancelled by your client and waiting for
                                    you for approval. You can <a
                                        onclick='return confirm("Are you sure you want to approve the cancellation of this waybill?")'
                                        href='/cancelwaybill/{{ $waybill->uid }}'>approve cancellation</a> or <a
                                        href='marksent'>mark sent</a> or <a href='opendispute'>open dispute</a></p>



                                @elseif($waybill->checkcancel($waybill->reference) == 'withdraw')
                                <p class='alert alert-success'>Waybill cancellation has been approved, You can <a
                                        href='withdraw'>Withdraw Funds</a></p>


                                @elseif($waybill->checkcancel($waybill->reference) == 'client-withdraw')
                                <p class='alert alert-success'>Waybill cancellation has been approved for your client!
                                    You can <a href='opendispute'>open dispute</a> within 2hours</p>

                                @else
                                @endif



                                @else
                                {{-- where self start --}}

                                @if($waybill->status == 0)
                                <a href='/premium-verify_purchase/{{ $waybill->uid }}'
                                    class='btn btn-primary btn-sm'>Make Payment</a>
                                <a onclick='return confirm("Are you sure you want to delete this waybill?")'
                                    href='/deletewaybill/{{ $waybill->uid }}' class='btn btn-danger btn-sm'>Delete
                                    Waybill</a>
                                @elseif($waybill->status == 1)
                                <a href='https://wa.me' class='btn btn-primary btn-sm'>Open Dispute</a>
                                <a onclick='return confirm("Are you sure you want to delete this waybill?")'
                                    href='/deletewaybill/{{ $waybill->uid }}' class='btn btn-danger btn-sm'>Cancel
                                    Waybill</a>
                                @elseif($waybill->status == 2)
                                <a onclick='confirm("Are you sure you want to mark this waybill as received?")'
                                    href='/markreceived/{{ $waybill->uid }}' class='btn btn-primary btn-sm'>Mark
                                    Received</a>
                                <a href='https://wa.me' class='btn btn-primary btn-sm'>Open Dispute</a>

                                @else


                                <p class='alert alert-soft-info'>Waybill received. Waybill marked closed!</p>


                                @endif

                                @if($waybill->checkcancel($waybill->reference) == 'self')
                                <p class='alert alert-danger'>Waybill has been cancelled by you, waiting for your client
                                    to also approve. You can <a href='message'>message client</a> or <a
                                        href='uncancel'>Uncancel waybill</a> or <a href='opendispute'>open dispute</a>
                                </p>

                                @elseif($waybill->checkcancel($waybill->reference) == 'client')
                                <p class='alert alert-danger'>Waybill has been cancelled by your client and waiting for
                                    you for approval. You can <a
                                        onclick='return confirm("Are you sure you want to approve the cancellation of this waybill?")'
                                        href='/cancelwaybill/{{ $waybill->uid }}'>approve cancellation</a> or <a
                                        href='opendispute'>open dispute</a></p>



                                @elseif($waybill->checkcancel($waybill->reference) == 'withdraw')
                                <p class='alert alert-success'>Waybill cancellation has been approved, You can now <a
                                        href='withdraw'>Withdraw Funds</a></p>


                                @elseif($waybill->checkcancel($waybill->reference) == 'client-withdraw')
                                <p class='alert alert-success'>Waybill cancellation has been approved for your client!
                                    You can <a href='opendispute'>open dispute</a> within 2hours</p>


                                @else


                                @endif


                                @endif
                            </div>
                        </td>
                    </tr>
                  





                </div>

                <!--begin::Row-->

            </div>

            <div class="offcanvas offcanvas-end show" tabindex="-1" id="offcanvasActivityStream" aria-labelledby="offcanvasActivityStreamLabel" aria-modal="true" role="dialog">
                <div class="offcanvas-header">
                  <h4 id="offcanvasActivityStreamLabel" class="mb-0">Activity stream</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                  <!-- Step -->
                  <ul class="step step-icon-sm step-avatar-sm">
                    <!-- Step Item -->
                    <li class="step-item">
                      <div class="step-content-wrapper">
                        <div class="step-avatar">
                          <img class="step-avatar" src="assets/img/160x160/img9.jpg" alt="Image Description">
                        </div>
            
                        <div class="step-content">
                          <h5 class="mb-1">Iana Robinson</h5>
            
                          <p class="fs-5 mb-1">Added 2 files to task <a class="text-uppercase" href="#"><i class="bi-journal-bookmark-fill"></i> Fd-7</a></p>
            
                          <ul class="list-group list-group-sm">
                            <!-- List Item -->
                            <li class="list-group-item list-group-item-light">
                              <div class="row gx-1">
                                <div class="col-6">
                                  <!-- Media -->
                                  <div class="d-flex">
                                    <div class="flex-shrink-0">
                                      <img class="avatar avatar-xs" src="assets/svg/brands/excel-icon.svg" alt="Image Description">
                                    </div>
                                    <div class="flex-grow-1 text-truncate ms-2">
                                      <span class="d-block fs-6 text-dark text-truncate" title="weekly-reports.xls">weekly-reports.xls</span>
                                      <span class="d-block small text-muted">12kb</span>
                                    </div>
                                  </div>
                                  <!-- End Media -->
                                </div>
                                <!-- End Col -->
            
                                <div class="col-6">
                                  <!-- Media -->
                                  <div class="d-flex">
                                    <div class="flex-shrink-0">
                                      <img class="avatar avatar-xs" src="assets/svg/brands/word-icon.svg" alt="Image Description">
                                    </div>
                                    <div class="flex-grow-1 text-truncate ms-2">
                                      <span class="d-block fs-6 text-dark text-truncate" title="weekly-reports.xls">weekly-reports.xls</span>
                                      <span class="d-block small text-muted">4kb</span>
                                    </div>
                                  </div>
                                  <!-- End Media -->
                                </div>
                                <!-- End Col -->
                              </div>
                              <!-- End Row -->
                            </li>
                            <!-- End List Item -->
                          </ul>
            
                          <span class="small text-muted text-uppercase">Now</span>
                        </div>
                      </div>
                    </li>
                    <!-- End Step Item -->
            
                    <!-- Step Item -->
                    <li class="step-item">
                      <div class="step-content-wrapper">
                        <span class="step-icon step-icon-soft-dark">B</span>
            
                        <div class="step-content">
                          <h5 class="mb-1">Bob Dean</h5>
            
                          <p class="fs-5 mb-1">Marked <a class="text-uppercase" href="#"><i class="bi-journal-bookmark-fill"></i> Fr-6</a> as <span class="badge bg-soft-success text-success rounded-pill"><span class="legend-indicator bg-success"></span>"Completed"</span></p>
            
                          <span class="small text-muted text-uppercase">Today</span>
                        </div>
                      </div>
                    </li>
                    <!-- End Step Item -->
            
                    <!-- Step Item -->
                    <li class="step-item">
                      <div class="step-content-wrapper">
                        <div class="step-avatar">
                          <img class="step-avatar-img" src="assets/img/160x160/img3.jpg" alt="Image Description">
                        </div>
            
                        <div class="step-content">
                          <h5 class="h5 mb-1">Crane</h5>
            
                          <p class="fs-5 mb-1">Added 5 card to <a href="#">Payments</a></p>
            
                          <ul class="list-group list-group-sm">
                            <li class="list-group-item list-group-item-light">
                              <div class="row gx-1">
                                <div class="col">
                                  <img class="img-fluid rounded" src="assets/svg/components/card-1.svg" alt="Image Description">
                                </div>
                                <div class="col">
                                  <img class="img-fluid rounded" src="assets/svg/components/card-2.svg" alt="Image Description">
                                </div>
                                <div class="col">
                                  <img class="img-fluid rounded" src="assets/svg/components/card-3.svg" alt="Image Description">
                                </div>
                                <div class="col-auto align-self-center">
                                  <div class="text-center">
                                    <a href="#">+2</a>
                                  </div>
                                </div>
                              </div>
                            </li>
                          </ul>
            
                          <span class="small text-muted text-uppercase">May 12</span>
                        </div>
                      </div>
                    </li>
                    <!-- End Step Item -->
            
                    <!-- Step Item -->
                    <li class="step-item">
                      <div class="step-content-wrapper">
                        <span class="step-icon step-icon-soft-info">D</span>
            
                        <div class="step-content">
                          <h5 class="mb-1">David Lidell</h5>
            
                          <p class="fs-5 mb-1">Added a new member to Front Dashboard</p>
            
                          <span class="small text-muted text-uppercase">May 15</span>
                        </div>
                      </div>
                    </li>
                    <!-- End Step Item -->
            
                    <!-- Step Item -->
                    <li class="step-item">
                      <div class="step-content-wrapper">
                        <div class="step-avatar">
                          <img class="step-avatar-img" src="assets/img/160x160/img7.jpg" alt="Image Description">
                        </div>
            
                        <div class="step-content">
                          <h5 class="mb-1">Rachel King</h5>
            
                          <p class="fs-5 mb-1">Marked <a class="text-uppercase" href="#"><i class="bi-journal-bookmark-fill"></i> Fr-3</a> as <span class="badge bg-soft-success text-success rounded-pill"><span class="legend-indicator bg-success"></span>"Completed"</span></p>
            
                          <span class="small text-muted text-uppercase">Apr 29</span>
                        </div>
                      </div>
                    </li>
                    <!-- End Step Item -->
            
                    <!-- Step Item -->
                    <li class="step-item">
                      <div class="step-content-wrapper">
                        <div class="step-avatar">
                          <img class="step-avatar-img" src="assets/img/160x160/img5.jpg" alt="Image Description">
                        </div>
            
                        <div class="step-content">
                          <h5 class="mb-1">Finch Hoot</h5>
            
                          <p class="fs-5 mb-1">Earned a "Top endorsed" <i class="bi-patch-check-fill text-primary"></i> badge</p>
            
                          <span class="small text-muted text-uppercase">Apr 06</span>
                        </div>
                      </div>
                    </li>
                    <!-- End Step Item -->
            
                    <!-- Step Item -->
                    <li class="step-item">
                      <div class="step-content-wrapper">
                        <span class="step-icon step-icon-soft-primary">
                          <i class="bi-person-fill"></i>
                        </span>
            
                        <div class="step-content">
                          <h5 class="mb-1">Project status updated</h5>
            
                          <p class="fs-5 mb-1">Marked <a class="text-uppercase" href="#"><i class="bi-journal-bookmark-fill"></i> Fr-3</a> as <span class="badge bg-soft-primary text-primary rounded-pill"><span class="legend-indicator bg-primary"></span>"In progress"</span></p>
            
                          <span class="small text-muted text-uppercase">Feb 10</span>
                        </div>
                      </div>
                    </li>
                    <!-- End Step Item -->
                  </ul>
                  <!-- End Step -->
            
                  <div class="d-grid">
                    <a class="btn btn-white" href="javascript:;">View all <i class="bi-chevron-right"></i></a>
                  </div>
                </div>
              </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Content-->
</div>
@endsection
<!--end::Content wrapper-->



@section('script')
<script>
    $(document).ready(function() {
     })
</script>
@endsection