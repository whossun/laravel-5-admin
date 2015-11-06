<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['group_id','name', 'display_name','sort'];

    public $datatable_fields = [
        'id'           => ['orderable' => false,'searchable' => false],
        'name'         => ['orderable' => false,'searchable' => false],
        'display_name' => ['orderable' => false,'searchable' => false],
        'group_id'     => ['orderable' => true,'searchable' => false],
        'sort'         => ['orderable' => false,'searchable' => false],
        'updated_at'   => ['orderable' => true,'searchable' => false],
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function group() {
        return $this->belongsTo(PermissionGroup::class, 'group_id');
    }

    public function dependencies() {
        return $this->hasMany(PermissionDependency::class, 'permission_id', 'id');
    }


}
