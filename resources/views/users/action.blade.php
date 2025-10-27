
<div class="btn-group dropend">
    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        ---
    </button>
    <ul class="dropdown-menu">
        <li>
            @if(is_null($user->deleted_at))
                @can('users.view')
                    <button type="button" class="btn btn-sm btn-outline-warning mb-2"  data-toggle="modal" data-target="#viewModel" onClick="view('{{ $user->id }}')"><span class="material-symbols-outlined me-3">table_eye</span></button>
                @endcan
            @endif
        </li>
        <li>
            @if(is_null($user->deleted_at))
                @can('users.view')
                    <button type="button" class="btn btn-sm btn-outline-info mb-2"  data-toggle="modal" id="editBtn" data-target="#editModel" onClick="edit('{{ $user->id }}')"><span class="material-symbols-outlined me-3">edit_document</span></button>
                @endcan
            @endif
        </li>
        <li>
            @if(is_null($user->deleted_at))
                @can('users.view')
                    <button type="button" class="btn btn-sm btn-outline-secondary mb-2" onClick="disable('{{ $user->id }}')"><span class="material-symbols-outlined me-3">person_off</span></button>
                @endcan
            @endif
        </li>
        <li>
            @if(is_null($user->deleted_at))
                @can('users.view')
                    <div class="dropdown btn mx-0 px-0">
                        <button type="button" class="btn btn-sm btn-outline-primary mb-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-id="{{$user->id}}"><span class="material-symbols-outlined me-3">lock_reset</span></button>
                        <div class="dropdown-menu align-content-center pull-left">
                            <form class="form-inline p-3">
                                <div class="form-group mb-2">
                                    <input type="password" class="form-control" placeholder="New Password">
                                </div>
                                <button type="submit" class="btn btn-primary">Change</button>
                            </form>
                        </div>
                    </div>
                @endcan
            @endif
        </li>
        <li>
            @if(!is_null($user->deleted_at))
                @can('users.view')
                    <button type="submit" class="btn btn-sm btn-outline-success mb-2" onClick="restore('{{$user->id}}','User')"><span class="material-symbols-outlined me-3">restore_page</span></button>
                @endcan
            @endif
        </li>
        <li>
            @if(is_null($user->deleted_at))
                @can('users.view')
                    <button type="submit" class="btn btn-sm btn-outline-danger mb-2" onClick="destroy('{{$user->id}}','User')"><span class="material-symbols-outlined me-3">delete</span></button>
                @endcan
            @endif
        </li>
        <li>
            @if(!is_null($user->deleted_at))
                @can('users.view')
                    <button type="submit" class="btn btn-sm btn-outline-danger mb-2" onClick="forceDelete('{{$user->id}}','User')"><span class="material-symbols-outlined me-3">delete_forever</span></button>
                @endcan
            @endif
        </li>
    </ul>
</div>
