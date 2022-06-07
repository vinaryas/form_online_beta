<?php

namespace App\Services\Rbac;

use App\PermissionRole;

class PermissionService{
    private $listPermission = "";

    public function rekursivePermission($parent = 0, $role_id = 0)
    {
        $permissions = PermissionRole::getPermissionRole($parent, $role_id);

        if(!empty($permissions)){
            $this->listPermission .= "<ul>";

            foreach ($permissions as $value) {
                $opened = '"opened": true';
                $selected = (!empty($value->role_id)) ? '"selected": true' : '';

                $this->listPermission .= "<li id='" . $value->id . "' data-jstree='{ " . $selected . " }'>";
                $this->listPermission .= $value->display_name;
                $this->rekursivePermission($value->id, $role_id);
                $this->listPermission .= '</li>';
            }

            $this->listPermission .= "</ul>";
        }

    }

    public function showPermission($role_id)
    {
        $this->rekursivePermission(0, $role_id);

        return $this->listPermission;
    }
}