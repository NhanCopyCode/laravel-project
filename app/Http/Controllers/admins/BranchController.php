<?php

namespace App\Http\Controllers\admins;

use App\Models\Branch;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;

class BranchController extends Controller
{
    //

    public function index()
    {
        $branchList = Branch::paginate(5);

        // dd($branchList);
        return view('admin.branch', compact('branchList'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function addBranch(BranchRequest $request)
    {

        $branch = Branch::create([
            'branch_name' => $request->branch_name,
            'branch_status_id' => $this->getBranchStatusId('active') //
        ]);

        if($branch) {
            return response()->json([
                'status' => 'success',
            ]);
        }else {
            return response()->json([
                'status' => 'error',
            ]);
        }
    }



    public function update()
    {

    }

    public function delete(Request $request)
    {
        dd('Xin chào');


    }

    public function testInsert() 
    {
        $branch = new Branch();

        $branch->branch_name = 'Nhân '. Str::random(10);

        $branch->save();

        // return back();
    }

    public function getBranchStatusId($branch_status_name) {
        $branch_status_list = config('branch_status');
        // dd($branch_status_list);

        foreach ($branch_status_list as $key => $value) {
            if ($value === $branch_status_name) {
                return $key;
            }
        }
    }
}
