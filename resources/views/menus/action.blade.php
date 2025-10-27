@if(is_null($data->deleted_at))
    @can('read_permissions')
        <button type="button" class="btn btn-sm btn-warning mb-2"  data-toggle="modal" data-target="#viewModel" onClick="view('{{ $data->id }}')"><i class="fas fa-eye"></i></button>
    @endcan
@endif

@if(is_null($data->deleted_at))
    @can('edit_permissions')
        <button type="button" class="btn btn-sm btn-info mb-2"  data-toggle="modal" data-target="#editModel" onClick="edit('{{ $data->id }}')"><i class="fas fa-edit"></i></button>
    @endcan
@endif

@if(!is_null($data->deleted_at))
    @can('restore_permissions')
        <button type="submit" class="btn btn-sm btn-success mb-2" onClick="restore('{{$data->id}}','Menu')"><i class="fas fa-trash-restore"></i></button>
    @endcan
@endif

@if(is_null($data->deleted_at))
    @can('delete_permissions')
        <button type="submit" class="btn btn-sm btn-outline-danger mb-2" onClick="destroy('{{$data->id}}','Menu')"><i class="fas fa-trash"></i></button>
    @endcan
@endif

@if(!is_null($data->deleted_at))
    @can('forceDelete_permissions')
        <button type="submit" class="btn btn-sm btn-danger mb-2" onClick="forceDelete('{{$data->id}}','Menu')"><i class="fas fa-trash"></i></button>
    @endcan
@endif
