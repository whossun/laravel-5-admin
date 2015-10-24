<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Article extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','description','content','author'];

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
        return $this->belongsTo('App\User', 'author');
    }
    
}