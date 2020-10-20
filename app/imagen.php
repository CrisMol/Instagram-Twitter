<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class imagen extends Model
{
    protected $table = 'imagenes'; //tabla de la bases de datos va a modificar

    //Relacion One to Many
    public function comments()
    {
    	return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }

    public function likes()
    {
    	return $this->hasMany('App\Like');
    }

    //Relacion Many to One
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
