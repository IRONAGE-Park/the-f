$(document).ready(function() {
	var EngMainFun = {
		init: function() {
			this.Carousel();
			this.mCarousel();
		},
		Carousel: function() {
			const main = $('.visual-posi');
			const carousel = main.map((index, m) => {
				return $(`.visual-posi:eq(${index})`);
			});
			repeatChange(main.length - 1, 0);
			function repeatChange(pre, index) {
				carousel[pre].animate({opacity:0}, 500, "easeOutCubic");
				carousel[index].show();
				carousel[index].animate({opacity:1}, 500, "easeOutCubic");
				setTimeout(repeatChange.bind(this, index, (index + 1) % main.length), 3000);
			}
		},
		mCarousel: function() {
			const main = $('.mvisual-posi');
			const carousel = main.map((index, m) => {
				return $(`.mvisual-posi:eq(${index})`);
			});
			repeatChange(main.length - 1, 0);
			function repeatChange(pre, index) {
				carousel[pre].animate({opacity:0}, 500, "easeOutCubic");
				carousel[index].show();
				carousel[index].animate({opacity:1}, 500, "easeOutCubic");
				setTimeout(repeatChange.bind(this, index, (index + 1) % main.length), 3000);
			}
		}
	};
	EngMainFun.init();
});


    