<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\imagen;
use App\Comment;
use App\Like;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
    	return view('image.create');
    }

    public function save(Request $request)
    {

    	//Validación
    	$validate = $this->validate($request, [
    		'description' => 'required',
    		'image-path' => 'required', 'image'
    	]);

    	$image_path = $request->file('image-path');
    	$description = $request->input('description');

    	//Asignar valores al objeto
    	$user = \Auth::user();
    	$image = new imagen();
    	$image->user_id = $user->id;
    	$image->description = $description;
    	//Subir fichero
    	if ($image_path) {
    		$image_path_name = time().$image_path->getClientOriginalName();
    		Storage::disk('images')->put($image_path_name, File::get($image_path));
    		$image->imagen_path = $image_path_name;
    	}

    	$image->save();

    	return redirect()->route('home')->with([
    		'message' => 'La imagen ha sido subida correctamente'
    	]);
    }

    public function getImage($filename)
    {
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    public function detail($id)
    {
        $image = imagen::find($id);

        return view('image.detail', [
            'image' => $image
        ]);
    }

    public function delete($id)
    {
        $user = \Auth::user();
        $image =  imagen::find($id);
        $comments = Comment::where('imagen_id', $id)->get();
        $likes = Like::where('imagen_id', $id)->get();

        if ($user && $image && $image->user->id == $user->id) {
            //Eliminar los comentarios
            if ($comments && count($comments)>=1) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }
            //Eliminar los likes
            if ($likes && count($likes)>=1) {
                foreach ($likes as $like) {
                    $like->delete();
                }
            }
            //Eliminar ficheros
            Storage::disk('images')->delete($image->imagen_path);
            //Eliminar registro de la imagen
            $image->delete();

            $message = array('message'=> 'La imagen se ha borrado');
        }else{
            $message = array('message'=> 'La imagen no se ha borrado');
        }

        return redirect()->route('home')->with(
            $message
        );
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $image = imagen::find($id);

        if ($user && $image && $image->user->id == $user->id) {
            return view('image.edit', ['image'=>$image]);
        }else{
            return redirect()->route('home');
        }
    }

    public function update(Request $request)
    {

        //Validación
        $validate = $this->validate($request, [
            'description' => 'required',
            'image-path' => 'image'
        ]);

        $image_id = $request->input('image_id');
        $image_path = $request->file('image-path');
        $description = $request->input('description');

        //Conseguir objeto image
        $image = imagen::find($image_id);
        $image->description = $description;

        if ($image_path) {
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->imagen_path = $image_path_name;
        }

        //Actualizar registro
        $image->update();

        return redirect()->route('image.detail', ['id'=>$image_id])
            ->with(['message'=> 'Imagen actualizada cone exito']);
    }
}
