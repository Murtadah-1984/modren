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
                            <input type="hidden" id="editID" name='id' value="">
                        </div>
                        <div class="form-group" >
                            <label for="editTitle">Title</label>
                            <input type="text" class="form-control" id="editTitle" value="{{ old('title') }}" name="title" required>
                        </div>
                        <div class="form-group" >
                            <label for="editRoute">Route</label>
                            <input type="text" class="form-control" id="editRoute" value="{{ old('route') }}" name="route" required>
                        </div>
                        <div class="form-group" >
                            <label for="editPolicy">Policy</label>
                            <input type="text" class="form-control" id="editPolicy" value="{{ old('policy') }}" name="policy" required>
                        </div>
                        <div class="form-group" >
                            <label for="editClass">Class</label>
                            <input type="text" class="form-control" id="editClass" value="{{ old('class') }}" name="class" required>
                        </div>
                        <div class="form-group" >
                            <label for="editParent">Parent</label>
                            <select class="form-control select2" id="editParent" name="parent_id" data-dropdown-css-class="select2-success" style="width: 100%;" >

                            </select>
                        </div>
                        <div class="form-group" >
                            <label for="editOrder">Order</label>
                            <input type="text" class="form-control" id="editOrder" value="{{ old('order') }}" name="order" required>
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
    let parentSelector=makeSelector('#editParent','Select Parent','{{ route('menus.create') }}');
    function edit(id) {
        $('#editModelLabel').html("Edit Record");
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: "/menus/" + id +"/edit",
            data:{id:id, action:'fetch_single'},
            success: function(res){
                $('#editID').val(res.id);
                $('#editTitle').val(res.title);
                $('#editRoute').val(res.route);
                $('#editPolicy').val(res.policy);
                $('#editClass').val(res.class);
                $('#editOrder').val(res.order);
                var newOption = new Option(res.parent.title, res.parent.id, true, true);
                parentSelector.append(newOption).trigger('change');
            }
        });
    }

</script>
<!-- Modal End-->
