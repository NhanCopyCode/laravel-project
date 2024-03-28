<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\OwnerRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\Auth\UserRequest;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\VarDumper\Caster\RedisCaster;

class UserController extends Controller
{
    //
    public function index() 
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {   
        // dd($request->all());
        $data = $request->all('email', 'password');
        
        if(auth()->attempt($data)) {
            
            //Nếu tài khoản không có status id = 2 thì tài khoản đó không được vào (status = 2 là active)
            if(Auth::user()->user_status_id != 2) {
                // dd('Vào được rồi');
                return redirect()->route('auth.')->with('msg', 'Tài khoản chưa được kích hoạt, vui lòng click vào <a style="font-size: 20px;font-weight: bold;" href="">đây</a> để kích hoạt');
            }
            $user = User::where('email', $request->email)->first();
            // dd(Auth::user());
            Auth::login($user);
            return redirect()->route('home');
        }else {
            return back()->with('msg--wrong-password', 'Nhập sai mật khẩu');
        }
        
        return back();
    }
    

    // public function register(UserRequest $request)
    // {
    //     return 'oke';
    //     $data = $request->all();
    //     dd($data);
    // }

    public function register()
    {
        return view('auth.sign_up');
    }

    public function check_register(Request $request) 
    {
        // dd($request->all());

        $rules = [
            'name' => ['required'
                , 'string'
                , 'min:6', 
            ],
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ];
        $messages = [
            'required' => ':attribute không được để trống',
            'unique' => ':attribute đã được đăng kí',
            'string' => ':attribute chỉ được nhập chữ cái',
            'email' => ':attribute không hợp lệ',
            'min' => ':attribute không được ít hơn :min kí tự',
            'confirmed' => ':attribute nhập lại không trùng nhau'
        ];

        $attributes = [
            'name' => 'Tên',
            'email' => 'Email',
            'password' => 'Mật khẩu'
        ];
        $request->validate($rules, $messages, $attributes);

        $data = request()->all('name', 'email');
        $token = strtoupper(Str::random(15));
        $data['token'] = $token;
        
        $data['password'] = Hash::make($request->password);
        // dd($data);
        if($user = User::create($data)) {
            Mail::send('email.active_account', compact('user'), function ($email) use($user) {
                // dd($user); 
                $email->subject('NhanggWebsite - Xác nhận tài khoản'); 
                $email->to($user->email, $user->name);
            });
        }

        return redirect()->route('auth.')->with('msg--confirm','Hãy vào email để kích hoạt tài khoản trong 24h');
        // return 'oke';
    }

    public function logout(Request $request)
    {
        // auth()->logout();
        Auth::logout();
        return redirect()->route('auth.');
    }

    public function login_owner()
    {
        return view('auth.owner_login');
    }

    public function check_login_owner(OwnerRequest $request)
    {
      
        $ownerLogin = $request->all('email', 'password');
        if(Auth::attempt($ownerLogin)) {
            
            //Nếu tài khoản không có status id = 2 thì tài khoản đó không được vào (status = 2 là active)
            if(Auth::user()->user_status_id != 2) {
                // dd('Vào được rồi');
                return redirect()->route('auth.login_owner')->with('msg--not_active', 'Tài khoản chưa được kích hoạt, vui lòng click vào <a style="font-size: 20px;font-weight: bold;" href="">đây</a> để kích hoạt');
            }


            $user = User::where('email', $request->email)->first();
            // dd($user);
            Auth::login($user);
            return redirect()->route('owner.index');
            
        }

        // return redirect()->route('home');
    }

    public function register_owner()
    {
        return view('auth.owner_register');
    }

    public function check_register_owner(RegisterRequest $request)
    {
        // dd($request->all());
        $data = $request->all('name', 'email');
        $data['password'] = Hash::make($request->password);
        $data['role_id'] = 2; // Role Owner = 2

        $token = strtoupper(Str::random(15));
        $data['token'] = $token;
        
        $data['password'] = Hash::make($request->password);
        if($user = User::create($data)) {
            // dd($user);
            Mail::send('email.active_account_owner', compact('user'), function ($email) use($user) {
                // dd($user); 
                $email->subject('NhanggWebsite - Xác nhận tài khoản'); 
                $email->to($user->email, $user->name);
            });
        }

        return redirect()->route('auth.login_owner')->with('msg--confirm','Hãy vào email để kích hoạt tài khoản trong 24h');
    }
    

    public function actived(User $user, $token)
    {
        if($user->token === $token && $user->created_at->diffInHours() <= 24) {
            $user->user_status_id = 2;
            $user->token = null;
            $user->save();
            // dd($user);
            return redirect()->route('auth.')->with('msg--actived', 'Xác nhận tài khoản thành công, bạn có thể đăng nhập');

        }else {
            return redirect()->route('auth.')->with('msg--rejected', 'Mã xác nhận đã hết hạn!');
        }
    }

    public function forgotPassowrd()
    {
        return view('auth.forgot_password');
    }

    
    public function owner_actived(User $user, $token)
    {
        if($user->token === $token && $user->created_at->diffInHours() <= 24) {
            $user->user_status_id = 2;
            $user->token = null;
            $user->save();
            // dd($user);
            return redirect()->route('auth.login_owner')->with('msg--actived', 'Xác nhận tài khoản thành công, bạn có thể đăng nhập');

        }else {
            return redirect()->route('auth.login_owner')->with('msg--rejected', 'Mã xác nhận đã hết hạn!');
        }
    }

    public function postForgetPassword(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users'
        ];

        $message = [
            'required' => ':attribute không được để trống',
            'email' => ':attribute không hợp lệ',
            'exists' => ':attribute chưa được đăng kí',
        ];

        $attributes = [
            'email' => 'Email',
        ];

        $request->validate($rules, $message, $attributes);

        $token = strtoupper(Str::random(10));
        $user = User::where('email', $request->email)->first();
        $user->update(['token' => $token]);
        // dd($user);


        Mail::send('email.check_email_forget', compact('user'), function($email) use ($user) {
            $email->subject('Nhangg Webiste - Lấy lại mật khẩu');
            $email->to($user->email, $user->name);
        });
        return redirect()->route('auth.forgot_password')->with('msg--email-forget-password', 'Vui lòng check email để thực hiện thay đổi mật khẩu');
    }


    public function getForgotPasword(User $user, $token)
    {
        if($user->token === $token)
        {
            return view('email.get_password', compact('user'));
        }

        return abort(404);
    }

    public function postForgotPasword(User $user, $token, Request $request)
    {
        // dd($ú);
        $rules = [
            'password' => 'required|confirmed'
        ];

        $message = [
            'required' => ':attribute không được để trống',
            'confirmed' => ':attribute nhập vào không trùng nhau'
        ];

        $attributes = [
            'password' => 'Mật khẩu'
        ];
        $request->validate($rules, $message, $attributes);
        // dd($user);

        $password = Hash::make( $request->password);
        // dd($password);
        $user->update(['password' => $password, 'token' => null]);
        $user->save();

        return redirect()->route('auth.')->with('msg--get-password', 'Đổi mật khẩu thành công');
    }


    public function test_view()
    {
        $user = User::find(2);
        return view('email.active_account', compact('user'));
    }

    public function profile()
    {
        $user = Auth::user();
        dd($user);
        return view('clients.profile');
    }
}
