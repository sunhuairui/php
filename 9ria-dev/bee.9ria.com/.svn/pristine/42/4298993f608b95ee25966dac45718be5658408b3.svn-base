// JavaScript Document

$(document).ready(function(){
	var mode = $(".third-frame").attr('mode');
	$('.resolution-selecter-deploy').click(function(){
		$('.resolutions').toggleClass('show-resolutions');
	});
	
	var inch50w = 375;  //5.0 Inch Screen Width
	var inch50h = 620;  //5.0 Inch Screen Height

	function initiate_homepage_slider(){
		if(mode == '1'){
			inch50h = 667;
			$('.main-frame')  .animate({ width: inch50h + 00, 	 height: inch50w,	});
			$('.second-frame').animate({ width: inch50h + 00,	 });
			$('.third-frame') .animate({ width: inch50h + 140,	 });
		}else{
			$('.main-frame')  .animate({ width: inch50w + 00, 	 height: inch50h,	});
			$('.second-frame').animate({ width: inch50w + 00,	 });
			$('.third-frame') .animate({ width: inch50w + 40,	 });
		}
		$('.third-frame') .removeClass('remove-border');	
		$('.resolutions a').removeClass('active-resolution');
		$(this).addClass('active-resolution');
		$(this).trigger('resieze_main_frame');
	};
	initiate_homepage_slider();


});
