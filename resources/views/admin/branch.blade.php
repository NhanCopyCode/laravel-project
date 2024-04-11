@extends('layouts.admin.admin_layout')

@section('content')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form_add_branch">
        Thêm chi nhánh mới
    </button>
    
    <!-- Modal -->
    <form method="POST" action="{{route('admin.branch.add')}}" class="modal fade modal-branch" id="form_add_branch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        @csrf
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Thêm chi nhánh</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="city">Thành phố</label>
                    <input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="Nhập tên chi nhánh..." required>
                    <div class="message_error_branch_name">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-add-branch">Thêm</button>
            </div>
        </div>
        </div>
    </form>

    {{-- Modal update branch --}}
    @include('blocks.admin.modal_update_branch')

    {{-- Display list branch  --}}
   <table class="table table-bordered " style="margin-top: 24px; min-width: 400px;">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th style="text-align: center;">
                    <input type="checkbox" class="check-all">
                </th>
                <th>Id chi nhánh</th>
                <th>Tên chi nhánh</th>
                <th>Trạng thái chi nhánh</th>
                <th>Lựa chọn</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($branchList as $item)
            <tr>
                <th class="text-center">{{++$i}}</th>
                <th scope="row" style="text-align: center;">
                    <input type="checkbox"  id="branch-id branch-id-{{$item->branch_id}}">
                </th>
                <td>{{$item->branch_id}}</td>
                <td>{{$item->branch_name}}</td>
                <td>
                    @php
                        if($item->branch_status_id === 1) {
                            echo '<span class="text-success">Hoạt động</span>';
                        }

                        if($item->branch_status_id === 2) {
                            echo '<span class="text-danger">Dừng hoạt động</span>';
                        }
                            
                    @endphp
                </td>
                <td style="display: flex;align-items: center;">
                    <a  href=""
                        class="btn btn-primary btn-update btn-update-branch" 
                        data-toggle = "modal"
                        data-target = "#form_update_branch"
                        data-id = "{{$item->branch_id}}"
                        data-branch-name = "{{$item->branch_name}}"
                        data-branch-status-id = "{{$item->branch_status_id}}"
                    >
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    {{-- <form action="{{route('admin.branch.delete')}}" method="POST" id="form_delete_branch">
                        @csrf
                        <input type="hidden" name="delete_branch_id" value="{{$item->branch_id}}">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </form> --}}
                    <a  href=""
                        class="btn btn-danger btn-delete btn-delete-branch" 
                        data-toggle = "modal"
                        data-target = "#form_delete_branch"
                        data-branch-id = "{{$item->branch_id}}"
                        data-branch-name = "{{$item->branch_name}}"
                    >
                        <i class="fa-regular fa-trash-can"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
   </table>
   {{$branchList->links()}}
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
            // alert('Xin chào');
            const checkAllInput = $('.check-all');
            const allBranchIdInput = $('input:checkbox');

            console.log(allBranchIdInput);
            
            checkAllInput.on('click', function() {
                allBranchIdInput.not(this).prop('checked', this.checked);
            });

            allBranchIdInput.change(function() {
                let totalInputTypeCheckboxWithoutInputCheckAll = $('input:checkbox').not('.check-all').length;
                let countChecked = $('input:checkbox:checked').not('.check-all').length;

                if(countChecked === 0) {
                    checkAllInput.prop('checked', false);
                }


                if(countChecked === totalInputTypeCheckboxWithoutInputCheckAll) {
                    checkAllInput.prop('checked', true);
                }
            });

            // Xử lý ajax phần add branch
            $(document).on('click', '.btn-add-branch', function(e) {
                e.preventDefault();

                let branch_name = $('#branch_name').val().trim();
                $('.message_error_branch_name').append('');

                $.ajax({
                    url: "{{route('admin.branch.add')}}",
                    method: 'POST',
                    data: { branch_name: branch_name},
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            $('#form_add_branch').modal('hide');
                            $('#form_add_branch')[0].reset();
                            $('.table').load(location.href + ' .table-bordered');
                        }
                    },
                    error: function(error) {
                        let errorMessage = error.responseJSON;
                        console.log(errorMessage);
                        $.each(errorMessage.errors, function (index, errMesage) { 
                            console.log('Xin chào lỗi');
                            $('.message_error_branch_name').append('<span class="text-danger">' + errMesage + '</span>')
                        });
                    }
                });
            });

            // Xử lý phần hiển thị modal update branch
            $(document).on('click', '.btn-update-branch', function(e){
                // alert('Xin chào');
                let id = $(this).data('id');
                let branch_status_id = $(this).data('branch-status-id');
                let branch_status_name = $(this).data('branch-name');
                
                console.log(branch_status_id, branch_status_name)
                $('#update_branch_name').val(branch_status_name);
                $('#update_branch_status').val(branch_status_id);
                $('#update_branch_id').val(id);
            });

            //xử lý sự kiện Update branch
            $(document).on('click', '.btn-submit-update-branch', function(e) {
                e.preventDefault();

                let branch_id = $('#update_branch_id').val();
                let branch_name = $('#update_branch_name').val().trim();
                let branch_status_id = $('#update_branch_status').val().trim();

                
                $.ajax({
                    url: "{{route('admin.branch.update')}}",
                    method: 'POST',
                    data: { 
                        branch_id : branch_id,
                        branch_name: branch_name,
                        branch_status_id : branch_status_id,
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            $('#form_update_branch').modal('hide');
                            $('#form_update_branch')[0].reset();
                            $('.table').load(location.href + ' .table-bordered');
                        }
                    },
                    error: function(error) {
                        $('.message_error_branch_name').append('');

                        let errorMessage = error.responseJSON;
                        console.log(errorMessage);
                        $.each(errorMessage.errors, function (index, errMesage) { 
                            console.log('Xin chào lỗi');
                            $('.message_error_branch_name').append('<span class="text-danger">' + errMesage + '</span>')
                        });
                    }
                });
            });


            // Xử lý sự kiện Delete branch
            $(document).on('click', '.btn-delete-branch', function(e) {
                e.preventDefault();
                let branch_id = $(this).data('branch-id');
                let branch_name = $(this).data('branch-name');
                
                alert(branch_id);
                // alert(branch_id);
                if(confirm(`Bạn có muốn xóa chi nhánh ${branch_name} không`)) {
                    $.ajax({
                    url: "{{route('admin.branch.delete')}}",
                    method: 'POST',
                    data: { 
                        branch_id : branch_id,
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status === 'success') {
                            $('.table').load(location.href + ' .table-bordered');
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
                            $('.message_error_branch_name').append('<span class="text-danger">' + errMesage + '</span>')
                        });
                    }
                });
                }
            });
        });
    </script>
@endsection