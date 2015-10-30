<?php namespace App\Repositories;

use App\Models\PermissionGroup;

class PermissionGroupRepository extends Repository {

    public function __construct(PermissionGroup $permissiongroup)
    {
        $this->model = $permissiongroup;
    }

}