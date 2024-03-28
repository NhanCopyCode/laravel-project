

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('assets/clients/css/login.css')}}">
    <title>Login with business owner</title>
</head>
<body>
    {{-- {{time()}} --}}
    <form action="{{route('auth.check_login_owner')}}" method="POST" class="login-box">
        @csrf
        <div class="login-header">
            <header>Login with business owner</header>
            @if (session('msg--confirm'))
                <span style="color: green;">{{session('msg--confirm')}}</span>
            @endif
            @if (session('msg--actived'))
                <span style="color: green;">{{session('msg--actived')}}</span>
            @endif
            @if (session('msg--email-forget-password'))
                <span style="color: green;">{{session('msg--email-forget-password')}}</span>
            @endif
            @if (session('msg--rejected'))
                <span style="color: red;">{{session('msg--rejected')}}</span>
            @endif

            @if (session('msg--not_active'))
                <span style="color: red;">{!!session('msg--not_active')!!}</span>
            @endif

        </div>
        <div class="input-box">
            <input type="text" class="input-field" placeholder="Email" name="email" autocomplete="off" required value="{{old('email')}}">
            @error('email')
                <span style="color: red;">{{$message}}</span>
            @enderror
        </div>
        <div class="input-box">
            <input type="password" class="input-field" placeholder="Password" name="password" autocomplete="off" required value="{{old('email')}}">
        </div>
        @error('password')
            <span style="color: red;">{{$message}}</span>
        @enderror
        <div class="forgot">
            <section>
                <input type="checkbox" id="check">
                <label for="check">Remember me</label>
            </section>
            <section>
                <a href="{{route('auth.forgot_password')}}">Forgot password</a>
            </section>
        </div>
        <div class="input-submit">
            <button type="submit" class="submit-btn" id="submit"></button>
            <label for="submit">Sign In</label>
        </div>
        <div class="sign-up-link">
            <p>Don't have account? <a href="{{route('auth.register_owner')}}">Register to become a car service provider</a></p>
        </div>
    </form>
    {{-- <script src="{{asset('assets/clients/js/login.js')}}"></script> --}}

</body>
</html>