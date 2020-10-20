@extends('layouts.app')

@section('content')
    <h1>{{$data['name']}}</h1>
    <img src="{{$data['image']}}">
@endsection