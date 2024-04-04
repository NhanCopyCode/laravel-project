<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\Auth\UserRequest;
use App\Http\Requests\Auth\AdminRequest;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\VarDumper\Caster\RedisCaster;
use App\Http\Requests\Auth\AdminRequest as AuthAdminRequest;

class UserController extends Controller
{
    //
    public function index() 
    {
        $user_status = config('user_status');

        //Kiểm tra người dùng login
        if(Auth::guard('web')->check() && Auth::guard('web')->user()->user_status_id == $user_status('active')) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    

    public function login(LoginRequest $request)
    {   
        //Lấy ra được user status của mỗi user
        $user_status = config('user_status');
      
        $data = $request->all('email', 'password');
        $remember = $request->remember_me == 'on' ? true : false;
        // dd($remember);
        
        if(Auth::guard('web')->attempt($data, $remember)) {
            // dd(Auth::user()->user_status_id != $user_status('active'));

            //Nếu tài khoản không có status id = 1 thì tài khoản đó không được vào (status = 1 là active)
            if(Auth::guard('web')->user()->user_status_id != $user_status('active')) {
                // dd('Vào lại được if');
                return redirect()->route('auth.index')->with('msg', 'Tài khoản chưa được kích hoạt, vui lòng click vào <a style="font-size: 20px;font-weight: bold;" href="'.route('auth.get_active').'">đây</a> để kích hoạt');
            }
            // dd('Không vào được if');
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
        $data['role_id'] = 1; // role_id = 1 = User
        
        $data['password'] = Hash::make($request->password);
        // user_status_id = 3 = pending (Mới đăng kí thì user status = 3)
        $data['user_status_id'] = 3; 
        // dd($data);
        if($user = User::create($data)) {
            // dd($user);

            Mail::send('email.active_account', compact('user'), function ($email) use($user) {
                // dd($user); 
                $email->subject('NhanggWebsite - Xác nhận tài khoản'); 
                $email->to($user->email, $user->name);
            });
        }

        return redirect()->route('auth.index')->with('msg--confirm','Hãy vào email để kích hoạt tài khoản trong 24h');
        // return 'oke';
    }

    public function logout(Request $request)
    {
        // dd($request->all());
        // auth()->logout();
        Auth::guard('web')->logout();
        return redirect()->route('auth.index');
    }

    public function admin_login()
    {
        return view('auth.admin_login');
    }

    public function check_admin_login(AdminRequest $request)
    {
        $adminLogin = $request->all('email', 'password');
        // dd($adminLogin);
        
       

        // $user = Auth::user();
        // dd($user->isAdminOrManager());
        if(Auth::guard('admin')->attempt($adminLogin)) {
            if(Auth::guard('admin')->user()->isAdminOrManager())
            {
                return redirect()->route('admin.index');

            }
            return redirect()->route('403');
            //Nếu tài khoản không có status id = 1 thì tài khoản đó không được vào (status = 1 là active)
            // if(Auth::user()->user_status_id != 1) {
            //     // dd('Vào được rồi');
            //     return redirect()->route('auth.login_admin')->with('msg--not_active', 'Tài khoản chưa được kích hoạt, vui lòng click vào <a style="font-size: 20px;font-weight: bold;" href="">đây</a> để kích hoạt');
            // }


            // $user = User::where('email', $request->email)->first();
            // dd($user);
            // Auth::login($user);
            
        }

        // return redirect()->route('home');
    }

    public function register_admin()
    {
        return view('auth.admin_register');
    }

    public function check_register_admin(RegisterRequest $request)
    {
        // dd($request->all());
        $data = $request->all('name', 'email');
        $data['password'] = Hash::make($request->password);
        $data['role_id'] = 3; // Role admin = 3

        $token = strtoupper(Str::random(15));
        $data['token'] = $token;
        $data['user_status_id'] = 1; // user_status_id = 1 (active)
        
        $data['password'] = Hash::make($request->password);
        // dd(User::create($data));
        // if($user = User::create($data)) {
        //     Mail::send('email.active_account_admin', compact('user'), function ($email) use($user) {
        //         // dd($user); 
        //         $email->subject('NhanggWebsite - Xác nhận tài khoản'); 
        //         $email->to($user->email, $user->name);
        //     });
        // }

        // return redirect()->route('auth.login_admin')->with('msg--confirm','Hãy vào email để kích hoạt tài khoản trong 24h');
        $user = User::create($data);
        if($user) {
            return redirect()->route('auth.login_admin')->with('msg--complete', 'Tạo thành công tài khoản admin');
        }

        return back()->with('msg--reject', 'Tạo tài khoản admin thất bại');
        
    }
    

    public function actived(User $user, $token)
    {
        
        if($user->token === $token && $user->created_at->diffInHours() <= 24) {
            $user->user_status_id = 1; // user_status_id = 1 = active
            $user->token = null;
            $user->save();
            // dd($user);
            return redirect()->route('auth.index')->with('msg--actived', 'Xác nhận tài khoản thành công, bạn có thể đăng nhập');

        }else {
            return redirect()->route('auth.index')->with('msg--rejected', 'Mã xác nhận đã hết hạn!');
        }
    }

    public function forgotPassowrd()
    {
        return view('auth.forgot_password');
    }

    
    public function admin_actived(User $user, $token)
    {
        if($user->token === $token && $user->created_at->diffInHours() <= 24) {
            $user->user_status_id = 2;
            $user->token = null;
            $user->save();
            // dd($user);
            return redirect()->route('auth.login_admin')->with('msg--actived', 'Xác nhận tài khoản thành công, bạn có thể đăng nhập');

        }else {
            return redirect()->route('auth.login_admin')->with('msg--rejected', 'Mã xác nhận đã hết hạn!');
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

        return redirect()->route('auth.index')->with('msg--get-password', 'Đổi mật khẩu thành công');
    }

    // Active account
    public function getActive()
    {
        // return 'Vào được get active account';
        return view('email.get_active');
    }

    public function postActive(Request $request)
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


        Mail::send('email.active_account', compact('user'), function ($email) use($user) {
            // dd($user); 
            $email->subject('NhanggWebsite - Xác nhận tài khoản'); 
            $email->to($user->email, $user->name);
        });
        return back()->with('msg--email-active-account', 'Vui lòng check email để kích hoạt tài khoản');
    }


    public function profile()
    {
        $user = Auth::user();
        // dd($user);
        return view('clients.profile');
    }
}
