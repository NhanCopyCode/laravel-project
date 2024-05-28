<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\UserManagementRequest;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        // dd('xin chào');
        $userList = DB::table("users")
        ->join('role', 'role.role_id', '=', 'users.role_id')
        ->join('userstatus', 'userstatus.user_status_id', '=', 'users.user_status_id')
        ->paginate(5);
        // $userList = User::paginate(5);

        // dd($userList);
        return view('admin.user', compact('userList'))->with('i', (request()->input('page', 1) - 1) * 5);
        // return view('admin.user', compact('userList'));
    }

    public function addUser(UserManagementRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->pasword) ,
            'role_id' => $request->role_id,
        ]);

        if($user) {
            return response()->json([
                'status' => 'success',
                'user' => $user
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Can not create user!',
            ]);
        }
    }



    public function update(Request $request)
    {
        // return $request->all();
        $rules = [
            'role_id' => "required|exists:role",
            'user_status_id' => 'required|exists:userstatus',
        ];

        $messages = [
            'required' => ':attribute không được để trống',
            'exists' => ':attribute không tồn tại trong hệ thống',
        ];

        $attributes = [
            'role_id' => 'Vai trò người dùng',
            'user_status_id' => 'Trạng thái người dùng'
        ];
        $request->validate($rules, $messages, $attributes);

        // $user_id = $request->user_id;
        // $user = user::findOrFail($user_id);

        $user = User::where('user_id', $request->user_id)->update([
            'role_id' => $request->role_id,
            'user_status_id' => $request->user_status_id
        ]);

        return response()->json([
            'status' => 'success',
            'user' => $user,
        ]);
    }

    public function delete(Request $request)
    {
        // dd('Xin chào');
        $user_id = $request->user_id;

        if(!$user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy id của người dùng'
            ]);
        }

        $user = User::find($user_id);
        // $models = ModelVehicle::where('user_id', $user_id)->get();

        $user_list_number = user::all()->count();
        if($user) {
            // user status id = 2 = "Block"
            $user->update([
                'user_status_id' => 2,
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công người dùng',
                'user_list_number' => $user_list_number
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy người dùng cần xóa'
            ]);
        }

    }


    // return view('admin.user', compact('userList'))->with('i', (request()->input('page', 1) - 1) * 5);

    //Search user
    public function searchuser(Request $request) {
        $userList = User::join('role', 'users.role_id', '=', 'role.role_id')
            ->join("userstatus", 'users.user_status_id', '=', 'userstatus.user_status_id')
            ->where('name', 'like', '%'.$request->search_string_user.'%')
            ->orWhere('phone_number', 'like', '%'.$request->search_string_user.'%')
            ->orWhere('users.user_id', 'like', '%'.$request->search_string_user.'%')
            ->orWhere('user_status_name', 'like', '%'.$request->search_string_user.'%')
            ->orWhere('users.email', 'like', '%'.$request->search_string_user.'%')
            ->orWhere('role.role_name', 'like', '%'.$request->search_string_user.'%')
            ->orderBy('user_id', 'asc')
            ->paginate(5);
        
        // dd($request->search_string_user);
        // dd($userList);

        if($userList->count() > 0) {
            return view('blocks.admin.search_user', compact('userList'))->with('i', (request()->input('page', 1) - 1) * 5)->render();
        }else {
            return response()->json([
                'status' => 'not found',
                'message' => 'Không tìm thấy người dùng'
            ]);
        }
    }
    

    public function getuserStatusId($user_status_name) {
        $user_status_list = config('user_status');
        // dd($user_status_list);

        foreach ($user_status_list as $key => $value) {
            if ($value === $user_status_name) {
                return $key;
            }
        }
    }


    
}
