<?php

namespace App\Services;

use App\RoleUser;

class roleUserService
{
    private $roleUser;

    public function __construct(RoleUser $roleUser)
    {
        $this->roleUser = $roleUser;
    }

    public function all()
	{
		return $this->roleUser->query();
	}

    public function store($data)
    {
        return $this->roleUser->insert($data);
    }

    public function update($data, $id)
    {
        return $this->roleUser->where('user_id', $id)->update($data);
    }

}
