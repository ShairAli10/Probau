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
                <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">User Detail
                </h1>
                <!--end::Heading-->
            </div>
            <!--end::Page title=-->
            <div class="d-flex ">
                <a href="{{ URL::to('UserPayment/' . $response['user']->id) }}">
                    <button type="button" class="btn btn-primary rounded-1 px-8 py-2">Payment History</button>
                </a>

                @if ($response['deleteRequest'] == true)
                    <a href="{{ URL::to('DeleteUser/' . $response['user']->id) }}">
                        <button type="button" class="btn btn-danger rounded-1 px-8 py-2 ms-4">Delete</button>
                    </a>
                @endif
            </div>


        </div>
        <!--end::Container-->
    </div>
    <!--end::Header-->

    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-fluid" id="">
            <div class="row g-5 g-xl-8">
                {{-- user detail --}}
                <div class="col-xl-6">
                    <div class="d-flex flex-wrap flex-sm-nowrap mb-4">
                        <!--begin: Pic-->
                        <div class="me-7 mb-4">
                            @if ($response['user']->profile_pic == '')
                                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                    <img src="{{ url('frontend/media/blank.png') }}" alt="image"
                                        style="height: 70px; width: 70px; object-fit:cover;" />
                                </div>
                            @else
                                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                    <img src="{{ asset('storage/' . $response['user']->profile_pic) }}"
                                        style=" height: 70px; width:70px;  object-fit: cover; " />

                                </div>
                            @endif

                        </div>
                        <!--end::Pic-->
                        <div class="flex-grow-1">
                            <div class="">
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center">
                                        <a class="text-gray-900 text-hover-primary fs-1 fw-bolder me-1">
                                            {{ $response['user']->name }}
                                        </a>
                                    </div>
                                </div>
                                <div class="fs-4 fw-bold text-muted">
                                    {{ $response['user']->email }}
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="fs-2 fw-bold pb-7">
                        Details
                    </div>

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold text-muted fs-5">Phone Number</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6">
                            <span class="fw-bold fs-6 text-gray-800">{{ $response['user']->phone }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold text-muted fs-5">Registration Date</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6">
                            <span
                                class="fw-bold fs-6 text-gray-800">{{ \Carbon\Carbon::parse($response['user']->created_at)->format('Y-m-d') }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold text-muted fs-5">Total Projects</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6">
                            <span class="fw-bold fs-6 text-gray-800">{{ count($response['user']['Projects']) }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-6 fw-bold text-muted fs-5">Address</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-6">
                            <span
                                class="fw-bold fs-6 text-gray-800">{{ strlen($response['user']->location) > 89 ? substr($response['user']->location, 0, 89) . '...' : $response['user']->location }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
                {{-- Graph --}}
                <div class="col-xl-6">
                    <div class="card card-xl-stretch mb-xl-8" style="">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <!--begin::Title-->
                            <h3 class="card-title align-items-start">
                                <span class="card-label fw-bold fs-1">{{ count($response['user']['Projects']) }}</span>
                                <span
                                    class="badge badge-light-danger fw-bolder pt-2">+{{ $response['graph_data']['this_month_projects_percentage'] }}%</span>
                            </h3>
                            <!--end::Title-->
                            <h3 class="card-title align-items-end flex-column">
                                <span class="card-label fw-bold text-muted fs-3 ">Total Projects</span>
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

                {{-- Projects --}}

                {{-- <a href="{{ URL::to('ProjectDetail/' . $row['id']) }}"> --}}

            </div>
            <div class="fs-1 fw-bolder pb-7">
                My Projects
            </div>
            <div class="card-body pt-0">
                @if (count($response['projects']))
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-dark fw-bold fs-7 text-uppercase gs-0">

                                    <th class="min-w-325px">Project Name</th>
                                    <th class="min-w-175px">Uploaded Date</th>
                                    <th class="min-w-125px">estimated Time</th>
                                    <th class="min-w-125px">Company Type</th>
                                    <th class="min-w-125px">Status</th>
                                    <th class="text-center min-w-100px">Action</th>
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
                            src="{{ url('frontend/media/noProject.png') }}" class="img-fluid ">
                    </div>
                @endif
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Content-->
    <script>
        var responseData = @json($response['graph_data']);
        console.log(responseData);
        (a = document.getElementById("kt_charts_widget_age_chart")),
        (o = parseInt(KTUtil.css(a, "height"))),
        (s = KTUtil.getCssVariableValue("--bs-gray-500")),
        (r = KTUtil.getCssVariableValue("--bs-gray-200")),
        (i = KTUtil.getCssVariableValue("--bs-danger")),
        (l = KTUtil.getCssVariableValue("--bs-gray-300")),
        a &&
            new ApexCharts(a, {
                series: [{
                    name: "Projects",
                    data: responseData.months_projects
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
                    categories: responseData.months,
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
                    min: 02,
                    max: 10,
                    tickAmount: 4,
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
                            return e + " Projects";
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
    </script>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var user_id = @json($id);

    var currentPage = 1;

    function loadVerificationData(page, search = '', sortingOption = '') {
        $('#loader').removeClass('d-none');
        $.ajax({
            url: '{{ route('ProjectsAgaintsUser', ['id' => ':id']) }}'.replace(':id', user_id) + '?page=' +
                page + '&search=' + search + '&sorting=' +
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
                    var badgeColors = ['text-warning', 'text-danger', 'text-primary', 'text-success'];
                    var bgColors = ['bg-light-warning', 'bg-light-danger', 'bg-light-primary',
                        'bg-light-success'
                    ];
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
                        <td class= "truncate">${row.uploaded_at}</td>
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
                                <a href="{{ URL::to('ProjectDetail') }}/${row.id}" class="link-danger fw-bolder">
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
