<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
   private $role;

   public function __construct(Role $role)
    {
        $this->role = $role;
    }

   public function all()
	{
		return $this->role->query();
	}

    public function store($data){
        return $this->role->create($data);
    }

}
