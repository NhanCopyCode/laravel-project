<table class="table table-bordered table-carrentalstore" style="margin-top: 24px; min-width: 400px;">
    <thead>
        <tr>
            <th class="text-center">STT</th>
            <th style="text-align: center;">
                <input type="checkbox" class="check-all">
            </th>
            <th>Id cửa hàng</th>
            <th>Địa chỉ cửa hàng</th>
            <th>Hình ảnh cửa hàng</th>
            <th>Chú thích cửa hàng</th>
            <th>Số điện thoại</th>
            <th>Chi nhánh</th>
            <th>Ngày tạo</th>
            <th>Lựa chọn</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($carRentalStoreList as $item)
        <tr>
            <th class="text-center">{{++$i}}</th>
            <th scope="row" style="text-align: center;">
                <input type="checkbox"  id="carrentalstore-id carrentalstore-id-{{$item->CarRentalStore_id}}">
            </th>
            <td>{{$item->CarRentalStore_id}}</td>
            <td>{{$item->real_location}}</td>
            <td>
                <img style="width: 100px; height: 100px;" src="http://127.0.0.1:8000/{{$item->avatar}}" alt="">
            </td>
            <td>{{$item->description}}</td>
            <td>{{$item->phone_number}}</td>
            <td>{{$item->branch_name}}</td>
            <td>{{$item->created_at}}</td>
            
            <td style="display: flex;align-items: center;">
                <a  href=""
                    class="btn btn-primary btn-update btn-update-carrentalstore" 
                    data-toggle = "modal"
                    data-target = "#form_update_carrentalstore"
                    data-id = "{{$item->CarRentalStore_id}}"
                    data-phone-number = "{{$item->phone_number}}"
                    data-avatar = "{{$item->avatar}}"
                    data-description = "{{$item->description}}"
                    data-location-id = "{{$item->location_id}}"
                    data-branch-id = "{{$item->branch_id}}"
                    data-province = "{{$item->province}}"
                    data-district = "{{$item->district}}"
                    data-ward = "{{$item->ward}}"
                    data-unique-location = "{{$item->unique_location}}"
                    data-province-id = "{{$item->province_id}}"
                    data-district-id = "{{$item->district_id}}"
                    data-ward-id = "{{$item->ward_id}}"
                >
                    <i class="fa-regular fa-pen-to-square"></i>
                </a>
                {{-- <form action="{{route('admin.carrentalstore.delete')}}" method="POST" id="form_delete_carrentalstore">
                    @csrf
                    <input type="hidden" name="delete_CarRentalStore_id" value="{{$item->CarRentalStore_id}}">
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </form> --}}
                <a  href=""
                    class="btn btn-danger btn-delete btn-delete-carrentalstore" 
                    data-toggle = "modal"
                    data-target = "#form_delete_carrentalstore"
                    data-carrentalstore-id = "{{$item->CarRentalStore_id}}"
                    data-location-id = "{{$item->location_id}}"
                >
                    <i class="fa-regular fa-trash-can"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$carRentalStoreList->links()}}