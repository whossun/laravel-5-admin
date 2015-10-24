<?php namespace App\Repositories;

use Illuminate\Http\Request;
use App\Permission;

class PermissionRepository extends Repository {

    protected $datatable_fields = [
        'id'         => ['orderable' => false,'searchable' => false],
        'name'      => ['orderable' => false,'searchable' => false],
        'label'      => ['orderable' => false,'searchable' => false],
        'created_at' => ['orderable' => true,'searchable' => false],
        'updated_at' => ['orderable' => true,'searchable' => false],
    ];

    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

}