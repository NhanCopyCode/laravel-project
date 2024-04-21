<?php

namespace App\Http\Controllers\admins;

use App\Models\Branch;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\Http\Requests\BranchRequest;
use Brian2694\Toastr\Facades\Toastr;

class BranchController extends Controller
{
    //

    public function index()
    {
        // dd('xin chào');
        $branchList = Branch::paginate(5);

        // dd($branchList);
        return view('admin.branch', compact('branchList'))->with('i', (request()->input('page', 1) - 1) * 5);
        // return view('admin.branch', compact('branchList'));
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



    public function update(Request $request)
    {
        // return $request->all();
        $rules = [
            'branch_name' => 'required|unique:branchs,branch_name,'.$request->branch_id.',branch_id',
            'branch_status_id' => 'required',
        ];

        $messages = [
            'required' => ':attribute không được để trống',
            'unique' => ':attribute đã tồn tại trong hệ thống',
        ];

        $attributes = [
            'branch_name' => 'Tên chi nhánh',
            'branch_status_id' => 'Trạng thái chi nhánh'
        ];
        $request->validate($rules, $messages, $attributes);

        // $branch_id = $request->branch_id;
        // $branch = Branch::findOrFail($branch_id);

        Branch::where('branch_id', $request->branch_id)->update([
            'branch_name' => $request->branch_name,
            'branch_status_id' => $request->branch_status_id
        ]);

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function delete(Request $request)
    {
        // dd('Xin chào');
        $branch_id = $request->branch_id;

        if(!$branch_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy id của chi nhánh'
            ]);
        }

        $branch = Branch::find($branch_id);
        $branch_list_number = Branch::all()->count();
        if($branch) {
            $branch->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công chi nhánh',
                'branch_list_number' => $branch_list_number,
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy chi nhánh cần xóa'
            ]);
        }

    }


    // return view('admin.branch', compact('branchList'))->with('i', (request()->input('page', 1) - 1) * 5);

    //Search branch
    public function searchBranch(Request $request) {
        $branchList = Branch::where('branch_name', 'like', '%'.$request->search_string_branch.'%')
            ->orWhere('branch_id', 'like', '%'.$request->search_string_branch.'%')
            ->orderBy('branch_id', 'asc')
            ->paginate(5);
        
        // dd($request->search_string_branch);
        // dd($branchs);

        if($branchList->count() > 0) {
            return view('blocks.admin.search_branch', compact('branchList'))->with('i', (request()->input('page', 1) - 1) * 5)->render();
        }else {
            return response()->json([
                'status' => 'not found',
                'message' => 'Không tìm thấy chi nhánh'
            ]);
        }
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

    public function testcart()
    {
        return 'xi ncahfo ';
    }

   
}
