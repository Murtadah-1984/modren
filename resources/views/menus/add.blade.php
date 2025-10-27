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
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" value="{{ old('title') }}" name="title" required>
                        </div>
                        <div class="form-group" >
                            <label for="route">Route</label>
                            <input type="text" class="form-control" id="route" value="{{ old('route') }}" name="route" required>
                        </div>
                        <div class="form-group" >
                            <label for="policy">Policy</label>
                            <input type="text" class="form-control" id="policy" value="{{ old('policy') }}" name="policy" required>
                        </div>
                        <div class="form-group" >
                            <label for="class">Class</label>
                            <input type="text" class="form-control" id="class" value="{{ old('class') }}" name="class" required>
                        </div>
                        <div class="form-group" >
                            <label for="parent">Parent</label>
                            <select class="form-control select2" id="parent" name="parent_id" data-dropdown-css-class="select2-success" style="width: 100%;" >

                            </select>
                        </div>
                        <div class="form-group" >
                            <label for="order">Order</label>
                            <input type="text" class="form-control" id="order" value="{{ old('order') }}" name="order" required>
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
    makeSelector('#parent','Select Parent','{{ route('menus.create') }}');
</script>

