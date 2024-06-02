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
<BODY>
    <div style="width: 600px; text-align:center; border-radius: 6px; background-color: #f5f5f5; margin: 0 auto;">
        <h1>Lịch đăng ký xe của bạn đã bị hủy</h1>
        <h3>Lý do hủy: {{$reason}}</h3>
        <h3>Thông tin đăng ký xe bị hủy</h3>
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
                    <td>{{$model->model_name}}</td>
                    <td>{{$model->engine_type}}</td>
                    <td>{{$model->year_of_production}}</td>
                    <td>{{$rental->rental_start_date}}</td>
                    <td>{{$rental->rental_end_date}}</td>
                    <td>{{$payment->amount}}</td>
                    <td>{{$rental->amount_paid}}</td>
                </tr>
            </tbody>
            
        </table>
    </div>
    
</BODY>