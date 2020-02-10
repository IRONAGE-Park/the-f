


// 영문 메인 이미지 롤링 제이쿼리 


    

$(document).ready(function() {
	var EngMainFun = {
		init: function() {
			this.EngImage();
		},
		EngImage: function() {
		  var main_01 = $('.visual-wrap .visual-posi-01'),
			  main_02 = $('.visual-wrap .visual-posi-02'),
			  main_03 = $('.visual-wrap .visual-posi-03'),
			  Time_01 = 3000;

			  //main_01.css("border", "solid 2px red");

		  setTimeout(onImages, 50);

		  function onImages(){
			
			setTimeout(mainImages01, Time_01);

			function mainImages01(){
			  main_01.animate({opacity:0}, 500, "easeOutCubic");
			  main_02.show();
			  main_02.animate({opacity:1}, 500, "easeOutCubic",function(){

				setTimeout(mainImages02, Time_01);
				function mainImages02(){
				  main_02.animate({opacity:0}, 500, "easeOutCubic");
				  main_03.show();
				  main_03.animate({opacity:1}, 500, "easeOutCubic",function(){

					  main_02.hide();
					  setTimeout(mainImages03, Time_01);
					  function mainImages03(){
						main_03.animate({opacity:0}, 500, "easeOutCubic");
						main_01.animate({opacity:1}, 500, "easeOutCubic",function(){

						  main_03.hide();

						  setTimeout(onImages, 50);
						});
					  }
				  });
				}
			  });

			}
		
		  }
		}
	};

	EngMainFun.init();
});


    