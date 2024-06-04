<div class="section__container" style="overflow-x: scroll;">
    <h1 class="booking_history__title text-center alert-info alert">Lịch sử thuê xe</h1>
    @if ($list_booking_vehicle->count() > 0)
        <table  class="table table-bordered mt-4">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Xe thuê</th>
                    <th scope="col">Hình ảnh xe</th>
                    <th scope="col">Số tiền đã trả</th>
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
                        
                        <td class="vnd_format">{{$history->amount_paid}}</td>
                        <td >{{$history->rental_start_date}}</td>
                        <td >{{$history->rental_end_date}}</td>
                        
                        
                        {{-- Nếu rental status id = 3 = Bị hủy --}}
                        @if ($history->rental_status_id === 3)
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
                            <a class="btn btn-primary " href="{{route('user.showVehicle', ['vehicle' => $history->vehicle_id])}}">Đặt lại xe</a>
                        </td>


                        {{-- Hành động --}}
                        <td>
                            <form action="{{route('user.cancel.vehicle', ['rental' => $history->rental_id])}}" method="POST" id="form_cancel_booking_vehicle">
                                @csrf
                                <input type="hidden" value="{{$history->rental_start_date}}" name="client_booking_rental_start_date" id="client_booking_rental_start_date">
                                <input type="hidden" value="{{$history->rental_end_date}}" name="client_booking_rental_end_date" id="client_booking_rental_end_date">
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

<script>
    $(document).ready(function () {
        function isOver48Hours(rentalStartDate) {
            // Lấy thời gian hiện tại
            var currentTime = new Date();

            // Tính số milliseconds từ thời điểm hiện tại đến thời điểm rentalStartDate
            var timeDiff = currentTime.getTime() - new Date(rentalStartDate).getTime();

            // Chuyển số milliseconds thành số giờ
            var hoursDiff = timeDiff / (1000 * 3600);

            // Kiểm tra nếu số giờ lớn hơn 48 thì trả về true, ngược lại trả về false
            return hoursDiff >= 48;
        }
        $(document).on('submit', '#form_cancel_booking_vehicle', function(e) {
            e.preventDefault(); 

            var form = $(this); // Lấy ra form đang được submit
            var url = form.attr('action'); // Lấy URL của action gửi form

            // Lấy rental_id từ input trong form
            var rental_id = form.find('input[name="rental_id"]').val();
            var rental_start_date = form.find('input[name="client_booking_rental_start_date"]').val();
            var rental_end_date = form.find('input[name="client_booking_rental_end_date"]').val();

            console.log(rental_start_date, rental_end_date);

            Swal.fire({
                title: `Bạn xác nhận có muốn hủy đặt xe không`,
                text: isOver48Hours(rental_start_date) ? "Do thời gian hủy đặt vẫn đúng quy định (trước 48h) nên hãy liên hệ số điện thoại 0919094701 để nhận lại số tiền cọc!" : "Do thời gian hủy đặt xe đã vi phạm quy định. Vậy nên bạn sẽ mất số tiền cọc, bạn có chắc chắn muốn hủy đặt xe?",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hủy thuê xe',
                cancelButtonText: 'Thoát',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                _token: "{{ csrf_token() }}", // Thêm token bảo mật CSRF
                                rental_id: rental_id // Truyền rental_id vào dữ liệu gửi đi
                            },
                            success: function (response) {
                                // Xử lý khi thành công, ví dụ như làm mới trang
                                location.reload();
                            },
                            error: function (xhr, status, error) {
                                // Xử lý khi có lỗi
                                console.error(xhr.responseText);
                            }
                        });

                    }

                })
            
        });
    });
</script>