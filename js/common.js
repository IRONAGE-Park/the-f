$(document).ready(function() {
	
	// gnb
	function mainFun() {

		// 전체메뉴보기
		var nav08 = $('#header .top-nav .nav-08 a'),
			nav09 = $('#header .top-nav .nav-09 a'),
			gnbUl = $('#header .gnb ul ul'),
			gBg = $('#header .gnb-bg');

		var fullmenuOn = false;//140408 전체메뉴 보기 클릭확인

		nav08.on('click', function(event) {
			event.preventDefault();
			nav08.hide(0);
			nav09.slideDown(300);
			gBg.add(gnbUl).slideDown(300);
			fullmenuOn = true;
		});
		nav09.on('click', function(event) {
			event.preventDefault();
			nav08.slideDown(300);
			nav09.hide(0);
			gBg.add(gnbUl).slideUp(300);
			fullmenuOn = false;
		});

		// 이미지 변경하기
		var 
			g01 = $('.gnb00'),
			g02 = $('#header .gnb ul li.gnb-01 a'), 	// gnb li
			g03 = $('#header .gnb ul li.gnb-02 a'), 	// gnb li
			g04 = $('#header .gnb ul li.gnb-03 a'), 	// gnb li
			g05 = $('#header .gnb ul li.gnb-04 a'), 	// gnb li

			tBanner = $('#article .top-banner img'), 	// banner img
			top1 = "0", 								// position top
			top2 = "671", 								// position top
			top3 = "1092", 								// position top
			top4 = "1513", 								// position top
			top5 = "1934", 								// position top
			esingTime = 1000, 							// esingTime
			bg1 = "#83b6d5", 							// background-color
			bg2 = "#add57f", 							// background-color
			bg3 = "#f3e391", 							// background-color
			bg4 = "#edad5c", 							// background-color
			bg5 = "#80cfd8", 							// background-color
			z1 = '24', 									// z-index
			z2 = '23', 									// z-index
			z3 = '22', 									// z-index
			z4 = '21', 									// z-index
			z5 = '20', 									// z-index
			ba01 = $('.banner .banner-area-01'), 		// banner-area
			ba02 = $('.banner .banner-area-02'), 		// banner-area
			ba03 = $('.banner .banner-area-03'), 		// banner-area
			ba04 = $('.banner .banner-area-04'), 		// banner-area
			ba05 = $('.banner .banner-area-05'), 		// banner-area
			bn01 = ba01.find('.banner-01'), 			// banner-area img
			bn02 = ba02.find('.banner-02'), 			// banner-area img
			bn03 = ba03.find('.banner-03'), 			// banner-area img
			bn04 = ba04.find('.banner-04'); 			// banner-area img
			bn05 = ba05.find('.banner-05'); 			// banner-area img

		// 메인메뉴 2단계가 보일때 배너 클릭시 메인메뉴 2단계 감추고,전체메뉴보기버튼 보이기
		function nav08Show() {
			if ( nav09.css('display') == 'block') {
				nav08.slideDown(300);
				nav09.hide(0);
				gBg.add(gnbUl).slideUp(0);
			};
		};

		// 배너클릭시 위치 이동
		// g01.on('click', function(event) {
		// 	event.preventDefault();
		// 	nav08Show();

		// 	ba01.css('backgroundColor','transparent').find(bn01).css('z-index', z1).animate({ top: top1 }, esingTime, 'easeInQuart', function(){ ba01.css('backgroundColor', bg1)});
		// 	ba02.css('backgroundColor','transparent').find(bn02).css('z-index', z2).animate({ top: top2 }, esingTime, 'easeInQuart', function(){ ba02.css('backgroundColor', bg2)});
		// 	ba03.css('backgroundColor','transparent').find(bn03).css('z-index', z3).animate({ top: top3 }, esingTime, 'easeInQuart', function(){ ba03.css('backgroundColor', bg3)});
		// 	ba04.css('backgroundColor','transparent').find(bn04).css('z-index', z4).animate({ top: top4 }, esingTime, 'easeInQuart', function(){ ba04.css('backgroundColor', bg4)});

		// });

		// g02.on('click', function(event) {
		// 	event.preventDefault();
		// 	nav08Show();

		// 	ba01.css('backgroundColor','transparent').find(bn01).css('z-index', z4).animate({ top: top4 }, esingTime, 'easeInQuart', function(){ ba01.css('backgroundColor', bg2)});
		// 	ba02.css('backgroundColor','transparent').find(bn02).css('z-index', z1).animate({ top: top1 }, esingTime, 'easeInQuart', function(){ ba02.css('backgroundColor', bg3)});
		// 	ba03.css('backgroundColor','transparent').find(bn03).css('z-index', z2).animate({ top: top2 }, esingTime, 'easeInQuart', function(){ ba03.css('backgroundColor', bg4)});
		// 	ba04.css('backgroundColor','transparent').find(bn04).css('z-index', z3).animate({ top: top3 }, esingTime, 'easeInQuart', function(){ ba04.css('backgroundColor', bg1)});

		// });

		// g03.on('click', function(event) {
		// 	event.preventDefault();
		// 	nav08Show();

		// 	ba01.css('backgroundColor','transparent').find(bn01).css('z-index', z3).animate({ top: top3 }, esingTime, 'easeInQuart', function(){ ba01.css('backgroundColor', bg3)});
		// 	ba02.css('backgroundColor','transparent').find(bn02).css('z-index', z4).animate({ top: top4 }, esingTime, 'easeInQuart', function(){ ba02.css('backgroundColor', bg4)});
		// 	ba03.css('backgroundColor','transparent').find(bn03).css('z-index', z1).animate({ top: top1 }, esingTime, 'easeInQuart', function(){ ba03.css('backgroundColor', bg1)});
		// 	ba04.css('backgroundColor','transparent').find(bn04).css('z-index', z2).animate({ top: top2 }, esingTime, 'easeInQuart', function(){ ba04.css('backgroundColor', bg2)});

		// });

		// g04.on('click', function(event) {
		// 	event.preventDefault();
		// 	nav08Show();

		// 	ba01.css('backgroundColor','transparent').find(bn01).css('z-index', z2).animate({ top: top2 }, esingTime, 'easeInQuart', function(){ ba01.css('backgroundColor', bg4)});
		// 	ba02.css('backgroundColor','transparent').find(bn02).css('z-index', z3).animate({ top: top3 }, esingTime, 'easeInQuart', function(){ ba02.css('backgroundColor', bg1)});
		// 	ba03.css('backgroundColor','transparent').find(bn03).css('z-index', z4).animate({ top: top4 }, esingTime, 'easeInQuart', function(){ ba03.css('backgroundColor', bg2)});
		// 	ba04.css('backgroundColor','transparent').find(bn04).css('z-index', z1).animate({ top: top1 }, esingTime, 'easeInQuart', function(){ ba04.css('backgroundColor', bg3)});

		// });

		//$('.gnb-li').hover(function() {
		$('.btn-animate').hover(function() {		
			// 공통적으로 해야되는 함수
			if (fullmenuOn == true) {
				return false;
			};
			nav08Show();
			// console.log( $('.banner-area img').is(":animated") );

			// if ( $('.banner-area img').is(":animated") ) {
			// 	return false;
			// };

			// id check
			//if ( $(this).hasClass('gnb-01') ) {
			if ( $(this).parents('li').hasClass('gnb-01') ) {
				//gnb-01
				// alert('gnb-01')
				ba01.css('z-index', z1).animate({ top: top1 }, esingTime, 'easeInQuart', function(){ });
				ba02.css('z-index', z2).animate({ top: top2 }, esingTime, 'easeInQuart', function(){ });
				ba03.css('z-index', z3).animate({ top: top3 }, esingTime, 'easeInQuart', function(){ });
				ba04.css('z-index', z4).animate({ top: top4 }, esingTime, 'easeInQuart', function(){ });
				ba05.css('z-index', z5).animate({ top: top5 }, esingTime, 'easeInQuart', function(){ });

			//} else if (  $(this).hasClass('gnb-02') ) {
			} else if (  $(this).parents('li').hasClass('gnb-02') ) {
				//gnb-02
				// alert('gnb-02')
				ba01.css('z-index', z5).animate({ top: top5 }, esingTime, 'easeInQuart', function(){ });
				ba02.css('z-index', z1).animate({ top: top1 }, esingTime, 'easeInQuart', function(){ });
				ba03.css('z-index', z2).animate({ top: top2 }, esingTime, 'easeInQuart', function(){ });
				ba04.css('z-index', z3).animate({ top: top3 }, esingTime, 'easeInQuart', function(){ });
				ba05.css('z-index', z4).animate({ top: top4 }, esingTime, 'easeInQuart', function(){ });
			//} else if (  $(this).hasClass('gnb-03') ) {
			} else if (  $(this).parents('li').hasClass('gnb-03') ) {
				//gnb-03
				// alert('gnb-03')
				ba01.css('z-index', z4).animate({ top: top4 }, esingTime, 'easeInQuart', function(){ });
				ba02.css('z-index', z5).animate({ top: top5 }, esingTime, 'easeInQuart', function(){ });
				ba03.css('z-index', z1).animate({ top: top1 }, esingTime, 'easeInQuart', function(){ });
				ba04.css('z-index', z2).animate({ top: top2 }, esingTime, 'easeInQuart', function(){ });
				ba05.css('z-index', z3).animate({ top: top3 }, esingTime, 'easeInQuart', function(){ });
			//} else if (  $(this).hasClass('gnb-04') ) {
			} else if (  $(this).parents('li').hasClass('gnb-04') ) {
				//gnb-04
				// alert('gnb-04')
				ba01.css('z-index', z3).animate({ top: top3 }, esingTime, 'easeInQuart', function(){ });
				ba02.css('z-index', z4).animate({ top: top4 }, esingTime, 'easeInQuart', function(){ });
				ba03.css('z-index', z5).animate({ top: top5 }, esingTime, 'easeInQuart', function(){ });
				ba04.css('z-index', z1).animate({ top: top1 }, esingTime, 'easeInQuart', function(){ });
				ba05.css('z-index', z2).animate({ top: top2 }, esingTime, 'easeInQuart', function(){ });
			//} else if (  $(this).hasClass('gnb-05') ) {
			} else if (  $(this).parents('li').hasClass('gnb-05') ) {
				//gnb-04
				// alert('gnb-04')
				ba01.css('z-index', z2).animate({ top: top2 }, esingTime, 'easeInQuart', function(){ });
				ba02.css('z-index', z3).animate({ top: top3 }, esingTime, 'easeInQuart', function(){ });
				ba03.css('z-index', z4).animate({ top: top4 }, esingTime, 'easeInQuart', function(){ });
				ba04.css('z-index', z5).animate({ top: top5 }, esingTime, 'easeInQuart', function(){ });
				ba05.css('z-index', z1).animate({ top: top1 }, esingTime, 'easeInQuart', function(){ });
			} 
		}, function() {
			// retrun flase
			return false;
		});



		// 퀵메뉴
		function quickFun() {
			$(window).scroll(function(){
			    var scrollTop = $(document).scrollTop();
			    // if (scrollTop < 168) {
			    //     scrollTop = 168;
			    // }
			    $("#quick").stop().animate( { "top" : scrollTop + 200 });
			});
		}
		quickFun();

	};
	mainFun();

	//고객센터 FAQ 아코디언
	if ($('.accodian-list').length!==0) {
		$('.accodian-list').accodian();
	};
	//레이어팝업
	var back_focus;
	var open_layer;
	centerPos = function (el) {
	    var target_layer = $('' + el + '');
	    var l_w = target_layer.width();
	    var l_h = target_layer.height();
	    var w_w = $(window).width();
	    var w_h = $(window).height();
	    var xpos = (w_w - l_w) / 2;
	    var ypos = (w_h - l_h) / 2;
	    target_layer.css({
	        'left': xpos,
	        'top': ypos
	    });
	}
	layerOpen = function (el) {
	    open_layer = $('' + el + '');
	    $('#curtain, #pop-win').show();
	    centerPos(el);
	    //$('html, body').addClass('no-scroll');
	    open_layer.attr('tabindex', '0').css({
	        "outline": "none"
	    });
	    open_layer.focus();
	}
	layerClose = function () {
	    $('#curtain, #pop-win').hide();
	    //$('html, body').removeClass('no-scroll');
	    if (typeof open_layer == "undefined") {
	        return false;
	    }
	    open_layer.removeAttr('tabindex').css({
	        "outline": ""
	    });
	}	
	$(document).on('click', '.btn-layer-close', function (e) {
	    e.preventDefault();
	    layerClose();
	    back_focus.focus();
	});
	$(document).on('click', '.btn-layer-open, .btn-check, .btn-certification, .btn-find', function(e) {
		e.preventDefault();
		/* Act on the event */
		back_focus = this;
		//layerOpen('.layer-pop'); 2014.03.20 이영미막음
		layerOpen('.layer-pop'); 
	});

	//탭
	var tabBtn = $('.tab-container .btn-tab');
	tabBtn.click(function(e){
    	e.preventDefault();
   		$('.tab-container .tab-wrap').removeClass('selected');
    	$(this).parents('.tab-wrap').addClass('selected');
  	});

  	// tooltip
  	$('#quick a').bstooltip({
  		placement: 'left'
  	});

  	
  	//20140325 서브타이틀 페이지 상세설명 문구 삭제
  	$('h3.title').find('em').remove();

  	//20140429 ipad viewport
  	$('meta[name="viewport"]').attr('content', 'width=1150, initial-scale=1.0, minimum-scale=1.0');

});
