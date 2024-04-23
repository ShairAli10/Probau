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
                <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">Project Detail
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
            <div class="row g-5 g-xl-8 pb-2">
                {{-- user detail --}}
                <div class="col-xl-4">

                    <div class="me-7 mb-4">
                        @if ($project->image == '')
                            <div class="">
                                <img src="{{ url('frontend/media/projectDetailBlank.png') }}" alt="image"
                                    style="height: 300px; width: 100%; object-fit:cover;" />
                            </div>
                        @else
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                <img src="{{ asset('storage/' . $project->image) }}"
                                    style=" height: 300px; width: 100%;  object-fit: cover; " />

                            </div>
                        @endif

                    </div>

                </div>
                {{-- Graph --}}
                <div class="col-xl-8">
                    <div class="row  d-flex flex-column pb-2">
                        @if ($project->status == 1)
                            <div class="col fs-2 fw-bold text-primary pb-10">
                                Open
                            </div>
                        @elseif($project->status == 2)
                            <div class="col fs-2 fw-bold text-warning pb-10">
                                In Progress
                            </div>
                        @else
                            <div class="col fs-2 fw-bold text-success pb-10">
                                Completed
                            </div>
                        @endif
                        <div class=" col text-muted fs-4">
                            @if ($project->status == 1)
                                {{ $project->created_at->format('M d, Y') }}
                            @elseif($project->status == 2)
                                Start Date : {{ $project->start_time }}
                            @else
                                {{ $project->start_time }} | {{ $project->start_time }}
                            @endif
                        </div>
                        <div class=" col text-dark fw-bolder fs-1 pb-1">
                            {{ $project->name }}
                        </div>
                        <div class=" col text-muted  fs-5 pb-1">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12 4C8.46535 4 5.59998 7.20207 5.59998 10.8C5.59998 14.3697 7.64264 18.2499 10.8296 19.7396C11.5726 20.0868 12.4274 20.0868 13.1703 19.7396C16.3573 18.2499 18.4 14.3697 18.4 10.8C18.4 7.20207 15.5346 4 12 4ZM12 12C12.8836 12 13.6 11.2837 13.6 10.4C13.6 9.51634 12.8836 8.8 12 8.8C11.1163 8.8 10.4 9.51634 10.4 10.4C10.4 11.2837 11.1163 12 12 12Z"
                                        fill="#7B849A" />
                                </svg>
                            </span>
                            {{ $project->location }}
                        </div>
                        <div class=" col text-muted pb-2 fs-5">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25"
                                    fill="none">
                                    <path
                                        d="M15.645 13.576L15.2807 13.9383C15.2807 13.9383 14.4146 14.7994 12.0506 12.4489C9.68659 10.0983 10.5527 9.23713 10.5527 9.23713L10.7821 9.00898C11.3474 8.44695 11.4006 7.5446 10.9075 6.88586L9.8987 5.53834C9.28833 4.72301 8.10886 4.6153 7.40926 5.31094L6.15358 6.55949C5.80668 6.90442 5.57422 7.35155 5.60241 7.84756C5.67453 9.11653 6.24867 11.8468 9.45239 15.0323C12.8498 18.4105 16.0376 18.5447 17.3411 18.4232C17.7534 18.3848 18.112 18.1748 18.401 17.8874L19.5374 16.7574C20.3045 15.9947 20.0883 14.687 19.1068 14.1535L17.5784 13.3226C16.9339 12.9723 16.1487 13.0752 15.645 13.576Z"
                                        fill="#7B849A" />
                                </svg>
                            </span>
                            {{ $project->phone_no }}
                        </div>
                        <div class=" col text-muted pb-4 fs-5">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.93726 7.38843C4 8.32569 4 9.83418 4 12.8512C4 15.8682 4 17.3767 4.93726 18.3139C5.87452 19.2512 7.38301 19.2512 10.4 19.2512H13.6C16.617 19.2512 18.1255 19.2512 19.0627 18.3139C20 17.3767 20 15.8682 20 12.8512C20 9.83418 20 8.32569 19.0627 7.38843C18.1255 6.45117 16.617 6.45117 13.6 6.45117H10.4C7.38301 6.45117 5.87452 6.45117 4.93726 7.38843ZM17.2609 9.26706C17.4731 9.52163 17.4387 9.89997 17.1841 10.1121L15.4269 11.5764C14.7178 12.1674 14.1431 12.6463 13.6359 12.9726C13.1075 13.3124 12.5929 13.5271 12 13.5271C11.4071 13.5271 10.8925 13.3124 10.3641 12.9726C9.85689 12.6463 9.28217 12.1674 8.57308 11.5764L6.81589 10.1121C6.56132 9.89997 6.52693 9.52163 6.73907 9.26706C6.95121 9.0125 7.32954 8.9781 7.58411 9.19024L9.31123 10.6295C10.0576 11.2515 10.5758 11.6819 11.0133 11.9633C11.4368 12.2356 11.7239 12.3271 12 12.3271C12.2761 12.3271 12.5632 12.2356 12.9867 11.9633C13.4242 11.6819 13.9424 11.2515 14.6888 10.6295L16.4159 9.19024C16.6705 8.9781 17.0488 9.0125 17.2609 9.26706Z"
                                        fill="#7B849A" />
                                </svg>
                            </span>
                            {{ $project->email }}
                        </div>
                        <div class=" col text-muted pb-4 fs-5">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M20 12C20 16.4183 16.4183 20 12 20C7.58172 20 4 16.4183 4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12Z"
                                        fill="#7B849A" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12 8.2C12.3314 8.2 12.6 8.46863 12.6 8.8V11.7515L14.4243 13.5757C14.6586 13.8101 14.6586 14.1899 14.4243 14.4243C14.1899 14.6586 13.8101 14.6586 13.5757 14.4243L11.5757 12.4243C11.4632 12.3117 11.4 12.1591 11.4 12V8.8C11.4 8.46863 11.6686 8.2 12 8.2Z"
                                        fill="white" />
                                </svg>
                            </span>
                            Estimated Time: {{ $project->time }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row d-flex flex-column pb-5">
                <a href="{{ URL::to('CompanyDetail/' . $project->uploaded_by->id) }}">
                    <div class="col-6 d-flex pb-4 text-hover-danger">
                        @if ($project->uploaded_by->profile_pic == '')
                            <div class="symbol symbol-100px symbol-circle symbol-lg-160px symbol-fixed position-relative">
                                <img src="{{ url('frontend/media/blank.png') }}" alt="image"
                                    style="height: 60px; width: 60px;" />
                            </div>
                        @else
                            <div class="symbol symbol-100px symbol-lg-160px symbol-circle symbol-fixed position-relative">
                                <img src="{{ asset('storage/' . $project->uploaded_by->profile_pic) }}"
                                    alt="image" style="height: 60px; width: 60px; object-fit:cover;" />
                            </div>
                        @endif
                        <div class="d-flex flex-column ms-3">
                            <div class="text-dark fw-bolder fs-3 mb-1">
                                {{ $project->uploaded_by->name }}
                            </div>
                            <span>
                                <div class="text-muted fs-6">
                                    {{ $project->uploaded_by->email }}
                                </div>
                            </span>
                        </div>
                    </div>
                </a>
                <div class="col fs-4 text-muted pb-5">
                    {{ $project->description }}
                </div>

                <div class="col text-dark fw-bolder fs-2">
                    Company Types
                </div>
            </div>

            @foreach ($project['company_types'] as $row)
                <div class="card card-xl-stretch mb-xl-8" style="">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start fs-2 fw-bolder">
                            <span class="card-label fw-bold fs-1"><svg width="23" height="21" viewBox="0 0 23 21"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M14.3082 0.0410156H16.3156C18.2081 0.0410156 19.1544 0.0410156 19.7423 0.628946C20.3302 1.21688 20.3302 2.16314 20.3302 4.05566V19.3615H21.3339C21.7496 19.3615 22.0867 19.6985 22.0867 20.1142C22.0867 20.5299 21.7496 20.867 21.3339 20.867H1.26056C0.84483 20.867 0.507813 20.5299 0.507812 20.1142C0.507812 19.6985 0.84483 19.3615 1.26056 19.3615H2.26423V7.06663C2.26423 5.17412 2.26423 4.22786 2.85216 3.63993C3.4401 3.05199 4.38637 3.052 6.2789 3.052H10.2936C12.1861 3.052 13.1324 3.05199 13.7203 3.63993C14.3082 4.22786 14.3082 5.17412 14.3082 7.06663V19.3615H15.8137V7.06663L15.8137 6.97682C15.8138 6.10802 15.8139 5.31144 15.7268 4.66346C15.6309 3.94989 15.4052 3.19569 14.7848 2.57538C14.1645 1.95507 13.4103 1.72936 12.6968 1.63342C12.0579 1.54753 11.2746 1.54641 10.42 1.54649C10.5046 1.15783 10.6458 0.864605 10.8815 0.628946C11.4694 0.0410156 12.4157 0.0410156 14.3082 0.0410156ZM4.52248 6.06297C4.52248 5.64724 4.8595 5.31023 5.27523 5.31023H11.2972C11.713 5.31023 12.05 5.64724 12.05 6.06297C12.05 6.4787 11.713 6.81572 11.2972 6.81572H5.27523C4.8595 6.81572 4.52248 6.4787 4.52248 6.06297ZM4.52248 9.07395C4.52248 8.65822 4.8595 8.32121 5.27523 8.32121H11.2972C11.713 8.32121 12.05 8.65822 12.05 9.07395C12.05 9.48968 11.713 9.8267 11.2972 9.8267H5.27523C4.8595 9.8267 4.52248 9.48968 4.52248 9.07395ZM4.52248 12.0849C4.52248 11.6692 4.8595 11.3322 5.27523 11.3322H11.2972C11.713 11.3322 12.05 11.6692 12.05 12.0849C12.05 12.5007 11.713 12.8377 11.2972 12.8377H5.27523C4.8595 12.8377 4.52248 12.5007 4.52248 12.0849ZM8.28623 16.3505C8.70196 16.3505 9.03898 16.6875 9.03898 17.1032V19.3615H7.53348V17.1032C7.53348 16.6875 7.8705 16.3505 8.28623 16.3505Z"
                                        fill="#F70D1A" />
                                </svg>
                            </span>
                            {{$row->name}}
                        </h3>
                        <!--end::Title-->

                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col">
                                <h3 class=" fs-1  fw-bold">
                                    Services
                                </h3>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($row['services'] as $service )
                            <div class="col-6 mb-6">
                                <div class="box">
                                    <div class="row pb-2">
                                        <div class="col fs-3 fw-bold ">
                                            {{$service->name}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col fs-3 fw-normal text-black-50  ">
                                            {{$service->description}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
        <!--end::Container-->
    </div>
    <!--end::Content-->
@endsection
