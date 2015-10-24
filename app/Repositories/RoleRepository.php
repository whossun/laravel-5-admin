<?php namespace App\Repositories;

use Illuminate\Http\Request;
use App\Role;

class RoleRepository extends Repository 
{

    protected $datatable_fields = [
        'id'         => ['orderable' => true,'searchable' => false],
        'name'      => ['orderable' => true,'searchable' => true],
        'label'        => ['orderable' => true,'searchable' => true],
        'created_at' => ['orderable' => true,'searchable' => false],
        'updated_at' => ['orderable' => true,'searchable' => false],
    ];

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