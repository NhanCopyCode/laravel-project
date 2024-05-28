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
                    data-role-id = "{{$item->role_id}}"
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