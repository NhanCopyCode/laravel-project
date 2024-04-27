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

console.log('nút close')
console.log(mobileMenuCloseBtn);

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
document.addEventListener('DOMContentLoaded', function(){
    const today = new Date().toISOString().slice(0, 10); // Lấy ngày hiện tại và chuyển định dạng sang YYYY-MM-DD
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');

    // Thiết lập ngày tối thiểu cho cả start và end date tương ứng với ngày hiện tại
    startDateInput.setAttribute('min', today);
    endDateInput.setAttribute('min', today);

    // Xử lý phần toggle navbar
    // ...

    // Thêm event listener cho sự kiện 'change' của start-date
    startDateInput.addEventListener('change', function() {
      // Cập nhật giá trị 'min' của end-date dựa vào giá trị của start-date
      endDateInput.setAttribute('min', startDateInput.value);
    });
});

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


