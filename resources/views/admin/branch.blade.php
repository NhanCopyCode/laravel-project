@extends('layouts.admin.admin_layout')

@section('content')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form_branch">
        Thêm chi nhánh mới
    </button>

    <!-- Modal -->
    <form method="POST" action="{{route('admin.branch.create')}}" class="modal fade modal-branch" id="form_branch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
                    <input type="text" class="form-control" id="city" name="branch_name" placeholder="Nhập tên chi nhánh..." required>
                    @error('branch_name')
                        <span style="color: red;">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
        </div>
        </div>
    </form>

    {{-- Display list branch  --}}
   <table class="table table-bordered " style="margin-top: 24px; min-width: 400px;">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" class="check-all">
                </th>
                <th>Id chi nhánh</th>
                <th>Tên chi nhánh</th>
                <th>Lựa chọn</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($branchList as $item)
            <tr>
                <th scope="row">
                    <input type="checkbox">
                </th>
                <td>{{$item->branch_id}}</td>
                <td>{{$item->branch_name}}</td>
                <td style="display: flex;align-items: center;">
                    <button class="btn btn-primary btn-update" >
                        <i class="fa-regular fa-pen-to-square"></i>
                    </button>
                    <form action="{{route('admin.branch.delete', ['id' => $item->branch_id])}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
   </table>
   
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
            console.log(checkAllInput);
        });
    </script>
@endsection