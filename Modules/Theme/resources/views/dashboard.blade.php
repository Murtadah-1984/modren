@extends('theme::layouts.app')

@section('content')

        <!-- Content -->
        <div class="container-lg">
            <!-- Page content -->
            <div class="row align-items-center">
                <div class="col-12 col-md-auto order-md-1 d-flex align-items-center justify-content-center mb-4 mb-md-0">
                    <div class="avatar text-info me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fs-4 duo-icon duo-icon-world" data-duoicon="world"><path fill="currentColor" d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2Z" class="duoicon-secondary-layer" opacity=".3"></path><path fill="currentColor" d="M12 4a7.988 7.988 0 0 0-6.335 3.114l-.165.221V9.02c0 1.25.775 2.369 1.945 2.809l.178.06 1.29.395c1.373.42 2.71-.697 2.577-2.096l-.019-.145-.175-1.049a1 1 0 0 1 .656-1.108l.108-.03.612-.14a2.667 2.667 0 0 0 1.989-3.263A7.987 7.987 0 0 0 12 4Zm2 9.4-1.564 1.251a.5.5 0 0 0-.041.744l1.239 1.239c.24.24.415.538.508.864l.175.613c.147.521.52.948 1.017 1.163a8.026 8.026 0 0 0 2.533-1.835l-.234-1.877a2 2 0 0 0-1.09-1.54l-1.47-.736A1 1 0 0 0 14 13.4Z" class="duoicon-primary-layer"></path></svg>
                    </div>
                    San Francisco, CA –&nbsp;<span>8:00 PM</span>
                </div>
                <div class="col-12 col-md order-md-0 text-center text-md-start">
                    <h1>Hello, John</h1>
                    <p class="fs-lg text-body-secondary mb-0">Here's a summary of your account activity for this week.</p>
                </div>
            </div>

            <!-- Divider -->
            <hr class="my-8">

            <!-- Stats -->
            <div class="row mb-8">
                <div class="col-12 col-md-6 col-xxl-3 mb-4 mb-xxl-0">
                    <div class="card bg-body-tertiary border-transparent">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <!-- Heading -->
                                    <h4 class="fs-sm fw-normal text-body-secondary mb-1">Earned</h4>

                                    <!-- Text -->
                                    <div class="fs-4 fw-semibold">$1,250</div>
                                </div>
                                <div class="col-auto">
                                    <!-- Avatar -->
                                    <div class="avatar avatar-lg bg-body text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fs-4 duo-icon duo-icon-credit-card" data-duoicon="credit-card"><path fill="currentColor" d="M22 10v7a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-7h20Z" class="duoicon-secondary-layer" opacity=".3"></path><path fill="currentColor" d="M19 4a3 3 0 0 1 3 3v1H2V7a3 3 0 0 1 3-3h14Zm-1 10h-3a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2Z" class="duoicon-primary-layer"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xxl-3 mb-4 mb-xxl-0">
                    <div class="card bg-body-tertiary border-transparent">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <!-- Heading -->
                                    <h4 class="fs-sm fw-normal text-body-secondary mb-1">Hours logged</h4>

                                    <!-- Text -->
                                    <div class="fs-4 fw-semibold">35.5 hrs</div>
                                </div>
                                <div class="col-auto">
                                    <!-- Avatar -->
                                    <div class="avatar avatar-lg bg-body text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fs-4 duo-icon duo-icon-clock" data-duoicon="clock"><path fill="currentColor" d="M12 4c6.928 0 11.258 7.5 7.794 13.5A8.998 8.998 0 0 1 12 22C5.072 22 .742 14.5 4.206 8.5A8.998 8.998 0 0 1 12 4Z" class="duoicon-secondary-layer" opacity=".3"></path><path fill="currentColor" d="M7.366 2.971A1 1 0 0 1 7 4.337a10.063 10.063 0 0 0-2.729 2.316 1 1 0 1 1-1.544-1.27 12.046 12.046 0 0 1 3.271-2.777 1 1 0 0 1 1.367.365h.001ZM18 2.606a12.044 12.044 0 0 1 3.272 2.776 1 1 0 0 1-1.544 1.27 10.042 10.042 0 0 0-2.729-2.315 1 1 0 0 1 1.002-1.731H18ZM12 8a1 1 0 0 0-.993.883L11 9v3.986c-.003.222.068.44.202.617l.09.104 2.106 2.105a1 1 0 0 0 1.498-1.32l-.084-.094L13 12.586V9a1 1 0 0 0-1-1Z" class="duoicon-primary-layer"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xxl-3 mb-4 mb-md-0">
                    <div class="card bg-body-tertiary border-transparent">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <!-- Heading -->
                                    <h4 class="fs-sm fw-normal text-body-secondary mb-1">Avg. time</h4>

                                    <!-- Text -->
                                    <div class="fs-4 fw-semibold">2:55 hrs</div>
                                </div>
                                <div class="col-auto">
                                    <!-- Avatar -->
                                    <div class="avatar avatar-lg bg-body text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fs-4 duo-icon duo-icon-slideshow" data-duoicon="slideshow"><path fill="currentColor" d="M21 3a1 1 0 1 1 0 2v11a2 2 0 0 1-2 2h-5.055l2.293 2.293a1 1 0 0 1-1.414 1.414l-2.829-2.828-2.828 2.828a1 1 0 0 1-1.414-1.414L10.046 18H5a2 2 0 0 1-2-2V5a1 1 0 1 1 0-2h18Z" class="duoicon-secondary-layer" opacity=".3"></path><path fill="currentColor" d="M8 11a1 1 0 0 0-1 1v1a1 1 0 1 0 2 0v-1a1 1 0 0 0-1-1Zm4-2a1 1 0 0 0-1 1v3a1 1 0 1 0 2 0v-3a1 1 0 0 0-1-1Zm4-2a1 1 0 0 0-.993.883L15 8v5a1 1 0 0 0 1.993.117L17 13V8a1 1 0 0 0-1-1Z" class="duoicon-primary-layer"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xxl-3">
                    <div class="card bg-body-tertiary border-transparent">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <!-- Heading -->
                                    <h4 class="fs-sm fw-normal text-body-secondary mb-1">Weekly growth</h4>

                                    <!-- Text -->
                                    <div class="fs-4 fw-semibold">14.5%</div>
                                </div>
                                <div class="col-auto">
                                    <!-- Avatar -->
                                    <div class="avatar avatar-lg bg-body text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fs-4 duo-icon duo-icon-discount" data-duoicon="discount"><path fill="currentColor" fill-rule="evenodd" d="M9.405 2.897a4 4 0 0 1 5.02-.136l.17.136.376.32c.274.234.605.389.96.45l.178.022.493.04a4 4 0 0 1 3.648 3.468l.021.2.04.494c.028.358.153.702.36.996l.11.142.322.376a4 4 0 0 1 .136 5.02l-.136.17-.321.376a1.997 1.997 0 0 0-.45.96l-.022.178-.039.493a4 4 0 0 1-3.468 3.648l-.201.021-.493.04a2.002 2.002 0 0 0-.996.36l-.142.111-.377.32a4 4 0 0 1-5.02.137l-.169-.136-.376-.321a1.997 1.997 0 0 0-.96-.45l-.178-.021-.493-.04a4 4 0 0 1-3.648-3.468l-.021-.2-.04-.494a2.002 2.002 0 0 0-.36-.996l-.111-.142-.321-.377a4 4 0 0 1-.136-5.02l.136-.169.32-.376c.234-.274.389-.605.45-.96l.022-.178.04-.493A4 4 0 0 1 7.197 3.75l.2-.021.494-.04c.358-.028.702-.153.996-.36l.142-.111.376-.32v-.001Z" class="duoicon-secondary-layer" opacity=".3"></path><path fill="currentColor" fill-rule="evenodd" d="M9.5 8a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Zm4.793.293-6 6a1 1 0 1 0 1.414 1.414l6-6a1 1 0 0 0-1.414-1.414ZM14.5 13a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" class="duoicon-primary-layer"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-xxl-8">
                    <!-- Performance -->
                    <div class="card mb-6">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="fs-6 mb-0">Performance</h3>
                                </div>
                                <div class="col-auto fs-sm me-n3">
                                    <span class="material-symbols-outlined text-primary me-1">circle</span>
                                    Total
                                </div>
                                <div class="col-auto fs-sm">
                                    <span class="material-symbols-outlined text-dark me-1">circle</span>
                                    Tracked
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas class="chart-canvas" id="userPerformanceChart" style="display: block; box-sizing: border-box; height: 350px; width: 806px;" width="1210" height="525"></canvas>
                                <div id="chart-tooltip" role="tooltip" class="popover bs-popover-top" style="visibility: hidden; left: 751.786px; top: 66.205px; transform: translateX(-50%) translateY(-100%) translateY(-1rem);"><div class="popover-arrow translate-middle-x"></div><div class="popover-content"><h3 class="popover-header"><span class="d-block text-center text-nowrap">Sun</span></h3><div class="popover-body d-flex flex-column gap-1"><div class="d-flex text-nowrap justify-content-left"><span class="material-symbols-outlined me-1" style="color: rgb(0, 85, 255);">circle</span><span>Total: 8hrs</span></div><div class="d-flex text-nowrap justify-content-left"><span class="material-symbols-outlined me-1" style="color: rgb(233, 234, 237);">circle</span><span>Tracked: 5.2hrs</span></div></div></div></div></div>
                        </div>
                    </div>

                    <!-- Projects -->
                    <div class="card mb-6 mb-xxl-0">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="fs-6 mb-0">Active projects</h3>
                                </div>
                                <div class="col-auto my-n3 me-n3">
                                    <a class="btn btn-sm btn-link" href="./projects/projects.html">
                                        Browse all
                                        <span class="material-symbols-outlined">arrow_right_alt</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                <tr><th class="fs-sm">Title</th>
                                    <th class="fs-sm">Status</th>
                                    <th class="fs-sm">Author</th>
                                    <th class="fs-sm">Team</th>
                                </tr></thead>
                                <tbody>
                                <tr onclick="window.location.href='./projects/project.html'" role="link" tabindex="0">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar">
                                                <img class="avatar-img" src="{{ asset('assets/img/projects/project-1.png') }}"...">
                                            </div>
                                            <div class="ms-4">
                                                <div>Filters AI</div>
                                                <div class="fs-sm text-body-secondary">Updated on Apr 10, 2024</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success">Ready to Ship</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center text-nowrap">
                                            <div class="avatar avatar-xs me-2">
                                                <img class="avatar-img" src="{{ asset('assets//img/photos/photo-2.jpg') }}="...">
                                            </div>
                                            Michael Johnson
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-group">
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="Michael Johnson">
                                                <img class="avatar-img" src="{{ asset('img/photos/photo-2.jpg') }}">
                                            </div>
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="Robert Garcia">
                                                <img class="avatar-img" src="{{ asset('img/photos/photo-3.jpg') }}">
                                            </div>
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="Olivia Davis">
                                                <img class="avatar-img" src="{{ asset('img/photos/photo-4.jpg') }}">
                                            </div>
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="Jessica Miller">
                                                <img class="avatar-img" src="{{ asset('img/photos/photo-5.jpg') }}">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr onclick="window.location.href='./projects/project.html'" role="link" tabindex="0">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar">
                                                <img class="avatar-img" src="{{ asset('img/projects/project-2.png') }}">
                                            </div>
                                            <div class="ms-4">
                                                <div>Design landing page</div>
                                                <div class="fs-sm text-body-secondary">Created on Mar 05, 2024</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger-subtle text-danger">Cancelled</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center text-nowrap">
                                            <div class="avatar avatar-xs me-2">
                                                <img class="avatar-img" src="{{ asset('img/photos/photo-1.jpg') }}">
                                            </div>
                                            Emily Thompson
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-group">
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="Olivia Davis">
                                                <img class="avatar-img" src="{{ asset('img/photos/photo-4.jpg') }}">
                                            </div>
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="Jessica Miller">
                                                <img class="avatar-img" src="{{ asset('img/photos/photo-5.jpg' ) }}">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr onclick="window.location.href='./projects/project.html'" role="link" tabindex="0">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fs-4 duo-icon duo-icon-book-3" data-duoicon="book-3"><path fill="currentColor" fill-rule="evenodd" d="M4 5a3 3 0 0 1 3-3h11a2 2 0 0 1 2 2v12.99c0 .168-.038.322-.113.472l-.545 1.09a1 1 0 0 0 0 .895l.543 1.088A1 1 0 0 1 19 22H7a3 3 0 0 1-3-3V5Z" class="duoicon-secondary-layer" opacity=".3"></path><path fill="currentColor" fill-rule="evenodd" d="M10 7a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-4ZM7 18h10.408a2.997 2.997 0 0 0 0 2H7a1 1 0 1 1 0-2Z" class="duoicon-primary-layer"></path></svg>
                                            </div>
                                            <div class="ms-4">
                                                <div>Update documentation</div>
                                                <div class="fs-sm text-body-secondary">Created on Jan 22, 2024</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">In Testing</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center text-nowrap">
                                            <div class="avatar avatar-xs me-2">
                                                <img class="avatar-img" src="{{ asset('img/photos/photo-2.jpg')}}">
                                            </div>
                                            Michael Johnson
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-group">
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="Emily Thompson">
                                                <img class="avatar-img" src="{{ asset('img/photos/photo-1.jpg') }}">
                                            </div>
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="Robert Garcia">
                                                <img class="avatar-img" src="{{ asset('img/photos/photo-3.jpg') }}">
                                            </div>
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="John Williams">
                                                <img class="avatar-img" src="{{ asset('/img/photos/photo-6.jpg') }}">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr onclick="window.location.href='./projects/project.html'" role="link" tabindex="0">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar">
                                                <img class="avatar-img" src="{{ asset('img/projects/project-3.png') }}">
                                            </div>
                                            <div class="ms-4">
                                                <div>Update Touche</div>
                                                <div class="fs-sm text-body-secondary">Updated on Apr 14, 2024</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success">Ready to Ship</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center text-nowrap">
                                            <div class="avatar avatar-xs me-2">
                                                <img class="avatar-img" src="{{ asset('img/photos/photo-5.jpg') }}">
                                            </div>
                                            Jessica Miller
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-group">
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="Robert Garcia">
                                                <img class="avatar-img" src="{{ asset('img/photos/photo-3.jpg') }}">
                                            </div>
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="Olivia Davis">
                                                <img class="avatar-img" src="{{ asset('assets/./assets/img/photos/photo-4.jpg') }}">
                                            </div>
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="Jessica Miller">
                                                <img class="avatar-img" src="{{ asset('img/photos/photo-5.jpg') }}">
                                            </div>
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="John Williams">
                                                <img class="avatar-img" src="{{ asset('img/photos/photo-6.jpg') }}">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr onclick="window.location.href='./projects/project.html'" role="link" tabindex="0">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fs-4 duo-icon duo-icon-box" data-duoicon="box"><path fill="currentColor" d="M21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-9h18Z" class="duoicon-secondary-layer" opacity=".3"></path><path fill="currentColor" d="M20 3a2 2 0 0 1 2 2v3H2V5a2 2 0 0 1 2-2h16Zm-6 10h-4a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2Z" class="duoicon-primary-layer"></path></svg>
                                            </div>
                                            <div class="ms-4">
                                                <div>Add Transactions</div>
                                                <div class="fs-sm text-body-secondary">Created on Apr 25, 2024</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-body-secondary">Backlog</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center text-nowrap">
                                            <div class="avatar avatar-xs me-2">
                                                <img class="avatar-img" src="./assets/img/photos/photo-4.jpg" alt="...">
                                            </div>
                                            Olivia Davis
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-group">
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="Robert Garcia">
                                                <img class="avatar-img" src="./assets/img/photos/photo-3.jpg" alt="...">
                                            </div>
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="John Williams">
                                                <img class="avatar-img" src="./assets/img/photos/photo-6.jpg" alt="...">
                                            </div>
                                            <div class="avatar avatar-xs" data-bs-toggle="tooltip" data-bs-title="Emily Thompson">
                                                <img class="avatar-img" src="./assets/img/photos/photo-1.jpg" alt="...">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xxl-4">
                    <!-- Goals -->
                    <div class="card mb-6">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="fs-6 mb-0">Goals</h3>
                                </div>
                                <div class="col-auto my-n3 me-n3">
                                    <button class="btn btn-sm btn-link" type="button">+ Add
                                    </button></div>
                            </div>
                        </div>
                        <div class="card-body py-3">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar">
                                                <div class="progress progress-circle text-primary" role="progressbar" aria-label="Increase monthly revenue" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-title="75%" style="--bs-progress-circle-value: 75"></div>
                                            </div>
                                        </div>
                                        <div class="col ms-n2">
                                            <h6 class="fs-base fw-normal mb-0">Increase monthly revenue</h6>
                                            <span class="fs-sm text-body-secondary">$10,000</span>
                                        </div>
                                        <div class="col-auto">
                                            <span class="text-body-secondary">Mar 15</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar">
                                                <div class="progress progress-circle text-secondary" role="progressbar" aria-label="Launch new feature" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-title="50%" style="--bs-progress-circle-value: 50"></div>
                                            </div>
                                        </div>
                                        <div class="col ms-n2">
                                            <h6 class="fs-base fw-normal mb-0">Launch new feature</h6>
                                            <span class="fs-sm text-body-secondary">Dark mode</span>
                                        </div>
                                        <div class="col-auto">
                                            <span class="text-body-secondary">Oct 01</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar">
                                                <div class="progress progress-circle text-danger" role="progressbar" aria-label="Grow user base" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-title="45%" style="--bs-progress-circle-value: 45"></div>
                                            </div>
                                        </div>
                                        <div class="col ms-n2">
                                            <h6 class="fs-base fw-normal mb-0">Grow user base</h6>
                                            <span class="fs-sm text-body-secondary">75%</span>
                                        </div>
                                        <div class="col-auto">
                                            <span class="text-body-secondary">Dec 12</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar">
                                                <div class="progress progress-circle text-primary" role="progressbar" aria-label="Improve customer satisfaction" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-title="60%" style="--bs-progress-circle-value: 60"></div>
                                            </div>
                                        </div>
                                        <div class="col ms-n2">
                                            <h6 class="fs-base fw-normal mb-0">Improve customer satisfaction</h6>
                                            <span class="fs-sm text-body-secondary">85%</span>
                                        </div>
                                        <div class="col-auto">
                                            <span class="text-body-secondary">Dec 15</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar">
                                                <div class="progress progress-circle text-success" role="progressbar" aria-label="Reduce response time" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-title="100%" style="--bs-progress-circle-value: 100"></div>
                                            </div>
                                        </div>
                                        <div class="col ms-n2">
                                            <h6 class="fs-base fw-normal mb-0">Reduce response time</h6>
                                            <span class="fs-sm text-body-secondary">1hr</span>
                                        </div>
                                        <div class="col-auto">
                                            <span class="text-body-secondary">Jan 01</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="fs-6 mb-0">Recent activity</h3>
                        </div>
                        <div class="card-body">
                            <ul class="activity">
                                <li data-icon="thumb_up">
                                    <div>
                                        <h6 class="fs-base mb-1">You <span class="fs-sm fw-normal text-body-secondary ms-1">1hr ago</span></h6>
                                        <p class="mb-0">Liked a post by @john_doe</p>
                                    </div>
                                </li>
                                <li data-icon="chat_bubble">
                                    <div>
                                        <h6 class="fs-base mb-1">Jessica Miller <span class="fs-sm fw-normal text-body-secondary ms-1">3hr ago</span></h6>
                                        <p class="mb-0">Commented on a photo</p>
                                    </div>
                                </li>
                                <li data-icon="share">
                                    <div>
                                        <h6 class="fs-base mb-1">Emily Thompson <span class="fs-sm fw-normal text-body-secondary ms-1">3hr ago</span></h6>
                                        <p class="mb-0">Shared an article: "Top 10 Travel Destinations"</p>
                                    </div>
                                </li>
                                <li data-icon="person_add">
                                    <div>
                                        <h6 class="fs-base mb-1">You <span class="fs-sm fw-normal text-body-secondary ms-1">1 day ago</span></h6>
                                        <p class="mb-0">Started following @jane_smith</p>
                                    </div>
                                </li>
                                <li data-icon="account_circle">
                                    <div>
                                        <h6 class="fs-base mb-1">Olivia Davis <span class="fs-sm fw-normal text-body-secondary ms-1">2 days ago</span></h6>
                                        <p class="mb-0">Updated profile picture</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
