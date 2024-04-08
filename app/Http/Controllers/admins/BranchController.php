<?php

namespace App\Http\Controllers\admins;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;

class BranchController extends Controller
{
    //

    public function index()
    {
        $branchList = Branch::all();
        // dd($branchList);
        return view('admin.branch', compact('branchList'));
    }

    public function create(BranchRequest $request)
    {
        // dd($request->all());
        $dataBranch = $request->branch_name;
        dd($dataBranch);

        return ;
    }

    public function update()
    {

    }

    public function delete(Request $request)
    {
        dd('Xin chào');


    }
}
