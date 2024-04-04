<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ccc
        }
        #error_content {

        }

        #error_content .error_message {

        }

        #error_content .error_link {
            text-decoration: none;
            
        }
    </style>
</head>
<body>
    <div id="error_content">
        <h1 class="error_message">Bạn chưa đăng ký cho tài khoản này. <a href="{{route("auth.login_owner")}}" class="error_link">Click vào đây để đăng kí</a></h1>
    </div>
</body>
</html>