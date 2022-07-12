<?php

namespace App\Services;

use App\PermissionRole;
use Illuminate\Support\Facades\DB;

class PermissionRoleService
{
	private $PermissionRole;

    public function __construct(PermissionRole $PermissionRole)
    {
        $this->PermissionRole = $PermissionRole;
    }

	public function all(){
		return $this->PermissionRole->query();
	}

    public function store($data){
        return $this->PermissionRole->create($data);
    }

    public function find($id){
        return $this->all()->where('id', $id);
    }

    public function getDetail(){
        $data = DB::table('permission_role')
        ->join('permissions', 'permissions.id','=','permission_role.permission_id')
        ->join('roles', 'roles.id', '=', 'permission_role.role_id')
        ->select(
            'permissions.display_name as permission_name',
            'roles.display_name as role_name'
        );

        return $data;
    }

}
