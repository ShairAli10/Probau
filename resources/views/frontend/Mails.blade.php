@extends('frontend.layout.master')
@section('content')
    <!--begin::Header-->
    <div id="kt_header" class="header">
        <!--begin::Container-->
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <!--begin::Wrapper-->
            <div class="d-flex d-lg-none align-items-center ms-n2 me-2">
                <!--begin::Aside mobile toggle-->
                <div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
                    <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                    <span class="svg-icon svg-icon-1 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                fill="black" />
                            <path opacity="0.3"
                                d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Aside mobile toggle-->
                <!--begin::Logo-->
                <a href="" class="d-flex align-items-center">
                    <img alt="Logo" src="{{ '../frontend/media/sidebarlogo.png' }}" class="h-20px" />
                </a>
                <!--end::Logo-->
            </div>

            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0"
                data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                <!--begin::Heading-->
                <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">Mailing List
                </h1>
                <!--end::Heading-->
            </div>
            <!--end::Page title=-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Header-->

    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-fluid" id="">

            <div class="row">
                <div class="col-6">

                    <form class="form" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-5">
                            <label class="fs-6 mt-2 form-label fw-bolder text-dark">Select User</label>
                            <select class="form-select form-select-lg form-select-solid" name="user_type" id="user_type"
                                required>
                                <option value="" selected disabled>Select User</option>
                                <option value="user">Private Users</option>
                                <option value="company">Company Users</option>
                                <option value="all">Both</option>

                            </select>
                        </div>

                        <div class="d-flex flex-column mb-5 mt-5  fv-row ">
                            <label class="fs-5 fw-bold mb-2">Message</label>
                            <textarea type="text" placeholder="Description" name="message" required class="form-control form-control-solid"
                                id="" cols="10" rows="5"></textarea>
                        </div>

                        <div class=" pt-7 ">
                            <!--begin::Button-->
                            <button type="submit" id="submitBtn" class="btn btn-primary w-30">
                                <span class="indicator-label">Send Email</span>
                            </button>
                            <!--end::Button-->
                        </div>
                        <!--end::Input group-->
                    </form>

                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Content-->
    <script>
        $(document).ready(function() {
            $('form.form').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: 'sendEmail',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);


                        Swal.fire({
                            icon: 'success',
                            title: 'Mail Sent Successfully',
                            text: 'Your Message has been sent!',
                            showConfirmButton: false,
                            timer: 1500,
                            didClose: () => {
                                location.reload();
                            }
                        });
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
