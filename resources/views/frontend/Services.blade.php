@extends('frontend.layout.master')
<style>
    .title {
        color: #7B849A;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 16.77px;
        /* 119.786% */
    }

    .int {
        color: #373A4A;
        font-size: 24px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .button-container {
        display: flex;
        align-items: center;
    }

    .button-container .btn {
        margin-right: 10px;
        /* Adjust the margin between buttons */
    }


    .edit-btn {
        display: flex;
        padding: 5px 10px;
        align-items: center;
        gap: 5px;
        border-radius: 5px;
        background: #259CD5;
    }

    .delete-btn {
        display: flex;
        padding: 5px 10px;
        align-items: center;
        gap: 10px;
        border-radius: 5px;
        background: #F00;
    }

    .tbl-head {
        color: #303030;
        text-align: right;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 18.525px;
        /* 115.781% */
        text-transform: capitalize;
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
                <h1 class="d-flex flex-column text-dark fw-bolder my-0 fs-1">{{ $category->name }}
                </h1>
    
                <p class="title pt-1">
                    @if (count($totall) <= 1)
                        Total Service:
                    @else
                        Total Services:
                    @endif
                    <span class="text-muted fs-3"> {{ count($totall) }}</span>
                </p>
                <!--end::Heading-->
            </div>
    
            <div>
                <button type="button" class="btn btn-primary me-3" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_add_interests">
                    Add Service</button>
            </div>
            <!--end::Page title=-->
    
        </div>
    


    </div>
    <!--end::Header-->


   
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-fluid" id="">
            <!--begin::Table-->
            @if (count($data))
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed" id="userTable">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="text-start tbl-head">
                                <th class="min-w-125px ">Sr No</th>
                                <th class="min-w-125px ">Service Name</th>
                                <th class="min-w-125px text-end">Action</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fs-6 fw-bold ">
                            @php
                                $serialNumber = 1;
                            @endphp
                            @foreach ($data as $index => $row)
                                <tr>
                                    <td class="text-muted">
                                        {{ str_pad($index + 1 + ($data->currentPage() - 1) * $data->perPage(), 2, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="">
                                        {{ $row->name }}
                                    </td>
                                    <td class="button-container text-end d-flex align-content-end justify-content-end">
                                        <button type="button" class="btn  btn-primary text-light edit-btn p-0"
                                            style="height: 40px;
                                        width: 100px;"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_update_interests"
                                            data-interest-id="{{ $row->id }}" data-interest-name="{{ $row->name }}">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5 19.9984C5 19.6671 5.26863 19.3984 5.6 19.3984H18.4C18.7314 19.3984 19 19.6671 19 19.9984C19 20.3298 18.7314 20.5984 18.4 20.5984H5.6C5.26863 20.5984 5 20.3298 5 19.9984Z"
                                                        fill="white" />
                                                    <path
                                                        d="M10.8599 15.0561C11.0635 14.8972 11.2483 14.7125 11.6176 14.3432L16.351 9.60981C15.7068 9.34168 14.9438 8.90125 14.2221 8.17964C13.5004 7.45791 13.06 6.69477 12.7919 6.0505L8.05841 10.7839L8.05838 10.784C7.68903 11.1533 7.50433 11.338 7.3455 11.5417C7.15813 11.7819 6.99749 12.0418 6.86642 12.3168C6.75531 12.55 6.67272 12.7977 6.50752 13.2933L5.63641 15.9067C5.55512 16.1505 5.61859 16.4194 5.80037 16.6012C5.98214 16.783 6.25102 16.8465 6.4949 16.7652L9.10824 15.894C9.60381 15.7289 9.85161 15.6463 10.0847 15.5351C10.3598 15.4041 10.6197 15.2434 10.8599 15.0561Z"
                                                        fill="white" />
                                                    <path
                                                        d="M17.6644 8.29636C18.6473 7.31351 18.6473 5.71999 17.6644 4.73714C16.6816 3.75429 15.0881 3.75429 14.1052 4.73714L13.5375 5.30484C13.5453 5.32832 13.5533 5.35212 13.5617 5.37623C13.7698 5.976 14.1624 6.76225 14.901 7.50081C15.6395 8.23938 16.4258 8.63199 17.0256 8.84008C17.0496 8.8484 17.0732 8.85643 17.0966 8.86417L17.6644 8.29636Z"
                                                        fill="white" />
                                                </svg>
                                            </span>
                                            Edit</button>
                                        {{-- <button type="button" style="height: 40px; width: 100px;"
                                            class="btn btn-danger delete-btn text-light delete-interest p-0"
                                            data-interest-id="{{ $row->id }}">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M4.80078 7.61905C4.80078 7.30346 5.06215 7.04762 5.38456 7.04762H9.21508C9.22028 6.37464 9.29322 5.45203 9.96108 4.81334C10.4867 4.31071 11.2072 4 12.0008 4C12.7943 4 13.5149 4.31071 14.0405 4.81334C14.7083 5.45203 14.7813 6.37464 14.7865 7.04762H18.617C18.9394 7.04762 19.2008 7.30346 19.2008 7.61905C19.2008 7.93464 18.9394 8.19048 18.617 8.19048H5.38456C5.06215 8.19048 4.80078 7.93464 4.80078 7.61905Z"
                                                        fill="white" />
                                                    <path
                                                        d="M11.686 20H12.3156C14.4816 20 15.5646 20 16.2687 19.3094C16.9729 18.6189 17.0449 17.4861 17.189 15.2206L17.3966 11.9562C17.4748 10.7269 17.5139 10.1123 17.1606 9.72281C16.8074 9.33333 16.2108 9.33333 15.0177 9.33333H8.98385C7.79078 9.33333 7.19424 9.33333 6.84099 9.72281C6.48774 10.1123 6.52683 10.7269 6.60501 11.9562L6.81261 15.2206C6.95669 17.4861 7.02873 18.6189 7.73288 19.3094C8.43703 20 9.52003 20 11.686 20Z"
                                                        fill="white" />
                                                </svg>
                                            </span>Delete
                                        </button> --}}
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
                        src="{{ url('frontend/media/NoService.png') }}" class="img-fluid ">
                </div>
            @endif

        </div>
        <!--end::Container-->
        <div class=" d-flex justify-content-end pb-5">
            {!! $data->onEachSide(1)->links() !!}
        </div>
        <!--begin::Modal - interests - Add-->
        <div class="modal fade" id="kt_modal_add_interests" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header pb-0 border-0 d-f justify-content-between">
                        <!--begin::Close-->
                        <p>

                        </p>

                        <p class="int fw-bold">
                            Add Service
                        </p>
                        <div class="btn btn-sm btn-icon btn-active-color-dark" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->

                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M17.4735 10.8068C17.4735 14.4887 14.4887 17.4735 10.8068 17.4735C7.1249 17.4735 4.14014 14.4887 4.14014 10.8068C4.14014 7.1249 7.1249 4.14014 10.8068 4.14014C14.4887 4.14014 17.4735 7.1249 17.4735 10.8068ZM8.78655 8.78657C8.98182 8.59131 9.2984 8.59131 9.49366 8.78657L10.8068 10.0997L12.1199 8.78658C12.3152 8.59132 12.6317 8.59132 12.827 8.78658C13.0223 8.98185 13.0223 9.29843 12.827 9.49369L11.5139 10.8068L12.827 12.1199C13.0222 12.3152 13.0222 12.6317 12.827 12.827C12.6317 13.0223 12.3151 13.0223 12.1199 12.827L10.8068 11.5139L9.49368 12.827C9.29841 13.0223 8.98183 13.0223 8.78657 12.827C8.59131 12.6317 8.59131 12.3152 8.78657 12.1199L10.0997 10.8068L8.78655 9.49368C8.59129 9.29841 8.59129 8.98183 8.78655 8.78657Z"
                                        fill="#252F4A" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--begin::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body  pt-4 mx-0">
                        <!--begin::Input group-->
                        <form action="AddService/{{ $id }}" method="get" class="form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="fv-row mb-5">
                                <!--begin::Input-->
                                <label for="name" class="fw-bold fs-6 pb-2 fw-600">Service Name</label> <input
                                    type="text" class="form-control form-control-solid" placeholder="Enter Service Name"
                                    name="name" required />
                                <!--end::Input-->
                            </div>
                            {{-- <input type="hidden" name="interest_id" id="interestId" value=""> --}}
                            <div class="d-flex justify-content-center align-content-center pt-2 ">
                                <!--begin::Button-->
                                <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
                                    <span class="indicator-label">Save</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <!--end::Button-->
                            </div>
                            <!--end::Input group-->
                        </form>
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - interests - Add-->


        <!--begin::Modal - interests - Update-->
        <div class="modal fade" id="kt_modal_update_interests" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header pb-0 border-0 d-f justify-content-between">
                        <!--begin::Close-->
                        <p>

                        </p>
                        <p class="int">
                            Update Service
                        </p>
                        <div class="btn btn-sm btn-icon btn-active-color-dark" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->

                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                    viewBox="0 0 21 21" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M17.4735 10.8068C17.4735 14.4887 14.4887 17.4735 10.8068 17.4735C7.1249 17.4735 4.14014 14.4887 4.14014 10.8068C4.14014 7.1249 7.1249 4.14014 10.8068 4.14014C14.4887 4.14014 17.4735 7.1249 17.4735 10.8068ZM8.78655 8.78657C8.98182 8.59131 9.2984 8.59131 9.49366 8.78657L10.8068 10.0997L12.1199 8.78658C12.3152 8.59132 12.6317 8.59132 12.827 8.78658C13.0223 8.98185 13.0223 9.29843 12.827 9.49369L11.5139 10.8068L12.827 12.1199C13.0222 12.3152 13.0222 12.6317 12.827 12.827C12.6317 13.0223 12.3151 13.0223 12.1199 12.827L10.8068 11.5139L9.49368 12.827C9.29841 13.0223 8.98183 13.0223 8.78657 12.827C8.59131 12.6317 8.59131 12.3152 8.78657 12.1199L10.0997 10.8068L8.78655 9.49368C8.59129 9.29841 8.59129 8.98183 8.78655 8.78657Z"
                                        fill="#252F4A" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--begin::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body  pt-4 mx-0">
                        <!--begin::Input group-->
                        <form action="{{ route('service_update', ['id' => 'interest_id']) }}" method="post"
                            class="form" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <!-- Add a hidden input field to carry the interest ID -->
                            <input type="hidden" name="interest_id" id="interestId" value="">
                            <div class="fv-row mb-5">
                                <!--begin::Input-->
                                <label for="name" class="fw-bold fs-6 pb-2 fw-600">Service Name</label>
                                <input type="text" class="form-control form-control-solid" placeholder=""
                                    name="name" id="interestName" />

                                <!--end::Input-->
                            </div>

                            <div class="d-flex justify-content-center align-content-center pt-2 ">
                                <!--begin::Button-->
                                <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
                                    <span class="indicator-label">Update</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <!--end::Button-->
                            </div>
                            <!--end::Input group-->
                        </form>
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - interests - Update-->

        {{-- script  --}}

        <script>
            $(document).ready(function() {
                $('#kt_modal_update_interests').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var interestId = button.data('interest-id');
                    var interestName = button.data('interest-name');
                    console.log(interestId, interestName);

                    var modal = $(this);

                    modal.find('#interestId').val(interestId);
                    modal.find('#interestName').val(interestName);

                    var form = modal.find('form');
                    var actionUrl = form.attr('action');
                    actionUrl = actionUrl.replace('interest_id', interestId);
                    form.attr('action', actionUrl);
                });
            });


            $(document).ready(function() {
                $('.delete-interest').click(function() {
                    var interestId = $(this).data('interest-id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to recover this data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "GET",
                                url: 'service_destroy/' + interestId,
                                success: function(response) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'Service has been deleted.',
                                        icon: 'success',
                                        showConfirmButton: false,
                                        timer: 700,
                                        onClose: () => {
                                            location
                                                .reload();
                                        }
                                    });
                                },
                                error: function(error) {
                                    Swal.fire('Error', 'Something went wrong.', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>
    </div>
    <!--end::Container-->


@endsection
