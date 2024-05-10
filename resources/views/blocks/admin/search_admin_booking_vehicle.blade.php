 <table class="table table-bordered table-admin-item-booking-vehicle table-payment" style="margin-top: 24px; min-width: 400px;">
    <thead>
        <tr>
            <th class="text-center">STT</th>
            <th style="text-align: center;">
                <input type="checkbox" class="check-all">
            </th>
            <th scope="col">ID giao dịch</th>
            <th scope="col">Xe thuê</th>
            <th scope="col">Hình ảnh xe</th>
            <th scope="col">Tổng tiền</th>
            <th scope="col">Ngày bắt đầu thuê</th>
            <th scope="col">Ngày kết thúc</th>
            <th scope="col">Trạng thái thanh toán</th>
            <th scope="col">Ngày thanh toán</th>
            <th scope="col">Phương thức thanh toán</th>
            <th scope="col">Trạng thái giao dịch</th>
            
            <th scope="col">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @if ($list_booking_vehicle->count() === 0)
            <h1 id="payment-no-data-text" class="text-center text-danger">Không có dữ liệu</h1>                
        @endif
        @foreach ($list_booking_vehicle as $item)
        <tr>
            <th class="text-center">{{++$i}}</th>
            <th scope="row" style="text-align: center;">
                <input type="checkbox"  id="payment-id payment-id-{{$item->payment_id}}">
            </th>
            <td>{{$item->payment_id}}</td>
            <td>{{$item->model_name}}</td>
            <td>
                <img style="height: 100px; object-fit: cover;" src="{{$item->vehicle_image_data_1}}" alt="Hình ảnh xe">
            </td>
            
            <td>{{$item->amount}}</td>
            <td>{{$item->rental_start_date}}</td>
            <td>{{$item->rental_end_date}}</td>
            
            @if ($item->rental_status_id === 1)
            <td class="text-danger">{{$item->rental_status_name}}</td>
            @else 
            <td class="text-success">{{$item->rental_status_name}}</td>
            @endif
            
            @if ($item->payment_date === null) 
                <td class="text-center">------</td>
            @else 
                <td>{{$item->payment_date}}</td>
            @endif

            {{-- Phương thức thanh toán --}}
            <td class="text-center">{{$item->payment_method_name}}</td>
            {{-- Trạng thái giao dịch --}}
            
            @if ($item->payment_is_deleted === 0 || $item->payment_is_deleted === null)
                <td class="text-success">Vẫn còn hiệu lực</td>
            @else 
                <td class="text-danger">Không còn hiệu lực</td>
            @endif
            <td style="display: flex;align-items: center;">
                <a  href=""
                    class="btn btn-primary btn-update btn-update-payment" 
                    data-toggle = "modal"
                    data-target = "#form_update_payment"
                    data-id = "{{$item->payment_id}}"
                    data-rental-status-id = "{{$item->rental_status_id}}"
                    data-rental-status-name = "{{$item->rental_status_name}}"
                    data-rental-id = "{{$item->rental_id}}"
                    data-payment-is-deleted = "{{$item->payment_is_deleted}}"
                >
                    <i class="fa-regular fa-pen-to-square"></i>
                </a>
                {{-- <form action="{{route('admin.payment.delete')}}" method="POST" id="form_delete_payment">
                    @csrf
                    <input type="hidden" name="delete_payment_id" value="{{$item->payment_id}}">
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </form> --}}
               
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{-- {{$branchList->links()}} --}}