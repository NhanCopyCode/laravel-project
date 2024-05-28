<?php

namespace App\Http\Controllers\admins;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileClientRequest;

class ProfileController extends Controller
{
    //
    public function index()
    {
        $user = Auth::guard('web')->user();
        // dd($user);
        return view('clients.profile', compact('user'));
    }

    public function updateProfile(ProfileClientRequest $request)
    {

        // Lấy người dùng hiện tại đang đăng nhập
        $user = Auth::guard('web')->user();

        // Kiểm tra nếu có avatar mới tải lên và xử lý lưu file
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $fileName = Str::slug($user->user_id) . '_' . time() . '.' . $request->avatar->extension();
            
            // Lưu vào thư mục 'public/storage/uploads/carrentalstores'
            $request->avatar->storeAs('clients/avatars', $fileName, 'public');
        
            // Lấy URL chính xác đến file đã lưu
            $path = env('APP_URL'). Storage::url('clients/avatars/' . $fileName);
            $user->avatar = $path;
        }

        // Cập nhật các thông tin khác của người dùng
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->CCCD = $request->input('CCCD');
        $user->date_of_birth = $request->input('date_of_birth');

        // Lưu thông tin người dùng cập nhật vào cơ sở dữ liệu
        $user->save();

        // Trả về phản hồi hoặc chuyển hướng sau khi cập nhật
        return redirect()->back()->with('success', 'Cập nhật hồ sơ thành công!');
    }
}
