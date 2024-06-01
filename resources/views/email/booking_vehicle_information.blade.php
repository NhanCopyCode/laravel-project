<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thông tin đặt xe</title>
    <style>
        table, th, td {
            border:1px solid black;
        }

        * {
            color: #000;
        }
    </style>
</head>
<body>
    <div style="width: 1000px; text-align:center; margin:0 auto; background-color: #f5f5f5; border-radius: 4px;">
        <h2 style="">Bạn đã đặt xe từ ngày {{$vehicle_information->rental_start_date}} đến ngày {{$vehicle_information->rental_end_date}}</h2>
        <h3>Dưới đây là thông tin đặt xe</h3>
        <table style="overflow-x: scroll">
            <thead>
                <tr>
                    <th>Tên xe</th>
                    <th>Động cơ</th>
                    <th>Năm sản xuất</th>
                    <th>Bắt đầu thuê từ ngày</th>
                    <th>Kết thúc từ ngày</th>
                    <th>Tổng tiền</th>
                    <th>Giá đã thanh toán</th>
    
                </tr>
    
            </thead>
    
            <tbody>
                <tr>
                    <td>{{$vehicle_information->model_name}}</td>
                    <td>{{$vehicle_information->engine_type}}</td>
                    <td>{{$vehicle_information->year_of_production}}</td>
                    <td>{{$vehicle_information->rental_start_date}}</td>
                    <td>{{$vehicle_information->rental_end_date}}</td>
                    <td>{{$vehicle_information->total_cost}}</td>
                    <td>{{$vehicle_information->total_cost}}</td>
                </tr>
            </tbody>
            
        </table>
    </div>
</body>
</html>
