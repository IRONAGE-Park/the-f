$(document).ready(function() {
	var slider = {
		index: 0,
		animate: false
	};
	
	slider.element = $(".mainBanner");
	slider.container = $(".mainSlide", slider.element);
	slider.images = $("a", slider.container);
	slider.prev = $(".btnPre", slider.element);
	slider.next = $(".btnNext", slider.element);
	slider.buttons = $("a", $(".paging", slider.element));
	
	slider.images.css({left: 0, display: "none"}).first().css("display", "");
	
	slider.change = function(before, after) {
		if (slider.animate)
			return false;
		slider.animate = true;
		
		slider.images.eq(before).fadeOut(500);
		slider.index = after % (slider.images.size());
		slider.images.eq(slider.index).fadeIn(500, function() {
			slider.animate = false;
		});

		slider.buttons.removeClass("active").eq(slider.index).addClass("active");
		
		return false;
	};
	
	slider.next.click(function() {
		return slider.change(slider.index, slider.index + 1);
	});
	
	slider.prev.click(function() {
		return slider.change(slider.index, slider.index - 1);
	});
	
	var i = 0;
	slider.buttons.each(function() {
		$(this).data("name", i++);
		
	}).click(function() {
		return slider.change(slider.index, $(this).data("name"));
	});
	
	slider.element.mouseout(function () {
		slider.interval = setInterval(function() {
			slider.next.click();
		}, 5000);
		
	}).mouseout();


	/*PROJECT SLIDER*/
	$('#proj').slideShow();  // 좌/우
});