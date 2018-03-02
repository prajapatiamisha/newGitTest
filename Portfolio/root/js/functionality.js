$(document).ready(function(){
	$('.category-item').click(function(){
		var c = $(this).attr('id');
		if(c == 'all'){
			$('.color-item').addClass('hide');
			setTimeout(function(){
				$('.color-item').removeClass('hide');

			},3000);


		}else{
			$('.color-item').addClass('hide');
			setTimeout(function(){
				$('.'+ c).removeClass('hide');

			},3000);

		}


	});
});