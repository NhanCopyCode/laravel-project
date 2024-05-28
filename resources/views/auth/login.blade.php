

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('assets/clients/css/login.css')}}">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <title>Login</title>
</head>
<body>
    
    {{-- <form action="{{route('auth.login')}}" method="POST" class="login-box">

        @csrf
        <div class="login-header">
            <header>Login</header>
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
            @if (session('msg--get-password'))
                <span style="color: green;">{{session('msg--get-password')}}</span>
            @endif
        </div>
        <div class="input-box">
            
            <input type="text" class="input-field" placeholder="Email" name="email" autocomplete="off" required @if(isset($_COOKIE['email_user'])) value="{{$_COOKIE['email_user']}}" @else value="{{old('email')}}" @endif>
            @error('email')
                <span style="color: red;">{{$message}}</span>
            @enderror
        </div>
        <div class="input-box">
            <input type="password" class="input-field" placeholder="Password" name="password" autocomplete="off" required  @if(isset($_COOKIE['password'])) value="{{$_COOKIE['password']}}" @else value="{{old('password')}}" @endif>
            @error('password')
                <span style="color: red;">{{$message}}</span>
            @enderror
            @if (session('msg--wrong-password'))
                <span style="color: red;">{{session('msg--wrong-password')}}</span>
            @endif
        </div>
        <div class="forgot">
            <section>
                <input name="remember_me" type="checkbox" id="check">
                <label for="check">Remember me</label>
            </section>
            <section>
                <a href="{{route("auth.forgot_password")}}">Forgot password</a>
            </section>
        </div>
        <div class="input-submit">
            <button type="submit" class="submit-btn" id="submit"></button>
            <label for="submit">Sign In</label>
        </div>
        
    </form> --}}
    <div class="login-header d-flex flex-column">
        <header style="margin-bottom: 40px; font-size: 50px;">Login</header>

        <a style="text-decoration: none;" class="login_google_btn btn btn-dark mt-10" href="/auth/google/redirect">Login with Google</a>
    </div>
    {{-- <script src="{{asset('assets/clients/js/login.js')}}"></script> --}}

</body>
</html>