<div style="width: 600px; margin: 0 auto;">
    <div style="text-align: center;">
        <h1>Xin chào {{$user->name}}</h1>
        <p>Bạn đã đăng kí tài khoản của chúng tôi</p>
        <p>Hãy click vào nút dưới để kích hoạt tài khoản</p>
        <a style="
            text-decoration: none;
            color: #000;
            border-radius: 4px;
            padding: 8px 12px;
            background-color: #ccc;

        " href="{{route('auth.user.actived', ['user' => $user->user_id, 'token'=> $user->token])}}">Kích hoạt tài khoản</a>
    </div>

</div>