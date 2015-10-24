<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Setting extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * Get the created date
     *
     * @return string
     */
    public function getCreatedAttribute()
    {
        return Date::parse($this->created_at)->format('d-m-Y');
    }
}