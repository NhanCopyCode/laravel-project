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