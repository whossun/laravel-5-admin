<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model {

    protected $fillable = ['name'];

    public $datatable_fields = [
        'id'           => ['orderable' => true,'searchable' => false],
        'name'         => ['orderable' => true,'searchable' => true],
        'created_at'   => ['orderable' => true,'searchable' => false],
        'updated_at'   => ['orderable' => true,'searchable' => false],
    ];

    public $route_resource = 'permissiongroups';

}