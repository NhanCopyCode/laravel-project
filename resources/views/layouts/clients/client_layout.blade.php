<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- Swiper css --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{asset('/assets/bootstrap/css/bootstrap.min.css')}}">
    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="{{asset('assets/clients/css/home.css')}}" />
    @yield('css')
    
    <title>NhangDriveHub</title>
</head>
<body>

    @include('blocks.clients.navbar')

    @include('blocks.clients.header')
   
    
    <section class="section__container vehicle__container">
        <h2 class="section__header">Xe máy</h2>
        <div class="vehicle__grid">
        <div class="vehicle__card">
            <img src="assets/hotel-1.jpg" alt="vehicle" />
            <div class="vehicle__content">
            <div class="vehicle__card__header">
                <h4>The Plaza Hotel</h4>
                <h4>$499</h4>
            </div>
            <p>New York City, USA</p>
            </div>
        </div>
        @foreach ($vehicle_list as $index => $vehicle)
            <a href="{{route('user.showVehicle', $vehicle->vehicle_id)}}" class="vehicle__card">
                <div class="swiper-container mySwiper{{$index}}">
                    <div class="swiper-wrapper vehicle-img__container">
                        <img class="swiper-slide" src="{{$vehicle->vehicle_image_data_1}}" alt="Ảnh xe" />
                        <img class="swiper-slide" src="{{$vehicle->vehicle_image_data_2}}" alt="Ảnh xe" />
                        <img class="swiper-slide" src="{{$vehicle->vehicle_image_data_3}}" alt="Ảnh xe" />
                    </div>
                </div>
                <div class="swiper-pagination{{$index}} swiper-pagination"></div>
                <div class="vehicle__content">
                <div class="vehicle__card__header">
                    <h4>{{$vehicle->model_name}}</h4>
                    <h4>{{$vehicle->rental_price_day}} VND</h4>
                </div>
                <p>{{$vehicle->description}}</p>
                <p>Trạng thái: 
                    @if ($vehicle->vehicle_status_name === 'Hoạt động')
                        <span class="text-success">{{$vehicle->vehicle_status_name}}</span>
                    @else 
                        <span class="text-danger">{{$vehicle->vehicle_status_name}}</span>

                    @endif
                </p>
                </div>
            </a>
        @endforeach
        </div>
    </section>

    <section class="client">
        <div class="section__container client__container">
        <h2 class="section__header">What our client say</h2>
        <div class="client__grid">
            <div class="client__card">
            <img src="assets/client-1.jpg" alt="client" />
            <p>
                The booking process was seamless, and the confirmation was
                instant. I highly recommend WDM&Co for hassle-free hotel bookings.
            </p>
            </div>
            <div class="client__card">
            <img src="assets/client-2.jpg" alt="client" />
            <p>
                The website provided detailed information about hotel, including
                amenities, photos, which helped me make an informed decision.
            </p>
            </div>
            <div class="client__card">
            <img src="assets/client-3.jpg" alt="client" />
            <p>
                I was able to book a room within minutes, and the hotel exceeded
                my expectations. I appreciate WDM&Co's efficiency and reliability.
            </p>
            </div>
        </div>
        </div>
    </section>

    <section class="section__container">
        <div class="reward__container">
        <p>100+ discount codes</p>
        <h4>Join rewards and discover amazing discounts on your booking</h4>
        <button class="reward__btn">Join Rewards</button>
        </div>
    </section>

   
    @yield('content')

    @include('blocks.clients.footer')


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    {{-- <script src="{{asset('/assets/clients/js/calendar.js')}}"></script> --}}
    <script src="{{asset('/assets/clients/js/script.js')}}"></script>

    <script>
        // Khởi tạo swiper js
        document.addEventListener('DOMContentLoaded', function () {
            var swipers = document.querySelectorAll('.swiper-container');
            
            console.log(swipers);
            swipers.forEach(function(swiperContainer, index) {
                var swiper = new Swiper(swiperContainer, {
                    pagination: {
                        el: '.swiper-pagination' + index,
                        clickable: true,
                        renderBullet: function (index, className) {
                            return '<span class="' + className + '">' + (index + 1) + '</span>';
                        },
                    },
                });
            });
        });
    </script>
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}
    @yield('js')
</body>
</html>