$(document).ready(function() {
	var back = document.referrer;
	var backPageFolder = back.split('/')[back.split('/').length-2];
	var current = location.href;
	var currentPageFolder = current.split('/')[current.split('/').length-2];
	// console.log('backPageFolder:'+backPageFolder+'=='+'currentPageFolder:'+currentPageFolder);

	if(backPageFolder!=currentPageFolder || backPageFolder=='undefined'){
		$('.sub-visual, .sub-visual .wrapper').delay(700).animate({
			'height':'-=150px'
		},{
			duration : 400
			,start : function(){
				$(this).css({
					'overflow':'visible'
				});
			}
			,progress : function(){
				$('.down').fadeOut(200, function() {

				});
				$('.up').fadeIn(500, function() {

				});
			}
			,complete : function(){
				$('.btn-switch').removeClass('btn-up').addClass('btn-down');
			}
		});
	}else{
		$('.sub-visual, .sub-visual .wrapper').height(208);
		$('.down').hide();
		$('.up').show();
		$('.btn-switch').removeClass('btn-up').addClass('btn-down');
	}

	$(document).on('click', '.btn-down', function(){
		$('.sub-visual, .sub-visual .wrapper').animate({
			'height':'+=150px'
			},{
			 	duration :500
			 	,start : function(){
			 		$(this).css({
			 			'overflow':'visible'
			 		});
			 	}
			 	,progress : function(){
					$('.up').fadeOut(500, function() {

					});
					$('.down').fadeIn(500, function() {

					});
				}
			 	,complete : function(){
					$('.btn-switch').removeClass('btn-down').addClass('btn-up');
				}
			});
	});
	$(document).on('click', '.btn-up', function(){
		$('.sub-visual, .sub-visual .wrapper').animate({
			'height':'-=150px'
		},{
			duration : 500
			,start : function(){
				$(this).css({
					'overflow':'visible'
				});
			}
			,progress : function(){
				$('.down').fadeOut(300, function() {

				});
				$('.up').fadeIn(500, function() {

				});
			}
			,complete : function(){
				$('.btn-switch').removeClass('btn-up').addClass('btn-down');
			}
		});
	});
});