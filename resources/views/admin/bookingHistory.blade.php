@extends('layouts.admin.admin_layout')

@section('content')
    <h1 class="admin_booking_hisotry__title text-center">Quản lý lịch sử thuê xe</h1>

     {{-- Modal update payment --}}
     @include('blocks.admin.modal_update_booking_history')

     {{-- Search button --}}
     <input type="text" class="form-control mb-3 mt-3" id="search-payment" name="search-payment" placeholder="Tìm kiếm...">
 

    <table class="table table-bordered table-admin-item-booking-vehicle" style="margin-top: 24px; min-width: 400px;">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th style="text-align: center;">
                    <input type="checkbox" class="check-all">
                </th>
                <th scope="col">ID giao dịch</th>
                <th scope="col">Xe thuê</th>
                <th scope="col">Hình ảnh xe</th>
                <th scope="col">Tổng tiền</th>
                <th scope="col">Ngày bắt đầu thuê</th>
                <th scope="col">Ngày kết thúc</th>
                <th scope="col">Trạng thái thanh toán</th>
                <th scope="col">Ngày thanh toán</th>
                <th scope="col">Phương thức thanh toán</th>
                <th scope="col">Trạng thái giao dịch</th>
                
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if ($list_booking_vehicle->count() === 0)
                <h1 id="payment-no-data-text" class="text-center text-danger">Không có dữ liệu</h1>                
            @endif
            @foreach ($list_booking_vehicle as $item)
            <tr>
                <th class="text-center">{{++$i}}</th>
                <th scope="row" style="text-align: center;">
                    <input type="checkbox"  id="payment-id payment-id-{{$item->payment_id}}">
                </th>
                <td>{{$item->payment_id}}</td>
                <td>{{$item->model_name}}</td>
                <td>
                    <img style="height: 100px; object-fit: cover;" src="{{$item->vehicle_image_data_1}}" alt="Hình ảnh xe">
                </td>
                
                <td>{{$item->amount}}</td>
                <td>{{$item->rental_start_date}}</td>
                <td>{{$item->rental_end_date}}</td>
                
                @if ($item->rental_status_id === 1)
                <td class="text-danger">{{$item->rental_status_name}}</td>
                @else 
                <td class="text-success">{{$item->rental_status_name}}</td>
                @endif
                
                @if ($item->payment_date === null) 
                    <td class="text-center">------</td>
                @else 
                    <td>{{$item->payment_date}}</td>
                @endif

                {{-- Phương thức thanh toán --}}
                <td class="text-center">{{$item->payment_method_name}}</td>
                {{-- Trạng thái giao dịch --}}
                @if ($item->payment_is_deleted === null || $item->payment_is_deleted === false)
                    <td class="text-success">Vẫn còn hiệu lực</td>
                @else 
                    <td class="text-danger">Không còn hiệu lực</td>
                @endif
                <td style="display: flex;align-items: center;">
                    <a  href=""
                        class="btn btn-primary btn-update btn-update-payment" 
                        data-toggle = "modal"
                        data-target = "#form_update_payment"
                        data-id = "{{$item->payment_id}}"
                        data-rental-status-id = "{{$item->rental_status_id}}"
                        data-rental-status-name = "{{$item->rental_status_name}}"
                        data-rental-id = "{{$item->rental_id}}"
                    >
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    {{-- <form action="{{route('admin.payment.delete')}}" method="POST" id="form_delete_payment">
                        @csrf
                        <input type="hidden" name="delete_payment_id" value="{{$item->payment_id}}">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </form> --}}
                    <a  href=""
                        class="btn btn-danger btn-delete btn-delete-payment" 
                        data-toggle = "modal"
                        data-target = "#form_delete_payment"
                        data-payment-id = "{{$item->payment_id}}"
                    >
                        <i class="fa-regular fa-trash-can"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$list_booking_vehicle->links()}}
@endsection

@section('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            const checkAllInputSelector = '.check-all';
            const checkBoxSelector = 'input[type="checkbox"]:not(.check-all)';

            // Delegate 'click' event for dynamic and current '.check-all' checkboxes
            $(document).on('click', checkAllInputSelector, function() {
                $(checkBoxSelector).prop('checked', this.checked);
            });

            // Delegate 'change' event for all checkboxes except '.check-all'
            $(document).on('change', checkBoxSelector, function() {
                const totalInputTypeCheckboxWithoutInputCheckAll = $(checkBoxSelector).length;
                const countChecked = $(checkBoxSelector + ':checked').length;
                
                // Update the '.check-all' checkbox based on other checkboxes' state
                $(checkAllInputSelector).prop('checked', totalInputTypeCheckboxWithoutInputCheckAll === countChecked);
            });

           

            // Xử lý phần hiển thị modal update payment
            $(document).on('click', '.btn-update-payment', function(e){
                // alert('Xin chào');
                let payment_id = $(this).data('id');
                let rental_id = $(this).data('rental-id');
                let rental_status_id = $(this).data('rental-status-id');
                let rental_status_name = $(this).data('rental-status-name');

                //Clear message error exists
                $('.message_error').empty();

                console.log(payment_id, rental_status_id, rental_status_name);
                
                // console.log(payment_status_id, payment_status_name)
                $('#update_payment_id').val(payment_id);
                $('#update_payment_status').val(rental_status_id);
                $('#booking_history_rental_id').val(rental_id);
               
            });

            //xử lý sự kiện Update payment
            $(document).on('click', '.btn-submit-update-payment', function(e) {
                e.preventDefault();

                

                let payment_id = $("#update_payment_id").val();
                let rental_status_id = $('#update_payment_status').val();
                let rental_id = $('#booking_history_rental_id').val();

                
                $.ajax({
                    url: "{{route('admin.booking.vehicle.update')}}",
                    method: 'POST',
                    data: { 
                        payment_id : payment_id,
                        rental_id: rental_id,
                        rental_status_id : rental_status_id,
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            $('#form_update_payment').modal('hide');
                            $('#form_update_payment')[0].reset();
                            $('.table').load(location.href + ' .table > *');

                            //Check if pagination exists and load it neccessary
                            if($('.pagination').length) {
                                $('.pagination').load(location.href + ' .pagination > *');
                            }

                            Command: toastr["success"](`Cập nhật thành công giao dịch "<span style="font-weight: bold;">${payment_id}</span>"`, "Cập nhật giao dịch")

                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": true,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut",
                            }
                        }
                    },
                    error: function(error) {
                        let errorMessage = error.responseJSON;
                        console.log(errorMessage);
                        $('.message_error').empty();

                        $.each(errorMessage.errors, function (field, messages) { 
                            console.log(field);
                            // console.log(errMesage);
                            console.log($('#error-'+field));
                            $('#update-error-' + field).append('<span class="text-danger">' + messages.join('<br>') + '</span>');
                        });
                    }
                });
            });


            // Xử lý sự kiện Delete payment
            $(document).on('click', '.btn-delete-payment', function(e) {
                e.preventDefault();
                let payment_id = $(this).data('payment-id');
                let payment_name = $(this).data('payment-name');
                
                if(confirm(`Bạn có muốn xóa mẫu xe ${payment_name} không`)) {
                    $.ajax({
                    url: "{{route('admin.booking.vehicle.delete')}}",
                    method: 'POST',
                    data: { 
                        payment_id : payment_id,
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            $('.table').load(location.href + ' .table > *');

                            //Check if pagination exists and load it neccessary
                            if($('.pagination').length) {
                                $('.pagination').load(location.href + ' .pagination > *');
                            }

                            Command: toastr["success"](`Xóa thành công mẫu xe`, "Xóa mẫu xe")

                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": true,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                        }

                        if(response.status === 'error') {
                            alert(response.message);
                        }
                    },
                    error: function(error) {
                        let errorMessage = error.responseJSON;
                        console.log(errorMessage);
                        $.each(errorMessage.errors, function (index, errMesage) { 
                            console.log('Xin chào lỗi');
                            $('.message_error_payment_name').append('<span class="text-danger">' + errMesage + '</span>')
                        });
                    }
                });
                }
            });

           // Seach brand realtime
            var timeout = null;
    
            $(document).on('keyup', '#search-payment', function(e) {
                e.preventDefault();
                clearTimeout(timeout); // Hủy timeout trước đó để thiết lập mới

                let searchpaymentValue = $(this).val();

                // Đặt một timeout khi người dùng gõ xong
                timeout = setTimeout(function() {
                    $.ajax({
                        url : "{{route('admin.booking.vehicle.search')}}",
                        method: 'GET',
                        data: {
                            search_string_payment : searchpaymentValue
                        },
                        success: function(res) {
                            if (res.status === 'not found') {
                                $('.table-payment').html('<span class="text-danger">Không tìm thấy kết quả</span>');
                                $('.pagination').hide();
                            } else {
                                $('.table-payment').html(res);
                                $('.pagination').show();
                            }
                        }
                    });
                }, 300); 
            });


        });
    </script>
@endsection