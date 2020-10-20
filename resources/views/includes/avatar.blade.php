@if(Auth::user()->imagen)
<div class="container-avatar">
	<img src="{{url('user/avatar/'.Auth::user()->imagen)}}" class="avatar">
</div>
 @endif