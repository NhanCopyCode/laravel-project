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
{{-- {{$brandList->links()}} --}}