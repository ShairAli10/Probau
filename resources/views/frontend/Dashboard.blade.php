@extends('frontend.layout.master')
<style>
    .num {
        color: #7B849A;
        font-size: 14.084px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .square-div {
        width: 12.456px;
        height: 12.456px;
    }
</style>
@section('content')
    <!--begin::Header-->
    <div id="kt_header" class="header">
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
                <h1 class="d-flex flex-column text-dark fw-bolder my-0 fs-1">Dashboard
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
            <div class="row pb-5">
                <div class="col">
                    <div class="card card-flush">
                        <div class="card-body row p-3">
                            <div class="col-10 d-flex">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="61" height="60"
                                        viewBox="0 0 61 60" fill="none">
                                        <path
                                            d="M32.9625 42.7728L33.4962 42.5949C38.0923 41.0629 40.3904 40.2969 40.8182 38.4844C41.2461 36.6718 39.5333 34.959 36.1075 31.5333L32.729 28.1547C32.726 28.1642 32.7229 28.1741 32.7196 28.1843C32.6804 28.3079 32.6236 28.49 32.5551 28.7188C32.4179 29.1771 32.2349 29.819 32.0522 30.5506C31.6782 32.0483 31.3387 33.7945 31.3387 35.1104C31.3387 36.4263 31.6782 38.1725 32.0522 39.6701C32.2349 40.4018 32.4179 41.0436 32.5551 41.5019C32.6236 41.7307 32.6804 41.9128 32.7196 42.0364C32.7392 42.0982 32.7544 42.1453 32.7645 42.1763L32.7756 42.2103L32.7781 42.2179L32.9625 42.7728Z"
                                            fill="#F70D1A" />
                                        <path
                                            d="M21.8278 46.4826C17.3047 47.9738 14.9215 48.5979 13.6032 47.2796C12.1435 45.8198 13.0653 43.0544 14.9089 37.5236L18.2879 27.3866C19.5519 23.5945 20.2945 21.3668 21.5336 20.4631L21.5232 20.5147C21.5087 20.5865 21.4879 20.6915 21.4616 20.8265C21.4091 21.0965 21.3348 21.4869 21.2472 21.9732C21.072 22.9453 20.8426 24.3037 20.6255 25.8515C20.1952 28.9179 19.7967 32.8359 20.002 35.9667C20.1262 37.8612 20.5203 40.2113 20.8721 42.0477C21.0496 42.9745 21.2196 43.7867 21.3452 44.3676C21.4081 44.6583 21.46 44.8915 21.4963 45.0527L21.5386 45.239L21.8278 46.4826Z"
                                            fill="#F70D1A" />
                                        <path
                                            d="M24.5854 20.5179L24.4841 21.0085L24.4831 21.0133L24.4794 21.0312L24.4644 21.1055C24.4511 21.1717 24.4314 21.2708 24.4064 21.3996C24.3562 21.6573 24.2846 22.034 24.1996 22.5053C24.0297 23.4485 23.8069 24.7675 23.5964 26.2683C23.1711 29.299 22.8114 32.9628 22.9955 35.7704C23.107 37.4702 23.471 39.6692 23.8185 41.4833C23.9906 42.3817 24.1556 43.1701 24.2774 43.7334C24.3383 44.0149 24.3883 44.2398 24.423 44.3935L24.4628 44.569L24.473 44.6132L24.6866 45.5315L30.1165 43.7215L29.9115 43.104C29.8994 43.0667 29.882 43.0128 29.8601 42.9439C29.8164 42.8063 29.7548 42.6084 29.6811 42.3623C29.534 41.8708 29.3379 41.1833 29.1415 40.397C28.7574 38.8586 28.3387 36.814 28.3387 35.1104C28.3387 33.4068 28.7574 31.3622 29.1415 29.8238C29.3379 29.0374 29.534 28.35 29.6811 27.8585C29.7548 27.6124 29.8164 27.4145 29.8601 27.2768C29.882 27.208 29.8994 27.1541 29.9115 27.1167L29.9298 27.0611L30.3552 25.781L29.3495 24.7753C27.2623 22.688 25.8109 21.2367 24.5854 20.5179Z"
                                            fill="#F70D1A" />
                                        <path
                                            d="M28.7376 10.7204C29.4444 11.1525 29.6671 12.0758 29.235 12.7826C28.9215 13.2955 29.0001 13.9564 29.4251 14.3815L29.6209 14.5773C30.7982 15.7546 31.2323 17.4841 30.7506 19.0779C30.5109 19.8709 29.6737 20.3194 28.8807 20.0797C28.0877 19.84 27.6392 19.0028 27.8789 18.2098C28.0407 17.6747 27.8949 17.0939 27.4996 16.6986L27.3038 16.5028C25.8988 15.0978 25.639 12.9132 26.6754 11.2178C27.1075 10.511 28.0308 10.2883 28.7376 10.7204Z"
                                            fill="#F70D1A" />
                                        <path
                                            d="M34.0068 14.7932C34.4089 14.3911 34.61 14.19 34.8425 14.1163C35.0391 14.054 35.2502 14.054 35.4468 14.1163C35.6793 14.19 35.8804 14.3911 36.2825 14.7932C36.6846 15.1953 36.8857 15.3963 36.9593 15.6288C37.0217 15.8254 37.0217 16.0365 36.9593 16.2332C36.8857 16.4657 36.6846 16.6667 36.2825 17.0688C35.8804 17.4709 35.6793 17.672 35.4468 17.7457C35.2502 17.808 35.0391 17.808 34.8425 17.7457C34.61 17.672 34.4089 17.4709 34.0068 17.0688C33.6047 16.6667 33.4037 16.4657 33.33 16.2332C33.2676 16.0365 33.2676 15.8254 33.33 15.6288C33.4037 15.3963 33.6047 15.1953 34.0068 14.7932Z"
                                            fill="#F70D1A" />
                                        <path
                                            d="M20.739 13.8818C21.1579 13.4629 21.8372 13.4629 22.2561 13.8818C22.6751 14.3007 22.6751 14.98 22.2561 15.3989C21.8372 15.8178 21.1579 15.8178 20.739 15.3989C20.3201 14.98 20.3201 14.3007 20.739 13.8818Z"
                                            fill="#F70D1A" />
                                        <path
                                            d="M46.8342 20.0936C46.5574 20.2003 46.312 20.4457 45.8212 20.9364C45.3304 21.4272 45.085 21.6726 44.9784 21.9494C44.8536 22.2734 44.8536 22.6322 44.9784 22.9561C45.085 23.233 45.3304 23.4784 45.8212 23.9691C46.312 24.4599 46.5574 24.7053 46.8342 24.812C47.1582 24.9368 47.517 24.9368 47.8409 24.812C48.1177 24.7053 48.3631 24.4599 48.8539 23.9691C49.3447 23.4784 49.5901 23.233 49.6967 22.9561C49.8216 22.6322 49.8216 22.2734 49.6967 21.9494C49.5901 21.6726 49.3447 21.4272 48.8539 20.9364C48.3631 20.4457 48.1177 20.2003 47.8409 20.0936C47.517 19.9688 47.1582 19.9688 46.8342 20.0936Z"
                                            fill="#F70D1A" />
                                        <path
                                            d="M45.0007 36.6267C45.4197 36.2078 46.0989 36.2078 46.5178 36.6267C46.9368 37.0456 46.9368 37.7249 46.5178 38.1438C46.0989 38.5627 45.4197 38.5627 45.0007 38.1438C44.5818 37.7249 44.5818 37.0456 45.0007 36.6267Z"
                                            fill="#F70D1A" />
                                        <path
                                            d="M42.2632 15.4435C43.0755 15.6059 43.6023 16.3962 43.4399 17.2085L43.1519 18.6484C42.7556 20.63 41.3278 22.2474 39.4106 22.8864C38.5148 23.185 37.8476 23.9408 37.6625 24.8667L37.3745 26.3066C37.212 27.119 36.4218 27.6458 35.6094 27.4833C34.7971 27.3208 34.2703 26.5306 34.4327 25.7183L34.7207 24.2784C35.117 22.2968 36.5448 20.6794 38.462 20.0404C39.3578 19.7418 40.025 18.986 40.2102 18.06L40.4981 16.6202C40.6606 15.8078 41.4508 15.281 42.2632 15.4435Z"
                                            fill="#F70D1A" />
                                        <path
                                            d="M49.7011 31.1192C48.9777 30.8029 48.1364 30.9358 47.5456 31.4596C45.9271 32.8948 43.5718 33.1334 41.6984 32.0518L41.2728 31.806C40.5553 31.3918 40.3095 30.4744 40.7237 29.757C41.1379 29.0395 42.0553 28.7937 42.7728 29.2079L43.1984 29.4537C43.9535 29.8896 44.9029 29.7935 45.5552 29.215C47.0209 27.9153 49.1081 27.5857 50.903 28.3705L51.4859 28.6254C52.245 28.9573 52.5913 29.8416 52.2594 30.6007C51.9275 31.3597 51.0431 31.706 50.2841 31.3741L49.7011 31.1192Z"
                                            fill="#F70D1A" />
                                        <path
                                            d="M41.8851 25.4832C42.304 25.0642 42.9832 25.0642 43.4022 25.4832C43.8211 25.9021 43.8211 26.5814 43.4022 27.0003C42.9832 27.4192 42.304 27.4192 41.8851 27.0003C41.4661 26.5814 41.4661 25.9021 41.8851 25.4832Z"
                                            fill="#F70D1A" />
                                    </svg>
                                </span>


                                <div class="p-3">
                                    <h5 class="fw-bolder fs-5 ">
                                        Free Subscription(Company side)
                                    </h5>

                                    @if ($response['free_subscription'] == '')
                                        <h5 class="fw-normal text-muted fs-8 ">
                                            No Free Subscription </h5>
                                    @else
                                        <h5 class="fw-normal text-muted fs-8 ">
                                            {{ $response['free_subscription']->title }}({{ $response['free_subscription']->start_date }}-
                                            {{ $response['free_subscription']->end_date }})
                                        </h5>
                                    @endif
                                </div>
                            </div>
                            <div class="col-2 d-flex justify-content-end align-content-end">
                                @if ($response['free_subscription'] == '')
                                    <div class="cursor-pointer p-4" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_free_subscription">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="31" height="30"
                                            viewBox="0 0 31 30" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15.3848 30C8.3137 30 4.77816 30 2.58146 27.8033C0.384766 25.6066 0.384766 22.0711 0.384766 15C0.384766 7.92893 0.384766 4.3934 2.58146 2.1967C4.77816 0 8.3137 0 15.3848 0C22.4558 0 25.9914 0 28.1881 2.1967C30.3848 4.3934 30.3848 7.92893 30.3848 15C30.3848 22.0711 30.3848 25.6066 28.1881 27.8033C25.9914 30 22.4558 30 15.3848 30ZM15.3848 9.375C16.0061 9.375 16.5098 9.87868 16.5098 10.5V13.875H19.8848C20.5061 13.875 21.0098 14.3787 21.0098 15C21.0098 15.6214 20.5061 16.125 19.8848 16.125H16.5098L16.5098 19.5C16.5098 20.1213 16.0061 20.625 15.3848 20.625C14.7634 20.625 14.2598 20.1213 14.2598 19.5V16.125H10.8848C10.2634 16.125 9.75976 15.6214 9.75976 15C9.75976 14.3787 10.2634 13.875 10.8848 13.875H14.2598L14.2598 10.5C14.2598 9.87868 14.7634 9.375 15.3848 9.375Z"
                                                fill="#F70D1A" />
                                        </svg>
                                    </div>
                                @else
                                    <a href="{{ URL::to('RemoveFreeSubscription') }}">
                                        <div class="cursor-pointer p-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="31" height="30"
                                                viewBox="0 0 31 30" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15.3848 30C8.3137 30 4.77816 30 2.58146 27.8033C0.384766 25.6066 0.384766 22.0711 0.384766 15C0.384766 7.92893 0.384766 4.3934 2.58146 2.1967C4.77816 0 8.3137 0 15.3848 0C22.4558 0 25.9914 0 28.1881 2.1967C30.3848 4.3934 30.3848 7.92893 30.3848 15C30.3848 22.0711 30.3848 25.6066 28.1881 27.8033C25.9914 30 22.4558 30 15.3848 30ZM21.0098 15C21.0098 15.6213 20.5061 16.125 19.8848 16.125H10.8848C10.2634 16.125 9.75977 15.6213 9.75977 15C9.75977 14.3787 10.2634 13.875 10.8848 13.875H19.8848C20.5061 13.875 21.0098 14.3787 21.0098 15Z"
                                                    fill="#99A1B7" />
                                            </svg>
                                        </div>
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-flush">
                        <div class="card-body row p-3">
                            <div class="col-10 d-flex">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="67" height="66"
                                        viewBox="0 0 67 66" fill="none">
                                        <path
                                            d="M32.2342 11C22.9539 11.009 18.1523 11.1751 15.1061 14.2213C12.0598 17.2675 11.8938 22.0692 11.8848 31.3495H22.6945C21.9224 30.385 21.3454 29.2474 21.0308 27.989C19.8467 23.2524 24.1371 18.9619 28.8738 20.1461C30.1321 20.4607 31.2698 21.0376 32.2342 21.8097V11Z"
                                            fill="#F70D1A" />
                                        <path
                                            d="M11.8848 34.6495C11.8938 43.9298 12.0598 48.7314 15.1061 51.7777C18.1523 54.8239 22.9539 54.9899 32.2342 54.999V37.6715C30.519 41.0974 26.9763 43.4495 22.8842 43.4495C21.973 43.4495 21.2342 42.7108 21.2342 41.7995C21.2342 40.8882 21.973 40.1495 22.8842 40.1495C26.2652 40.1495 29.098 37.8029 29.8429 34.6495H11.8848Z"
                                            fill="#F70D1A" />
                                        <path
                                            d="M35.5342 54.999C44.8145 54.9899 49.6162 54.8239 52.6624 51.7777C55.7087 48.7314 55.8747 43.9298 55.8837 34.6495H37.9256C38.6705 37.8029 41.5033 40.1495 44.8843 40.1495C45.7955 40.1495 46.5342 40.8882 46.5342 41.7995C46.5342 42.7108 45.7955 43.4495 44.8843 43.4495C40.7922 43.4495 37.2495 41.0974 35.5342 37.6715V54.999Z"
                                            fill="#F70D1A" />
                                        <path
                                            d="M55.8837 31.3495C55.8747 22.0692 55.7087 17.2675 52.6624 14.2213C49.6162 11.1751 44.8145 11.009 35.5342 11V21.8097C36.4987 21.0376 37.6363 20.4607 38.8947 20.1461C43.6313 18.9619 47.9218 23.2524 46.7376 27.989C46.423 29.2474 45.8461 30.385 45.074 31.3495H55.8837Z"
                                            fill="#F70D1A" />
                                        <path
                                            d="M28.0734 23.3476C30.5188 23.9589 32.2342 26.156 32.2342 28.6767V31.3495H29.5614C27.0408 31.3495 24.8437 29.634 24.2323 27.1886C23.6524 24.8689 25.7536 22.7676 28.0734 23.3476Z"
                                            fill="#F70D1A" />
                                        <path
                                            d="M35.5342 28.6767V31.3495H38.2071C40.7277 31.3495 42.9248 29.634 43.5362 27.1886C44.1161 24.8689 42.0149 22.7676 39.6951 23.3476C37.2497 23.9589 35.5342 26.156 35.5342 28.6767Z"
                                            fill="#F70D1A" />
                                    </svg>
                                </span>
                                <div class="p-3">
                                    <h5 class="fw-bolder fs-5 ">
                                        Free Projects(User Side)
                                    </h5>
                                    @if ($response['free_projects'] == '')
                                        <h5 class="fw-normal text-muted fs-8 ">
                                            No Free Projects </h5>
                                    @else
                                        <h5 class="fw-normal text-muted fs-8 ">
                                            {{ $response['free_projects']->title }}({{ $response['free_projects']->start_date }}-
                                            {{ $response['free_projects']->end_date }})
                                        </h5>
                                    @endif
                                </div>
                            </div>
                            <div class="col-2 d-flex justify-content-end align-content-end">
                                @if ($response['free_projects'] == '')
                                    <div class="cursor-pointer p-4" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_free_projects">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="31" height="30"
                                            viewBox="0 0 31 30" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15.3848 30C8.3137 30 4.77816 30 2.58146 27.8033C0.384766 25.6066 0.384766 22.0711 0.384766 15C0.384766 7.92893 0.384766 4.3934 2.58146 2.1967C4.77816 0 8.3137 0 15.3848 0C22.4558 0 25.9914 0 28.1881 2.1967C30.3848 4.3934 30.3848 7.92893 30.3848 15C30.3848 22.0711 30.3848 25.6066 28.1881 27.8033C25.9914 30 22.4558 30 15.3848 30ZM15.3848 9.375C16.0061 9.375 16.5098 9.87868 16.5098 10.5V13.875H19.8848C20.5061 13.875 21.0098 14.3787 21.0098 15C21.0098 15.6214 20.5061 16.125 19.8848 16.125H16.5098L16.5098 19.5C16.5098 20.1213 16.0061 20.625 15.3848 20.625C14.7634 20.625 14.2598 20.1213 14.2598 19.5V16.125H10.8848C10.2634 16.125 9.75976 15.6214 9.75976 15C9.75976 14.3787 10.2634 13.875 10.8848 13.875H14.2598L14.2598 10.5C14.2598 9.87868 14.7634 9.375 15.3848 9.375Z"
                                                fill="#F70D1A" />
                                        </svg>
                                    </div>
                                @else
                                    <a href="{{ URL::to('RemoveFreeProjects') }}">
                                        <div class="cursor-pointer p-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="31" height="30"
                                                viewBox="0 0 31 30" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15.3848 30C8.3137 30 4.77816 30 2.58146 27.8033C0.384766 25.6066 0.384766 22.0711 0.384766 15C0.384766 7.92893 0.384766 4.3934 2.58146 2.1967C4.77816 0 8.3137 0 15.3848 0C22.4558 0 25.9914 0 28.1881 2.1967C30.3848 4.3934 30.3848 7.92893 30.3848 15C30.3848 22.0711 30.3848 25.6066 28.1881 27.8033C25.9914 30 22.4558 30 15.3848 30ZM21.0098 15C21.0098 15.6213 20.5061 16.125 19.8848 16.125H10.8848C10.2634 16.125 9.75977 15.6213 9.75977 15C9.75977 14.3787 10.2634 13.875 10.8848 13.875H19.8848C20.5061 13.875 21.0098 14.3787 21.0098 15Z"
                                                    fill="#99A1B7" />
                                            </svg>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row pb-5">
                <div class="col">
                    <div class="card card-flush" style="background-color: #f9cbce; max-height:230px;">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex flex-column flex-grow-1">
                                <p class="text-dark text-hover-primary fw-bolder fs-3">Project Payment</p>
                                <div class="earnings_graph" style="height: 100px"></div>
                            </div>

                            <div class="pt-5">
                                <span class="text-dark fw-bolder fs-2x lh-0">€</span>

                                <span
                                    class="text-dark fw-bolder  fs-3x me-2 lh-1">{{ $response['project_payment']['totall_payments'] }}</span>

                                <span
                                    class="text-dark fw-bolder fs-6 lh-0">{{ $response['project_payment']['current_month_payments'] }}%
                                    this month</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-flush" style="background-color: #d7efe0; max-height:230px;">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex flex-column flex-grow-1">
                                <p class="text-dark text-hover-primary fw-bolder fs-3">Total Projects</p>
                                <div class="totall_projects_graph" style="height: 100px"></div>
                            </div>
                            <div class="pt-5">
                                <span
                                    class="text-dark fw-bolder fs-3x me-2 lh-0">{{ $response['totall_projects']['total_projects'] }}</span>
                                <span
                                    class="text-dark fw-bolder fs-6 lh-0">{{ $response['totall_projects']['current_month_project'] }}%
                                    this month</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-flush" style="background-color: #c7e5f9; max-height:230px;">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex flex-column flex-grow-1">
                                <p class="text-dark text-hover-primary fw-bolder fs-3">Totall Users</p>
                                <div class="totall_users_graph" style="height: 100px"></div>
                            </div>

                            <div class="pt-5">
                                <span
                                    class="text-dark fw-bolder fs-3x me-2 lh-1">{{ $response['private_users']['totall_users'] }}</span>

                                <span
                                    class="text-dark fw-bolder fs-6 lh-0">{{ $response['private_users']['current_month_user'] }}%
                                    this month</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-flush" style="background-color: #e9e9e9; max-height:230px;">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex flex-column flex-grow-1">
                                <p class="text-dark text-hover-primary fw-bolder fs-3">Company Users</p>
                                <div class="company_users_graph" style="height: 100px"></div>
                            </div>
                            <div class="pt-5">
                                <span
                                    class="text-dark fw-bolder fs-3x me-2 lh-0">{{ $response['company_users']['totall_users'] }}</span>
                                <span
                                    class="text-dark fw-bolder fs-6 lh-0">{{ $response['company_users']['current_month_user'] }}%
                                    this month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row pb-5">
                <div class="col-6">
                    <div class="card card-flush" style="max-height:350px;">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span
                                    class="card-label fw-bold fs-1 mb-2">{{ $response['completed_projects']['total_projects'] }}
                                    <span
                                        class="ms-2 badge badge-light-danger fs-4 fw-bolder pt-2">{{ $response['completed_projects']['current_month_project'] }}%</span>
                                </span>
                                <span class="text-muted fw-bold fs-3">Completed Projects</span>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="kt_charts_widget_3_chart" style="height: 100px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-6">

                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <div class="d-flex justify-content-end align-content-end">
                                <div class="pb-5 d-flex align-items-center justify-content-between">
                                    <div class="square-div bg-primary"></div>
                                    <div class="ms-2 num">User</div>
                                    <div class="square-div bg-success ms-2"></div>
                                    <div class="ms-2  num">Companies</div>
                                    <div class="square-div bg-danger ms-2"></div>
                                    <div class="ms-2 num">Projects</div>
                                </div>
                            </div>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Chart-->
                            <div id="kt_charts_widget_2_chart" style="height: 170px"></div>
                            <!--end::Chart-->
                        </div>
                        <!--end::Body-->
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="card card-xl-stretch mb-xl-8" style="">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <!--begin::Title-->
                            <h3 class="card-title align-items-start">
                                <span
                                    class="card-label fw-bold fs-1">{{ $response['subscription_payment']['totall_payments'] }}€</span>
                                <span
                                    class="badge badge-light-danger fs-4 fw-bolder pt-2">{{ $response['subscription_payment']['current_month_payments'] }}%</span>
                            </h3>
                            <!--end::Title-->
                            <h3 class="card-title align-items-end flex-column">
                                <span class="card-label fw-bold text-muted fs-2 ">Subscription payment</span>
                            </h3>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Chart-->
                            <div id="kt_charts_widget_age_chart" style="height: 150px"></div>
                            <!--end::Chart-->
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-xl-stretch" style="height:335px;">
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Heading-->
                            <div class="fs-2hx fw-bolder">{{ $response['subscriptions']['totall_subscription'] }}
                                <span
                                    class="badge badge-light-danger fs-4 fw-bolder ">{{ $response['subscriptions']['current_month_subscription'] }}%</span>
                            </div>
                            <div class="fs-4 fw-bold text-gray-400 mb-7">Total Subscriptions</div>
                            <!--end::Heading-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-wrap">
                                <!--begin::Chart-->
                                <div class="d-flex flex-center h-100px w-100px me-9 mb-5">
                                    <canvas id="kt_project_list_chart"></canvas>
                                </div>
                                <!--end::Chart-->
                                <!--begin::Labels-->
                                <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
                                    <!--begin::Label-->
                                    <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                                        <div class="bullet bg-success me-3"></div>
                                        <div class="text-gray-400">Basic</div>
                                        <div class="ms-auto fw-bolder text-gray-700">
                                            {{ $response['subscriptions']['total_basic'] }}</div>
                                    </div>
                                    <!--end::Label-->
                                    <!--begin::Label-->
                                    <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                                        <div class="bullet fs-4 bg-primary me-3"></div>
                                        <div class="text-gray-400">Pro</div>
                                        <div class="ms-auto fw-bolder text-gray-700">
                                            {{ $response['subscriptions']['total_pro'] }}</div>
                                    </div>
                                    <!--end::Label-->
                                    <!--begin::Label-->
                                    <div class="d-flex fs-6 fw-bold align-items-center">
                                        <div class="bullet bg-danger me-3"></div>
                                        <div class="text-gray-400">Premium</div>
                                        <div class="ms-auto fw-bolder text-gray-700">
                                            {{ $response['subscriptions']['total_premium'] }}</div>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Labels-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Content-->

    <!--begin::Modal - Free Subscription-->
    <div class="modal fade" id="kt_modal_free_subscription" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <form class="form" method="post" action="{{ URL::to('FreeSubscription') }}"
                    id="kt_modal_free_subscription_form">
                    <div class="modal-header" id="kt_modal_free_subscription_header">
                        <h2></h2>
                        <h2>Free Subscription</h2>
                        <div class="btn btn-sm btn-icon btn-active-color-danger" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="28"
                                    viewBox="0 0 27 28" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M26.8307 14.0013C26.8307 21.3651 20.8612 27.3346 13.4974 27.3346C6.1336 27.3346 0.164062 21.3651 0.164062 14.0013C0.164062 6.63751 6.1336 0.667969 13.4974 0.667969C20.8612 0.667969 26.8307 6.63751 26.8307 14.0013ZM9.4569 9.96083C9.84742 9.57031 10.4806 9.57031 10.8711 9.96083L13.4974 12.5871L16.1236 9.96086C16.5141 9.57034 17.1473 9.57034 17.5378 9.96086C17.9283 10.3514 17.9283 10.9846 17.5378 11.3751L14.9116 14.0013L17.5378 16.6275C17.9283 17.018 17.9283 17.6512 17.5378 18.0417C17.1472 18.4322 16.5141 18.4322 16.1235 18.0417L13.4974 15.4155L10.8711 18.0417C10.4806 18.4322 9.84745 18.4322 9.45693 18.0417C9.0664 17.6512 9.0664 17.018 9.45693 16.6275L12.0831 14.0013L9.4569 11.375C9.06637 10.9845 9.06637 10.3514 9.4569 9.96083Z"
                                        fill="#259CD5" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body py-10 px-lg-17">
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_free_subscription_scroll" data-kt-scroll="true"
                            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_free_subscription_header"
                            data-kt-scroll-wrappers="#kt_modal_free_subscription_scroll" data-kt-scroll-offset="300px">
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group mb-5 fv-row">
                                        <label class="fs-5 fw-bold mb-2">From</label>
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control form-control-solid subscription_start" required
                                                placeholder="Start Date" name="start_date" id="start_date" />
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    viewBox="0 0 30 30" fill="none">
                                                    <path
                                                        d="M10.75 5.75C10.75 5.33579 10.4142 5 10 5C9.58579 5 9.25 5.33579 9.25 5.75V7.32926C7.81067 7.44451 6.86577 7.72737 6.17157 8.42157C5.47737 9.11577 5.19451 10.0607 5.07926 11.5H24.9207C24.8055 10.0607 24.5226 9.11577 23.8284 8.42157C23.1342 7.72737 22.1893 7.44451 20.75 7.32926V5.75C20.75 5.33579 20.4142 5 20 5C19.5858 5 19.25 5.33579 19.25 5.75V7.2629C18.5847 7.25 17.839 7.25 17 7.25H13C12.161 7.25 11.4153 7.25 10.75 7.2629V5.75Z"
                                                        fill="#99A1B7" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5 15.25C5 14.411 5 13.6653 5.0129 13H24.9871C25 13.6653 25 14.411 25 15.25V17.25C25 21.0212 25 22.9069 23.8284 24.0784C22.6569 25.25 20.7712 25.25 17 25.25H13C9.22876 25.25 7.34315 25.25 6.17157 24.0784C5 22.9069 5 21.0212 5 17.25V15.25ZM20 17.25C20.5523 17.25 21 16.8023 21 16.25C21 15.6977 20.5523 15.25 20 15.25C19.4477 15.25 19 15.6977 19 16.25C19 16.8023 19.4477 17.25 20 17.25ZM20 21.25C20.5523 21.25 21 20.8023 21 20.25C21 19.6977 20.5523 19.25 20 19.25C19.4477 19.25 19 19.6977 19 20.25C19 20.8023 19.4477 21.25 20 21.25ZM16 16.25C16 16.8023 15.5523 17.25 15 17.25C14.4477 17.25 14 16.8023 14 16.25C14 15.6977 14.4477 15.25 15 15.25C15.5523 15.25 16 15.6977 16 16.25ZM16 20.25C16 20.8023 15.5523 21.25 15 21.25C14.4477 21.25 14 20.8023 14 20.25C14 19.6977 14.4477 19.25 15 19.25C15.5523 19.25 16 19.6977 16 20.25ZM10 17.25C10.5523 17.25 11 16.8023 11 16.25C11 15.6977 10.5523 15.25 10 15.25C9.44772 15.25 9 15.6977 9 16.25C9 16.8023 9.44772 17.25 10 17.25ZM10 21.25C10.5523 21.25 11 20.8023 11 20.25C11 19.6977 10.5523 19.25 10 19.25C9.44772 19.25 9 19.6977 9 20.25C9 20.8023 9.44772 21.25 10 21.25Z"
                                                        fill="#99A1B7" />
                                                </svg>
                                            </span>
                                        </div>
                                        <span class="text-danger mt-1" id="subscriptionStartDate"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group mb-5 fv-row">
                                        <label class="fs-5 fw-bold mb-2">To</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-solid subscription_end"
                                                placeholder="End Date" name="end_date" id="end_date" />
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    viewBox="0 0 30 30" fill="none">
                                                    <path
                                                        d="M10.75 5.75C10.75 5.33579 10.4142 5 10 5C9.58579 5 9.25 5.33579 9.25 5.75V7.32926C7.81067 7.44451 6.86577 7.72737 6.17157 8.42157C5.47737 9.11577 5.19451 10.0607 5.07926 11.5H24.9207C24.8055 10.0607 24.5226 9.11577 23.8284 8.42157C23.1342 7.72737 22.1893 7.44451 20.75 7.32926V5.75C20.75 5.33579 20.4142 5 20 5C19.5858 5 19.25 5.33579 19.25 5.75V7.2629C18.5847 7.25 17.839 7.25 17 7.25H13C12.161 7.25 11.4153 7.25 10.75 7.2629V5.75Z"
                                                        fill="#99A1B7" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5 15.25C5 14.411 5 13.6653 5.0129 13H24.9871C25 13.6653 25 14.411 25 15.25V17.25C25 21.0212 25 22.9069 23.8284 24.0784C22.6569 25.25 20.7712 25.25 17 25.25H13C9.22876 25.25 7.34315 25.25 6.17157 24.0784C5 22.9069 5 21.0212 5 17.25V15.25ZM20 17.25C20.5523 17.25 21 16.8023 21 16.25C21 15.6977 20.5523 15.25 20 15.25C19.4477 15.25 19 15.6977 19 16.25C19 16.8023 19.4477 17.25 20 17.25ZM20 21.25C20.5523 21.25 21 20.8023 21 20.25C21 19.6977 20.5523 19.25 20 19.25C19.4477 19.25 19 19.6977 19 20.25C19 20.8023 19.4477 21.25 20 21.25ZM16 16.25C16 16.8023 15.5523 17.25 15 17.25C14.4477 17.25 14 16.8023 14 16.25C14 15.6977 14.4477 15.25 15 15.25C15.5523 15.25 16 15.6977 16 16.25ZM16 20.25C16 20.8023 15.5523 21.25 15 21.25C14.4477 21.25 14 20.8023 14 20.25C14 19.6977 14.4477 19.25 15 19.25C15.5523 19.25 16 19.6977 16 20.25ZM10 17.25C10.5523 17.25 11 16.8023 11 16.25C11 15.6977 10.5523 15.25 10 15.25C9.44772 15.25 9 15.6977 9 16.25C9 16.8023 9.44772 17.25 10 17.25ZM10 21.25C10.5523 21.25 11 20.8023 11 20.25C11 19.6977 10.5523 19.25 10 19.25C9.44772 19.25 9 19.6977 9 20.25C9 20.8023 9.44772 21.25 10 21.25Z"
                                                        fill="#99A1B7" />
                                                </svg>
                                            </span>
                                        </div>
                                        <span class="text-danger mt-1" id="subscriptionEndDate"></span>
                                    </div>

                                </div>
                            </div>


                            <div class="fv-row mb-5">
                                <label for="title" class="fw-bolder pb-2 fw-600">Offer Tittle</label>
                                <input type="text" placeholder= "Title" name="title" id="title" required
                                    class="form-control form-control-solid" />
                            </div>


                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="fs-5 fw-bold mb-2">Detail</label>
                                <textarea type="text" placeholder="Description" name="description" required
                                    class="form-control form-control-solid" id="" cols="10" rows="5"></textarea>
                            </div>
                        </div>
                        <input type="hidden" placeholder="Title" name="type" value="2" />
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="submit" id="kt_modal_free_subscription_submit" class="btn btn-danger w-75">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal - Free Subscription-->

    <!--begin::Modal - Free Projects-->
    <div class="modal fade" id="kt_modal_free_projects" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <form class="form" method="post" action="{{ URL::to('FreeProjects') }}"
                    id="kt_modal_free_projects_form">
                    <div class="modal-header" id="kt_modal_free_projects_header">
                        <h2></h2>
                        <h2>Free Projects</h2>
                        <div class="btn btn-sm btn-icon btn-active-color-danger" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="28"
                                    viewBox="0 0 27 28" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M26.8307 14.0013C26.8307 21.3651 20.8612 27.3346 13.4974 27.3346C6.1336 27.3346 0.164062 21.3651 0.164062 14.0013C0.164062 6.63751 6.1336 0.667969 13.4974 0.667969C20.8612 0.667969 26.8307 6.63751 26.8307 14.0013ZM9.4569 9.96083C9.84742 9.57031 10.4806 9.57031 10.8711 9.96083L13.4974 12.5871L16.1236 9.96086C16.5141 9.57034 17.1473 9.57034 17.5378 9.96086C17.9283 10.3514 17.9283 10.9846 17.5378 11.3751L14.9116 14.0013L17.5378 16.6275C17.9283 17.018 17.9283 17.6512 17.5378 18.0417C17.1472 18.4322 16.5141 18.4322 16.1235 18.0417L13.4974 15.4155L10.8711 18.0417C10.4806 18.4322 9.84745 18.4322 9.45693 18.0417C9.0664 17.6512 9.0664 17.018 9.45693 16.6275L12.0831 14.0013L9.4569 11.375C9.06637 10.9845 9.06637 10.3514 9.4569 9.96083Z"
                                        fill="#259CD5" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body py-10 px-lg-17">
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_free_subscription_scroll" data-kt-scroll="true"
                            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_free_subscription_header"
                            data-kt-scroll-wrappers="#kt_modal_free_subscription_scroll" data-kt-scroll-offset="300px">
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group mb-5 fv-row">
                                        <label class="fs-5 fw-bold mb-2">From</label>
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control form-control-solid subscription_start" required
                                                placeholder="Start Date" name="start_date" id="project_start_date" />
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    viewBox="0 0 30 30" fill="none">
                                                    <path
                                                        d="M10.75 5.75C10.75 5.33579 10.4142 5 10 5C9.58579 5 9.25 5.33579 9.25 5.75V7.32926C7.81067 7.44451 6.86577 7.72737 6.17157 8.42157C5.47737 9.11577 5.19451 10.0607 5.07926 11.5H24.9207C24.8055 10.0607 24.5226 9.11577 23.8284 8.42157C23.1342 7.72737 22.1893 7.44451 20.75 7.32926V5.75C20.75 5.33579 20.4142 5 20 5C19.5858 5 19.25 5.33579 19.25 5.75V7.2629C18.5847 7.25 17.839 7.25 17 7.25H13C12.161 7.25 11.4153 7.25 10.75 7.2629V5.75Z"
                                                        fill="#99A1B7" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5 15.25C5 14.411 5 13.6653 5.0129 13H24.9871C25 13.6653 25 14.411 25 15.25V17.25C25 21.0212 25 22.9069 23.8284 24.0784C22.6569 25.25 20.7712 25.25 17 25.25H13C9.22876 25.25 7.34315 25.25 6.17157 24.0784C5 22.9069 5 21.0212 5 17.25V15.25ZM20 17.25C20.5523 17.25 21 16.8023 21 16.25C21 15.6977 20.5523 15.25 20 15.25C19.4477 15.25 19 15.6977 19 16.25C19 16.8023 19.4477 17.25 20 17.25ZM20 21.25C20.5523 21.25 21 20.8023 21 20.25C21 19.6977 20.5523 19.25 20 19.25C19.4477 19.25 19 19.6977 19 20.25C19 20.8023 19.4477 21.25 20 21.25ZM16 16.25C16 16.8023 15.5523 17.25 15 17.25C14.4477 17.25 14 16.8023 14 16.25C14 15.6977 14.4477 15.25 15 15.25C15.5523 15.25 16 15.6977 16 16.25ZM16 20.25C16 20.8023 15.5523 21.25 15 21.25C14.4477 21.25 14 20.8023 14 20.25C14 19.6977 14.4477 19.25 15 19.25C15.5523 19.25 16 19.6977 16 20.25ZM10 17.25C10.5523 17.25 11 16.8023 11 16.25C11 15.6977 10.5523 15.25 10 15.25C9.44772 15.25 9 15.6977 9 16.25C9 16.8023 9.44772 17.25 10 17.25ZM10 21.25C10.5523 21.25 11 20.8023 11 20.25C11 19.6977 10.5523 19.25 10 19.25C9.44772 19.25 9 19.6977 9 20.25C9 20.8023 9.44772 21.25 10 21.25Z"
                                                        fill="#99A1B7" />
                                                </svg>
                                            </span>
                                        </div>
                                        <span class="text-danger mt-1" id="projectStartDate"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group mb-5 fv-row">
                                        <label class="fs-5 fw-bold mb-2">To</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-solid subscription_end"
                                                placeholder="End Date" name="end_date" id="project_end_date" />
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    viewBox="0 0 30 30" fill="none">
                                                    <path
                                                        d="M10.75 5.75C10.75 5.33579 10.4142 5 10 5C9.58579 5 9.25 5.33579 9.25 5.75V7.32926C7.81067 7.44451 6.86577 7.72737 6.17157 8.42157C5.47737 9.11577 5.19451 10.0607 5.07926 11.5H24.9207C24.8055 10.0607 24.5226 9.11577 23.8284 8.42157C23.1342 7.72737 22.1893 7.44451 20.75 7.32926V5.75C20.75 5.33579 20.4142 5 20 5C19.5858 5 19.25 5.33579 19.25 5.75V7.2629C18.5847 7.25 17.839 7.25 17 7.25H13C12.161 7.25 11.4153 7.25 10.75 7.2629V5.75Z"
                                                        fill="#99A1B7" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5 15.25C5 14.411 5 13.6653 5.0129 13H24.9871C25 13.6653 25 14.411 25 15.25V17.25C25 21.0212 25 22.9069 23.8284 24.0784C22.6569 25.25 20.7712 25.25 17 25.25H13C9.22876 25.25 7.34315 25.25 6.17157 24.0784C5 22.9069 5 21.0212 5 17.25V15.25ZM20 17.25C20.5523 17.25 21 16.8023 21 16.25C21 15.6977 20.5523 15.25 20 15.25C19.4477 15.25 19 15.6977 19 16.25C19 16.8023 19.4477 17.25 20 17.25ZM20 21.25C20.5523 21.25 21 20.8023 21 20.25C21 19.6977 20.5523 19.25 20 19.25C19.4477 19.25 19 19.6977 19 20.25C19 20.8023 19.4477 21.25 20 21.25ZM16 16.25C16 16.8023 15.5523 17.25 15 17.25C14.4477 17.25 14 16.8023 14 16.25C14 15.6977 14.4477 15.25 15 15.25C15.5523 15.25 16 15.6977 16 16.25ZM16 20.25C16 20.8023 15.5523 21.25 15 21.25C14.4477 21.25 14 20.8023 14 20.25C14 19.6977 14.4477 19.25 15 19.25C15.5523 19.25 16 19.6977 16 20.25ZM10 17.25C10.5523 17.25 11 16.8023 11 16.25C11 15.6977 10.5523 15.25 10 15.25C9.44772 15.25 9 15.6977 9 16.25C9 16.8023 9.44772 17.25 10 17.25ZM10 21.25C10.5523 21.25 11 20.8023 11 20.25C11 19.6977 10.5523 19.25 10 19.25C9.44772 19.25 9 19.6977 9 20.25C9 20.8023 9.44772 21.25 10 21.25Z"
                                                        fill="#99A1B7" />
                                                </svg>
                                            </span>
                                        </div>
                                        <span class="text-danger mt-1" id="projectEndDate"></span>
                                    </div>
                                </div>
                            </div>


                            <div class="fv-row mb-5">
                                <label for="title" class="fw-bolder pb-2 fw-600">Offer Tittle</label>
                                <input type="text" placeholder= "Title" name="title" id="title" required
                                    class="form-control form-control-solid" />
                            </div>


                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="fs-5 fw-bold mb-2">Detail</label>
                                <textarea type="text" placeholder="Description" name="description" required
                                    class="form-control form-control-solid" id="" cols="10" rows="5"></textarea>
                            </div>
                        </div>
                        <input type="hidden" placeholder="Title" name="type" value="1" />
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="submit" id="kt_modal_free_subscription_submit" class="btn btn-danger w-75">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal - Free Projects-->

    <script>
        var responseData = @json($response);


        (a = document.getElementById("kt_charts_widget_age_chart")),
        (o = parseInt(KTUtil.css(a, "height"))),
        (s = KTUtil.getCssVariableValue("--bs-gray-500")),
        (r = KTUtil.getCssVariableValue("--bs-gray-200")),
        (i = KTUtil.getCssVariableValue("--bs-danger")),
        (l = KTUtil.getCssVariableValue("--bs-gray-300")),
        a &&
            new ApexCharts(a, {
                series: [{
                    name: "Payments",
                    data: responseData.subscription_payment.last_twelve_months_payments
                }, ],
                chart: {
                    fontFamily: "inherit",
                    type: "bar",
                    height: 200,
                    toolbar: {
                        show: !1
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        columnWidth: ["30%"],
                        borderRadius: 4,
                    },
                },
                legend: {
                    show: !1
                },
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    show: !0,
                    width: 2,
                    colors: ["transparent"]
                },
                xaxis: {
                    categories: responseData.eight_months_name,
                    axisBorder: {
                        show: !1
                    },
                    axisTicks: {
                        show: !1
                    },
                    labels: {
                        style: {
                            colors: s,
                            fontSize: "12px"
                        }
                    },
                },
                yaxis: {
                    min: 0,
                    max: 100,
                    tickAmount: 5,
                    labels: {
                        style: {
                            colors: s,
                            fontSize: "12px"
                        }
                    },
                },
                fill: {
                    opacity: 1
                },
                states: {
                    normal: {
                        filter: {
                            type: "none",
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: "none",
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: !1,
                        filter: {
                            type: "none",
                            value: 0
                        },
                    },
                },
                tooltip: {
                    style: {
                        fontSize: "12px"
                    },
                    y: {
                        formatter: function(e) {
                            return e + "%";
                        },
                    },
                },
                colors: [i, l],
                grid: {
                    borderColor: r,
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: !0
                        }
                    },
                },
            }).render();

        // totall earnings graph
        (function() {
            var e,
                t = document.querySelectorAll(".earnings_graph");
            [].slice.call(t).map(function(t) {
                if (((e = parseInt(KTUtil.css(t, "height"))), t)) {
                    var a = KTUtil.getCssVariableValue("--bs-gray-800"),
                        o = KTUtil.getCssVariableValue("--bs-gray-300");
                    new ApexCharts(t, {
                        series: [{
                            name: "Net Profit",
                            data: responseData.project_payment.last_twelve_months_payments,
                        }, ],
                        grid: {
                            show: !1,
                            padding: {
                                top: 0,
                                bottom: 0,
                                left: 0,
                                right: 0,
                            },
                        },
                        chart: {
                            fontFamily: "inherit",
                            type: "area",
                            height: e,
                            toolbar: {
                                show: !1
                            },
                            zoom: {
                                enabled: !1
                            },
                            sparkline: {
                                enabled: !0
                            },
                        },
                        plotOptions: {},
                        legend: {
                            show: !1
                        },
                        dataLabels: {
                            enabled: !1
                        },
                        fill: {
                            type: "gradient",
                            gradient: {
                                opacityFrom: 0.4,
                                opacityTo: 0,
                                stops: [20, 120, 120, 120],
                            },
                        },
                        stroke: {
                            curve: "smooth",
                            show: !0,
                            width: 3,
                            colors: ["#FFFFFF"],
                        },
                        xaxis: {
                            categories: responseData.six_months_name,
                            axisBorder: {
                                show: !1
                            },
                            axisTicks: {
                                show: !1
                            },
                            labels: {
                                show: !1,
                                style: {
                                    colors: a,
                                    fontSize: "12px"
                                },
                            },
                            crosshairs: {
                                show: !1,
                                position: "front",
                                stroke: {
                                    color: o,
                                    width: 1,
                                    dashArray: 3,
                                },
                            },
                            tooltip: {
                                enabled: !0,
                                formatter: void 0,
                                offsetY: 0,
                                style: {
                                    fontSize: "12px"
                                },
                            },
                        },
                        yaxis: {
                            min: 0,
                            max: 60,
                            labels: {
                                show: !1,
                                style: {
                                    colors: a,
                                    fontSize: "12px"
                                },
                            },
                        },
                        states: {
                            normal: {
                                filter: {
                                    type: "none",
                                    value: 0
                                }
                            },
                            hover: {
                                filter: {
                                    type: "none",
                                    value: 0
                                }
                            },
                            active: {
                                allowMultipleDataPointsSelection: !1,
                                filter: {
                                    type: "none",
                                    value: 0
                                },
                            },
                        },
                        tooltip: {
                            style: {
                                fontSize: "12px"
                            },
                            y: {
                                formatter: function(e) {
                                    return e + " %";
                                },
                            },
                        },
                        colors: ["#ffffff"],
                        markers: {
                            colors: [a],
                            strokeColor: [o],
                            strokeWidth: 3,
                        },
                    }).render();
                }
            });
        })(),
        // totall user graph
        (function() {
            var e,
                t = document.querySelectorAll(".totall_users_graph");
            [].slice.call(t).map(function(t) {
                if (((e = parseInt(KTUtil.css(t, "height"))), t)) {
                    var a = KTUtil.getCssVariableValue("--bs-gray-800"),
                        o = KTUtil.getCssVariableValue("--bs-gray-300");
                    new ApexCharts(t, {
                        series: [{
                            name: "Registered",
                            data: responseData.private_users.last_twelve_months_users,
                        }, ],
                        grid: {
                            show: !1,
                            padding: {
                                top: 0,
                                bottom: 0,
                                left: 0,
                                right: 0,
                            },
                        },
                        chart: {
                            fontFamily: "inherit",
                            type: "area",
                            height: e,
                            toolbar: {
                                show: !1
                            },
                            zoom: {
                                enabled: !1
                            },
                            sparkline: {
                                enabled: !0
                            },
                        },
                        plotOptions: {},
                        legend: {
                            show: !1
                        },
                        dataLabels: {
                            enabled: !1
                        },
                        fill: {
                            type: "gradient",
                            gradient: {
                                opacityFrom: 0.4,
                                opacityTo: 0,
                                stops: [20, 120, 120, 120],
                            },
                        },
                        stroke: {
                            curve: "smooth",
                            show: !0,
                            width: 3,
                            colors: ["#FFFFFF"],
                        },
                        xaxis: {
                            categories: responseData.six_months_name,
                            axisBorder: {
                                show: !1
                            },
                            axisTicks: {
                                show: !1
                            },
                            labels: {
                                show: !1,
                                style: {
                                    colors: a,
                                    fontSize: "12px"
                                },
                            },
                            crosshairs: {
                                show: !1,
                                position: "front",
                                stroke: {
                                    color: o,
                                    width: 1,
                                    dashArray: 3,
                                },
                            },
                            tooltip: {
                                enabled: !0,
                                formatter: void 0,
                                offsetY: 0,
                                style: {
                                    fontSize: "12px"
                                },
                            },
                        },
                        yaxis: {
                            min: 0,
                            max: 60,
                            labels: {
                                show: !1,
                                style: {
                                    colors: a,
                                    fontSize: "12px"
                                },
                            },
                        },
                        states: {
                            normal: {
                                filter: {
                                    type: "none",
                                    value: 0
                                }
                            },
                            hover: {
                                filter: {
                                    type: "none",
                                    value: 0
                                }
                            },
                            active: {
                                allowMultipleDataPointsSelection: !1,
                                filter: {
                                    type: "none",
                                    value: 0
                                },
                            },
                        },
                        tooltip: {
                            style: {
                                fontSize: "12px"
                            },
                            y: {
                                formatter: function(e) {
                                    return e + " %";
                                },
                            },
                        },
                        colors: ["#ffffff"],
                        markers: {
                            colors: [a],
                            strokeColor: [o],
                            strokeWidth: 3,
                        },
                    }).render();
                }
            });
        })(),
        // total projects graph
        (function() {
            var e,
                t = document.querySelectorAll(".totall_projects_graph");
            [].slice.call(t).map(function(t) {
                e = parseInt(KTUtil.css(t, "height"));
                var a = KTUtil.getCssVariableValue("--bs-gray-800");
                new ApexCharts(t, {
                    series: [{
                        name: "Projects",
                        data: responseData.totall_projects.last_twelve_months_projects,
                    }, ],
                    chart: {
                        fontFamily: "inherit",
                        height: e,
                        type: "bar",
                        toolbar: {
                            show: !1
                        },
                    },
                    grid: {
                        show: !1,
                        padding: {
                            top: 0,
                            bottom: 0,
                            left: 0,
                            right: 0
                        },
                    },
                    colors: ["#ffffff"],
                    plotOptions: {
                        bar: {
                            borderRadius: 2.5,
                            dataLabels: {
                                position: "top"
                            },
                            columnWidth: "20%",
                        },
                    },
                    dataLabels: {
                        enabled: !1,
                        formatter: function(e) {
                            return e + "%";
                        },
                        offsetY: -20,
                        style: {
                            fontSize: "12px",
                            colors: ["#304758"]
                        },
                    },
                    xaxis: {
                        labels: {
                            show: !1
                        },
                        categories: responseData.twelve_months_name,
                        position: "top",
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1
                        },
                        crosshairs: {
                            show: !1
                        },
                        tooltip: {
                            enabled: !1
                        },
                    },
                    yaxis: {
                        show: !1,
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1,
                            background: a
                        },
                        labels: {
                            show: !1,
                            formatter: function(e) {
                                return e + "%";
                            },
                        },
                    },
                }).render();
            });
        })(),
        // totall company users graph 
        (function() {
            var e,
                t = document.querySelectorAll(".company_users_graph");
            [].slice.call(t).map(function(t) {
                e = parseInt(KTUtil.css(t, "height"));
                var a = KTUtil.getCssVariableValue("--bs-gray-800");
                new ApexCharts(t, {
                    series: [{
                        name: "Registered",
                        data: responseData.company_users.last_twelve_months_users,

                    }, ],
                    chart: {
                        fontFamily: "inherit",
                        height: e,
                        type: "bar",
                        toolbar: {
                            show: !1
                        },
                    },
                    grid: {
                        show: !1,
                        padding: {
                            top: 0,
                            bottom: 0,
                            left: 0,
                            right: 0
                        },
                    },
                    colors: ["#ffffff"],
                    plotOptions: {
                        bar: {
                            borderRadius: 2.5,
                            dataLabels: {
                                position: "top"
                            },
                            columnWidth: "20%",
                        },
                    },
                    dataLabels: {
                        enabled: !1,
                        formatter: function(e) {
                            return e + "%";
                        },
                        offsetY: -20,
                        style: {
                            fontSize: "12px",
                            colors: ["#304758"]
                        },
                    },
                    xaxis: {
                        labels: {
                            show: !1
                        },
                        categories: responseData.twelve_months_name,
                        position: "top",
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1
                        },
                        crosshairs: {
                            show: !1
                        },
                        tooltip: {
                            enabled: !1
                        },
                    },
                    yaxis: {
                        show: !1,
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1,
                            background: a
                        },
                        labels: {
                            show: !1,
                            formatter: function(e) {
                                return e + "%";
                            },
                        },
                    },
                }).render();
            });
        })(),
        // Completed Projects graph
        (function() {
            var e = document.getElementById("kt_charts_widget_3_chart"),
                t =
                (parseInt(KTUtil.css(e, "height")),
                    KTUtil.getCssVariableValue("--bs-gray-500")),
                a = KTUtil.getCssVariableValue("--bs-gray-200"),
                o = KTUtil.getCssVariableValue("--bs-danger"),
                s = KTUtil.getCssVariableValue("--bs-light-danger");
            e &&
                new ApexCharts(e, {
                    series: [{
                        name: "Projects",
                        data: responseData.completed_projects.last_twelve_months_projects,
                    }, ],
                    chart: {
                        fontFamily: "inherit",
                        type: "area",
                        height: 150,
                        toolbar: {
                            show: !1
                        },
                    },
                    plotOptions: {},
                    legend: {
                        show: !1
                    },
                    dataLabels: {
                        enabled: !1
                    },
                    fill: {
                        type: "solid",
                        opacity: 1
                    },
                    stroke: {
                        curve: "smooth",
                        show: !0,
                        width: 3,
                        colors: [o],
                    },
                    xaxis: {
                        categories: responseData.six_months_name,
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1
                        },
                        labels: {
                            style: {
                                colors: t,
                                fontSize: "12px"
                            }
                        },
                        crosshairs: {
                            position: "front",
                            stroke: {
                                color: o,
                                width: 1,
                                dashArray: 3
                            },
                        },
                        tooltip: {
                            enabled: !0,
                            formatter: void 0,
                            offsetY: 0,
                            style: {
                                fontSize: "12px"
                            },
                        },
                    },
                    yaxis: {
                        min: 0, // Start from 0
                        max: 300, // Up to 20
                        tickAmount: 3,
                        labels: {
                            style: {
                                colors: t,
                                fontSize: "12px"
                            }
                        },
                    },
                    states: {
                        normal: {
                            filter: {
                                type: "none",
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: "none",
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: !1,
                            filter: {
                                type: "none",
                                value: 0
                            },
                        },
                    },
                    tooltip: {
                        style: {
                            fontSize: "12px"
                        },
                        y: {
                            formatter: function(e) {
                                return e + " %";
                            },
                        },
                    },
                    colors: [s],
                    grid: {
                        borderColor: a,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: !0
                            }
                        },
                    },
                    markers: {
                        strokeColor: o,
                        strokeWidth: 3
                    },
                }).render();
        })(),
        // user projects & companies chart 
        (function() {
            var e = document.getElementById("kt_charts_widget_2_chart"),
                t = parseInt(KTUtil.css(e, "height")),
                a = KTUtil.getCssVariableValue("--bs-gray-500"),
                o = KTUtil.getCssVariableValue("--bs-gray-200"),
                s = KTUtil.getCssVariableValue("--bs-primary"),
                r = KTUtil.getCssVariableValue("--bs-danger");
            x = KTUtil.getCssVariableValue("--bs-success");

            e &&
                new ApexCharts(e, {
                    series: [{
                            name: "Users",
                            data: responseData.detail_graph.last_twelve_months_users,
                        },
                        {
                            name: "Projects",
                            data: responseData.detail_graph.last_twelve_months_projects,
                        },
                        {
                            name: "Companies",
                            data: responseData.detail_graph.last_twelve_months_company,
                        },
                    ],
                    chart: {
                        fontFamily: "inherit",
                        type: "bar",
                        height: t,
                        toolbar: {
                            show: !1
                        },
                    },
                    plotOptions: {
                        bar: {
                            horizontal: !1,
                            columnWidth: ["40%"],
                            borderRadius: 4,
                        },
                    },
                    legend: {
                        show: !1
                    },
                    dataLabels: {
                        enabled: !1
                    },
                    stroke: {
                        show: !0,
                        width: 2,
                        colors: ["transparent"]
                    },
                    xaxis: {
                        categories: responseData.six_months_name,
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1
                        },
                        labels: {
                            style: {
                                colors: a,
                                fontSize: "12px"
                            }
                        },
                    },
                    yaxis: {
                        min: 0,
                        max: 100,
                        tickAmount: 5,
                        labels: {
                            style: {
                                colors: a,
                                fontSize: "12px"
                            }
                        },
                    },
                    fill: {
                        opacity: 1
                    },
                    states: {
                        normal: {
                            filter: {
                                type: "none",
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: "none",
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: !1,
                            filter: {
                                type: "none",
                                value: 0
                            },
                        },
                    },
                    tooltip: {
                        style: {
                            fontSize: "12px"
                        },
                        y: {
                            formatter: function(e) {
                                return e;
                            },
                        },
                    },
                    colors: [s, r, x],
                    grid: {
                        borderColor: o,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: !0
                            }
                        },
                    },
                }).render();
        })()
    </script>

    <script>
        var responseData = @json($response);
        "use strict";
        var KTProjectList = {
            initProjectListChart: function() {
                var t = document.getElementById("kt_project_list_chart");
                if (t) {
                    var e = t.getContext("2d");
                    new Chart(e, {
                        type: "doughnut",
                        innerHeight: 200,
                        data: {
                            datasets: [{
                                data: [responseData.subscriptions.pro, responseData.subscriptions
                                    .basic, responseData.subscriptions.premium
                                ],
                                backgroundColor: [
                                    "#0092f1",
                                    "#50CD89",
                                    "#F00",
                                ],
                            }, ],
                            labels: ["Pro", "Basic", "Premium"],
                        },
                        options: {
                            chart: {
                                fontFamily: "inherit"
                            },
                            cutout: "75%",
                            cutoutPercentage: 65,
                            responsive: !0,
                            maintainAspectRatio: !1,
                            title: {
                                display: !1
                            },
                            animation: {
                                animateScale: !0,
                                animateRotate: !0
                            },
                            tooltips: {
                                enabled: !0,
                                intersect: !1,
                                mode: "nearest",
                                bodySpacing: 5,
                                yPadding: 10,
                                xPadding: 10,
                                caretPadding: 0,
                                displayColors: !1,
                                backgroundColor: "#20D489",
                                titleFontColor: "#ffffff",
                                cornerRadius: 4,
                                footerSpacing: 0,
                                titleSpacing: 0,
                            },
                            plugins: {
                                legend: {
                                    display: !1
                                }
                            },
                        },
                    });
                }
            },
        };

        // Call the init function when the DOM is ready
        document.addEventListener("DOMContentLoaded", function() {
            KTProjectList.initProjectListChart();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize Flatpickr for "From" input
            flatpickr(".subscription_start", {
                dateFormat: "M d, Y",
                mode: "single",
                minDate: "today"
            });

            // Initialize Flatpickr for "To" input
            flatpickr(".subscription_end", {
                dateFormat: "M d, Y",
                mode: "single",
                minDate: "today"
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('kt_modal_free_subscription_form');
            var endDateInput = document.getElementById('end_date');
            var startDateInput = document.getElementById('start_date');

            var subscriptionEndDateError = document.getElementById('subscriptionEndDate');
            var subscriptionStartDateError = document.getElementById('subscriptionStartDate');


            form.addEventListener('submit', function(event) {
                if (!endDateInput.value.trim()) {
                    subscriptionEndDateError.textContent = 'Please select the End Date.';
                    event.preventDefault(); // Prevent form submission
                } else {
                    subscriptionEndDateError.textContent =
                        ''; // Clear the error message if the field is not empty
                }

                if (!startDateInput.value.trim()) {
                    subscriptionStartDateError.textContent = 'Please select the Start Date.';
                    event.preventDefault(); // Prevent form submission
                } else {
                    subscriptionStartDateError.textContent =
                        ''; // Clear the error message if the field is not empty
                }

            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('kt_modal_free_projects_form');
            var projectEndDateInput = document.getElementById('project_end_date');
            var projectStartDateInput = document.getElementById('project_start_date');

            var projectEndDateError = document.getElementById('projectEndDate');
            var projectStartDateError = document.getElementById('projectStartDate');

            form.addEventListener('submit', function(event) {
                if (!projectEndDateInput.value.trim()) {
                    projectEndDateError.textContent = 'Please select the End Date.';
                    event.preventDefault();
                } else {
                    projectEndDateError.textContent = '';
                }

                if (!projectStartDateInput.value.trim()) {
                    projectStartDateError.textContent = 'Please select the Start Date.';
                    event.preventDefault();
                } else {
                    projectStartDateError.textContent = '';
                }
            });
        });
    </script>
@endsection
