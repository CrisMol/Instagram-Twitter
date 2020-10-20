<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\imagen;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $images = imagen::orderBy('id', 'desc')->paginate(5);
        return view('home', [
            'images' => $images
        ]);
    }

    public function All(){
        $url = 'https://rickandmortyapi.com/api/character/3';
        $data = Http::get('https://rickandmortyapi.com/api/character/3')->json();
        return view('api.api', ['data'=>$data]);
    }
}
