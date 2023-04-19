<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCreateUser;
use App\Http\Services\UserService;
use App\Model\KycLevel;
use App\Model\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function adminList(Request $request){
        $data['title'] = __('Admins');
        $data['roles'] = Role::all();
        if ( !$request->ajax() ) {
            return view('admin.admins.lists', $data);
        } else {
            $admins = User::leftJoin('roles','users.role_id','roles.id')
                          ->select('users.*','roles.title as role_title')
                          ->where('users.role', '<>', USER_ROLE_USER)
                          ->where('users.id', '<>', Auth::user()->id);

            return datatables($admins)

                ->addColumn('status', function ($item) {
                    return statusAction($item->status);
                })
                ->editColumn('name', function ($item) {
                    return $item->first_name.' '.$item->last_name;
                })
                ->editColumn('role_title', function ($item) {
                    return $item->role_title;
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? with(new Carbon($item->created_at))->format('d M Y') : '';
                })
                ->addColumn('action', function ($item){
                    $html = '<div class="btn-group">
                              <button type="button" class="btn btn-sm btn-success">Action</button>
                              <button type="button" class="btn btn-sm btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              </button>
                              <div class="dropdown-menu">';

                    if ($item->status == STATUS_ACTIVE){
                        $html .= dropdownButton(__('Edit'), route('adminEdit').'?id='.($item->unique_code).'&type=edit');
                        $html .= dropdownButton(__('Suspend'),NULL,'action',$item->id,'suspend');
                        if(!empty($item->google2fa_secret)) {
                            $html .= dropdownButton(__('Remove gauth'),NULL,'remove-gauth-action',$item->unique_code,'gauth');
                        }
                        if($item->is_verified == STATUS_PENDING) {
                            $html .= dropdownButton(__('Verify Email'),NULL,'verify-email-action',$item->unique_code,'verify email');
                        }
                        $html .= dropdownButton(__('Delete'),NULL,'action',$item->id,'delete');
                    } else {
                        $html .= dropdownButton(__('Edit'),route('adminEdit').'?id='.($item->unique_code).'&type=view');
                        $html .= dropdownButton(__('Activate'), route('admin.user.active',($item->unique_code)));
                    }

                    $html.='</div></div>';
                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function adminAddEdit(AdminCreateUser $request){
        $userService = new UserService();
        $response = $userService->userAddEdit($request);
        if ($response['success'] == TRUE){
            return redirect()->route('adminList')->with('success',$response['message']);
        }else{
            return redirect()->back()->with('dismiss',$response['message']);
        }
    }

    public function adminEdit(Request $request){
        $data['title'] = __('Admin Edit');
        $data['user'] = User::where('unique_code', $request->id)->first();
        $data['type'] = $request->type;
        $data['roles'] = Role::all();
        return view('admin.admins.edit',$data);
    }

}
