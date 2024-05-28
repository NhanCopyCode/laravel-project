<div style="width: 600px; margin: 0 auto; border: 1px solid #ccc; border-radius: 4px; background: #f5f5f5;">
    <div style="text-align: center;">
        <h3>Xin chào {{$user->name}}</h3>
        <p>Vui lòng click vào 
            <a style="
            font-weight: bold;
            text-decoration: underline;
            font-size: 18px;

        " href="{{route('auth.get_forgot_password', ['user' => $user->user_id, 'token'=> $user->token])}}">Link</a>
            ở đây để đặt lại mật khẩu
        </p>
        <span style="text-decoration: ">Chú ý: mã xác nhận chỉ có hiệu lực trong 24h</span>
        
    </div>

</div>