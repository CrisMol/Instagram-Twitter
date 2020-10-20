var url = 'http://proyecto-laravel.com.devel/';

window.addEventListener("load", function(){
	//Boton de Like
	
	$('.btn-like').css('cursor','pointer');
	$('.btn-dislike').css('cursor','pointer');

	function like(){
		$('.btn-like').unbind('click').click(function(){
			$(this).addClass('btn-dislike').removeClass('btn-like');
			$(this).attr('src', url+'img/heart-red.png');

			$.ajax({
				url: url+'like/'+$(this).data('id'),
				type: 'GET',
				success: function(response){
					if (response.like) {
						console.log("Has dado like");
					}else{
						console.log("Error al dar like");
					}	
				}
			});

			dislike();
		})
	}

	like();

	//Botón de Dislike
	function dislike(){
		$('.btn-dislike').unbind('click').click(function(){
			$(this).addClass('btn-like').removeClass('btn-dislike');
			$(this).attr('src', url+'img/heart-black.png');


			$.ajax({
				url: url+'dislike/'+$(this).data('id'),
				type: 'GET',
				success: function(response){
					if (response.like) { //El like es lo que retorna la funcion de la url
						console.log("Has dado dislike");
					}else{
						console.log("Error al dar dislike");
					}	
				}
			});

			like();
		})
	}

	dislike();

	//Buscador
	$('#buscador').submit(function(){
		$(this).attr('action',url+'gente/'+$('#buscador #search').val());
	});
});