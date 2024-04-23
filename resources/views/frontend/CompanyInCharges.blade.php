@extends('frontend.layout.master')
<style>
    .loader {
        border: 4px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top: 4px solid #3498db;
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
        /* Adjust the max-width based on your requirements */
    }

    .box {
        border-radius: 10px;
        background: #F1F2F7;
        padding: 8px 12px;
        align-items: flex-start;
        gap: 10px;
        flex-wrap: wrap;

    }

    .box:hover {
        box-shadow: #259CD5;
        transform: scale(1.05);
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    a {
        color: inherit !important;
        text-decoration: none;
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
                <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">Company detail
                </h1>
                <!--end::Heading-->
            </div>
            <!--end::Page title=-->
            @if ($response['deleteRequest'] == true)
            <div class="d-flex ">
                <a href="{{ URL::to('DeleteUser/' . $response['user']->id) }}">
                    <button type="button" class="btn btn-danger rounded-1 px-8 py-2 ms-4">Delete</button>
                </a>
            </div>
        @endif
        </div>
        <!--end::Container-->
    </div>
    <!--end::Header-->

    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-fluid" id="">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    @if ($response['user']->profile_pic == '')
                        <div class="symbol symbol-circle  symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <img src="{{ url('frontend/media/blank.png') }}" alt="image"
                                style="height: 80px; width:80px;" />
                        </div>
                    @else
                        <div class="symbol symbol-circle  symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <img src="{{ asset('storage/' . $response['user']->profile_pic) }}" alt="image"
                                style="height: 80px; width:80px; object-fit: cover;" />
                        </div>
                    @endif
                </div>
                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <span class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.9996 4C8.46499 4 5.59961 7.20207 5.59961 10.8C5.59961 14.3697 7.64227 18.2499 10.8293 19.7396C11.5722 20.0868 12.427 20.0868 13.17 19.7396C16.357 18.2499 18.3996 14.3697 18.3996 10.8C18.3996 7.20207 15.5342 4 11.9996 4ZM11.9996 12C12.8833 12 13.5996 11.2837 13.5996 10.4C13.5996 9.51635 12.8833 8.8 11.9996 8.8C11.116 8.8 10.3996 9.51635 10.3996 10.4C10.3996 11.2837 11.116 12 11.9996 12Z"
                                            fill="#7B849A" />
                                    </svg>
                                </span>
                                <span class="text-muted fs-3 pt-1 ms-2">
                                    {{ $response['user']->location }}
                                </span>

                            </div>
                            <!--end::Name-->
                            <!--begin::Info-->
                            <div class="flex-wrap fw-bold fs-6 mb-4 pe-2">
                                <div class="d-flex align-items-center text-gray-400 me-5 pb-2 ">
                                    <div class="d-flex align-items-center text-gray-400 me-5">
                                        <span class="me-1 mb-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20"
                                                viewBox="0 0 21 20" fill="none">
                                                <path
                                                    d="M9.62551 1.39834C9.96263 0.789748 10.8377 0.789747 11.1748 1.39834L13.6074 5.78989C13.7295 6.01031 13.9398 6.16828 14.1855 6.22423L18.9764 7.31507C19.6246 7.46267 19.8851 8.24534 19.4546 8.75195L16.1427 12.6492C15.9877 12.8317 15.9131 13.0692 15.9361 13.3076L16.4324 18.462C16.498 19.1431 15.7994 19.638 15.1786 19.3504L10.7724 17.3088C10.5363 17.1994 10.264 17.1994 10.0279 17.3088L5.62165 19.3504C5.00088 19.638 4.30232 19.1431 4.3679 18.462L4.86424 13.3076C4.88719 13.0692 4.81264 12.8317 4.65758 12.6492L1.34571 8.75195C0.915193 8.24534 1.17567 7.46267 1.82391 7.31507L6.61482 6.22423C6.86052 6.16828 7.07075 6.01031 7.19286 5.78989L9.62551 1.39834Z"
                                                    fill="#FFCB45" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <span class="fw-bolder text-dark">
                                            {{ $response['user']->avgRating }}
                                        </span>
                                        ({{ $response['user']->totalRating }} Reviews)
                                    </div>
                                    <div class="d-flex align-items-center text-gray-400 ms-4">
                                        <span class="me-1 mb-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.60543 9.68392L10.4054 5.41725C11.3148 4.60896 12.6851 4.60896 13.5944 5.41725L18.3944 9.68392C18.9067 10.1394 19.1999 10.7922 19.1999 11.4777V19.3999H19.9999C20.3313 19.3999 20.5999 19.6686 20.5999 19.9999C20.5999 20.3313 20.3313 20.5999 19.9999 20.5999H3.9999C3.66853 20.5999 3.3999 20.3313 3.3999 19.9999C3.3999 19.6686 3.66853 19.3999 3.9999 19.3999H4.7999V11.4777C4.7999 10.7922 5.09306 10.1394 5.60543 9.68392ZM9.7999 9.59994C9.7999 9.26857 10.0685 8.99994 10.3999 8.99994H13.5999C13.9313 8.99994 14.1999 9.26857 14.1999 9.59994C14.1999 9.93131 13.9313 10.1999 13.5999 10.1999H10.3999C10.0685 10.1999 9.7999 9.93131 9.7999 9.59994ZM13.6415 11.3999C14.3603 11.3999 14.9597 11.3999 15.4355 11.4639C15.9377 11.5314 16.3912 11.6799 16.7555 12.0443C17.1199 12.4087 17.2685 12.8621 17.336 13.3644C17.3999 13.8402 17.3999 14.4396 17.3999 15.1583L17.3999 19.3999H16.1999V15.1999C16.1999 14.4287 16.1986 13.9107 16.1467 13.5243C16.097 13.1551 16.0113 12.9971 15.907 12.8928C15.8028 12.7886 15.6448 12.7028 15.2756 12.6532C14.8892 12.6012 14.3711 12.5999 13.5999 12.5999H10.3999C9.62869 12.5999 9.11065 12.6012 8.72422 12.6532C8.35505 12.7028 8.19705 12.7886 8.0928 12.8928C7.98854 12.9971 7.90276 13.1551 7.85313 13.5243C7.80118 13.9107 7.7999 14.4287 7.7999 15.1999V19.3999H6.5999L6.5999 15.1583C6.59988 14.4396 6.59986 13.8402 6.66383 13.3644C6.73136 12.8621 6.87989 12.4087 7.24427 12.0443C7.60864 11.6799 8.06208 11.5314 8.56432 11.4639C9.04014 11.3999 9.63952 11.3999 10.3583 11.3999H13.6415ZM8.9999 14.7999C8.9999 14.4686 9.26853 14.1999 9.5999 14.1999H14.3999C14.7313 14.1999 14.9999 14.4686 14.9999 14.7999C14.9999 15.1313 14.7313 15.3999 14.3999 15.3999H9.5999C9.26853 15.3999 8.9999 15.1313 8.9999 14.7999ZM8.9999 17.1999C8.9999 16.8686 9.26853 16.5999 9.5999 16.5999H14.3999C14.7313 16.5999 14.9999 16.8686 14.9999 17.1999C14.9999 17.5313 14.7313 17.7999 14.3999 17.7999H9.5999C9.26853 17.7999 8.9999 17.5313 8.9999 17.1999Z"
                                                    fill="#7B849A" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        Company Tax {{ $response['user']->company_tax }}
                                    </div>
                                </div>

                                <div class="d-flex align-items-center text-gray-400 me-5 ">
                                    <div class="d-flex align-items-center text-gray-400 me-5">
                                        <span class="me-1 mb-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <circle cx="9.60039" cy="7.2" r="3.2" fill="#7B849A" />
                                                <ellipse cx="9.6" cy="16.0008" rx="5.6" ry="3.2"
                                                    fill="#7B849A" />
                                                <path
                                                    d="M19.1989 16.0003C19.1989 17.3258 17.5705 18.4003 15.5823 18.4003C16.168 17.76 16.5708 16.9564 16.5708 16.0014C16.5708 15.0454 16.1671 14.241 15.5802 13.6003C17.5684 13.6003 19.1989 14.6748 19.1989 16.0003Z"
                                                    fill="#7B849A" />
                                                <path
                                                    d="M16.7989 7.20054C16.7989 8.52602 15.7244 9.60054 14.3989 9.60054C14.1099 9.60054 13.8328 9.54945 13.5762 9.4558C13.9546 8.79013 14.1708 8.02013 14.1708 7.19964C14.1708 6.37977 13.955 5.6103 13.577 4.94496C13.8334 4.85152 14.1102 4.80054 14.3989 4.80054C15.7244 4.80054 16.7989 5.87505 16.7989 7.20054Z"
                                                    fill="#7B849A" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        {{ $response['user']->no_employee }}
                                    </div>
                                    <div class="d-flex align-items-center text-gray-400 me-5">
                                        <span class="me-1 mb-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M12.0416 3.3999H11.9584C11.2396 3.39988 10.6402 3.39986 10.1644 3.46383C9.66218 3.53136 9.20874 3.67989 8.84437 4.04427C8.47999 4.40865 8.33145 4.86209 8.26393 5.36432C8.19996 5.84014 8.19998 6.43951 8.2 7.15829V7.22048C6.58306 7.27338 5.61209 7.46233 4.93726 8.13716C4 9.07442 4 10.5829 4 13.5999C4 16.6169 4 18.1254 4.93726 19.0626C5.87452 19.9999 7.38301 19.9999 10.4 19.9999H13.6C16.617 19.9999 18.1255 19.9999 19.0627 19.0626C20 18.1254 20 16.6169 20 13.5999C20 10.5829 20 9.07442 19.0627 8.13716C18.3879 7.46233 17.4169 7.27338 15.8 7.22048V7.15831C15.8 6.43954 15.8 5.84014 15.7361 5.36432C15.6685 4.86209 15.52 4.40865 15.1556 4.04427C14.7913 3.67989 14.3378 3.53136 13.8356 3.46383C13.3598 3.39986 12.7604 3.39988 12.0416 3.3999ZM14.6 7.20141V7.1999C14.6 6.4287 14.5987 5.91065 14.5468 5.52422C14.4971 5.15505 14.4114 4.99705 14.3071 4.8928C14.2029 4.78855 14.0449 4.70277 13.6757 4.65313C13.2893 4.60118 12.7712 4.59991 12 4.59991C11.2288 4.59991 10.7107 4.60118 10.3243 4.65313C9.95515 4.70277 9.79715 4.78855 9.6929 4.8928C9.58864 4.99705 9.50286 5.15505 9.45323 5.52422C9.40128 5.91065 9.4 6.4287 9.4 7.1999V7.20141C9.71363 7.1999 10.0465 7.1999 10.4 7.1999H13.6C13.9535 7.1999 14.2864 7.1999 14.6 7.20141ZM16 9.5999C16 10.0417 15.6418 10.3999 15.2 10.3999C14.7582 10.3999 14.4 10.0417 14.4 9.5999C14.4 9.15807 14.7582 8.7999 15.2 8.7999C15.6418 8.7999 16 9.15807 16 9.5999ZM8.8 10.3999C9.24183 10.3999 9.6 10.0417 9.6 9.5999C9.6 9.15807 9.24183 8.7999 8.8 8.7999C8.35817 8.7999 8 9.15807 8 9.5999C8 10.0417 8.35817 10.3999 8.8 10.3999Z"
                                                    fill="#7B849A" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        Total Projects {{ $response['user']->totalProjects }}
                                    </div>
                                </div>

                            </div>
                            <!--end::Info-->

                        </div>
                        <!--end::User-->
                    </div>
                    <!--end::Title-->

                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->

            <div class="row d-flex flex-column pb-5">
                <div class="col text-dark fw-bolder fs-2 pb-5">
                    {{ $response['user']->name }}
                </div>
            </div>
            <!--begin::Navs-->
            <div class="d-flex overflow-auto h-55px pb-1">
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-danger me-6 {{ Request::is('CompanyDetail/' . $id) ? 'active' : null }}"
                            href="{{ URL::to('CompanyDetail/' . $id) }}">About</a>
                    </li>
                    <!--end::Nav item-->
                     <!--begin::Nav item-->
                     <li class="nav-item">
                        <a class="nav-link text-active-danger me-6 {{ Request::is('CompanyDetailProjects/' . $id) ? 'active' : null }}"
                            href="{{ URL::to('CompanyDetailProjects/' . $id) }}">Projects</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-danger me-6 {{ Request::is('CompanyReviews/' . $id) ? 'active' : null }}"
                            href="{{ URL::to('CompanyReviews/' . $id) }}">Reviews</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-danger me-6 {{ Request::is('CompanyInCharges/' . $id) ? 'active' : null }}"
                            href="{{ URL::to('CompanyInCharges/' . $id) }}">Incharges</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-danger me-6 {{ Request::is('CompanySubscription/' . $id) ? 'active' : null }}"
                            href="{{ URL::to('CompanySubscription/' . $id) }}">Subscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-danger me-6 {{ Request::is('CompanyPastProjects/' . $id) ? 'active' : null }}"
                            href="{{ URL::to('CompanyPastProjects/' . $id) }}">Past Projects</a>
                    </li>
                    <!--end::Nav item-->
                </ul>
            </div>
            <!--begin::Navs-->
            <div class="card card-flush mb-5 mb-xl-10" style="background-color: none; max-height:350px;">
                <div class="card-body" style="overflow-y: auto; ">
                    <div class="table-responsive">
                        @if (count($response['company_users']))
                            <!--begin::Table-->
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="text-start text-muted fw-bolder fs-5 text-uppercase gs-0">
                                        <th class="min-w-175px">User</th>
                                        <th class="min-w-175px text-center">Email</th>
                                        <th class="min-w-175px text-center">Phone Number</th>
                                        <th class="min-w-175px text-center">Designation</th>
                                        <th class="min-w-175px text-center">Joining Date</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->

                                <tbody class="text-gray-600 fw-bold">
                                    @foreach ($response['company_users'] as $row)
                                        <tr>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center">
                                                    @if ($row->image == "")
                                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                            <img src="{{ url('frontend/media/blank.png') }}"
                                                                alt="image" style="height: 50px; width: 50px;" />
                                                        </div>
                                                    @else
                                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                            <div class="symbol-label">
                                                                <img src="{{ asset('storage/' . $row->image) }}"
                                                                    alt="image" style="height: 50px; width: 50px;" />
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <!--end::Avatar-->
                                                    <div class="d-flex justify-content-start fs-6 flex-column">
                                                        {{ $row->name }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                {{ $row->email }}
                                            </td>
                                            <td class="text-center">
                                                {{ $row->phone_no }}
                                            </td>
                                            <td class="text-center">
                                                {{ $row->designation }}
                                            </td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($row->joining_date)->format('F d, Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        @else
                            <div class="col" style="text-align: center;">
                                <img alt="Logo" src="{{ url('frontend/media/NoIcharges.png') }}"
                                    class="img-fluid">
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Content-->
@endsection
