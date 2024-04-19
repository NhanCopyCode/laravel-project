 <!--Update carrentalstore Modal -->
 <form method="POST" action="{{ route('admin.carrentalstore.update') }}" class="modal fade modal-carrentalstore" id="form_update_carrentalstore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    @csrf
    <input type="hidden" id="update_carrentalstore_id">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Thêm cửa hàng</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="provinceSelect">Chọn Tỉnh/Thành phố</label>
                    <select class="form-control update-provinceSelectClass" name="province" id="update-provinceSelect">

                    </select>
                    <div class="message_error_province">

                    </div>
                </div>

                <div class="form-group">
                    <label for="districtSelect">Chọn Quận/Huyện</label>
                    <select class="form-control update-districtSelectClass" name="district" id="update-districtSelect">

                    </select>
                    <div class="message_error_district">

                    </div>
                </div>

                <div class="form-group">
                    <label for="wardSelect">Chọn Phường/Xã</label>
                    <select class="form-control update-wardSelectClass" name="ward" id="update-wardSelect">

                    </select>
                    <div class="message_error_ward">

                    </div>
                </div>

                <div class="form-group">
                    <label for="unique_location">Địa chỉ cụ thể</label>
                    <input type="text" name="unique_location" class="form-control" id="update-unique_location" placeholder="Nhập địa chỉ....">
                    <div class="message_error_unique_location">

                    </div>
                </div>

                <div class="form-group">
                    <label for="phone_number">Số điện thoại liên hệ</label>
                    <input type="number" name="phone_number" class="form-control" id="update-phone_number" placeholder="Nhập số điện thoại....">
                    <div class="message_error_phone_number">

                    </div>
                </div>

                <div class="form-group">
                    <label for="avatar">Hình ảnh cửa hàng</label>
                    <input type="file" id="update-avatar" class="form-control" name="avatar">
                    <img class="image-preview-carrentalstore"  alt="Ảnh cửa hàng" style="width: 100px; height: 100px;margin-top: 12px;">
                    <div class="message_error_avatar">

                    </div>
                </div>

                <div class="form-group">
                    <label for="avatar">Nhập thêm tiểu sử cửa hàng</label>
                    <textarea class="form-control" name="description" id="update-description" cols="30" rows="2"></textarea>
                    <div class="message_error_avatar">

                    </div>
                </div>
                
                <div class="form-group">
                    <label for="branch_id">Chọn chi nhánh</label>
                    <select class="form-control" name="branch_id" id="update-branch_id">
                        @foreach ($branch_list as $branch)
                            <option value="{{$branch->branch_id}}">{{$branch->branch_name}}</option>
                        @endforeach
                    </select>
                    <div class="message_error_carrentalstore_id">

                    </div>
                </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-submit-update-carrentalstore">Cập nhật</button>
        </div>
    </div>
    </div>
</form>