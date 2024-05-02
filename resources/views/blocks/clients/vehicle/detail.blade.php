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
            <form action="" method="POST" class="vehicle-detail__container-right__group-input">
                <div class="form-group">
                    <label for="paymentmethod">Chọn phương thức thanh toán</label>
                    <select class="form-control" name="payment_method" id="paymentmethod">
                        @foreach ($payment_method_list as $payment_method_item)
                            <option value="{{$payment_method_item->payment_method_id}}">{{$payment_method_item->payment_method_name}}</option>
                        @endforeach
                    </select>
               </div>
               <div class="form-group">
                    <label for="start_date">Ngày bắt đầu</label>
                    <input class="form-control" type="date" name="start_date" id="start_date">
               </div>
               <div  class="form-group">
                    <label for="end_date">Ngày kết thúc</label>
                    <input class="form-control" type="date" name="end_date" id="end_date">
                </div>



                <button style="margin-top: 24px;" class="btn btn-primary" type="submit">Đặt xe</button>
            </form>
        </div>
   </div>

</div>