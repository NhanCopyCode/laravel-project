 <!--Update branch Modal -->
 <form method="POST" action="{{route('admin.branch.add')}}" class="modal fade modal-branch" id="form_add_branch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    @csrf
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Thêm chi nhánh</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="city">Thành phố</label>
                <input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="Nhập tên chi nhánh..." required>
                <div class="message_error_branch_name">

                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
    </div>
    </div>
</form>