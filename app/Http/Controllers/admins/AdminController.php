<?php

namespace App\Http\Controllers\admins;

use App\Models\Brand;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function index()
    {
        //
        // dd(123);
        $dataBrand = Branch::all();
        
        return view('admin.home', compact('dataBrand'));
    }

    public function logout() {
        Auth::guard('admin')->logout();

        return redirect()->route('auth.login_admin');
    }


}
