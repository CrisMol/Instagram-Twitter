<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    //Relacion Many to One
    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function imagenes()
    {
    	return $this->belongsTo('App\imagen', 'image_id');
    }
}
