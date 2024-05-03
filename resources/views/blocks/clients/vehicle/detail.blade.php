<div class="section__container">
  
   <div class="vehicle-detail__container">
        <div class="vehicle-detail__container-left">
            <div class="vehicle-detail__header">
                <h1 class="vehicle-detail__title">
                    {{$vehicle->model_name}}
                </h1>
            </div>
            <div class="vehicle-detail__group-img">
                <img src="{{$vehicle->vehicle_image_data_1}}" alt="Ảnh xe">
                <div class="vehicle-detail__group-img__footer">
                    <img src="{{$vehicle->vehicle_image_data_1}}" alt="Ảnh xe">
                    <img src="{{$vehicle->vehicle_image_data_2}}" alt="Ảnh xe">
                    <img src="{{$vehicle->vehicle_image_data_3}}" alt="Ảnh xe">
    
                </div>
            </div>
        </div>

        <div class="vehicle-detail__container-right">
            <div class="vehicle-detail__container-right__location">
                <h3>Vị trí: {{$vehicle->unique_location}}</h2>
                <p>Động cơ: {{$vehicle->engine_type}} phân khối</p>
                <p>Màu sắc: {{$vehicle->color}}</p>
                <p>Năm sản xuất: {{$vehicle->year_of_production}}</p>
                @if ($vehicle->vehicle_status_name === "Hoạt động")
                    <p >Trạng thái: <span class="text-success">{{$vehicle->vehicle_status_name}}</span></p>
                @else 
                    <p >Trạng thái: <span class="text-danger">{{$vehicle->vehicle_status_name}}</span></p>
                @endif
               
                <p>Giá thuê một ngày: <span class="vnd_format">{{$vehicle->rental_price_day}}</span> VND</p>
            </div>
            <form action="{{route('user.booking.vehicle')}}" method="POST" class="vehicle-detail__container-right__group-input">
                @csrf
                <input type="hidden" name="vehicle_id" value="{{$vehicle->vehicle_id}}">
                <input type="hidden" name="booking_rental_price_day" value="{{$vehicle->rental_price_day}}">
                {{-- <div class="form-group">
                    <label for="paymentmethod">Chọn phương thức thanh toán</label>
                    @foreach ($payment_method_list as $payment_method_item)
                        <div class="form-check">
                            <input type="radio" name="payment_method_id" id="payment_method_{{$payment_method_item->payment_method_id}}" class="form-check-input" value="{{$payment_method_item->payment_method_id}}">
                            <label for="payment_method_{{$payment_method_item->payment_method_id}}" class="form-check-label">
                                {{$payment_method_item->payment_method_name}}
                            </label>
                        </div>
                    @endforeach
                    @error('payment_method')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
               </div> --}}
               <div class="form-group">
                    <label for="start_date">Ngày bắt đầu</label>
                    <input class="form-control" type="date" name="booking_start_date" id="booking_start_date">
                    @error('booking_start_date')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
               </div>
               <div  class="form-group">
                    <label for="end_date">Ngày kết thúc</label>
                    <input class="form-control" type="date" name="booking_end_date" id="booking_end_date">
                    @error('booking_end_date')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <p>Số tiền phải trả: <span id="booking_vehicle_price"></span></p>
                <input type="hidden" id="booking_total_price" name="booking_total_price" value="">
                <button style="margin-top: 24px;" name="form_booking_vehicle" class="btn btn-primary" type="submit">Đặt xe</button>
            </form>
            <form action="{{route('vnpay.payment')}}" method="POST">
                @csrf
            <button id="button_vnpay_payment" class="btn btn-outline-dark" name="redirect" type="submit"><ion-icon name="card-outline"></ion-icon>Thanh toán VNPAY</button>
            </form>
        </div>
   </div>

</div>