<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Article extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','description','content','author'];

    public $datatable_fields = [
        'id'          => ['orderable' => true,'searchable' => false],
        'name'        => ['orderable' => true,'searchable' => true],
        'description' => ['orderable' => true,'searchable' => true],
        'author'      => ['orderable' => true,'searchable' => true],
        'created_at'  => ['orderable' => true,'searchable' => false],
        'updated_at'  => ['orderable' => true,'searchable' => false],
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

    public function user()
    {
        return $this->belongsTo(User::class, 'author');
    }

}