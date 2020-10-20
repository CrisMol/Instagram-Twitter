@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Subir nueva Imagen:</div>
                <div class="card-body">
                    <form action="{{route('image.save')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="image-path" class="col-md-3 col-form-label text-md-right">Imagen</label>
                            <div class="col-md-7">
                                <input type="file" name="image-path" id="image-path" class="form-control {{ $errors->has('image-path') ? 'is-invalid' : ''}}" required="">
                                @if($errors->has('image-path'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$errors->first('image-path')}}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label text-md-right">Descripción</label>
                            <div class="col-md-7">
                                <textarea name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : ''}}" required="">
                                    
                                </textarea>
                                @if($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$errors->first('description')}}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-3">
                                <input type="submit" name="" class="btn btn-primary" value="Subir Imagen">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection