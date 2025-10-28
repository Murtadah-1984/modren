@extends('Modules.Theme.resources.views.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Menus') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div id="event_info" class="box"></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div id="card-search"></div>
                            <div class="card-tools">
                                @can('scope_menus')
                                    <select class="btn btn-iframe-close" id="scope-select">
                                        <option value="">Select a scope...</option>
                                    </select>
                                @endcan
                                @can('export_menus')
                                    <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Export Options
                                    </a>
                                    <div id="actions" class="dropdown-menu" aria-labelledby="dropdownMenuLink"></div>
                                @endcan
                                <button type="button" class="btn btn-outline-primary" id="select-toggle"><i
                                            class="far fa-square"></i></button>
                                @can('forceDelete_menus')
                                    <button type="button" class="btn btn-danger" onclick="massForceDelete('Menu')"><i
                                                class="fas fa-trash"></i></button>
                                @endcan
                                @can('delete_menus')
                                    <button type="button" class="btn btn-outline-danger" onclick="massDestroy('Menu')">
                                        <i class="fas fa-trash"></i></button>
                                @endcan
                                @can('restore_menus')
                                    <button type="button" class="btn btn-outline-success" onclick="massRestore('Menu')">
                                        <i class="fas fa-trash-restore"></i></button>
                                @endcan
                                @can('add_menus')
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#addModel"><i class="fas fa-plus"></i></button>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-xl">
                                <table class="table table-striped table-bordered hover" id="dataTable">
                                    <thead>
                                    <tr class="bg-gradient-gray-dark font-weight-bold">
                                        <td class="text-center"></td>
                                        <td class="text-center">#</td>
                                        <td class="text-center">Title</td>
                                        <td class="text-center">Route</td>
                                        <td class="text-center">Class</td>
                                        <td class="text-center">Policy</td>
                                        <td class="text-center">Parent</td>
                                        <td class="text-center">Order</td>
                                        <td class="text-center">Actions</td>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr class="bg-gradient-gray-dark font-weight-bold">
                                        <td class="text-center"></td>
                                        <td class="text-center">#</td>
                                        <td class="text-center">Title</td>
                                        <td class="text-center">Route</td>
                                        <td class="text-center">Class</td>
                                        <td class="text-center">Policy</td>
                                        <td class="text-center">Parent</td>
                                        <td class="text-center">Order</td>
                                        <td class="text-center">Actions</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div><!-- ./ Card Modal-->
                </div>
                @include('menus.edit')
                @include('menus.add')
                @include('menus.view')

            </div>
            <!-- /.row -->
            <div class="row text-center">
                <a href="javascript:" class="img-circle elevation-2 bg-gradient-gray-dark p-2 m-4" id="return-to-top"
                   style="display: block; cursor: pointer;"><i class="fas fa-chevron-up"></i></a>
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

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
        const table = $('#dataTable').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            pageLength: 10,
            stateSave: true,
            colReorder: true,
            fixedColumns: true,
            fixedHeader: true,
            select: true,
            dom: 'lBfrtip',
            order: [[1, 'asc']],
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100],],
            buttons: [@can('export_menus')'copyHtml5', 'excelHtml5', 'pdfHtml5', 'print'@endcan],

            ajax: "{{ route('menus.index') }}",
            columns: [
                {
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    printable: false,
                    width: "1%",
                    className: 'text-center align-middle'
                },
                {data: 'id', name: 'id', className: 'text-center align-middle', width: "1%"},
                {data: 'title', name: 'title', className: 'text-center align-middle'},
                {data: 'route', name: 'route', className: 'text-center align-middle'},
                {data: 'class', name: 'class', className: 'text-center align-middle'},
                {data: 'policy', name: 'policy', className: 'text-center align-middle'},
                {data: 'parent.title', name: 'parent.title', className: 'text-center align-middle'},
                {data: 'order', name: 'order', className: 'text-center align-middle'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    printable: false,
                    className: 'text-center align-middle'
                },

            ],
            // Deleted Record Conditional Formating
            rowCallback: function (row, data, index) {
                if (data.deleted_at) {
                    $(row).addClass("bg-danger");
                }
            }
        });
        table.buttons().container().appendTo($('#actions'));

    </script>
@endsection
