<?php

namespace App\Http\Controllers\admin;

use App\Model\Role;
use App\Model\RolePermission;
use Carbon\Carbon;
use App\Services\RolePermissionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public  function list(Request $request){
        $data = Role::get();
        if ( !$request->ajax() ) {
            return view('admin.role.list', $data);
        } else {
            return datatables($data)
                ->editColumn('name', function ($item) {
                    return $item->title;
                })
                ->addColumn('action', function ($item) {
                    $html = '<div class="btn-group">
                              <button type="button" class="btn btn-sm btn-success">Action</button>
                              <button type="button" class="btn btn-sm btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              </button>
                              <div class="dropdown-menu">';
                    $html .= dropdownButton(__('Edit'),  route('roleDetails',$item->id));
                    $html .= dropdownButton(__('Delete'), route('roleDelete',$item->id), 'action', 'delete');
                    $html .= '</div></div>';
                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function addOrEditPage (Request $request){
        return view('admin.role.add-edit');
    }
    public function addOrEdit (Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ],[
            'title.required' => __('Role name is required') ,
        ]);
        if($validator->fails()) {
            return redirect()->back()->with('dismiss',$validator->errors()->all()[0]);
        }
        $roleService = new RolePermissionService();
        $response = $roleService->addOrEditRole($request);
        if(isset($request->id)){
            if($response){
                return redirect()->route('roleList')->with('success','Role updated successfully');
            }else {
                return redirect()->route('roleList')->with('dismiss', 'Role updated failed');
            }
        }
        if($response){
            return redirect()->route('roleList')->with('success','Role created successfully');
        }else {
            return redirect()->route('roleList')->with('dismiss', 'Role created failed');
        }
        return redirect()->route('roleList')->with('dismiss', 'Role failed');
    }

    public function roleDetails($id){
        $data['role'] = Role::where('id',$id)->first();
        $data['permission'] = RolePermission::where('role_id',$id)->get();
        return view('admin.role.add-edit',$data);
    }
    public function roleDelete($id){
        Role::where('id',$id)->delete();
        RolePermission::where('role_id',$id)->delete();
        return redirect()->route('roleList')->with('success', 'Role deleted successfully');
    }
}
