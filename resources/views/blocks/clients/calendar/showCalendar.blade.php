<div class="section__container">
    <div id="calendar"></div>
</div>

<script>
    $(document).ready(function() {
        var booking = @json($events);
        var calendar = $('#calendar').fullCalendar({
            editable:true,
            header:{
            left:'prev,next today',
            center:'title',
            right:'month'
            },
            events: booking,
            selectable: true,
            selectHelper: true,
        })
    });
</script>