@extends('layouts.admin.admin_layout')

@section('content')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form_add_model">
        Thêm mẫu xe mới
    </button>
    
    <!-- Modal add bracnh -->
    <form method="POST" action="{{route('admin.model.add')}}" class="modal fade modal-model" id="form_add_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        @csrf
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Thêm mẫu xe</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="model-vehicle">Tên mẫu xe</label>
                    <input type="text" class="form-control" id="model_name" name="model_name" placeholder="Nhập tên mẫu xe..." required>
                    <div class="message_error" id="error-model_name">

                    </div>
                </div>
                <div class="form-group">
                    <label for="engine_type">Dung tích xilanh (cc)</label>
                    <input type="number" class="form-control" id="engine_type" name="engine_type" placeholder="Nhập dung tích xilanh..." required>
                    <div class="message_error" id="error-engine_type">

                    </div>
                </div>

                <div class="form-group">
                    <label for="color">Nhập màu sắc (cc)</label>
                    <input type="text" class="form-control" id="color" name="color" placeholder="Nhập màu sắc..." required>
                    <div class="message_error" id="error-color">

                    </div>
                </div>

                <div class="form-group">
                    <label for="year_of_production">Năm sản xuất</label>
                    <input type="number" class="form-control" id="year_of_production" name="year_of_production" placeholder="Nhập năm sản xuất..." required>
                    <div class="message_error" id="error-year_of_production">

                    </div>
                </div>

                <div class="form-group">
                    <label for="brand_id">Chọn mẫu xe</label>
                    <select class="form-control" name="brand_id" id="brand_id">
                        @foreach ($brand_list as $brand)
                            <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                        @endforeach
                    </select>
                    <div class="message_error" id="error-brand_id">

                    </div>
                </div>


            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-add-model">Thêm</button>
            </div>
        </div>
        </div>
    </form>

    {{-- Modal update model --}}
    @include('blocks.admin.modal_update_model')

    {{-- Search button --}}
    <input type="text" class="form-control mb-3 mt-3" id="search-model" name="search-model" placeholder="Tìm kiếm...">


    {{-- Display table list model  --}}
   <table class="table table-bordered table-model" style="margin-top: 24px; min-width: 400px;">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th style="text-align: center;">
                    <input type="checkbox" class="check-all">
                </th>
                <th>Id mẫu xe</th>
                <th>Tên mẫu xe</th>
                <th>Dung tích xilanh</th>
                <th>Màu sắc</th>
                <th>Năm sản xuất</th>
                <th>Hãng sản xuất</th>
                <th>Trạng thái</th>
                <th>Lựa chọn</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($modelList as $item)
            <tr>
                <th class="text-center">{{++$i}}</th>
                <th scope="row" style="text-align: center;">
                    <input type="checkbox"  id="model-id model-id-{{$item->model_id}}">
                </th>
                <td>{{$item->model_id}}</td>
                <td>{{$item->model_name}}</td>
                <td>{{$item->engine_type}}</td>
                <td>{{$item->color}}</td>
                <td>{{$item->year_of_production}}</td>
                <td>{{$item->brand_name}}</td>
                <td>
                    @php
                        if($item->model_status_id === 1) {
                            echo '<span class="text-success">Hoạt động</span>';
                        }

                        if($item->model_status_id === 2) {
                            echo '<span class="text-danger">Dừng hoạt động</span>';
                        }
                            
                    @endphp
                </td>
                <td style="display: flex;align-items: center;">
                    <a  href=""
                        class="btn btn-primary btn-update btn-update-model" 
                        data-toggle = "modal"
                        data-target = "#form_update_model"
                        data-id = "{{$item->model_id}}"
                        data-model-name = "{{$item->model_name}}"
                        data-model-status-id = "{{$item->model_status_id}}"
                        data-engine-type = "{{$item->engine_type}}"
                        data-color = "{{$item->color}}"
                        data-year-of-production = "{{$item->year_of_production}}"
                        data-brand-id = "{{$item->brand_id}}"
                        data-model-status-id = "{{$item->model_status_id}}"
                    >
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    {{-- <form action="{{route('admin.model.delete')}}" method="POST" id="form_delete_model">
                        @csrf
                        <input type="hidden" name="delete_model_id" value="{{$item->model_id}}">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </form> --}}
                    <a  href=""
                        class="btn btn-danger btn-delete btn-delete-model" 
                        data-toggle = "modal"
                        data-target = "#form_delete_model"
                        data-model-id = "{{$item->model_id}}"
                        data-model-name = "{{$item->model_name}}"
                    >
                        <i class="fa-regular fa-trash-can"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$modelList->links()}}
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

            // Xử lý ajax phần add model
            $(document).on('click', '.btn-add-model', function(e) {
                e.preventDefault();

                let model_name = $('#model_name').val().trim();
                let engine_type = $('#engine_type').val().trim();
                let color = $('#color').val().trim();
                let year_of_production = $('#year_of_production').val().trim();
                let brand_id = $('#brand_id').val().trim();

                $('.message_error_model_name').append('');

                $.ajax({
                    url: "{{route('admin.model.add')}}",
                    method: 'POST',
                    data: { 
                        model_name: model_name,
                        engine_type: engine_type,
                        color: color,
                        year_of_production: year_of_production,
                        brand_id: brand_id
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            $('#form_add_model').modal('hide');
                            $('#form_add_model')[0].reset();
                            $('.table').load(location.href + ' .table > *');

                            //Check if pagination exists and load it neccessary
                            if($('.pagination').length) {
                                $('.pagination').load(location.href + ' .pagination > *');
                            }

                            Command: toastr["success"](`Thêm thành công mẫu xe "<span style="font-weight: bold;">${model_name}</span>"`, "Thêm mẫu xe")

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
                        $('.message_error').empty();

                        $.each(errorMessage.errors, function (field, messages) { 
                            console.log(field);
                            // console.log(errMesage);
                            $('#error-' + field).append('<span class="text-danger">' + messages.join('<br>') + '</span>');
                        });
                    }
                });
            });

            // Xử lý phần hiển thị modal update model
            $(document).on('click', '.btn-update-model', function(e){
                // alert('Xin chào');
                let id = $(this).data('id');
                let model_status_name = $(this).data('model-name');
                let engine_type = $(this).data('engine-type');
                let color = $(this).data('color');
                let year_of_production = $(this).data('year-of-production');
                let brand_id = $(this).data('brand-id');
                let model_status_id = $(this).data('model-status-id');

                //Clear message error exists
                $('.message_error').empty();

                console.log(year_of_production, brand_id, model_status_id);
                
                // console.log(model_status_id, model_status_name)
                $('#update_model_id').val(id);
                $('#update_model_name').val(model_status_name);
                $('#update_engine_type').val(engine_type);
                $('#update_color').val(color);
                $('#update_year_of_production').val(year_of_production);
                $('#update_brand_id').val(brand_id);
                // $('#update_model_status').val(model_status_id);
                $('#update_model_status_id').val(model_status_id);
            });

            //xử lý sự kiện Update model
            $(document).on('click', '.btn-submit-update-model', function(e) {
                e.preventDefault();

                let model_id = $('#update_model_id').val();
                let model_name = $('#update_model_name').val().trim();
                let engine_type = $('#update_engine_type').val().trim();
                let color = $('#update_color').val().trim();
                let year_of_production = $('#update_year_of_production').val().trim();
                let brand_id = $('#update_brand_id').val().trim();
                let model_status_id = $('#update_model_status_id').val().trim();
                
                $.ajax({
                    url: "{{route('admin.model.update')}}",
                    method: 'POST',
                    data: { 
                        model_id : model_id,
                        model_name: model_name,
                        engine_type: engine_type,
                        color: color,
                        year_of_production: year_of_production,
                        brand_id: brand_id,
                        model_status_id : model_status_id,
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            $('#form_update_model').modal('hide');
                            $('#form_update_model')[0].reset();
                            $('.table').load(location.href + ' .table > *');

                            //Check if pagination exists and load it neccessary
                            if($('.pagination').length) {
                                $('.pagination').load(location.href + ' .pagination > *');
                            }

                            Command: toastr["success"](`Cập nhật thành công mẫu xe "<span style="font-weight: bold;">${model_name}</span>"`, "Cập nhật mẫu xe")

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


            // Xử lý sự kiện Delete model
            $(document).on('click', '.btn-delete-model', function(e) {
                e.preventDefault();
                let model_id = $(this).data('model-id');
                let model_name = $(this).data('model-name');
                
                if(confirm(`Bạn có muốn xóa mẫu xe ${model_name} không`)) {
                    $.ajax({
                    url: "{{route('admin.model.delete')}}",
                    method: 'POST',
                    data: { 
                        model_id : model_id,
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
                            $('.message_error_model_name').append('<span class="text-danger">' + errMesage + '</span>')
                        });
                    }
                });
                }
            });

           // Seach brand realtime
            var timeout = null;
    
            $(document).on('keyup', '#search-model', function(e) {
                e.preventDefault();
                clearTimeout(timeout); // Hủy timeout trước đó để thiết lập mới

                let searchmodelValue = $(this).val();

                // Đặt một timeout khi người dùng gõ xong
                timeout = setTimeout(function() {
                    $.ajax({
                        url : "{{route('admin.model.search')}}",
                        method: 'GET',
                        data: {
                            search_string_model : searchmodelValue
                        },
                        success: function(res) {
                            if (res.status === 'not found') {
                                $('.table-model').html('<span class="text-danger">Không tìm thấy kết quả</span>');
                                $('.pagination').hide();
                            } else {
                                $('.table-model').html(res);
                                $('.pagination').show();
                            }
                        }
                    });
                }, 300); 
            });


        });
    </script>
@endsection