<table class="table table-bordered table-vehicle" style="margin-top: 24px; min-width: 400px;">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th style="text-align: center;">
                    <input type="checkbox" class="check-all">
                </th>
                <th>Id xe</th>
                <th>Cửa hàng</th>
                <th>Mẫu xe</th>
                <th>Thông tin chi tiết</th>
                <th>Biển số xe</th>
                <th>Giá thành thuê /ngày</th>
                <th>Ảnh của xe</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Lựa chọn</th>
            </tr>
        </thead>
        <tbody>
            @if ($vehicleList->count() === 0)
                <h1 id="vehicle-no-data-text" class="text-center text-danger">Không có dữ liệu</h1>                
            @endif
            @foreach ($vehicleList as $item)
            <tr>
                <th class="text-center">{{++$i}}</th>
                <th scope="row" style="text-align: center;">
                    <input type="checkbox"  id="vehicle-id vehicle-id-{{$item->vehicle_id}}">
                </th>
                <td>{{$item->vehicle_id}}</td>
                <td>{{$item->unique_location}}</td>
                <td>{{$item->model_type}}</td>
                <td>{{$item->vehicle_description}}</td>
                <td>{{$item->license_plate}}</td>
                <td>{{$item->rental_price_day}}</td>
                <td >
                    <img style="width: 100px; height:100px; object-fit: cover;" src="{{$item->vehicle_image_data_1}}" alt="Ảnh xe">
                    <img style="width: 100px; height:100px; object-fit: cover;" src="{{$item->vehicle_image_data_2}}" alt="Ảnh xe">
                    <img style="width: 100px; height:100px; object-fit: cover;" src="{{$item->vehicle_image_data_3}}" alt="Ảnh xe">
                </td>
                <td>
                    @php
                        if($item->vehicle_status_id === 1) {
                            echo '<span class="text-success">Hoạt động</span>';
                        }

                        if($item->vehicle_status_id === 2) {
                            echo '<span class="text-danger">Dừng hoạt động</span>';
                        }
                            
                    @endphp
                </td>
                <td>{{$item->vehicle_created_at}}</td>
                <td style="display: flex;align-items: center;">
                    <a  href=""
                        class="btn btn-primary btn-update btn-update-vehicle" 
                        data-toggle = "modal"
                        data-target = "#form_update_vehicle"
                        data-id = "{{$item->vehicle_id}}"
                        data-CarRentalStore-id = "{{$item->vehicle_carrentalstore_id}}"
                        data-model-type = "{{$item->model_type}}"
                        data-model-id = "{{$item->model_id}}"
                        data-description = "{{$item->vehicle_description}}"
                        data-license-plate = "{{$item->license_plate}}"
                        data-rental-price-day = "{{$item->rental_price_day}}"
                        data-vehicle-image-id = "{{$item->vehicle_image_id}}"
                        data-vehicle-status-id = "{{$item->vehicle_status_id}}"
                        data-vehicle-image-data-1 = "{{$item->vehicle_image_data_1}}"
                        data-vehicle-image-data-2 = "{{$item->vehicle_image_data_2}}"
                        data-vehicle-image-data-3 = "{{$item->vehicle_image_data_3}}"
                    >
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    {{-- <form action="{{route('admin.vehicle.delete')}}" method="POST" id="form_delete_vehicle">
                        @csrf
                        <input type="hidden" name="delete_vehicle_id" value="{{$item->vehicle_id}}">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </form> --}}
                    <a  href=""
                        class="btn btn-danger btn-delete btn-delete-vehicle" 
                        data-toggle = "modal"
                        data-target = "#form_delete_vehicle"
                        data-vehicle-id = "{{$item->vehicle_id}}"
                        data-vehicle-image-id = "{{$item->vehicle_image_id}}"
                        data-license-plate = "{{$item->license_plate}}"
                    >
                        <i class="fa-regular fa-trash-can"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>