<?php namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends Repository
{

    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    public function save($id, $data)
    {
        $role = parent::save($id, $data);

        //Assing user roles
        if (count($data['permissions']) > 0) {
            $role->permissions()->sync($data['permissions']);
        }

        return $role;
    }

}