<!-- Add Modal Start-->
<div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="addModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="addModelLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:updateOrCreate('#addForm','#addModel')" id="addForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-group" >
                            <label for="name">Name</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" value="{{ old('name') }}" name="name" required>
                        </div>
                        <div class="form-group" >
                            <label for="email">Email</label>
                            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" value="{{ old('email') }}" name="email" required>
                        </div>
                        <div class="form-group" >
                            <label for="role" >Role</label>
                            <div class="select2-success">
                                <select class="form-control select2 {{ $errors->has('role_id') ? 'is-invalid' : '' }}" id="role_id" name="role_id" data-dropdown-css-class="select2-success" style="width: 100%;" required>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Additional Roles</label>
                            <div class="select2-success">
                                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" multiple="multiple" name="roles[]" id="roles" data-dropdown-css-class="select2-success" style="width: 100%;" >

                                </select>
                            </div>
                        </div>

                        <div class="form-group" >
                            <label for="password">Password</label>
                            <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password"  name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn-submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal End-->
<script type="text/javascript">
    makeSelector('#role_id','Select a Role','{{ route('api.roles.index') }}');
    makeSelector('#roles','Select Additional Roles','{{ route('api.roles.index') }}');
</script>

