<?php

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Support\PermissionRoleService;
use App\Services\Support\PermissionService;
use App\Services\Support\RoleService;
use Illuminate\Support\Facades\DB;


class PermissionRoleController extends Controller
{
    public function index(){
        $permissions = PermissionService::all()->get();
        $roles = RoleService::all()->get();
        $permissionRoles = PermissionRoleService::getDetail()->get();

        return view('permission_role.index', compact('permissions', 'roles', 'permissionRoles'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        try{
            $data = [
                'permission_id'=>$request->permission_id,
                'role_id'=>$request->role_id,
            ];
            $store = PermissionRoleService::store($data);
            DB::commit();
            return redirect()->route('permission_role.index');
        }catch(\Throwable $th){
            dd($th);
        }
    }
}
