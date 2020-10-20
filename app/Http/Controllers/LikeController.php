<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function like($imagen_id)
    {
    	//Recoger datos del usuario y la imagen
    	$user = \Auth::user();

    	//Condición para ver si existe el like y evitar duplicación

    	$isset_like = Like::where('user_id', $user->id)
    						->where('imagen_id', $imagen_id)
    						->count();
    	if ($isset_like == 0) {
    		$like = new Like();
    		$like->user_id = $user->id;
    		$like->imagen_id = (int)$imagen_id;

    		$like->save();

    		return response()->json([
    			'like' => $like
    		]);
    	}else{
    		return response()->json([
    			'message' => 'El like ya existe'
    		]);
    	}
    }

    public function dislike($imagen_id)
    {
    	//Recoger datos del usuario y la imagen
    	$user = \Auth::user();

    	//Condición para ver si existe el like y evitar duplicación

    	$like = Like::where('user_id', $user->id)
    						->where('imagen_id', $imagen_id)
    						->first();
    	if ($like) {
    		
    		$like->delete();

    		return response()->json([
    			'like' => $like,
    			'message' => 'Dislike Correctamente'
    		]);
    	}else{
    		return response()->json([
    			'message' => 'El like no existe'
    		]);
    	}
    }

    public function likes()
    {
        $user = \Auth::user();
        $likes = Like::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(5);

        return view('likes.like', [
            'likes' => $likes
        ]);
    }
}
