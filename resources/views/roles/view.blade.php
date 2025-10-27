<!-- View Modal Start-->
<div class="modal fade" id="viewModel" tabindex="-1" role="dialog" aria-labelledby="viewModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h2 class="modal-title" id="viewModelLabel"></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Record</th>
                                <th scope="col">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="align-middle"><strong>Name</strong></td>
                                <td class="align-middle" id="viewName"></td>
                            </tr>
                            <tr>
                                <td class="align-middle"><strong>Display Name</strong></td>
                                <td class="align-middle" id="viewDisplayName"></td>
                            </tr>
                            <tr>
                                <td class="align-middle"><strong>Permissions</strong></td>
                                <td class="align-middle" id="viewPermissions"></td>
                            </tr>
                            <tr>
                                <td class="align-middle"><strong>Created at</strong></td>
                                <td class="align-middle" id="viewCreatedAt"></td>
                            </tr>
                            <tr>
                                <td class="align-middle"><strong>Created By</strong></td>
                                <td class="align-middle" id="viewCreatedBy"></td>
                            </tr>

                            <tr>
                                <td class="align-middle"><strong>Update At</strong></td>
                                <td class="align-middle" id="viewUpdatedAt"></td>
                            </tr>
                            <tr>
                                <td class="align-middle"><strong>Update By</strong></td>
                                <td class="align-middle" id="viewUpdatedBy"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-warning">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //  view Script
    function view(id) {
        $('#viewModelLabel').html("Record Details");
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: "/roles/" + id ,
            data:{id:id, action:'fetch_single'},
            success: function(res){
                $('#viewName').html(res.name);
                $('#viewDisplayName').html(res.display_name);
                $('#viewCreatedAt').html(res.created_at);
                $('#viewCreatedBy').html(res.created_by);
                $('#viewUpdatedAt').html(res.updated_at);
                $('#viewUpdatedBy').html(res.updated_by);
                let permissions='';
                res.permissions.forEach(function(permission){
                    permissions+= permission.key+"</br>";
                })
                $("#viewPermissions").html(permissions);
            }
        })
    }
</script>
<!-- Modal End-->
