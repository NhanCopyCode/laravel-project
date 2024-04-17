@extends('layouts.admin.admin_layout')

@section('content')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form_add_carrentalstore">
        Thêm cửa hàng mới
    </button>
    
    <!-- Modal add bracnh -->
    <form method="POST" action="{{route('admin.carrentalstore.add')}}" enctype="multipart/form-data" class="modal fade modal-carrentalstore" id="form_add_carrentalstore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        @csrf
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Thêm cửa hàng</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="provinceSelect">Chọn Tỉnh/Thành phố</label>
                    <select class="form-control provinceSelectClass" name="province" id="provinceSelect">

                    </select>
                    <div class="message_error_province">

                    </div>
                </div>

                <div class="form-group">
                    <label for="districtSelect">Chọn Quận/Huyện</label>
                    <select class="form-control districtSelectClass" name="district" id="districtSelect">

                    </select>
                    <div class="message_error_district">

                    </div>
                </div>

                <div class="form-group">
                    <label for="wardSelect">Chọn Phường/Xã</label>
                    <select class="form-control wardSelectClass" name="ward" id="wardSelect">

                    </select>
                    <div class="message_error_ward">

                    </div>
                </div>

                <div class="form-group">
                    <label for="unique_location">Địa chỉ cụ thể</label>
                    <input type="text" name="unique_location" class="form-control" id="unique_location" placeholder="Nhập địa chỉ....">
                    <div class="message_error_unique_location">

                    </div>
                </div>

                <div class="form-group">
                    <label for="phone_number">Số điện thoại liên hệ</label>
                    <input type="number" name="phone_number" class="form-control" id="phone_number" placeholder="Nhập số điện thoại....">
                    <div class="message_error_phone_number">

                    </div>
                </div>

                <div class="form-group">
                    <label for="avatar">Hình ảnh cửa hàng</label>
                    <input type="file" id="avatar" class="form-control" name="avatar">
                    <div class="message_error_avatar">

                    </div>
                </div>

                <div class="form-group">
                    <label for="avatar">Nhập thêm tiểu sử cửa hàng</label>
                    <textarea class="form-control" name="description" id="description" cols="30" rows="2"></textarea>
                    <div class="message_error_avatar">

                    </div>
                </div>
                
                <div class="form-group">
                    <label for="branch_id">Chọn chi nhánh</label>
                    <select class="form-control" name="branch_id" id="branch_id">
                        @foreach ($branch_list as $branch)
                            <option value="{{$branch->branch_id}}">{{$branch->branch_name}}</option>
                        @endforeach
                    </select>
                    <div class="message_error_carrentalstore_id">

                    </div>
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-add-carrentalstore">Thêm</button>
            </div>
        </div>
        </div>
    </form>

    {{-- Modal update carrentalstore --}}
    @include('blocks.admin.modal_update_carrentalstore')

    {{-- Search button --}}
    <input type="text" class="form-control mb-3 mt-3" id="search-carrentalstore" name="search-carrentalstore" placeholder="Tìm kiếm...">


    {{-- Display table list carrentalstore  --}}
   <table class="table table-bordered table-carrentalstore" style="margin-top: 24px; min-width: 400px;">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th style="text-align: center;">
                    <input type="checkbox" class="check-all">
                </th>
                <th>Id cửa hàng</th>
                <th>Địa chỉ cửa hàng</th>
                <th>Hình ảnh cửa hàng</th>
                <th>Chú thích cửa hàng</th>
                <th>Số điện thoại</th>
                <th>Chi nhánh</th>
                <th>Ngày tạo</th>
                <th>Lựa chọn</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carRentalStoreList as $item)
            <tr>
                <th class="text-center">{{++$i}}</th>
                <th scope="row" style="text-align: center;">
                    <input type="checkbox"  id="carrentalstore-id carrentalstore-id-{{$item->CarRentalStore_id}}">
                </th>
                <td>{{$item->CarRentalStore_id}}</td>
                <td>{{$item->real_location}}</td>
                <td>
                    <img style="width: 100px; height: 100px;" src="http://127.0.0.1:8000/{{$item->avatar}}" alt="">
                </td>
                <td>{{$item->description}}</td>
                <td>{{$item->phone_number}}</td>
                <td>{{$item->branch_name}}</td>
                <td>{{$item->created_at}}</td>
                
                <td style="display: flex;align-items: center;">
                    <a  href=""
                        class="btn btn-primary btn-update btn-update-carrentalstore" 
                        data-toggle = "modal"
                        data-target = "#form_update_carrentalstore"
                        data-id = "{{$item->CarRentalStore_id}}"
                        data-phone-number = "{{$item->phone_number}}"
                        data-avatar = "{{$item->avatar}}"
                        data-description = "{{$item->description}}"
                        data-location-id = "{{$item->location_id}}"
                        data-branch-id = "{{$item->branch_id}}"
                        data-province = "{{$item->province}}"
                        data-district = "{{$item->district}}"
                        data-ward = "{{$item->ward}}"
                        data-unique-location = "{{$item->unique_location}}"
                    >
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    {{-- <form action="{{route('admin.carrentalstore.delete')}}" method="POST" id="form_delete_carrentalstore">
                        @csrf
                        <input type="hidden" name="delete_CarRentalStore_id" value="{{$item->CarRentalStore_id}}">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </form> --}}
                    <a  href=""
                        class="btn btn-danger btn-delete btn-delete-carrentalstore" 
                        data-toggle = "modal"
                        data-target = "#form_delete_carrentalstore"
                        data-carrentalstore-id = "{{$item->CarRentalStore_id}}"
                    >
                        <i class="fa-regular fa-trash-can"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$carRentalStoreList->links()}}
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
        document.addEventListener('DOMContentLoaded', function() {
            // Hàm lấy dữ liệu từ API và thêm vào thẻ select
            window.fetchProvinces = function() {
                fetch('http://127.0.0.1:8000/api/provine')
                .then(response => response.json()) // Chuyển response thành JSON
                .then(data => {
                    console.log(data);
                if (data.provines.exitcode === 1) { // Kiểm tra exitcode để đảm bảo rằng yêu cầu thành công
                    populateSelect(data.provines.data.data); // Truy cập vào mảng chứa dữ liệu tỉnh
                } else {
                    throw new Error('Lỗi khi lấy dữ liệu');
                }
                })
                .catch(error => console.error('Có lỗi xảy ra:', error)); // Bắt lỗi nếu có
            }
            
            // Hàm thêm các tỉnh vào trong thẻ select
            function populateSelect(provinces) {
                const select = document.querySelector('.provinceSelectClass');
                const updateSelectProvince = document.querySelector('.update-provinceSelectClass');
                console.log(updateSelectProvince);
                const option = document.createElement('option');
                option.value = '0';
                option.textContent = 'Chọn Tỉnh/Thành phố';
                select.appendChild(option);
                provinces.forEach(province => {
                    const option_list = document.createElement('option');

                    option_list.value = province.code; // Dùng _id làm giá trị cho thẻ option
                    option_list.textContent = province.name_with_type; // Dùng tên đầy đủ của tỉnh làm nội dung hiển thị
                    
                    select.appendChild(option_list); // Thêm thẻ option vào thẻ select
                });

                provinces.forEach(province => {
                    const option_list = document.createElement('option');

                    option_list.value = province.code; // Dùng _id làm giá trị cho thẻ option
                    option_list.textContent = province.name_with_type; // Dùng tên đầy đủ của tỉnh làm nội dung hiển thị
                    updateSelectProvince.appendChild(option_list);
                })
            }
            
            // Gọi hàm để tải dữ liệu và thêm vào select
            window.fetchProvinces();
        });
    </script>

    <script>
        $(document).ready(function () {

            
            // Lấy dữ liệu add vào ward khi người dùng onchange provines
            $(document).on('change', '#provinceSelect', function(e) {
                e.preventDefault();

                let provine_id = $(this).val().trim();

                if(provine_id){
                    $.ajax({
                        url: "{{route('admin.district.get')}}",
                        method: 'GET',
                        dataType: 'json',
                        data: {
                            provine_id: provine_id
                        },
                        success: function(res) {
                            console.log(res.status_code);
                            $('#districtSelect').empty();
                            if(res.status_code === 'success'){
                                    
                                $('#districtSelect').append(`<option value="0">Chọn Quận/Huyện</option>`)
                                $.each(res['district'], function (index, district) { 
                                    $('#districtSelect').append(`<option value="${district.code}">${district.name_with_type}</option>`);
                                });
                            }else {
                                return;
                            }

                            $('#wardSelect').empty();
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                }
                
            });
            
            // Lấy dữ liệu của ward khi district được lựa chọn
            $(document).on('change', '#districtSelect', function(e) {
                e.preventDefault();

                let district_id = $(this).val().trim();

                if(district_id)  {
                    $.ajax({
                        url : "{{route('admin.ward.get')}}",
                        method : 'GET',
                        dataType : 'json',
                        data: {
                            district_id : district_id
                        },
                        success: function(res) {
                            $('#wardSelect').empty();
                            if(res.status_code === 'success') {
                                console.log(res);
                                $('#wardSelect').append(`<option value="0">Chọn Phường/Xã</option>`)
                                $.each(res['wards'], function (index, ward) { 
                                    $('#wardSelect').append(`<option value="${ward.code}">${ward.name_with_type}</option>`);
                                });

                            }
                        },  
                        error: function(err) {

                        }
                    });
                }
            });

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

            // Xử lý ajax phần add carrentalstore
            $(document).on('click', '.btn-add-carrentalstore', function(e) {
                e.preventDefault();

                // let carrentalstore_name = $('#carrentalstore_name').val().trim();
                let formData = new FormData();
                formData.append('province', $('#provinceSelect option:selected').text());
                formData.append('district', $('#districtSelect option:selected').text());
                formData.append('ward', $('#wardSelect option:selected').text());
                formData.append('unique_location', $('#unique_location').val().trim());
                formData.append('description', $('#description').val().trim());
                formData.append('phone_number', $('#phone_number').val().trim());
                formData.append('branch_id', $('#branch_id').val().trim());
                let avatarFiles = $('#avatar')[0].files;
                if(avatarFiles.length > 0) {
                    formData.append('avatar', avatarFiles[0]);
                }

                $.ajax({
                    url: "{{route('admin.carrentalstore.add')}}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            $('#form_add_carrentalstore').modal('hide');
                            $('#form_add_carrentalstore')[0].reset();
                            $('.table').load(location.href + ' .table > *');

                            //Check if pagination exists and load it neccessary
                            if($('.pagination').length) {
                                $('.pagination').load(location.href + ' .pagination > *');
                            }

                            Command: toastr["success"](`Thêm thành công cửa hàng "<span style="font-weight: bold;">${carrentalstore_name}</span>"`, "Thêm cửa hàng")

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
                    },
                    error: function(error) {
                        $('.message_error_carrentalstore_name').append('');

                        let errorMessage = error.responseJSON;
                        console.log(errorMessage);
                        $.each(errorMessage.errors, function (index, errMesage) { 
                            console.log('Xin chào lỗi');
                            $('.message_error_carrentalstore_name').append('<span class="text-danger">' + errMesage + '</span>')
                        });
                    }
                });
            });

            // Xử lý phần hiển thị modal update carrentalstore
            $(document).on('click', '.btn-update-carrentalstore', function(e){
                // alert('Xin chào');
                let id = $(this).data('id');
                let phone_number = $(this).data('phone-number');
                let description = $(this).data('description');
                let avatar = 'http://127.0.0.1:8000' +$(this).data('avatar');
                let branch_id = $(this).data('branch-id');
                let location_id = $(this).data('location-id');
                let province = $(this).data('province');
                let ward = $(this).data('ward');
                let district = $(this).data('district');
                let unique_location = $(this).data('unique-location');
              
                console.log(phone_number, description, avatar, unique_location);

                window.fetchProvinces();
                // $('#provinceSelect').val(province);
                // $('#wardSelect').val(ward);
                // $('#districtSelect').val(district);
                $('#update-phone_number').val(phone_number);
                $('#update-unique_location').val(unique_location);
                $('#update-description').val(description);
                $('#update-unique_location').val(unique_location);
                $('#update-branch_id').val(branch_id);
                $('#update_carrentalstore_id').val(id);
            });

            //xử lý sự kiện Update carrentalstore
            $(document).on('click', '.btn-submit-update-carrentalstore', function(e) {
                e.preventDefault();

                let CarRentalStore_id = $('#update_carrentalstore_id').val();
                let carrentalstore_name = $('#update_carrentalstore_name').val().trim();
                let carrentalstore_status_id = $('#update_carrentalstore_status').val().trim();
               

                
                $.ajax({
                    url: "{{route('admin.carrentalstore.update')}}",
                    method: 'POST',
                    data: { 
                        CarRentalStore_id : CarRentalStore_id,
                        carrentalstore_name: carrentalstore_name,
                        carrentalstore_status_id : carrentalstore_status_id,
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            $('#form_update_carrentalstore').modal('hide');
                            $('#form_update_carrentalstore')[0].reset();
                            $('.table').load(location.href + ' .table > *');

                            //Check if pagination exists and load it neccessary
                            if($('.pagination').length) {
                                $('.pagination').load(location.href + ' .pagination > *');
                            }

                            Command: toastr["success"](`Cập nhật thành công cửa hàng "<span style="font-weight: bold;">${carrentalstore_name}</span>"`, "Cập nhật cửa hàng")

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
                    },
                    error: function(error) {
                        $('.message_error_carrentalstore_name').append('');

                        let errorMessage = error.responseJSON;
                        console.log(errorMessage);
                        $.each(errorMessage.errors, function (index, errMesage) { 
                            console.log('Xin chào lỗi');
                            $('.message_error_carrentalstore_name').append('<span class="text-danger">' + errMesage + '</span>')
                        });
                    }
                });
            });


            // Xử lý sự kiện Delete carrentalstore
            $(document).on('click', '.btn-delete-carrentalstore', function(e) {
                e.preventDefault();
                let CarRentalStore_id = $(this).data('carrentalstore-id');
                let carrentalstore_name = $(this).data('carrentalstore-name');
                
                if(confirm(`Bạn có muốn xóa cửa hàng ${carrentalstore_name} không`)) {
                    $.ajax({
                    url: "{{route('admin.carrentalstore.delete')}}",
                    method: 'POST',
                    data: { 
                        CarRentalStore_id : CarRentalStore_id,
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            $('.table').load(location.href + ' .table > *');

                            //Check if pagination exists and load it neccessary
                            if($('.pagination').length) {
                                $('.pagination').load(location.href + ' .pagination > *');
                            }

                            Command: toastr["success"](`Xóa thành công cửa hàng`, "Xóa cửa hàng")

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
                            $('.message_error_carrentalstore_name').append('<span class="text-danger">' + errMesage + '</span>')
                        });
                    }
                });
                }
            });

            // Seach carrentalstore realtime
            var timeout = null;
    
            $(document).on('keyup', '#search-carrentalstore', function(e) {
                e.preventDefault();
                clearTimeout(timeout); // Hủy timeout trước đó để thiết lập mới

                let searchcarrentalstoreValue = $(this).val();

                // Đặt một timeout khi người dùng gõ xong
                timeout = setTimeout(function() {
                    $.ajax({
                        url : "{{route('admin.carrentalstore.search')}}",
                        method: 'GET',
                        data: {
                            search_string_carrentalstore : searchcarrentalstoreValue
                        },
                        success: function(res) {
                            if (res.status === 'not found') {
                                $('.table-carrentalstore').html('<span class="text-danger">Không tìm thấy kết quả</span>');
                                $('.pagination').hide();
                            } else {
                                $('.table-carrentalstore').html(res);
                                $('.pagination').show();
                            }
                        }
                    });
                }, 300); 
            });


        });
    </script>
@endsection