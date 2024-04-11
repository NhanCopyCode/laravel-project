 <!--Update branch Modal -->
 <form method="POST" action="{{ route('admin.branch.update') }}" class="modal fade modal-branch" id="form_update_branch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    @csrf
    <input type="hidden" id="update_branch_id">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật chi nhánh</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="city">Thành phố</label>
                <input type="text" class="form-control" id="update_branch_name" name="branch_name" placeholder="Nhập tên chi nhánh..." required>
                
                <div class="message_error_branch_name">

                </div>
            </div>

            <div class="form-group">
                <label for="branch_status">Trạng thái chi nhánh</label>
                <select class="form-control" name="branch_status" id="update_branch_status">
                    @foreach ($branch_status_list as $key => $status)
                        <option  
                            value="{{$status->branch_status_id}}"
                        >{{$status->branch_status_name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-submit-update-branch">Cập nhật</button>
        </div>
    </div>
    </div>
</form>