<?php

namespace App\Services\Rbac;

use App\Role;

class RoleService
{

    private $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function saveData($data)
    {
        $user = Role::create($data);

        return $user;
    }

    public function updateData($data, $id)
    {
        $user = Role::where('id', '=', $id)->update($data);

        return $user;
    }

    public function all()
	{
		return $this->role->query();
	}
}
