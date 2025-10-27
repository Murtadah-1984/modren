@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="container-lg">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Users') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-center my-4">
                <div class="spinner-border" role="status" id="spinner">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <ul class="nav nav-pills nav-fill">
                                    @can('users.view')
                                        <li class="nav-item">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Select a scope...
                                                </button>
                                                <select class="dropdown-menu" id="scope-select">

                                                </select>
                                            </div>
                                        </li>
                                    @endcan
                                    <li class="nav-item">
                                        <button type="button" class="btn btn-outline-primary" id="select-toggle"><span class="material-symbols-outlined me-3">select_check_box</span></button>
                                    </li>
                                    @can('users.view')
                                        <li class="nav-item">
                                            <button type="button" class="btn btn-outline-danger" onclick="massForceDelete('User')"><span class="material-symbols-outlined me-3">delete_forever</span></button>
                                        </li>
                                    @endcan
                                    @can('users.view')
                                        <li class="nav-item">
                                        <button type="button" class="btn btn-outline-danger" onclick="massDestroy('User')"><span class="material-symbols-outlined me-3">delete_history</span></button>
                                        </li>
                                    @endcan
                                    @can('users.view')
                                        <li class="nav-item">
                                        <button type="button" class="btn btn-outline-success" onclick="massRestore('User')"><span class="material-symbols-outlined me-3">restore_from_trash</span></button>
                                        </li>
                                    @endcan
                                    @can('users.view')
                                        <li class="nav-item">
                                        <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#addModel"><span class="material-symbols-outlined me-3">add</span></button>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-xl">
                                <table class="table table-striped table-bordered hover" id="TabledataTable">
                                    <thead>
                                        <tr class="bg-gradient-gray-dark font-weight-bold">
                                            <td class="text-center"></td>
                                            <td class="text-center">#</td>
                                            <td class="text-center">Name</td>
                                            <td class="text-center">Email</td>
                                            <td class="text-center">Roles</td>
                                            <td class="text-center">Actions</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div><!-- ./ Card Modal-->
                </div>
                @include('users.edit')
                @include('users.add')
                @include('users.view')

            </div>
            <!-- /.row -->
            <div class="row text-center">
                <a href="javascript:" class="img-circle elevation-2 bg-gradient-gray-dark p-2 m-4" id="return-to-top" style="display: block; cursor: pointer;"><i class="fas fa-chevron-up"></i></a>
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>

@endsection
@section('scripts')
    @parent
    <script type="text/javascript">
        /**
         * ------------------------------------------
         * --------------------------------------------
         * Render DataTable
         * --------------------------------------------
         * --------------------------------------------
         */
        const table = createDataTable({!! $columns !!});
    </script>
@endsection
