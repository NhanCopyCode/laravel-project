<div class="section__container">
  
    @if (session('msg--success'))
        <div class="alert alert-success">
            {!! session('msg--success') !!}
        </div>
    @endif
    @if (session('msg--success-vnpay'))
        <div class="alert alert-success">
            {!! session('msg--success-vnpay') !!}
        </div>
    @endif
   <div class="vehicle-detail__container">
        <div class="vehicle-detail__container-left">
            <div class="vehicle-detail__header">
                <h1 class="vehicle-detail__title">
                    {{$vehicle->model_name}}
                </h1>
            </div>
            <div class="vehicle-detail__group-img">
                <a class="vehicle-detail__main-image" href="{{$vehicle->vehicle_image_data_1}}" data-lightbox="vehicle_images">
                    <img src="{{$vehicle->vehicle_image_data_1}}" alt="Ảnh xe">
                </a>
                <div class="vehicle-detail__group-img__footer">
                    <a href="{{$vehicle->vehicle_image_data_1}}" data-lightbox="vehicle_images">
                        <img src="{{$vehicle->vehicle_image_data_1}}" alt="Ảnh xe">
                    </a>
                    <a href="{{$vehicle->vehicle_image_data_2}}" data-lightbox="vehicle_images">
                        <img src="{{$vehicle->vehicle_image_data_2}}" alt="Ảnh xe">
                    </a>
                    <a href="{{$vehicle->vehicle_image_data_3}}" data-lightbox="vehicle_images">
                        <img src="{{$vehicle->vehicle_image_data_3}}" alt="Ảnh xe">
                    </a>
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
               
                <p id="rental_price_day_detail">Giá thuê một ngày: <span  class="vnd_format">{{$vehicle->rental_price_day}}</span> VND</p>
            </div>
            <form action="{{route('user.booking.vehicle')}}" method="POST" class="vehicle-detail__container-right__group-input" id="form_booking_vehicle_detail">
                @csrf
                <input type="hidden" name="vehicle_id" value="{{$vehicle->vehicle_id}}">
                <input type="hidden" name="booking_rental_price_day" value="{{$vehicle->rental_price_day}}">
                
                <div class="form-group">
                    <label style="font-weight: bold;" class="font-weight-bold" for="booking_daterange">Chọn ngày thuê</label>
                    <input class="form-control" required  type="text" id="booking_daterange" name="booking_daterange" value="{{old('booking_daterange')}}"/>
                    @if ($errors->has('booking_daterange'))
                        <span class="text-danger">{{ $errors->first('booking_daterange') }}</span>
                    @elseif ($errors->has('booking_total_price'))
                        <span class="text-danger">{{ $errors->first('booking_total_price') }}</span>
                    @endif

                </div>
                {{-- Tiếng việt --}}
                <input type="hidden" id="language"  name="language" value="vn">
                <input type="hidden" name="payment_method_id" value="1">

                
                <p>Số tiền phải trả: <span id="booking_vehicle_price" class="vnd_format"></span></p>
               
                <input type="hidden" id="booking_total_price" name="booking_total_price" value="{{$vehicle->rental_price_day}}" >
                <button style="margin-top: 24px;" name="form_booking_vehicle" id="booking_vehicle_button" class="btn btn-primary" type="button" data-toggle="modal" data-target="#bookingModal">Thanh toán bằng tiền mặt</button>
                <button id="button_vnpay_payment" class="btn btn-dark" name="redirect" value="vnpay_payment" type="submit"><ion-icon name="card-outline"></ion-icon>Thanh toán VNPAY</button>
            </form>

            {{-- <form action="{{route('vnpay.payment')}}" method="POST">
                @csrf
            <button id="button_vnpay_payment" class="btn btn-outline-dark" name="redirect" type="submit"><ion-icon name="card-outline"></ion-icon>Thanh toán VNPAY</button>
            </form> --}}
            {{-- Button VNPAY --}}
            
        </div>
   </div>

</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <script>
        Swal.fire({
            title: 'Đặt xe thất bại! Xin vui lòng hãy kiểm tra!!',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonText: 'OK',
            });
    </script>
@endif

@if (session('msg--success'))
    <script>
        Swal.fire({
              title: 'Đặt xe thành công, hãy vào lịch sử đặt xe để kiểm tra!',
              icon: 'success',
              showCancelButton: false,
              confirmButtonText: 'OK',
            });
    </script>
@endif

@if (session('msg--failure'))
    <script>
        Swal.fire({
              title: '{{ session('msg--failure') }}',
              icon: 'warning',
              showCancelButton: false,
              confirmButtonText: 'OK',
            });
    </script>
@endif

@if (session('error'))
    <script>

        Swal.fire({
              title: 'Đặt xe thất bại! Xin vui lòng hãy kiểm tra lại!',
              icon: 'warning',
              showCancelButton: false,
              confirmButtonText: 'OK',
            });
    </script>
@endif


<script defer>
    // document.addEventListener('DOMContentLoaded', function(e) {

    //     const formBookingVehicle = document.getElementById('form_booking_vehicle_detail');
    //     const bookingButton = document.getElementById('booking_vehicle_button');
        
    //     console.log(formBookingVehicle);
    //     formBookingVehicle.addEventListener('submit', function(e) {
    //         e.preventDefault();
    //         console.log('sdafsf');
    //     });
    //     bookingButton.addEventListener('click', function(event) {
    //         event.preventDefault(); // Ngăn chặn việc gửi form mặc định

    //         var userConfirmation = confirm("Bạn có muốn đặt xe không?"); // Hiển thị cảnh báo

    //         if(userConfirmation) {
    //             formBookingVehicle.submit(); // Nếu người dùng nhấn OK, gửi form
    //         }
    //         // Không cần phần else vì event đã bị prevent ở trên rồi nếu không phải là OK.
    //     });

    // });

</script>
 
<script>
    $(document).ready(function() {
         // Auto focus khi người dùng mới vào trang
         $('#booking_daterange').focus();
    });
    $(function() {
        const list_rental_time = @json($list_rental_time);
        // Hàm kiểm tra xem ngày đã có trong danh sách không
        function isInvalidDate(date) {
            return list_rental_time.some(function (rental) {
                // Sử dụng 'rental_start_date' và 'rental_end_date' từ object
                const start = moment(rental.rental_start_date);
                const end = moment(rental.rental_end_date).subtract(1, 'days');
                // Kiểm tra xem 'date' có nằm trong khoảng thời gian không khả dụng đó không
                // So sánh ở cấp độ ngày để bỏ qua giờ
                return date.isBetween(start, end, 'day', '[]');
            });
        }

       
        $('input[name="booking_daterange"]').daterangepicker(
            {
                opens: 'left',
                // autoUpdateInput: false,
                minDate: new Date(),
                isInvalidDate: isInvalidDate ,// Sử dụng hàm để xác định các ngày không khả dụng
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }, 
            function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
</script>
<script defer src="{{asset('assets/clients/js/total_cost_vehicle_detail.js')}}"></script>