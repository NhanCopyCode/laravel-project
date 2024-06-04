'use strict';


// modal variables
const modal = document.querySelector('[data-modal]');
const modalCloseBtn = document.querySelector('[data-modal-close]');
const modalCloseOverlay = document.querySelector('[data-modal-overlay]');

// // modal function
// const modalCloseFunc = function () { modal.classList.add('closed') }

// // modal eventListener
// modalCloseOverlay.addEventListener('click', modalCloseFunc);
// modalCloseBtn.addEventListener('click', modalCloseFunc);





// notification toast variables
// const notificationToast = document.querySelector('[data-toast]');
// const toastCloseBtn = document.querySelector('[data-toast-close]');

// // notification toast eventListener
// toastCloseBtn.addEventListener('click', function () {
//   notificationToast.classList.add('closed');
// });




// mobile menu variables
const mobileMenuOpenBtn = document.querySelectorAll('[data-mobile-menu-open-btn]');
// console.log(mobileMenuOpenBtn);
const mobileMenu = document.querySelectorAll('[data-mobile-menu]');
const mobileMenuCloseBtn = document.querySelectorAll('[data-mobile-menu-close-btn]');
const overlay = document.querySelector('[data-overlay]');


for (let i = 0; i < mobileMenuOpenBtn.length; i++) {
  console.log(mobileMenuOpenBtn[i]);
  // mobile menu function
  const mobileMenuCloseFunc = function () {
    mobileMenu[i].classList.remove('active');
    overlay.classList.remove('active');
  }

  mobileMenuOpenBtn[i].addEventListener('click', function () {
    mobileMenu[i].classList.add('active');
    overlay.classList.add('active');
    console.log('Xin chào bạn đã click vào nút đầu tiên')
  });

  mobileMenuCloseBtn[i].addEventListener('click', mobileMenuCloseFunc);
  overlay.addEventListener('click', mobileMenuCloseFunc);

}





// accordion variables
const accordionBtn = document.querySelectorAll('[data-accordion-btn]');
const accordion = document.querySelectorAll('[data-accordion]');

for (let i = 0; i < accordionBtn.length; i++) {

  accordionBtn[i].addEventListener('click', function () {

    const clickedBtn = this.nextElementSibling.classList.contains('active');

    for (let i = 0; i < accordion.length; i++) {

      if (clickedBtn) break;

      if (accordion[i].classList.contains('active')) {

        accordion[i].classList.remove('active');
        accordionBtn[i].classList.remove('active');

      }

    }

    this.nextElementSibling.classList.toggle('active');
    this.classList.toggle('active');

  });

}

// Ẩn hiện menu của user

document.addEventListener('DOMContentLoaded', function() {
  const user_icon = document.querySelector('.user_icon');
  if(user_icon) {
    user_icon.addEventListener('click', function(event) {
        var userMenu = document.querySelector('.user_menu');
        if(userMenu) {
            userMenu.classList.toggle('show');
        }
    });
  }

  // Đóng menu khi click ra ngoài
  window.onclick = function(event) {
      if (!event.target.matches('.user_icon')) {
          var dropdowns = document.getElementsByClassName('user_menu');
          for (var i = 0; i < dropdowns.length; i++) {
              var openDropdown = dropdowns[i];
              if (openDropdown.classList.contains('show')) {
                  openDropdown.classList.remove('show');
              }
          }
      }
  };
});

// Xử lý phần min date của form booking
// document.addEventListener('DOMContentLoaded', function(){
//     const today = new Date().toISOString().slice(0, 10); // Lấy ngày hiện tại và chuyển định dạng sang YYYY-MM-DD
//     const startDateInput = document.getElementById('start-date');
//     const endDateInput = document.getElementById('end-date');

//     // Thiết lập ngày tối thiểu cho cả start và end date tương ứng với ngày hiện tại
//     startDateInput.setAttribute('min', today);
//     endDateInput.setAttribute('min', today);

//     // Xử lý phần toggle navbar
//     // ...

//     // Thêm event listener cho sự kiện 'change' của start-date
//     startDateInput.addEventListener('change', function() {
//       // Cập nhật giá trị 'min' của end-date dựa vào giá trị của start-date
//       endDateInput.setAttribute('min', startDateInput.value);
//     });
// });

function toggleNavbar() {
  const navbarMenu = document.querySelector('.nav__links');
  const nav = document.querySelector('nav');
  const overlay = document.getElementById("overlay");


  if (navbarMenu) {
      navbarMenu.classList.toggle('active');
      nav.classList.toggle('active');

      // Kiểm tra trạng thái hiện tại của thuộc tính display
      if (overlay.style.display === "block") {
        // Nếu hiện tại là block, chuyển thành none
        overlay.style.display = "none";
      } else {
        // Nếu không phải block (có thể là none hoặc trống), chuyển thành block
        overlay.style.display = "block";
      }
  }
}


function off() {
  const navbarMenu = document.querySelector('.nav__links');
  const nav = document.querySelector('nav');

  if (navbarMenu) {
      navbarMenu.classList.toggle('active');
      nav.classList.toggle('active');
  }
  document.getElementById("overlay").style.display = "none";
}

// Đoạn code này dùng để format tiền
document.addEventListener('DOMContentLoaded', function() {
  
  //Format tiền
  function formatCash(str) {
    if (str === '') return str;
    return str.split('').reverse().reduce((prev, next, index) => {
      return ((index % 3) ? next : (next + '.')) + prev
    })
  }

  const bookingVehicleDateRange = document.getElementById('booking_daterange');
  if(bookingVehicleDateRange)
  {
    bookingVehicleDateRange.addEventListener('change', function(e) {
      const VND_elements = document.querySelectorAll('.vnd_format');
      VND_elements.forEach(e => {
  
          e.textContent = formatCash(e.textContent);
      });
    });

  }
  const VND_elements = document.querySelectorAll('.vnd_format');
  VND_elements.forEach(e => {
      
      e.textContent = formatCash(e.textContent);
  });

  //Ngăn chặn hành vi mặc định
  const button_search_vehicle_available = document.querySelector("button[name='form_search_vehicle_available']");
  const button_booking_vehicle = document.querySelector("button[name='form_booking_vehicle']");
  const button_booking_vehicle_VNPAY = document.getElementById('button_vnpay_payment');

  if(button_search_vehicle_available)
  {
    button_search_vehicle_available.addEventListener('click', function(e) {

    })
  }

  //Ngăn chặn hành vi mặc định của button vnpay khi thanh toán (alert thông báo 'Bạn có muốn thuê xe này không')
  if(button_booking_vehicle_VNPAY) {
      button_booking_vehicle_VNPAY.addEventListener('click', function(e) {
        e.preventDefault();
        const vehicle_title = document.querySelector('.vehicle-detail__title').textContent;

        Swal.fire({
          title: `Bạn có muốn đặt chiếc ${vehicle_title} này bằng phương thức VNPAY không?`,
          text: "Bạn chỉ cần cọc 10% để đặt xe và hãy trả toàn bộ số tiền khi nhận xe nhá!. Hãy kiểm tra xe trước khi nhận xe",
          icon: 'success',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Đặt',
          cancelButtonText: 'Hủy',
        }).then((result) => {
          if (result.isConfirmed) {
              var input = document.createElement("input");
              input.type = "hidden";
              input.name = "redirect";
              input.value = "vnpay_payment";
              const form = document.getElementById("form_booking_vehicle_detail");
              // Xử lý khi thuê 1 ngày
              var datesRangeBooking = $('#booking_daterange').val();
              const dates = datesRangeBooking.split(' - ');
              const startDate = new Date(dates[0]).getTime();
              const endDate = new Date(dates[1]).getTime();
              console.log(startDate, endDate);
              if(startDate !== endDate) {
                  form.appendChild(input);
              
                  form.submit();
    
                  setTimeout(() => {
                      form.removeChild(input);
                  }, 0);
              }else {
                  Swal.fire({
                      icon: "error",
                      title: "Vui lòng chọn từ 1 ngày trở lên!",
                  });
              }
             
          }
      })
      })
  }

  if(button_booking_vehicle)
  {
    button_booking_vehicle.addEventListener('click', function(e) {
      e.preventDefault();
      const vehicle_title = document.querySelector('.vehicle-detail__title').textContent;

      Swal.fire({
        title: `Bạn có muốn đặt chiếc ${vehicle_title} này không?`,
        text: "Hãy kiểm tra xe trước khi thanh toán và nhận xe",
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đặt',
        cancelButtonText: 'Hủy',
    }).then((result) => {
        if (result.isConfirmed) {
            var input = $('#booking_daterange').val();
            const dates = input.split(' - ');
            const startDate = new Date(dates[0]);
            const endDate = new Date(dates[1]);
            console.log(startDate, endDate);
            if(startDate !== endDate) {
                // document.getElementById("form_booking_vehicle_detail").submit();

            }else {
                Swal.fire({
                    icon: "error",
                    title: "Vui lòng chọn từ 1 ngày trở lên!",
                });
            }
        }
    })
  
    })

  }

});

window.addEventListener('load', function() {

  const startDateInput = document.getElementById('booking_start_date');
  const endDateInput = document.getElementById('booking_end_date');
  const priceDisplay = document.getElementById('booking_vehicle_price');
  const rentalPriceDay = document.querySelector('input[name="booking_rental_price_day"');
  const bookingTotalPrice = document.getElementById('booking_total_price');


  if(startDateInput && endDateInput && priceDisplay && rentalPriceDay && bookingTotalPrice) {
    function calculatePrice() {
      const startDate = new Date(startDateInput.value);
      const endDate = new Date(endDateInput.value);
      const timeDifference = endDate - startDate;
      const daysDifference = timeDifference / (1000 * 60 * 60 * 24); // chuyển từ milliseconds sang ngày
      console.log(startDate, endDate, timeDifference, daysDifference);
      const pricePerDay = rentalPriceDay.value; // giá mỗi ngày
      if (endDate > startDate) {
        const totalPrice = daysDifference * pricePerDay;
        priceDisplay.textContent = new Intl.NumberFormat().format(totalPrice); // format số tiền theo định dạng locale\
        bookingTotalPrice.value = totalPrice; 
      } else {
        priceDisplay.textContent = '';
      }
    }
  
    // Thêm sự kiện khi giá trị ngày bắt đầu hoặc ngày kết thúc thay đổi
    startDateInput.addEventListener('change', calculatePrice);
    endDateInput.addEventListener('change', calculatePrice);
  }
  
});

// Xử lý phần alert khi clients click 'Thanh toán bằng tiền mặt'
// document.addEventListener('DOMContentLoaded', function() {
//     const bookingButtonByCash = document.getElementById('booking_vehicle_button');
//     bookingButtonByCash.addEventListener('click', function(e) {
//       if(!confirm('Bạn có muốn thuê xe này ')) {
//         e.preventDefault();
//       }
//     });
// })

/*

vnp_Amount=90000000
&vnp_BankCode=NCB
&vnp_CardType=ATM
&vnp_OrderInfo=Thanh+toan+GD%3A+6931
&vnp_PayDate=20240523151858
&vnp_ResponseCode=24
&vnp_TmnCode=JY3C3HGY
&vnp_TransactionNo=14426521
&vnp_TransactionStatus=02
&vnp_TxnRef=6931
&vnp_SecureHash=c9213f0f5287e0094e7619716287fb8910828bce852af4ca5ca37700af7bf207c087264041dc53973272763c5bcafe960230ec4c2e8a2b47d0ec82218e6b02f1
*/