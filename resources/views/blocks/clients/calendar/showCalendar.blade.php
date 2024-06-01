<div class="section__container">
    <div id="calendar"></div>
</div>

<script>
    $(document).ready(function() {
        var booking = @json($events);
        $('#calendar').fullCalendar({
            editable: false,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek' // Thêm các chế độ xem khác
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
        });
    });
</script>