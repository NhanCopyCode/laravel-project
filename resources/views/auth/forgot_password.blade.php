

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('assets/clients/css/login.css')}}">
    <title>Login</title>
</head>
<body>
    {{-- {{time()}} --}}
    <form action="{{route('auth.forgot_passowrd_mail')}}" method="POST" class="login-box">

        @csrf
        <div class="login-header">
            <header>Nhập email để lấy lại mật khẩu</header>
           
            @if (session('msg--email-forget-password'))
                <span style="color: green;">{{session('msg--email-forget-password')}}</span>
            @endif
        </div>
        <div class="input-box">
            <input type="email" class="input-field" placeholder="Email" name="email" autocomplete="off" required value="{{old('email')}}">
            @error('email')
                <span style="color: red;margin-bottom: 12px;">{{$message}}</span>
            @enderror
        </div>
       
        <div style="margin-top: 12px;" class="input-submit">
            <button type="submit" class="submit-btn" id="submit"></button>
            <label for="submit">Get password</label>
        </div>
      
    </form>
    {{-- <script src="{{asset('assets/clients/js/login.js')}}"></script> --}}

    <script>
      
    </script>
</body>
</html>