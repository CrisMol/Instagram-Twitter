@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @include('includes.message')
            <div class="card pub_image pub_image_detail">
                <div class="card-header">

                    @if($image->user->imagen)
                    <div class="container-avatar">
                        <img src="{{url('user/avatar/'.$image->user->imagen)}}" class="avatar">
                    </div>
                    @endif
                    <div class="data-user">
                        {{$image->user->name.' '.$image->user->surname}}
                        <span class="nickname">
                            {{' !@ '.$image->user->nick}}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                   <div class="image-container image-detail">
                       <img src="{{ url('/image/file/'.$image->imagen_path) }}">
                   </div>
                   <div class="description">
                       <span class="nickname">{{'@'.$image->user->nick}}</span> 
                       <p>{{$image->description}}</p>
                   </div>
                   <div class="likes">
                    <?php $user_like = false; ?>
                        @foreach($image->likes as $like)
                          @if($like->user_id == Auth::user()->id)
                            <?php $user_like = true; ?>
                          @endif
                        @endforeach

                        @if($user_like)
                          <img src="{{asset('img/heart-red.png')}}" data-id="{{$image->id}}" class="btn-dislike">
                        @else
                          <img src="{{asset('img/heart-black.png')}}" data-id="{{$image->id}}" class="btn-like">
                        @endif

                        <span class="number-likes">{{count($image->likes)}}</span>
                   </div>
                   @if(Auth::user() && Auth::user()->id == $image->user->id)
                   <div class="actions">
                      <a href="{{ route('image.edit', ['id'=>$image->id])}}" class="btn btn-sm btn-primary">Actualizar</a>
                      <!--<a href="{{ route('image.delete', ['id'=> $image->id])}}" class="btn btn-sm btn-danger">Borrar</a>-->
                      <!-- Button to Open the Modal -->
                      <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal">
                        Eliminar
                      </button>

                      <!-- The Modal -->
                      <div class="modal" id="myModal">
                        <div class="modal-dialog">
                          <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h4 class="modal-title">¿Estás Seguro?</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                              ¿Esta seguro que desea eliminar definitivamente esta imagen?
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                              <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                              <a href="{{ route('image.delete', ['id'=> $image->id])}}" class="btn btn-danger">Borrar Definitivamente</a>
                            </div>

                          </div>
                        </div>
                      </div>

                   </div>
                   @endif
                   <div class="clearfix"></div>
                   <div class="comments">
                            <h3>Comentarios {{count($image->comments)}}</h3>
                            <hr> 

                            <form action="{{ route('comment.save')}}" method="POST">
                                @csrf

                                <input type="hidden" name="image_id" value="{{$image->id}}">
                                <p>
                                  <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : ''}}" name="content"></textarea>
                                  @if($errors->has('content'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$errors->first('content')}}</strong>
                                    </span>
                                  @endif
                                </p>
                                <button type="submit" class="btn btn-success">Enviar</button>
                            </form>
                            <hr>
                            @foreach($image->comments as $comment)
                                <div class="description">
                                   <span class="nickname">{{'@'.$comment->user->nick}}</span> 
                                   <span class="nickname">{{'| '.\FormatTime::LongTimeFilter($comment->created_at)}}</span>
                                   <p>{{$comment->content}}</p>

                                   @if (Auth::check() && ($comment->user_id == Auth::user()->id || $comment->imagenes->user_id == Auth::user()->id))
                                      <a href="{{ url('/comment/delete/'.$comment->id) }}" class="btn btn-sm btn-danger">Eliminar</a>
                                   @endif
                                </div>
                            @endforeach    
                   </div>
                </div>
            </div>
        </div>
</div>
@endsection
