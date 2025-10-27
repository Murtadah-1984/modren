<!-- Add Modal Start-->
<div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="addModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="addModelLabel">Add Record</h5>
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
                            <input type="text" class="form-control" id="name" value="{{ old('name') }}" name="name" required>
                        </div>
                        <div class="form-group" >
                            <label for="display_name">Display Name</label>
                            <input type="text" class="form-control" id="display_name" value="{{ old('display_name') }}" name="display_name" required>
                        </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn-submit" class="btn btn-success">Submit</button>
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal End-->
<script type="text/javascript">

</script>

