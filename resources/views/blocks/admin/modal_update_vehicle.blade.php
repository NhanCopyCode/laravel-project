 <!--Update model Modal -->
 <form method="POST" action="{{ route('admin.model.update') }}" class="modal fade modal-model" id="form_update_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    @csrf
    <input type="hidden" id="update_model_id">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật mẫu xe</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="model-vehicle">Tên mẫu xe</label>
                <input type="text" class="form-control" id="update_model_name" name="model_name" placeholder="Nhập tên mẫu xe..." required>
                <div class="message_error" id="update-error-model_name">

                </div>
            </div>
            <div class="form-group">
                <label for="engine_type">Dung tích xilanh (cc)</label>
                <input type="number" class="form-control" id="update_engine_type" name="engine_type" placeholder="Nhập dung tích xilanh..." required>
                <div class="message_error" id="update-error-engine_type">

                </div>
            </div>

            <div class="form-group">
                <label for="color">Nhập màu sắc (cc)</label>
                <input type="text" class="form-control" id="update_color" name="color" placeholder="Nhập màu sắc..." required>
                <div class="message_error" id="update-error-color">

                </div>
            </div>

            <div class="form-group">
                <label for="year_of_production">Năm sản xuất</label>
                <input type="number" class="form-control" id="update_year_of_production" name="year_of_production" placeholder="Nhập năm sản xuất..." required>
                <div class="message_error" id="update-error-year_of_production">

                </div>
            </div>

            <div class="form-group">
                <label for="brand_id">Chọn mẫu xe</label>
                <select class="form-control" name="brand_id" id="update_brand_id">
                    @foreach ($brand_list as $brand)
                        <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                    @endforeach
                </select>
                <div class="message_error" id="update-error-brand_id">

                </div>
            </div>

            <div class="form-group">
                <label for="model_status_id">Trạng thái</label>
                <select class="form-control" name="model_status_id" id="update_model_status_id">
                    @foreach ($model_status_list as $status)
                        <option value="{{$status->model_status_id}}">{{$status->model_status_name}}</option>
                    @endforeach
                </select>
                <div class="message_error" id="update-error-year_of_production">

                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-submit-update-model">Cập nhật</button>
        </div>
    </div>
    </div>
</form>