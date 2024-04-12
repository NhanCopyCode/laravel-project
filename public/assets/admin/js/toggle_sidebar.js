const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
});

$(document).ready(function () {

    // toggle sidebar car item
    $(document).on('click', '.sidebar-car', function (e) {
        $('.list-car-sidebar').slideToggle(500);
    });

    //
});