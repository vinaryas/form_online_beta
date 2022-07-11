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

        return view('permission_role.index', compact('permissions', 'roles'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        try{
            $data = [
                'name'=>$request->name,
                'display_name'=>$request->display_name,
                'description'=>$request->description,
            ];
            $store = PermissionRoleService::store($data);
            DB::commit();
            return redirect()->route('permissionRole.index');
        }catch(\Throwable $th){
            dd($th);
        }
    }
}
