<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name'];

    public $datatable_fields = [
        'id'           => ['orderable' => true,'searchable' => false],
        'name'         => ['orderable' => true,'searchable' => true],
        'display_name' => ['orderable' => true,'searchable' => true],
        'created_at'   => ['orderable' => true,'searchable' => false],
        'updated_at'   => ['orderable' => true,'searchable' => false],
    ];

    /**
     * Get the created date
     *
     * @return string
     */
    public function getCreatedAttribute()
    {
        return Date::parse($this->created_at)->format('d-m-Y');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Permissions relation
     * @return Permissions
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Save Permision in Role
     * @param  Permission $permission
     * @return Role
     */
    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }
}
