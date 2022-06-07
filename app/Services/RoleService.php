<?php

namespace App\Services;

use App\Models\jabatan;
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

}
