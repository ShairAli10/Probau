@extends('frontend.layout.master')
@section('content')


    <!--begin::Header-->
    <div id="kt_header" class="header">
        <div class="container-fluid d-flex align-items-center justify-content-between">

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
                <h1 class="d-flex flex-column text-dark fw-bolder my-0 fs-1">Payment History
                </h1>
                <!--end::Heading-->
            </div>
            <!--end::Page title=-->
        </div>



    </div>
    <!--end::Header-->



    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Table-->
            @if (count($payments))
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="text-start text-dark fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-125px ">Project</th>
                                <th class="min-w-125px ">amount</th>
                                <th class="min-w-125px ">Date</th>
                                <th class="min-w-125px">Time</th>
                                <th class="min-w-125px">Payment Method</th>

                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
                            @foreach ($payments as $row)
                                <tr>
                                    <td class="d-flex align-items-center">
                                        @if ($row['projects']->image)
                                            <div class="symbol symbol-50px overflow-hidden me-3">
                                                <div class="symbol-label">
                                                    <img src="{{ asset('storage/' . $row['projects']->image) }}"
                                                        alt="image" class="w-100" />
                                                </div>
                                            </div>
                                        @else
                                            <div class="symbol symbol-50px overflow-hidden me-3">
                                                <div class="symbol-label">
                                                    <img src="{{ url('frontend/media/Buildings.png') }}"
                                                        alt="image" class="w-100" />
                                                </div>
                                            </div>
                                        @endif
                                        <div class="d-flex flex-column">
                                            <div class="text-gray-800 text-hover-danger cursor-pointer mb-1">
                                                {{ $row['projects']->name }}
                                            </div>
                                            <span>
                                                <div class="text-muted fs-6 pt-1"
                                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">
                                                    @foreach ($row['projects']->company_type as $data)
                                                        {{ $data['name'] }}
                                                        @if (!$loop->last)
                                                            |
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-danger">€{{ $row->price }}</td>
                                    <td>{{ $row->created_at->format('M d, Y') }}</td>
                                    <td>{{ $row->created_at->format('h:iA') }}</td>
                                    <td>
                                        @if ($row->payment_method == 'stripe')
                                        <div class="fs-4 text-dark">
                                            <a class="link-primary">
                                                Stripe
                                            </a>
                                        </div>
                                        @else
                                        <div class="fs-4 text-dark">
                                            <a class="link-success">
                                                ApplePay
                                            </a>
                                        </div>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
            @else
                <div class=" text-center">
                    <img alt="Logo" style="align-items: center; margin-top:50px"
                        src="{{ url('frontend/media/pusernopayment.png') }}" class="img-fluid ">
                </div>
            @endif

        </div>
        <!--end::Container-->
        <div class=" d-flex justify-content-end pb-5">
            {!! $payments->onEachSide(1)->links() !!}
        </div>
    </div>
    <!--end::Container-->
    </div>
    <!--end::Content-->
@endsection
