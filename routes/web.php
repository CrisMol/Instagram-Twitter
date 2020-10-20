<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//use App\imagen;

Route::get('/', function () {

	/*
	$images = Imagen::all();
	foreach ($images as $image) {
		var_dump($image->user);
		echo '<h4>Comentario</h4>';
		foreach ($image->comments as $comment) {
			echo $comment->content;
		}
	}

	die();*/
    return view('welcome');
});

Auth::routes();

//Generales
Route::get('/home', 'HomeController@index')->name('home');
//Para Usuarios
Route::get('/configuracion', 'UserController@config')->name('config');
Route::get('/gente/{search?}', 'UserController@index')->name('user.index');
Route::post('/user/update', 'UserController@update')->name('user.update');
Route::get('/user/avatar/{filename}', 'UserController@getImagen')->name('user.avatar');
Route::get('/profile/{id}', 'UserController@profile')->name('profile');
//Imagen
Route::get('/subir-imagen', 'ImageController@create')->name('image.create');
Route::post('/guardar-imagen', 'ImageController@save')->name('image.save');
Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');
Route::get('/imagen/{id}', 'ImageController@detail')->name('image.detail');
Route::get('/imagen/delete/{id}', 'ImageController@delete')->name('image.delete');
Route::get('/imagen/editar/{id}', 'ImageController@edit')->name('image.edit');
//Comentarios
Route::post('/comment/save', 'CommentsController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'CommentsController@delete')->name('comment.delete');
//Likes
Route::get('/like/{imagen_id}', 'LikeController@like')->name('like.save');
Route::get('/dislike/{imagen_id}', 'LikeController@dislike')->name('like.delete');
Route::get('/likes', 'LikeController@likes')->name('likes');

Route::get('/api', 'HomeController@All')->name('api');