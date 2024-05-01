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
            <p class="vehicle__description">{{$vehicle->description}}</p>
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