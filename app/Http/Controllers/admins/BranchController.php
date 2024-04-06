<?php

namespace App\Http\Controllers\admins;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BranchController extends Controller
{
    //

    public function index()
    {
        $branchList = Branch::all();
        // dd($branchList);
        return view('admin.branch');
    }

    public function create(Request $request)
    {
        dd($request);

        return ;
    }

    public function update()
    {

    }

    public function delete(Request $request)
    {
        
    }
}
