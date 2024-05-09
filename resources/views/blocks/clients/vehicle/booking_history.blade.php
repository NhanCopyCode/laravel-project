<div class="section__container">
    <h1 class="booking_history__title text-center">Lịch sử thuê xe</h1>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Id</th>
              <th scope="col">Xe thuê</th>
              <th scope="col">Hình ảnh xe</th>
              <th scope="col">Tổng tiền</th>
              <th scope="col">Ngày bắt đầu thuê</th>
              <th scope="col">Ngày kết thúc</th>
              <th scope="col">Trạng thái</th>
              <th scope="col">Ngày thanh toán</th>
              <th scope="col">Thuê lại xe</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_booking_vehicle as $history)
                <tr>
                    <th scope="row">1</th>
                    <td>{{$history->payment_id}}</td>
                    <td>{{$history->model_name}}</td>
                    <td>
                        <img style="height: 100px; object-fit: cover;" src="{{$history->vehicle_image_data_1}}" alt="Hình ảnh xe">
                    </td>
                    
                    <td>{{$history->amount}}</td>
                    <td>{{$history->rental_start_date}}</td>
                    <td>{{$history->rental_end_date}}</td>
                    
                    @if ($history->rental_status_id === 1)
                    <td class="text-danger">{{$history->rental_status_name}}</td>
                    @else 
                    <td class="text-success">{{$history->rental_status_name}}</td>
                    @endif
                    
                    @if ($history->payment_date === null) 
                        <td class="text-center">------</td>
                    @else 
                        <td>{{$history->payment_date}}</td>
                    @endif
                    <td>
                        <a href="{{route('user.showVehicle', ['vehicle' => $history->vehicle_id])}}">Link</a>
                    </td>
                </tr>
                @endforeach
               
        </tbody>
    
    </table>
    {{$list_booking_vehicle->links()}}
</div>