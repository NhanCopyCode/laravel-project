<div class="section__container">
    <h1 class="booking_history__title text-center alert-info alert">Lịch sử thuê xe</h1>
    @if ($list_booking_vehicle->count() > 0)
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                <th scope="col">Xe thuê</th>
                <th scope="col">Hình ảnh xe</th>
                <th scope="col">Tổng tiền</th>
                <th scope="col">Ngày bắt đầu thuê</th>
                <th scope="col">Ngày kết thúc</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Ngày thanh toán</th>
                <th scope="col">Hình thức thanh toán</th>
                <th scope="col">Thuê lại xe</th>
                <th scope="col">Hành động</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($list_booking_vehicle as $history)
                    <tr>
                        <td>{{$history->model_name}}</td>
                        <td>
                            <img style="height: 100px; object-fit: cover;" src="{{$history->vehicle_image_data_1}}" alt="Hình ảnh xe">
                        </td>
                        
                        <td class="vnd_format">{{$history->amount}}</td>
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
                        {{-- Hình thức thanh toán --}}
                        <td>{{$history->payment_method_name}}</td>
                        <td>
                            <a href="{{route('user.showVehicle', ['vehicle' => $history->vehicle_id])}}">Link</a>
                        </td>


                        {{-- Hành động --}}
                        <td>
                            <form action="{{route('user.cancel.vehicle', ['rental' => $history->rental_id])}}" method="POST">
                                @csrf
                                {{-- <a href="{{route('user.cancel.vehicle' , ['payment' => $history->payment_id])}}" class="btn btn-danger btn-sm">Hủy đặt xe</a> --}}
                                <button class="btn btn-danger">Hủy đặt xe</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                
            </tbody>
        
        </table>
    @else 
        <h2 class="alert alert-success text-center mt-5">Bạn chưa đặt xe nào, nếu muốn đặt xe hãy click vào <a href="{{route('user.booking.index')}}">đây</a></h2>
    @endif
    {{$list_booking_vehicle->links()}}
</div>