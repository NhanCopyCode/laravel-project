 <!--Update vehicle Modal -->
 <form method="POST" action="{{ route('admin.vehicle.update') }}" class="modal fade modal-vehicle" id="form_update_vehicle" enctype="multipart/form-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    @csrf
    <input type="hidden" id="update_vehicle_id">
    <input type="hidden" id="update_vehicle_image_id">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật xe</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="update-vehicle-CarRentalStore_id">Chọn cửa hàng</label>
                    <select name="update-vehicle-CarRentalStore_id" id="update-vehicle-CarRentalStore_id" class="form-control">
                        @foreach ($carrentalstore_list as $carrentalstore_item)
                            <option value="{{$carrentalstore_item->CarRentalStore_id}}">{{$carrentalstore_item->unique_location}}</option>
                        @endforeach
                    </select>
                    <div class="message_error" id="error-update-vehicle-CarRentalStore_id">

                    </div>
                </div>
                <div class="form-group">
                    <label for="update-vehicle-model_id">Chọn mẫu xe</label>
                    <select name="update-vehicle-model_id" id="update-vehicle-model_id" class="form-control">
                        @foreach ($model_list as $model_item)
                            <option value="{{$model_item->model_id}}">{{$model_item->model_type}}</option>
                        @endforeach
                    </select>
                    <div class="message_error" id="error-update-vehicle-model_id">

                    </div>
                </div>
                <div class="form-group">
                    <label for="update-vehicle-vehicle_description">Nhập thông tin chi tiết</label>
                    <textarea class="form-control" name="update-vehicle-vehicle_description" id="update-vehicle-vehicle_description" cols="30" rows="2"></textarea>
                    <div class="message_error" id="error-update-vehicle-vehicle_description">

                    </div>
                </div>

                <div class="form-group">
                    <label for="update-vehicle-license_plate">Nhập biển số xe</label>
                    <input type="text" class="form-control" id="update-vehicle-license_plate" name="update-vehicle-license_plate" placeholder="75AF-137.80" value="" required>
                    <div class="message_error" id="error-update-vehicle-license_plate">

                    </div>
                </div>

                <div class="form-group">
                    <label for="update-vehicle-rental_price_day">Nhập số tiền thuê một ngày</label>
                    <input type="number" min="0" class="form-control" id="update-vehicle-rental_price_day" name="update-vehicle-rental_price_day" placeholder="Số tiền thuê mỗi ngày...." required>
                    <div class="message_error" id="error-update-vehicle-rental_price_day">

                    </div>
                </div>

                <div class="form-group">
                    <label for="update-vehicle-vehicle_status_id">Trạng thái xe</label>
                    <select class="form-control" name="update-vehicle-vehicle_status_id" id="update-vehicle-vehicle_status_id">
                        @foreach ($vehicle_status_list as $vehicle_status_item)
                            <option value="{{$vehicle_status_item->vehicle_status_id}}">{{$vehicle_status_item->vehicle_status_name}}</option>
                        @endforeach
                    </select>
                    <div class="message_error" id="error-update-vehicle-vehicle_status">

                    </div>
                </div>

                <div class="form-group">
                    <label for="update-vehicle-vehicle_image_name[]">Hình ảnh của xe (Chọn 3 hình)</label>
                    <input type="file" id="update-vehicle-vehicle_image_name[]" name="update-vehicle-vehicle_image_name[]" class="form-control" accept="image/*" multiple>
                    <img style="width: 100px; height: 100px; object-fit: cover;" id="update-vehicle-image-data-1" src="" alt="Hình ảnh của xe">
                    <img style="width: 100px; height: 100px; object-fit: cover;" id="update-vehicle-image-data-2" src="" alt="Hình ảnh của xe">
                    <img style="width: 100px; height: 100px; object-fit: cover;" id="update-vehicle-image-data-3" src="" alt="Hình ảnh của xe">
                    <div class="message_error" id="error-update-vehicle-vehicle_image_name">

                    </div>
                </div>

                

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-submit-update-vehicle">Cập nhật</button>
            </div>
        </div>
    </div>
</form>