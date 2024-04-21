@extends('layouts.admin.admin_layout')

@section('content')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form_add_brand">
        Thêm hãng xe mới
    </button>
    
    <!-- Modal add bracnh -->
    <form method="POST" action="{{route('admin.brand.add')}}" class="modal fade modal-brand" id="form_add_brand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        @csrf
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Thêm hãng xe</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="city">Hãng xe</label>
                    <input type="text" class="form-control" id="brand_name" name="brand_name" placeholder="Nhập tên hãng xe..." required>
                    <div class="message_error_brand_name">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-add-brand">Thêm</button>
            </div>
        </div>
        </div>
    </form>

    {{-- Modal update brand --}}
    @include('blocks.admin.modal_update_brand')

    {{-- Search button --}}
    <input type="text" class="form-control mb-3 mt-3" id="search-brand" name="search-brand" placeholder="Tìm kiếm...">


    {{-- Display table list brand  --}}
   <table class="table table-bordered table-brand" style="margin-top: 24px; min-width: 400px;">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th style="text-align: center;">
                    <input type="checkbox" class="check-all">
                </th>
                <th>Id hãng xe</th>
                <th>Tên hãng xe</th>
                <th>Trạng thái hãng xe</th>
                <th>Lựa chọn</th>
            </tr>
        </thead>
        <tbody>
            @if ($brandList->count() === 0)
                <h1 class="text-center text-danger">Không có dữ liệu</h1>                
            @endif
            @foreach ($brandList as $item)
            <tr>
                <th class="text-center">{{++$i}}</th>
                <th scope="row" style="text-align: center;">
                    <input type="checkbox"  id="brand-id brand-id-{{$item->brand_id}}">
                </th>
                <td>{{$item->brand_id}}</td>
                <td>{{$item->brand_name}}</td>
                <td>
                    @php
                        if($item->brand_status_id === 1) {
                            echo '<span class="text-success">Hoạt động</span>';
                        }

                        if($item->brand_status_id === 2) {
                            echo '<span class="text-danger">Dừng hoạt động</span>';
                        }
                            
                    @endphp
                </td>
                <td style="display: flex;align-items: center;">
                    <a  href=""
                        class="btn btn-primary btn-update btn-update-brand" 
                        data-toggle = "modal"
                        data-target = "#form_update_brand"
                        data-id = "{{$item->brand_id}}"
                        data-brand-name = "{{$item->brand_name}}"
                        data-brand-status-id = "{{$item->brand_status_id}}"
                    >
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    {{-- <form action="{{route('admin.brand.delete')}}" method="POST" id="form_delete_brand">
                        @csrf
                        <input type="hidden" name="delete_brand_id" value="{{$item->brand_id}}">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </form> --}}
                    <a  href=""
                        class="btn btn-danger btn-delete btn-delete-brand" 
                        data-toggle = "modal"
                        data-target = "#form_delete_brand"
                        data-brand-id = "{{$item->brand_id}}"
                        data-brand-name = "{{$item->brand_name}}"
                    >
                        <i class="fa-regular fa-trash-can"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$brandList->links()}}
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

            // Xử lý ajax phần add brand
            $(document).on('click', '.btn-add-brand', function(e) {
                e.preventDefault();

                let brand_name = $('#brand_name').val().trim();
                $('.message_error_brand_name').append('');

                $.ajax({
                    url: "{{route('admin.brand.add')}}",
                    method: 'POST',
                    data: { brand_name: brand_name},
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            $('#form_add_brand').modal('hide');
                            $('#form_add_brand')[0].reset();
                            $('.table').load(location.href + ' .table > *');

                            //Check if pagination exists and load it neccessary
                            if($('.pagination').length) {
                                $('.pagination').load(location.href + ' .pagination > *');
                            }

                            Command: toastr["success"](`Thêm thành công hãng xe "<span style="font-weight: bold;">${brand_name}</span>"`, "Thêm hãng xe")

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
                            console.log('Xin chào lỗi');
                            $('.message_error_brand_name').append('<span class="text-danger">' + errMesage + '</span>')
                        });
                    }
                });
            });

            // Xử lý phần hiển thị modal update brand
            $(document).on('click', '.btn-update-brand', function(e){
                // alert('Xin chào');
                let id = $(this).data('id');
                let brand_status_id = $(this).data('brand-status-id');
                let brand_status_name = $(this).data('brand-name');
                let messageError = $('.message_error_brand_name');

                //Clear message error exists
                messageError.empty();
                
                console.log(brand_status_id, brand_status_name)
                $('#update_brand_name').val(brand_status_name);
                $('#update_brand_status').val(brand_status_id);
                $('#update_brand_id').val(id);
            });

            //xử lý sự kiện Update brand
            $(document).on('click', '.btn-submit-update-brand', function(e) {
                e.preventDefault();

                let brand_id = $('#update_brand_id').val();
                let brand_name = $('#update_brand_name').val().trim();
                let brand_status_id = $('#update_brand_status').val().trim();

                
                $.ajax({
                    url: "{{route('admin.brand.update')}}",
                    method: 'POST',
                    data: { 
                        brand_id : brand_id,
                        brand_name: brand_name,
                        brand_status_id : brand_status_id,
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            $('#form_update_brand').modal('hide');
                            $('#form_update_brand')[0].reset();
                            $('.table').load(location.href + ' .table > *');

                            //Check if pagination exists and load it neccessary
                            if($('.pagination').length) {
                                $('.pagination').load(location.href + ' .pagination > *');
                            }

                            Command: toastr["success"](`Cập nhật thành công hãng xe "<span style="font-weight: bold;">${brand_name}</span>"`, "Cập nhật hãng xe")

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
                        $('.message_error_brand_name').append('');

                        let errorMessage = error.responseJSON;
                        console.log(errorMessage);
                        $.each(errorMessage.errors, function (index, errMesage) { 
                            console.log('Xin chào lỗi');
                            $('.message_error_brand_name').append('<span class="text-danger">' + errMesage + '</span>')
                        });
                    }
                });
            });


            // Xử lý sự kiện Delete brand
            $(document).on('click', '.btn-delete-brand', function(e) {
                e.preventDefault();
                let brand_id = $(this).data('brand-id');
                let brand_name = $(this).data('brand-name');
                
                if(confirm(`Bạn có muốn xóa hãng xe ${brand_name} không`)) {
                    $.ajax({
                    url: "{{route('admin.brand.delete')}}",
                    method: 'POST',
                    data: { 
                        brand_id : brand_id,
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            $('.table').load(location.href + ' .table > *');

                            //Check if pagination exists and load it neccessary
                            if($('.pagination').length) {
                                $('.pagination').load(location.href + ' .pagination > *');
                            }

                            Command: toastr["success"](`Xóa thành công hãng xe`, "Xóa hãng xe")

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
                            $('.message_error_brand_name').append('<span class="text-danger">' + errMesage + '</span>')
                        });
                    }
                });
                }
            });

            // Seach brand realtime
            var timeout = null;
    
            $(document).on('keyup', '#search-brand', function(e) {
                e.preventDefault();
                clearTimeout(timeout); // Hủy timeout trước đó để thiết lập mới

                let searchbrandValue = $(this).val();

                // Đặt một timeout khi người dùng gõ xong
                timeout = setTimeout(function() {
                    $.ajax({
                        url : "{{route('admin.brand.search')}}",
                        method: 'GET',
                        data: {
                            search_string_brand : searchbrandValue
                        },
                        success: function(res) {
                            if (res.status === 'not found') {
                                $('.table-brand').html('<span class="text-danger">Không tìm thấy kết quả</span>');
                                $('.pagination').hide();
                            } else {
                                $('.table-brand').html(res);
                                $('.pagination').show();
                            }
                        }
                    });
                }, 300); 
            });


        });
    </script>
@endsection