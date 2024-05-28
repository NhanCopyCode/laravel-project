@extends('layouts.admin.admin_layout')

@section('content')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form_add_user">
        Thêm người dùng
    </button>
    
    <!-- Modal add bracnh -->
    <form method="POST" action="{{route('admin.user.add')}}" class="modal fade modal-user" id="form_add_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        @csrf
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Thêm người dùng</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Tên người dùng</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nguyen Van A" required value="{{old('name')}}">
                    <div class="message_error_name message_error">

                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="abc@gmail.com" required value="{{old('email')}}">
                    <div class="message_error_email message_error">

                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password"  required value="{{old('password')}}">
                    <div class="message_error_password message_error">

                    </div>
                </div>

                <div class="form-group">
                    <label for="role_id">Chọn vai trò</label>
                    <select class="form-control" name="role_id" id="role_id" value="{{old('role_id')}}">
                        <option value="2">Quản lý</option>
                        <option value="3">Admin</option>
                    </select>
                    <div class="message_error_role_id message_error">

                    </div>
                </div>
                <div class="form-group">
                    <input type="checkbox" id="btnShowPassword">
                    <label for="btnShowPassword">Hiển thị mật khẩu</label>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-add-user">Thêm</button>
            </div>
        </div>
        </div>
    </form>

    {{-- Modal update user --}}
    @include('blocks.admin.modal_update_user')

    {{-- Search button --}}
    <input type="text" class="form-control mb-3 mt-3" id="search-user" name="search-user" placeholder="Tìm kiếm...">

    

    {{-- Display table list user  --}}
   <table class="table table-bordered table-user" style="margin-top: 24px; min-width: 400px;">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th style="text-align: center;">
                    <input type="checkbox" class="check-all">
                </th>
                <th>Id người dùng</th>
                <th>Ảnh đại diện</th>
                <th>Tên người dùng</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th>Số điện thoại</th>
                <th>Ngày sinh</th>
                <th>Trạng thái người dùng</th>
                <th>Lựa chọn</th>
            </tr>
        </thead>
        <tbody>
            @if ($userList->count() === 0)
                <h1 id="user-no-data-text" class="text-center text-danger">Không có dữ liệu</h1>                
            @endif
            @foreach ($userList as $item)
            <tr>
                <th class="text-center">{{++$i}}</th>
                <th scope="row" style="text-align: center;">
                    <input type="checkbox"  id="user-id user-id-{{$item->user_id}}">
                </th>
                <th>{{$item->user_id}}</th>
                <th style="width: 120px;">
                    <img style="font-weight: normal; width: 100%; object-fit: cover;" src="{{$item->avatar}}" alt="Ảnh đại diện">
                </th>
                <td>{{$item->name}}</td>
                {{-- Email --}}
                <td>{{$item->email}}</td>
                <td>{{$item->role_name}}</td>
                <td>
                    @if ($item->phone_number)
                        {{$item->phone_number}}
                    @else 
                        <span class="text-danger">Chưa có</span>
                    @endif
                </td>
                <td>
                    @if ($item->date_of_birth)
                        {{$item->date_of_birth}}
                    @else 
                        <span class="text-danger">Chưa có</span>
                    @endif
                </td>

                <td>
                    @php
                        if($item->user_status_id === 1) {
                            echo '<span class="text-success">Hoạt động</span>';
                        }

                        if($item->user_status_id === 2) {
                            echo '<span class="text-danger">Dừng hoạt động</span>';
                        }
                            
                    @endphp
                </td>
                <td style="display: flex;align-items: center;">
                    <a  href=""
                        class="btn btn-primary btn-update btn-update-user" 
                        data-toggle = "modal"
                        data-target = "#form_update_user"
                        data-id = "{{$item->user_id}}"
                        data-user-name = "{{$item->name}}"
                        data-user-status-id = "{{$item->user_status_id}}"
                    >
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    {{-- <form action="{{route('admin.user.delete')}}" method="POST" id="form_delete_user">
                        @csrf
                        <input type="hidden" name="delete_user_id" value="{{$item->user_id}}">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </form> --}}
                    <a  href=""
                        class="btn btn-danger btn-delete btn-delete-user" 
                        data-toggle = "modal"
                        data-target = "#form_delete_user"
                        data-user-id = "{{$item->user_id}}"
                        data-user-name = "{{$item->name}}"
                    >
                    <i class="fa-regular fa-circle-xmark"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$userList->links()}}
@endsection

@section('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{asset('assets/clients/js/show_password.js')}}"></script>

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

            // Xử lý ajax phần add user
            $(document).on('click', '.btn-add-user', function(e) {
                e.preventDefault();

                let email = $('#email').val().trim();
                let password = $('#password').val().trim();
                let role_id = $('#role_id').val().trim();
                let name = $('#name').val().trim();
                $('.message_error').empty();

                $.ajax({
                    url: "{{route('admin.user.add')}}",
                    method: 'POST',
                    data: { 
                       email: email,
                       password: password,
                       role_id: role_id, 
                       name: name,
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            //Ẩn message 'Không có dữ liệu'
                            $('#user-no-data-text').hide();

                            $('#form_add_user').modal('hide');
                            $('#form_add_user')[0].reset();
                            $('.table').load(location.href + ' .table > *');

                            //Check if pagination exists and load it neccessary
                            if($('.pagination').length) {
                                $('.pagination').load(location.href + ' .pagination > *');
                            }

                            Command: toastr["success"](`Thêm thành công người dùng "<span style="font-weight: bold;">${name}</span>"`, "Thêm người dùng")

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
                        let errorMessage = error.responseJSON;
                        console.log(errorMessage);
                        $.each(errorMessage.errors, function (index, errMesage) { 
                            console.log(index);
                            $(`.message_error_${index}`).append('<span class="text-danger">' + errMesage + '</span>')
                        });
                    }
                });
            });

            // Xử lý phần hiển thị modal update user
            $(document).on('click', '.btn-update-user', function(e){
                // alert('Xin chào');
                let id = $(this).data('id');
                let user_status_id = $(this).data('user-status-id');
                let user_status_name = $(this).data('user-name');
                let messageError = $('.message_error_name');

                //Clear message error exists
                messageError.empty();
                
                console.log(user_status_id, user_status_name)
                $('#update_name').val(user_status_name);
                $('#update_user_status').val(user_status_id);
                $('#update_user_id').val(id);
            });

            //xử lý sự kiện Update user
            $(document).on('click', '.btn-submit-update-user', function(e) {
                e.preventDefault();

                let user_id = $('#update_user_id').val();
                let name = $('#update_name').val().trim();
                let user_status_id = $('#update_user_status').val().trim();

                $('.message_error').empty();
                
                $.ajax({
                    url: "{{route('admin.user.update')}}",
                    method: 'POST',
                    data: { 
                        user_id : user_id,
                        name: name,
                        user_status_id : user_status_id,
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            $('#form_update_user').modal('hide');
                            $('#form_update_user')[0].reset();
                            $('.table').load(location.href + ' .table > *');

                            //Check if pagination exists and load it neccessary
                            if($('.pagination').length) {
                                $('.pagination').load(location.href + ' .pagination > *');
                            }

                            Command: toastr["success"](`Cập nhật thành công người dùng "<span style="font-weight: bold;">${name}</span>"`, "Cập nhật người dùng")

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
                        $('.message_error').empty();

                        let errorMessage = error.responseJSON;
                        console.log(errorMessage);
                        $.each(errorMessage.errors, function (index, errMesage) { 
                            console.log('Xin chào lỗi');
                            $(`.message_error_${index}`).append('<span class="text-danger">' + errMesage + '</span>')
                        });
                    }
                });
            });


            // Xử lý sự kiện Delete user
            $(document).on('click', '.btn-delete-user', function(e) {
                e.preventDefault();
                let user_id = $(this).data('user-id');
                let name = $(this).data('user-name');
                

                
                if(confirm(`Chặn người dùng ${name}?`)) {
                    $.ajax({
                    url: "{{route('admin.user.delete')}}",
                    method: 'POST',
                    data: { 
                        user_id : user_id,
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            //Hiển thị message "khong có dữ liệu"
                            if(response.user_list_number === 1) {
                                $('#user-no-data-text').show();
                            }
                            $('.table').load(location.href + ' .table > *');

                            //Check if pagination exists and load it neccessary
                            if($('.pagination').length) {
                                $('.pagination').load(location.href + ' .pagination > *');
                            }

                            Command: toastr["success"](`Chặn thành công người dùng`, `Chặn người dùng ${name}`)

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
                        $('.message_error').empty();
                        let errorMessage = error.responseJSON;
                        console.log(errorMessage);
                        $.each(errorMessage.errors, function (index, errMesage) { 
                            $(`.message_error_${index}`).append('<span class="text-danger">' + errMesage + '</span>')
                        });
                    }
                });
                }
            });

            // Seach user realtime
            var timeout = null;
    
            $(document).on('keyup', '#search-user', function(e) {
                e.preventDefault();
                clearTimeout(timeout); // Hủy timeout trước đó để thiết lập mới

                let searchuserValue = $(this).val();

                // Đặt một timeout khi người dùng gõ xong
                timeout = setTimeout(function() {
                    $.ajax({
                        url : "{{route('admin.user.search')}}",
                        method: 'GET',
                        data: {
                            search_string_user : searchuserValue
                        },
                        success: function(res) {
                            if (res.status === 'not found') {
                                $('.table-user').html('<span class="text-danger">Không tìm thấy kết quả</span>');
                                $('.pagination').hide();
                            } else {
                                $('.table-user').html(res);
                                $('.pagination').show();
                            }
                        }
                    });
                }, 300); 
            });


        });
    </script>
@endsection