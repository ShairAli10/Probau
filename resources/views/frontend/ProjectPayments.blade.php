@extends('frontend.layout.master')
<style>
    .loader {
        border: 4px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top: 4px solid #F70D1A;
        width: 40px;
        height: 40px;
        animation: spin 0.5s linear infinite;
        position: fixed;
        top: 57%;
        left: 59%;
        transform: translate(-50%, -50%);
        z-index: 9999;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }


    }
    .truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100px;
    }
</style>
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
                <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">Payment History
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
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <div class="d-flex overflow-auto h-55px pb-1">
                        <ul
                            class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                            <!--begin::Nav item-->
                            <li class="nav-item">
                                <a class="nav-link text-active-danger me-6 {{ Request::is('PaymentHistory') ? 'active' : null }}"
                                    href="{{ URL::to('PaymentHistory') }}">Subscription Payment</a>
                            </li>
                            <!--end::Nav item-->
                            <!--begin::Nav item-->
                            <li class="nav-item">
                                <a class="nav-link text-active-danger me-6 {{ Request::is('ProjectPayment') ? 'active' : null }}"
                                    href="{{ URL::to('ProjectPayment') }}">Projects Payment</a>
                            </li>
                            <!--end::Nav item-->

                            <!--end::Nav item-->
                        </ul>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    @if (count($data))
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-dark fw-bold fs-7 text-uppercase gs-0">

                                    <th class="min-w-125px">User </th>
                                    <th class="min-w-125px">Project Name</th>
                                    <th class="min-w-125px">Amount </th>
                                    <th class="min-w-125px">Date</th>
                                    <th class="min-w-125px">Payment Method</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-bold" id="verification-table-body">
                                {{-- ajax data is appending here  --}}
                                <div id="loader" class="loader"></div>

                            </tbody>
                            <!--end::Table body-->
                        </table>
                    </div>
                    <!--end::Table-->
                    <div class="pagination d-flex justify-content-end" id="pagination-links"></div>
                    @else
                        <div class=" text-center">
                            <img alt="Logo" style="align-items: center; margin-top:50px"
                                src="{{ url('frontend/media/pusernopayment.png') }}" class="img-fluid ">
                        </div>
                    @endif
                </div>


                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Content-->
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var currentPage = 1;

    function loadVerificationData(page) {
        $('#loader').removeClass('d-none');
        $.ajax({
            url: '{{ route('ProjectPayments') }}?page=' + page,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var users = response.users;
                console.log(response);
                var tableBody = $('#verification-table-body');


                tableBody.empty();

                if (users.data.length === 0) {
                    // If no users found, display a message in a new row
                    var noUserRow = `
            <tr>
                <td colspan="6" class="text-center pt-10 fw-bolder fs-2"></td>
            </tr>
        `;
                    tableBody.append(noUserRow);
                } else {
                    var badgeColors = ['text-warning', 'text-danger', 'text-primary', 'text-success'];
                    var bgColors = ['bg-light-warning', 'bg-light-danger', 'bg-light-primary',
                        'bg-light-success'
                    ];
                    var count = 0;
                    $.each(users.data, function(index, row) {
                        var newRow = `
                    <tr>
                        <td class="d-flex align-items-center">
                            ${row.user.profile_pic ? `
                                <div class="symbol symbol-50px overflow-hidden me-3">
                                    <div class="symbol-label">
                                        <img src="{{ asset('storage/') }}/${row.user.profile_pic}" alt="image" class="w-100" />
                                    </div>
                                </div>` : `
                                <div class="symbol symbol-50px overflow-hidden me-3">
                                    <div class="symbol-label">
                                        <img src="{{ url('frontend/media/blank.png') }}" alt="image" class="w-100" />
                                    </div>
                                </div>`}

                            <div class="d-flex flex-column">
                                <div class="text-gray-800 text-hover-primary cursor-pointer mb-1">
                                    ${row.user.name}
                                </div>
                                <span>#${row.user.id}</span>
                            </div>
                        </td>
                        <td>${row.projects.name}</td>
                        <td class = "fw-bolder text-danger">€${row.price}</td>
                        <td style = "padding-left:10px;">${row.registration_date}</td>
                        <td style="padding-left:40px;">
                            ${row.payment_method == "ApplePay" ?
                                `<div class="fs-5 text-dark">
                                    <a class="link-success">
                                        ApplePay
                                    </a>
                                </div>` :
                                `<div class="fs-5 text-dark">
                                    <a class="link-primary">
                                        Stripe
                                    </a>
                                </div>`}
                        </td>
                       
                    </tr>
                `;
                        tableBody.append(newRow);
                        count++;
                    });
                    // Update pagination links

                    var paginationLinks = $('#pagination-links');
                    paginationLinks.empty();

                    // Add pagination links to the page
                    for (var i = 1; i <= users.last_page; i++) {
                        var pageLink =
                            `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
                        paginationLinks.append(pageLink);
                    }
                }
                $('#loader').addClass('d-none');

            },
        });
    }

    // Handle page clicks
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        currentPage = $(this).data('page');
        loadVerificationData(currentPage);
    });

    $(document).ready(function() {
        loadVerificationData(currentPage);
    });
</script>
