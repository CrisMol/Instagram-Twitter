<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($search=null)
    {
        if (!empty($search)) {
            $users = User::where('nick', 'LIKE', '%'.$search.'%')
                ->orwhere('name', 'LIKE', '%'.$search.'%')
                ->orwhere('surname', 'LIKE', '%'.$search.'%')
                ->orderBy('id', 'desc')
                ->paginate(5);
        }else{
            $users = User::orderBy('id', 'desc')->paginate(5);
        }

        return view('user.index', ['users'=>$users]);
    }
    
    public function config()
    {
    	return view('user.config');
    }

    public function update(Request $request)
    {
    	//Conseguir usuario identificado
    	$user = \Auth::user();
    	$id = $user->id;

    	//Validación
    	$validate = $this->validate($request, [
    		'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick, '.$id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email, ' .$id]
    	]);
    	//Recoger datos
    	$name = $request->input('name');
    	$surname = $request->input('surname');
    	$nick = $request->input('nick');
    	$email = $request->input('email');
    	//Asignar nuevos valores al objeto del usuario
    	$user->name = $name;
    	$user->surname = $surname;
    	$user->nick = $nick;
    	$user->email = $email;

    	//Subir la imagen
    	$image_path = $request->file('imagen_path');
    	if ($image_path) {
    		//Poner nombre único
    		$imagen_path = time().$image_path->getClientOriginalName();
    		//Guardar en la carpeta storage (storage/app/users)
    		Storage::disk('users')->put($imagen_path, File::get($image_path));
    		//Setear el nombre de la imagen en el objecto
    		$user->imagen = $imagen_path;
    	}


    	$user->update();

    	return redirect()->route('config')->with(['message'=>'Usuario Actualizado Correctamente']);
    }

    public function getImagen($filename)
    {
    	$file = Storage::disk('users')->get($filename);

    	return new Response($file, 200);
    }


    public function profile($id)
    {
        $user = User::find($id);

        return view('user.profile', [
            'user'=>$user
        ]);
    }

}
