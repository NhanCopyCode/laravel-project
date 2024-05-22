@extends('layouts.clients.client_layout')
@section('header')
    @include('blocks.clients.header_booking')
@endsection
@section('content')    
    <div class="section__container">
        <div class="row booking-vehicle__container">
            <div class="col-4 booking__container__filter-sidebar">
                <form action="{{route('user.search.advanced')}}" method="GET" id="filters-sidebar" class="filters-sidebar border rounded-2">
                    <div class="filters-sidebar__heading border-bottom p-3">
                        <h5 class="fw-bold">Chọc lọc theo: </h5>
                    </div>
                    {{-- Mẫu xe --}}
                    <div class="filters-sidebar__model border p-3">
                        <div class="filters-sidear__model-heading">
                            <h5 class="fw-bold">Các mẫu xe phổ biến: </h5>
                        </div>
                        @foreach ($model_list as $item)
                            <div class="form-group">
                                <input class="form-check-input"  type="checkbox" name="models[]" id="{{$item->model_name}}" value="{{$item->model_name}}" {{ in_array($item->model_name, request('models', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{$item->model_name}}">{{$item->model_name}} </label>
                            </div>
                        @endforeach
                    </div>
                    {{-- Số phân khối --}}
                    <div class="filters-sidebar__model border p-3">
                        <div class="filters-sidear__model-heading">
                            <h5 class="fw-bold">Chọn phân khối: </h5>
                        </div>
                        
                        @foreach ($list_engine_type as $item)
                            <div class="form-group">
                                <input class="form-check-input"  type="checkbox" name="engine_type[]" id="{{$item->engine_type}}" value="{{$item->engine_type}}" {{ in_array($item->engine_type, request('engine_type', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{$item->engine_type}}">{{$item->engine_type}} </label>
                            </div>
                        @endforeach
                    </div>
                    {{-- Chọn màu --}}
                    <div class="filters-sidebar__model border p-3">
                        <div class="filters-sidear__model-heading">
                            <h5 class="fw-bold">Chọn màu xe: </h5>
                        </div>
                        
                        @foreach ($list_color as $item)
                            <div class="form-group">
                                <input class="form-check-input" type="checkbox" name="colors[]" id="{{$item->color}}" value="{{$item->color}}" {{ in_array($item->color, request('colors', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{$item->color}}">{{$item->color}} </label>
                            </div>
                        @endforeach
                    </div>

                    {{-- Chọn năm sản xuất --}}
                    <div class="filters-sidebar__model border p-3">
                        <div class="filters-sidear__model-heading">
                            <h5 class="fw-bold">Chọn năm sản xuất: </h5>
                        </div>
                        
                        @foreach ($year_of_production as $item)
                            <div class="form-group">
                                <input class="form-check-input" type="checkbox" name="year_of_productions[]" id="{{$item->year_of_production}}" value="{{$item->year_of_production}}" {{ in_array($item->year_of_production, request('year_of_productions', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{$item->year_of_production}}">{{$item->year_of_production}} </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group p-3">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </form>  
            </div>
            <div class="col-8 booking__container__vehicle_item">
                <div class="row booking__section">
                    <div class="booking__section__header">
                        <h3>Danh sách toàn bộ xe: </h3>
                        <h3>
                            Tìm thấy <span class="vehicle_count fw-bold">
                                @if (isset($vehicle_count))
                                    {{$vehicle_count}}
                                @endif
                            </span> xe
                        </h3>
                    </div>
                    
                    <div class="booking__section__content">
                        @if ($vehicle_list)
                            @foreach ($vehicle_list as $vehicle)
                                <div class="row booking__section__item border rounded mb-4"  style="height: 200px;">
                                    <div class="col-4">
                                        <div class="row booking__section__item-group-img">
                                            <a class="col-8 booking__section__item-main-img" style="object-fit: cover; height: 200px;" data-lightbox="booking_vehicle_{{$vehicle->vehicle_id}}" href="{{$vehicle->vehicle_image_data_1}}" alt="Ảnh xe" class="col-8  p-1">
                                                <img src="{{$vehicle->vehicle_image_data_1}}" alt="Ảnh xe">
                                            </a>
                                            <div class="col-4 d-flex flex-column booking__section__item-group-img-sidebar">
                                                <a style="height: 33.33333%; object-fit: cover;" data-lightbox="booking_vehicle_{{$vehicle->vehicle_id}}"  href="{{$vehicle->vehicle_image_data_1}}" alt="Ảnh xe" class=" p-1">
                                                     <img src="{{$vehicle->vehicle_image_data_1}}" alt="Ảnh xe">
                                                </a>
                                                <a style="height: 33.33333%; object-fit: cover;" data-lightbox="booking_vehicle_{{$vehicle->vehicle_id}}"  href="{{$vehicle->vehicle_image_data_2}}" alt="Ảnh xe" class=" p-1">
                                                     <img src="{{$vehicle->vehicle_image_data_2}}" alt="Ảnh xe">
                                                </a>
                                                <a style="height: 33.33333%; object-fit: cover;" data-lightbox="booking_vehicle_{{$vehicle->vehicle_id}}"  href="{{$vehicle->vehicle_image_data_3}}" alt="Ảnh xe" class=" p-1">
                                                     <img src="{{$vehicle->vehicle_image_data_3}}" alt="Ảnh xe">
                                                </a>
        
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="col-8">
                                        <div class="row d-flex justify-content-between booking__section__item-header">
                                            <h4 class="fw-bold">{{$vehicle->model_name}}</h4>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-end booking__section__item-content">
                                            <div class="booking__section__item-content-description d-flex flex-column">
                                                <p>Chi tiết: {{$vehicle->description}}</p>
                                                <p>Giá thuê xe: {{$vehicle->rental_price_day}}</p>
                                            </div>

                                            <a style="height: 40px;" href="{{env('APP_URL')}}/user/vehicle/{{$vehicle->vehicle_id}}" class="btn btn-primary">
                                                Đặt xe
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                        <div class="booking__pagination">
                            {{ $vehicle_list->links()}}

                        </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            
            var urlParamsReal = null;
            var urlFilterSidebar = null;
            var urlHeaderBooking = null;
            var formId_clone = null;

            function updateContentBookingVehicle(formId, page = 1) {
                 // Lấy dữ liệu từ form
                formId_clone = formId;
                var formData = $(formId).serialize();
                urlParams = formData;

                if(formId_clone !== '#filters-sidebar') {
                    urlHeaderBooking = formData;
                    urlParamsReal ='?' + urlHeaderBooking + '&page=' + page  ;
                }else if(formId_clone !== '#form_search_vehicle_advanced') {
                    urlFilterSidebar = formData;
                    urlParamsReal = '?' +  urlFilterSidebar + '&page=' + page ;
                }

                if(urlFilterSidebar !== null && urlHeaderBooking !== null) {
                    console.log('Vào được tỏng if');
                    urlParamsReal = '?' + urlHeaderBooking + '&' + urlFilterSidebar + '&page=' + page ;
                } 

                console.log('urlFilterSideBar: ' + urlFilterSidebar);
                console.log('urlHeaderBooking: ' + urlHeaderBooking);
                // var urlParams = window.location.search;
                // if(urlParams) {
                //     urlParams = urlParams + formData;
                // }else {
                //     urlParams = '?' + formData;
                // }
                // console.log(urlParams);
                var url = window.location.origin + window.location.pathname;

                var newUrl = url + urlParamsReal;

                history.pushState({path:newUrl}, '', newUrl);


                var newFormData = urlParamsReal.replace(/\?/g, '');
                // newFormData += '&page=' + currentPage + '&per_page=' + perPage;
                console.log('newFormData', newFormData);
                // Gửi yêu cầu AJAX đến server
                $.ajax({
                    type: "GET",
                    url: "{{ route('user.search.advanced') }}",
                    data: newFormData,
                    dataType: "json", // Giả sử máy chủ trả về JSON
                    success: function (response) {
                        // Xử lý khi có dữ liệu trả về
                        // Bạn cần thay thế nội dung của phần tử với class .booking__main
                        // với dữ liệu trả về từ máy chủ
                        var html = '';
                        var pagination = '';
                        console.log(response);
                        if(response.status === 'success') {
                            var currentPage = response.current_page;
                            var totalPages = response.total_pages;
                            console.log('currentPage: ' + currentPage + ' totalPages: ' + totalPages);

                            // Paganation
                            pagination = '<nav aria-label="Page navigation example"><ul class="pagination">';
                            if (currentPage > 1) {
                                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + (currentPage - 1) + '">&laquo;</a></li>';
                            }

                            for (var i = 1; i <= totalPages; i++) {
                                pagination += '<li class="page-item' + (i == currentPage ? ' active' : '') + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                            }

                            if (currentPage < totalPages) {
                                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + (currentPage + 1) + '">&raquo;</a></li>';
                            }
                            pagination += '</ul></nav>';


                            response.vehicle_available.forEach(function(item) {
                            var vehicleItemRoute = '{{ env('APP_URL')}}' +  `/user/vehicle/${item.vehicle_id}`;
                                html += `<div class="row booking__section__item border rounded mb-4"  style="height: 200px;">
                                <div class="col-4">
                                    <div class="row booking__section__item-group-img">
                                        <a class="col-8 booking__section__item-main-img" style="object-fit: cover; height: 200px;" data-lightbox="booking_vehicle_${item.vehicle_id}" href="{{$vehicle->vehicle_image_data_1}}" alt="Ảnh xe" class="col-8  p-1">
                                            <img src="${item.vehicle_image_data_1}" alt="Ảnh xe">
                                        </a>
                                        <div class="col-4 d-flex flex-column booking__section__item-group-img-sidebar">
                                            <a style="height: 33.33333%; object-fit: cover;" data-lightbox="booking_vehicle_${item.vehicle_id}"  href="${item.vehicle_image_data_1}" alt="Ảnh xe" class=" p-1">
                                                    <img src="${item.vehicle_image_data_1}" alt="Ảnh xe">
                                            </a>
                                            <a style="height: 33.33333%; object-fit: cover;" data-lightbox="booking_vehicle_${item.vehicle_id}"  href="${item.vehicle_image_data_2}" alt="Ảnh xe" class=" p-1">
                                                    <img src="${item.vehicle_image_data_2}" alt="Ảnh xe">
                                            </a>
                                            <a style="height: 33.33333%; object-fit: cover;" data-lightbox="booking_vehicle_${item.vehicle_id}"  href="${item.vehicle_image_data_3}" alt="Ảnh xe" class=" p-1">
                                                    <img src="${item.vehicle_image_data_3}" alt="Ảnh xe">
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="row d-flex justify-content-between booking__section__item-header">
                                            <h4 class="fw-bold">{{$vehicle->model_name}}</h4>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-end booking__section__item-content">
                                            <div class="booking__section__item-content-description d-flex flex-column">
                                                <p>Chi tiết: {{$vehicle->description}}</p>
                                                <p>Giá thuê xe: {{$vehicle->rental_price_day}}</p>
                                            </div>

                                            <a style="height: 40px;" href="{{env('APP_URL')}}/user/vehicle/{{$vehicle->vehicle_id}}" class="btn btn-primary">
                                                Đặt xe
                                            </a>
                                        </div>
                                </div>
                            </div>`;
                            });
                        } else {
                            html = `<div class="col-md-12 alert alert-danger"><p>${response.message}</p></div>`;
                            console.log(html);
                        }

                        // Cập nhật nội dung vào phần tử với class .booking__main
                        $('.booking__section__content').html(html);
                        //Cập nhật số lượng xe
                        $('.vehicle_count').html(response.vehicle_number);
                        // Cập nhật lại pagination
                        $('.booking__pagination').html(pagination);

                    },
                    error: function (request, status, error) {
                        // Xử lý lỗi từ máy chủ
                        // alert('Có lỗi xảy ra: ' + request.responseText);
                    }
                });
            }
            // Khi người dùng submit form tìm kiếm nâng cao
            $('.filters-sidebar').on('submit', function(event) {
                event.preventDefault(); // Ngăn không cho gửi form theo cách truyền thống
                updateContentBookingVehicle('#filters-sidebar');
               
            });

            // Handle pagination click
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).data('page');
                updateContentBookingVehicle(formId_clone, page);
            });


            // Xử lý phần from daterange
            $('#form_search_vehicle_advanced').on('submit', function(event) {
              event.preventDefault();
              updateContentBookingVehicle('#form_search_vehicle_advanced');

               
          });

    });

    </script>
@endsection