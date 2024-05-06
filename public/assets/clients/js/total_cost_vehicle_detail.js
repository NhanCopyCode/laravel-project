$(function() {
   $('#booking_daterange').on('change', function(e) {
         // Giả sử value input của bạn là một chuỗi như sau:
        const  input = $(this).val();
        const rental_price_date = $('input[name="booking_rental_price_day"]').val();

        // Tách chuỗi dựa vào ' - ' để lấy ngày bắt đầu và kết thúc
        const dates = input.split(' - ');

        // Chuyển đổi các chuỗi thành đối tượng Date
        const startDate = new Date(dates[0]);
        const endDate = new Date(dates[1]);

        console.log(startDate, endDate);

        // Tính số ngày chênh lệch
        const timeDiff = endDate - startDate;

        // Chia cho số milliseconds trong một ngày
        const daysDiff = timeDiff / (1000 * 60 * 60 * 24);
      
        let totalPrice = daysDiff * rental_price_date;
        totalPrice = formatCash(totalPrice.toString());
        $('#booking_vehicle_price').text(totalPrice);
       
   });

   function formatCash(str) {
      if (str === '') return str;
      return str.split('').reverse().reduce((prev, next, index) => {
        return ((index % 3) ? next : (next + '.')) + prev
      })
    }
});