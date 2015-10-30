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
    protected $fillable = ['name', 'display_name'];

    public $datatable_fields = [
        'id'           => ['orderable' => false,'searchable' => false],
        'name'         => ['orderable' => false,'searchable' => false],
        'display_name' => ['orderable' => false,'searchable' => false],
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

    /**
     * Roles relation
     * @return Roles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
