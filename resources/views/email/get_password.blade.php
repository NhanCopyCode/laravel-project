

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('assets/clients/css/login.css')}}">
    <title>Nhangg Website</title>
</head>
<body>
    {{-- {{time()}} --}}
    <form action="{{route('auth.post_forgot_password', ['user' => $user->user_id, 'token' => $user->token])}}" method="POST" class="login-box">

        @csrf
        <div class="login-header">
            <header>Đổi mật khẩu</header>
            @if (session('msg'))
                <span style="color: red;">{!!session('msg')!!}</span>
            @endif
            @if (session('msg--rejected'))
                <span style="color: red;">{{session('msg--reject')}}</span>
            @endif
            @if (session('msg--actived'))
                <span style="color: green;">{{session('msg--actived')}}</span>
            @endif
            @if (session('msg--confirm'))
                <span style="color: green;">{{session('msg--confirm')}}</span>
            @endif
        </div>
      
        <div class="input-box">
            <input type="password" class="input-field" placeholder="Password" name="password" autocomplete="off" required value="{{old('password')}}">
            @error('password')
                <span style="color: red;">{{$message}}</span>
            @enderror
        </div>
        <div class="input-box">
            <input type="password" class="input-field" placeholder="Password confirmation " name="password_confirmation" autocomplete="off" required value="{{old('password_confirmation ')}}">
            
        </div>
        <div class="forgot">
            <section>
                <input id="btnShowPassword" type="checkbox" >
                <label for="btnShowPassword">Hiển thị mật khẩu</label>
            </section>
            
        </div>
        <div class="input-submit">
            <button type="submit" class="submit-btn" id="submit"></button>
            <label for="submit">Đổi mật khẩu</label>
        </div>
        
    </form>
    <script src="{{asset('assets/clients/js/show_password.js')}}"></script>

</body>
</html>