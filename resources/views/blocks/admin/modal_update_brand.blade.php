 <!--Update brand Modal -->
 <form method="POST" action="{{ route('admin.brand.update') }}" class="modal fade modal-brand" id="form_update_brand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    @csrf
    <input type="hidden" id="update_brand_id">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật hãng xe</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="city">Thành phố</label>
                <input type="text" class="form-control" id="update_brand_name" name="brand_name" placeholder="Nhập tên hãng xe..." required>
                
                <div class="message_error_brand_name">

                </div>
            </div>

            <div class="form-group">
                <label for="brand_status">Trạng thái hãng xe</label>
                <select class="form-control" name="brand_status" id="update_brand_status">
                    
                    @foreach ($brand_status_list as $key => $status)
                        <option  
                            value="{{$status->brand_status_id}}"
                        >{{$status->brand_status_name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-submit-update-brand">Cập nhật</button>
        </div>
    </div>
    </div>
</form>