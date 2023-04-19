<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Role;
use App\Model\RolePermission;
use App\Services\RolePermissionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class permission_check
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = [ 'success' => false, 'message' => __('You have no access') ];
        $user = Auth::user();
        if($user->role == 1) return $next($request);
        $route = Route::current()->action;
        $permission = getPermissionField();
        if(!isset($route['group'])){
            return $next($request);
        }

        if(!array_key_exists($route['group'],$permission)){
            return $next($request);
        }else{
            $permission = $permission[$route['group']];
        }
        $as = str_replace('.','_',$route['as']);
        $got_you = false;
        foreach ($permission as $per){
            if($per['name'] == $as){
                $permission_data = RolePermission::where(['role_id' => $user->role_id,'name' => $as,'slug' => $per['slug'],'group' => $route['group']])->first();
                if($permission_data &&  $permission_data->status){
                    return $next($request);
                }
                $got_you = true;
            }
        }
        if($got_you) {
            if($request->ajax()) {
                if($as == 'adminPendingWithdrawal') return $next($request);
                return $response;
            }
            return redirect()->back()->with('dismiss',__('You have no access'));
//            abort(401, 'You are not authorize');
        }
        $permission_data = RolePermission::where(['role_id' => $user->role_id,'slug' => 'other','group' => $route['group']])->first();
        if($permission_data &&  $permission_data->status){
            return $next($request);
        }
        if($request->ajax()) {
            return $response;
        }
        return redirect()->back()->with('dismiss',__('You have no access'));
       // abort(401,'You are not authorize');
    }
}
