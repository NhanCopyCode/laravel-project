

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
    <form action="{{route('auth.check_register_owner')}}" method="POST" class="login-box">
        @csrf
        <div class="login-header">
            <header>Register with the business owner</header>
        </div>
        <div class="input-box">
            <input type="text" class="input-field" placeholder="Full name" name="name" autocomplete="off" required value="{{old('name')}}">
            @error('name')
                <span style="color: red;">{{$message}}</span>
            @enderror
        </div>
        <div class="input-box">
            <input type="text" class="input-field" placeholder="Email" name="email" autocomplete="off" required value="{{old('email')}}">
            @error('email')
                <span style="color: red;">{{$message}}</span>
            @enderror
        </div>
        <div class="input-box">
            <input type="password" class="input-field" placeholder="Password" name="password" autocomplete="off" required value="{{old('password')}}">
         
        </div>
        <div class="input-box">
            <input type="password" class="input-field" placeholder="Password confirm" name="password_confirmation" autocomplete="off" required value="{{old('password_confirmation')}}">
            @error('password')
                <span style="color: red;">{{$message}}</span>
            @enderror
        </div>
        <div class="forgot">
            <section>
                <input type="checkbox" id="check">
                <label for="check">Remember me</label>
            </section>

            <section>
                <input type="checkbox" id="btnShowPassword"></input>
                <label for="btnShowPassword">Show password</label>
            </section>
        </div>
        <div class="input-submit">
            <button type="submit" class="submit-btn" id="submit"></button>
            <label for="submit">Sign Up</label>
        </div>
        <div class="sign-up-link">
            <p>You already have an account? <a href="{{route('auth.login_owner')}}">Sign in</a></p>
        </div>
    </form>
    <script src="{{asset('assets/clients/js/show_password.js')}}"></script>

</body>
</html>