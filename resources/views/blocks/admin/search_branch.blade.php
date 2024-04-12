 {{-- Display table list branch  --}}
 <table class="table table-bordered table-branch" style="margin-top: 24px; min-width: 400px;">
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
{{-- {{$branchList->links()}} --}}