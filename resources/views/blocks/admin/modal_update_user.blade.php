 <!--Update user Modal -->
 <form method="POST" action="{{ route('admin.user.update') }}" class="modal fade modal-user" id="form_update_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    @csrf
    <input type="hidden" id="update_user_id" name="user_id">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật người dùng</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">

            <div class="form-group">
                <label for="role_id">Chọn vai trò</label>
                <select class="form-control" name="role_id" id="update_role_id" value="{{old('role_id')}}">
                    <option value="2">Quản lý</option>
                    <option value="3">Admin</option>
                </select>
                <div class="message_error_role_id message_error">

                </div>
            </div>
            
            <div class="form-group">
                <label for="user_status_id">Chọn trạng thái người dùng</label>
                <select class="form-control" name="user_status_id" id="update_user_status_id" value="{{old('user_status_id')}}">
                    @foreach ($user_status_list as $item)
                        <option value="{{$item->user_status_id}}">{{$item->user_status_name}}</option>
                    @endforeach
                </select>
                <div class="message_error_user_status_id message_error">

                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-submit-update-user">Cập nhật</button>
        </div>
    </div>
    </div>
</form>