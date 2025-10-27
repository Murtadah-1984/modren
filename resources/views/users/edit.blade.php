<!-- Edit Modal Start-->
<div class="modal fade" id="editModel" role="dialog" aria-labelledby="editModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
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
                            <label for="name">Name</label>
                            <input type="hidden" id="editID" name='id' value="">
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="editName" value="" name="name" required>
                        </div>
                        <div class="form-group" >
                            <label for="email">Email</label>
                            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="editEmail" value="{{ old('email') }}" name="email" required>
                        </div>
                        <div class="form-group" >
                            <label for="role" >Role</label>
                            <div class="select2-info">
                                <select class="form-control select2" id="editRole_id" name="role_id" data-dropdown-css-class="select2-info" style="width: 100%;" required>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Additional Roles</label>
                            <div class="select2-info">
                                <select class="form-control select2" multiple="multiple" name="roles[]" id="editRoles" data-dropdown-css-class="select2-info" style="width: 100%;" >

                                </select>
                            </div>
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
    let roleSelector=makeSelector('#editRole_id','Select a Role','{{ route('api.roles.index') }}');


    function edit(id) {
        $('#editModelLabel').html("Edit Record");
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: "/users/" + id +"/edit",
            data:{id:id, action:'fetch_single'},
            success: function(res){
                $('#editID').val(res.id);
                $('#editName').val(res.name);
                $('#editEmail').val(res.email);
                var newOption = new Option(res.role.display_name, res.role.id, true, true);
                roleSelector.append(newOption).trigger('change');
                let options=[];
                res.roles.forEach(function(role){
                    options.push(new Option(role.display_name, role.id, true, true));
                });
                rolesSelector.append(options).trigger('change');
            }
        });
    }

    /**
     * ------------------------------------------
     * --------------------------------------------
     * Disable Script
     * --------------------------------------------
     * --------------------------------------------
     */
    function disable(id){
        $.ajax({
            type: 'POST',
            url: "/users/disable/" + id,
            dataType: 'json',
            headers: {'x-csrf-token': $('meta[name="csrf-token"]').attr('content'), 'Accept':'application/json'},
            success: function(data){
                console.log('Success:', data);
                alertNow('success', data.message);
            }
        })
        table.ajax.reload();
    }
</script>
<!-- Modal End-->
