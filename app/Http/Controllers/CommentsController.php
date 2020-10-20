<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request)
    {

    	$validate = $this->validate($request, [
    		'image_id' => ['integer', 'required'],
    		'content' =>  ['string', 'required']
    	]);
    	
    	$user = \Auth::user();
    	$image_id = $request->input('image_id');
    	$content = $request->input('content');

    	$comment = new Comment();
    	$comment->user_id = $user->id;
    	$comment->imagen_id = $image_id;
    	$comment->content = $content;

    	$comment->save();
		return redirect()->route('image.detail', ['id' => $image_id])->with([
    		'message' => 'Has publicado tu comentario correctamente '
    	]);	
    }


    public function delete($id)
    {
    	//Conseguir datos del usuario identificado
    	$user = \Auth::user();
    	//Conseguir objeto del comentario
    	$comment = Comment::find($id);
    	//Comprobar si soy el dueño del comentario o de la publicación
    	if ($user && ($comment->user_id == $user->id || $comment->imagenes->user_id == $user->id)) {
    		$comment->delete();
    		return redirect()->route('image.detail', ['id' => $comment->imagen_id])->with([
    			'message' => 'Comentario eliminado correctamente '
    		]);	
    	}else{
    		return redirect()->route('image.detail', ['id' => $comment->imagen_id])->with([
    			'message' => 'Comentario no se ha podido eliminar '
    		]);	
    	}
    }
}
