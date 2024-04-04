<div style="width: 600px; margin: 0 auto;">
    <div style="text-align: center;">
        <h1>Xin chào {{$user->name}}</h1>
        <p>Vui lòng click vào link dưới đây để đặt lại mật khẩu</p>
        <span>Chú ý: mã xác nhận chỉ có hiệu lực trong 72h</span>
        <a style="
            text-decoration: none;
            color: #000;
            border-radius: 4px;
            padding: 8px 12px;
            background-color: #ccc;

        " href="{{route('auth.get_forgot_password', ['user' => $user->user_id, 'token'=> $user->token])}}">Lấy lại mật khẩu</a>
    </div>

</div>