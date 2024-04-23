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
        /* Adjust the max-width based on your requirements */
    }

    .select2-container--bootstrap5 .select2-dropdown .select2-results__option.select2-results__option--highlighted {
    background-color: #f1faff;
    color: #f70004;
    transition: color .2s ease,background-color .2s ease;
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
                <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">All Projects
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
                    <!--begin::Card title-->
                    <div class=" mb-5">
                        <!--begin::Title-->
                        <h3 class="mt-4" style=" font-weight:400; ">Total Projects: <span class="fs-5" id="user-count"
                                style="font-weight:500 "> </span> </h3>
                        <!--end::Title-->

                    </div>

                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar mb-5">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-between " data-kt-user-table-toolbar="base">

                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative ">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                            rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <input type="text" id="global-search"
                                    class="form-control form-control-solid w-250px ps-14" placeholder="Search" />
                            </div>
                            <!--end::Search-->
                            <div style="margin-left:10px;">
                                <!--begin::Filter-->
                                <button type="button" class="btn btn-light-danger me-3" data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->Filter</button>
                                <!--begin::Menu 1-->
                                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-dark fw-bolder">Sort By</div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Separator-->
                                    <!--begin::Content-->
                                    <div class="px-7 py-5" data-kt-user-table-filter="form">
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <label class="form-label fs-6 fw-bold">Status:</label>
                                            <select id="request-date-filter" class="form-select form-select-solid fw-bolder text-danger"
                                                data-kt-select2="true" data-placeholder="Select option"
                                                data-allow-clear="true" data-kt-user-table-filter="role"
                                                data-hide-search="true">
                                                <option></option>
                                                <option class="text-hover-danger" value="open">Open</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="reset" id="reset-filter-button"
                                                class="btn btn-light btn-active-light-danger fw-bold me-2 px-6"
                                                data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>

                                            <button type="submit" id="apply-filter-button"
                                                class="btn btn-danger fw-bold px-6" data-kt-menu-dismiss="true"
                                                data-kt-user-table-filter="filter">Apply</button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Menu 1-->
                                <!--end::Filter-->
                            </div>
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none"
                            data-kt-user-table-toolbar="selected">
                            <div class="fw-bolder me-5">
                                <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                            </div>
                            <button type="button" class="btn btn-danger"
                                data-kt-user-table-select="delete_selected">Delete
                                Selected</button>
                        </div>
                        <!--end::Group actions-->

                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->

                <div class="card-header border-0">
                    <div class="d-flex overflow-auto h-55px pb-1">
                        <ul
                            class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                            <!--begin::Nav item-->
                            <li class="nav-item">
                                <a class="nav-link text-active-danger me-6 {{ Request::is('AllProjects') ? 'active' : null }}"
                                    href="{{ URL::to('AllProjects') }}">Companies</a>
                            </li>
                            <!--end::Nav item-->
                            <!--begin::Nav item-->
                            <li class="nav-item">
                                <a class="nav-link text-active-danger me-6 {{ Request::is('UserProject') ? 'active' : null }}"
                                    href="{{ URL::to('UserProject') }}">Private Users</a>
                            </li>
                            <!--end::Nav item-->

                            <!--end::Nav item-->
                        </ul>
                    </div>
                </div>


                <!--begin::Card body-->
                <div class="card-body pt-0">
                    @if (count($projects))
                        <!--begin::Table-->
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-dark fw-bold fs-7 text-uppercase gs-0">

                                        <th class="min-w-325px">Project Name</th>
                                        <th class="min-w-125px">Uploaded At</th>
                                        <th class="min-w-125px">Estimated Time</th>
                                        <th class="min-w-125px">Company Type</th>
                                        <th class="min-w-125px">Status</th>
                                        <th class="text-center min-w-125px">Action</th>
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
                                src="{{ url('frontend/media/noProjectFound.png') }}" class="img-fluid ">
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

    function loadVerificationData(page, search = '', sortingOption = '') {
        $('#loader').removeClass('d-none');
        $.ajax({
            url: '{{ route('CompanyProjects') }}?page=' + page + '&search=' + search + '&sorting=' +
                sortingOption,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                var users = response.users;
                var tableBody = $('#verification-table-body');
                var userCount = response.userCount;
                $('#user-count').text(userCount);

                tableBody.empty();

                if (users.data.length === 0) {
                    // If no project found, display a message in a new row
                    var noUserRow = `
            <tr>
                <td colspan="6" class="text-center pt-10 fw-bolder fs-2">No Project found</td>
            </tr>
        `;
                    tableBody.append(noUserRow);
                } else {
                    var count = 0;
                    $.each(users.data, function(index, row) {
                        var companyTypeNames = row.company_types.map(function(company_type) {
                            return company_type.name;
                        });

                        var companyTypeHtml = companyTypeNames.join(' | ');

                        var newRow = `
                    <tr>
                        <td class="d-flex align-items-center">
                            ${row.image ? `
                                <div class="symbol symbol-50px overflow-hidden me-3">
                                    <div class="symbol-label">
                                        <img src="{{ asset('storage/') }}/${row.image}" alt="image" class="w-100" />
                                    </div>
                                </div>` : `
                                <div class="symbol symbol-50px overflow-hidden me-3">
                                    <div class="symbol-label">
                                        <img src="{{ url('frontend/media/Buildings.png') }}" alt="image" class="w-100" />
                                    </div>
                                </div>`}

                            <div class="d-flex flex-column">
                                <div class="text-gray-800 text-hover-primary cursor-pointer mb-1">
                                    ${row.name}
                                </div>
                                <span>
                                    <div class="text-muted  fs-6 pt-1" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px;">
                                        ${row.location}
                                    </div>
                                </span>
                            </div>
                        </td>
                        <td>${row.uploaded_at}</td>
                        <td>${row.time}</td>
                        <td>
                            <div class="text-muted  fs-6 pt-1" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px;">
                                ${companyTypeHtml}
                            </div>
                        </td>
                        <td class="">
                            ${row.status == 1 ?
                                    `<a class="link-primary fw-bolder fs-6">Open</a>` :
                                    row.status == 2 ?
                                    `<a class="link-warning fw-bolder fs-6">In Progress</a>` :
                                    `<a class="link-success fw-bolder fs-6">Completed</a>`}


                            
                        </td>
                        <td class="text-end">
                            <div class="fs-5 fw-bolder text-dark">
                                <a href="{{ URL::to('CompanyProjectDetail') }}/${row.id}" class="link-danger fw-bolder">
                                    View Details
                                </a>
                            </div>
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
        var searchTerm = $('#global-search').val();
        var sortingOption = $('#request-date-filter').val();
        loadVerificationData(currentPage, searchTerm, sortingOption);
    });
    $(document).on('click', '#apply-filter-button', function(e) {
        e.preventDefault();
        var currentPage = 1;
        var searchTerm = $('#global-search').val();
        var sortingOption = $('#request-date-filter').val();
        loadVerificationData(currentPage, searchTerm, sortingOption);
    });

    $(document).on('click', '#reset-filter-button', function(e) {
        e.preventDefault();
        $('#request-date-filter').val('').trigger('change');
        loadVerificationData(currentPage);
    });
    $(document).ready(function() {
        // Handle global search input
        $('#global-search').on('input', function() {
            var searchTerm = $(this).val();
            loadVerificationData(currentPage, searchTerm);
        });
    });
    $(document).ready(function() {
        loadVerificationData(currentPage);
    });
</script>
