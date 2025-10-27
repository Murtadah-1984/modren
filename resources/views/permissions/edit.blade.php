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
                            <label for="editKey">Key</label>
                            <input type="hidden" id="editID" name='id' value="">
                            <input type="text" class="form-control" id="editKey" value="{{ old('key') }}" name="key" required>
                        </div>
                        <div class="form-group" >
                            <label for="editTable_name">Table</label>
                            <input type="text" class="form-control" id="editTable_name" value="{{ old('table_name') }}" name="table_name" required>
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
            url: "/permissions/" + id +"/edit",
            data:{id:id, action:'fetch_single'},
            success: function(res){
                $('#editID').val(res.id);
                $('#editKey').val(res.key);
                $('#editTable_name').val(res.table_name);
            }
        });
    }

</script>
<!-- Modal End-->
