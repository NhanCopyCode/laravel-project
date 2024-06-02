$(function() {
    let dispaly_booking_amount_paid = $('input[name="booking_total_price"]').val().trim();
    dispaly_booking_amount_paid = parseFloat(dispaly_booking_amount_paid) * (100/15);
    dispaly_booking_amount_paid = String(dispaly_booking_amount_paid);
    $('#booking_vehicle_price').text(formatCash(dispaly_booking_amount_paid));
   $('#booking_daterange').on('change', function(e) {
         // Giả sử value input của bạn là một chuỗi như sau:
        const  input = $(this).val();
        const rental_price_date = $('input[name="booking_rental_price_day"]').val();

        // Tách chuỗi dựa vào ' - ' để lấy ngày bắt đầu và kết thúc
        const dates = input.split(' - ');

        // Chuyển đổi các chuỗi thành đối tượng Date
        const startDate = new Date(dates[0]);
        const endDate = new Date(dates[1]);


        // Tính số ngày chênh lệch
        const timeDiff = endDate - startDate;

        // Chia cho số milliseconds trong một ngày
        const daysDiff = timeDiff / (1000 * 60 * 60 * 24) + 1;
      
        let totalPrice = daysDiff * rental_price_date;
        let amount_paid = totalPrice * (15 / 100);
        // console.log("Số tiền phải trả 10%: "  + amount_paid);

        // Set tiền vào cho input booking vehicle price 
        $('#booking_total_price').val(amount_paid);


        totalPrice = formatCash(totalPrice.toString());
        $('#booking_vehicle_price').text(totalPrice);
        $('#booking_vehicle_price').addClass('alert alert-success');

       
   });

   function formatCash(str) {
      if (str === '') return str;
      return str.split('').reverse().reduce((prev, next, index) => {
        return ((index % 3) ? next : (next + '.')) + prev
      })
    }
});