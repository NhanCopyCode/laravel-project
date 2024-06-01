<div id="admin_booking_calendar">

</div>
<div class="modal fade" id="modal_calendar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="POST" action="{{route('admin.booking.vehicle.cancle')}}" class="modal-dialog" role="document" id="form_admin_cancle_booking_vehicle">
        @csrf
        {{-- <input type="hidden" name="user_id">
        <input type="hidden" name="vehicle_id"> --}}
        <input type="hidden" name="rental_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hủy lịch đăng ký xe</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h4 class="text-center alert alert-danger ">Bạn có muốn hủy lịch đăng kí xe <span id="vehicle_title"></span> này?</h4>
            @error('rental_id')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            <p class="fw-bold">Thời gian đăng kí</p>
            <p>Từ ngày: <span id="vehicle_rental_start_date"></span></p>
            <p>Đến ngày: <span id="vehicle_rental_end_date"></span></p>

            <div class="form-group">
                <label for="reason">Hãy nhập lí do hủy lịch đăng ký xe</label>
                <textarea name="reason" id="reason" cols="55" rows="5" required="">
                </textarea>
                @error('reason')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger btn_cancel_booking_vehicle">Hủy lịch đăng ký xe</button>
        </div>
      </div>
    </form>
  </div>
<script>
    $(document).ready(function() {
        var booking = @json($events);
        console.log('admin booking', booking);
        function renderCalendar() {
            $('#admin_booking_calendar').fullCalendar({
                editable: false,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month' // Thêm các chế độ xem khác
                },
                disableDragging: true,
                events: booking,
                selectable: true,
                selectHelper: true,
                defaultView: 'month', // Đặt chế độ xem mặc định là tuần hoặc ngày để hiển thị thời gian
                allDaySlot: true, // Ẩn khung thời gian "All Day"
                slotDuration: '01:00:00', // Đặt độ dài của mỗi khung thời gian (ở đây là 30 phút)
                // minTime: '06:00:00', // Giới hạn thời gian bắt đầu hiển thị trên lịch (6 giờ sáng)
                // maxTime: '20:00:00', // Giới hạn thời gian kết thúc hiển thị trên lịch (8 giờ tối)
                timeFormat: 'H:mm', // Định dạng thời gian 24 giờ
                dayClick: function(info) {
                    console.log(info);
                },
                eventClick: function(info) {
                    var formattedStart = moment(info.start).format('YYYY-MM-DD HH:mm:ss');
                    var formattedEnd = moment(info.end).format('YYYY-MM-DD HH:mm:ss');

                    $('input[name="rental_id"]').val(info.rental_id);
                    // $('input[name="user_id"]').val(info.user_id);
                    // alert('Id của event: ' + info.id);
                    $('#modal_calendar').modal('show');
                    $('#vehicle_title').text(info.title);
                    $('#vehicle_rental_start_date').text(formattedStart);
                    $('#vehicle_rental_end_date').text(formattedEnd);
                }
            });
        }
        renderCalendar();

        $('#form_admin_cancle_booking_vehicle').on('submit', function(e) {
            e.preventDefault();
            const rental_id = $('input[name="rental_id"]').val().trim();
            const reasonText = $('#reason').val();

            console.log()
            // Thêm code xử lý ở đây
            $.ajax({
                type: "POST",
                url: "{{ route('admin.booking.vehicle.cancle') }}",
                data: {
                    _token: $('input[name="_token"]').val(),
                    rental_id: rental_id,
                    reason: reasonText
                },
                success: function (response) {
                    // alert(response);
                    // Có thể thêm mã để làm mới lịch hoặc đóng modal sau khi hủy thành công
                    $('#modal_calendar').modal('hide');

                    // $('#admin_booking_calendar').load(location.href + ' .content > *');
                    location.reload();
                    // renderCalendar();

                    // $('#admin_booking_calendar').fullCalendar('refetchEvents');
                },
                error: function(err) {
                    alert('Có lỗi xảy ra: ' + err.responseJSON.message);
                }
            });
        });
    });
</script>