<!-- Edit Modal Start-->
@php
 use \App\Models\Permission;
@endphp
<div class="modal fade" id="editModel" role="dialog" aria-labelledby="editModelLabel" aria-hidden="true" >
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" >
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h2 class="modal-title" id="editModelLabel"></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:updateOrCreate('#editForm','#editModel')" id="editForm" class=" form-horizontal" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-group" >
                            <input type="hidden" id="editID" name='id' value="">
                        </div>
                        <div class="form-group" >
                            <label for="editName">Name</label>
                            <input type="text" class="form-control" id="editName" value="{{ old('name') }}" name="name" required>
                        </div>
                        <div class="form-group" >
                            <label for="editDisplayName">Display Name</label>
                            <input type="text" class="form-control" id="editDisplayName" value="{{ old('display_name') }}" name="display_name" required>
                        </div>
                        <div class="form-group">
                            <label for="permission">Permissions</label><br>
                            <a href="#" class="permission-select-all">Select All</a> / <a href="#"  class="permission-deselect-all">Deselect All</a>
                            <ul class="permissions checkbox">
                                @foreach((Permission::all()->groupBy('table_name')) as $table => $permission)
                                    <li>
                                        <input type="checkbox" id="{{$table}}" class="permission-group">
                                        <label for="{{$table}}"><strong>{{\Illuminate\Support\Str::title(str_replace('_',' ', $table))}}</strong></label>
                                        <ul>
                                            @foreach($permission as $perm)
                                                <li>
                                                    <input type="checkbox" id="permission-{{$perm->id}}" name="permissions[{{$perm->id}}]" class="the-permission" value="{{$perm->id}}" >
                                                    <label for="permission-{{$perm->id}}">{{\Illuminate\Support\Str::title(str_replace('_', ' ', $perm->key))}}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn-update" class="btn btn-info">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    /**
     * ------------------------------------------
     * --------------------------------------------
     * Edit Script
     * --------------------------------------------
     * --------------------------------------------
     */
    function edit(id) {
        $('#editModelLabel').html("Edit Record");
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: "/roles/" + id +"/edit",
            data:{id:id, action:'fetch_single'},
            success: function(res){
                $('#editID').val(res.id);
                $('#editName').val(res.name);
                $('#editDisplayName').val(res.display_name);
                res.permissions.forEach(function(permission){
                    document.getElementById(permission.table_name).checked = true;
                    document.getElementById('permission-'+permission.id).checked = true;
                });



            }
        });
    }

</script>
<script>

        $('.permission-group').on('change', function(){
            $(this).siblings('ul').find("input[type='checkbox']").prop('checked', this.checked);
        });

        $('.permission-select-all').on('click', function(){
            $('ul.permissions').find("input[type='checkbox']").prop('checked', true);
            return false;
        });

        $('.permission-deselect-all').on('click', function(){
            $('ul.permissions').find("input[type='checkbox']").prop('checked', false);
            return false;
        });

        function parentChecked(){
            $('.permission-group').each(function(){
                var allChecked = true;
                $(this).siblings('ul').find("input[type='checkbox']").each(function(){
                    if(!this.checked) allChecked = false;
                });
                $(this).prop('checked', allChecked);
            });
        }

        parentChecked();

        $('.the-permission').on('change', function(){
            parentChecked();
        });
</script>
<!-- Modal End-->
