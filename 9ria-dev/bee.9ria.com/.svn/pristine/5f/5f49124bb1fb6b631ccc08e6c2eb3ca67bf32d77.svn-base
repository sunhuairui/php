var list = $(".templete .list");

list.find("li").hover(function(){
	$(this).find(".img div").fadeIn(200);
}, function(){
	$(this).find(".img div").fadeOut(200);
});

$(window).resize(function(){
	autoCenter();
});

function autoCenter(){
	var itemWidth = 190;	
	var listWidth = list.width();
	if(listWidth < 890) listWidth = 890;
	var rowNum = parseInt(listWidth / (190 + 80));
	var area = listWidth - rowNum * itemWidth;
	list.find("li").css({
		marginLeft: parseInt(area / (rowNum * 2)),
		marginRight: parseInt(area / (rowNum * 2))
	});	
}
autoCenter();

$(".popup label").click(function(){
	$(this).find("em").addClass("checked").find("input").attr("checked", true);
	$(this).siblings().find("em").removeClass("checked").find("input").attr("checked", false);
});

$(".popup-close").click(function(){
	$(".popup-bg,.popup").fadeOut("fast");
});

var liveList = $(".live .list li.on");

liveList.click(function(){
	$(".popup-bg,#viewPop").fadeIn("fast");
});


var prizeItem = '\
	<div class="prize-item" style="display:none;">\
		<ul>\
			<li><span>奖项名称</span><input type="" name="" id="" value="" class="txt"/></li>\
			<li><span>奖品名称</span><input type="" name="" id="" value="" class="txt"/></li>\
			<li>\
				<span>中奖概率</span><input type="" name="" id="" value="" class="txt short"/>\
				<span>奖品图片</span><input type="button" value="上传图片" class="up" />\
			</li>\
		</ul>\
		<div class="delete"></div>\
	</div>';

$(".setting .add").click(function(){
	$(".prize-list").append(prizeItem);
	$(".prize-list .prize-item:last-child").slideDown();
});

$(".setting").on("click", ".delete",function(){
	var item = $(this).parents(".prize-item");	
	item.slideUp(function(){
		item.remove();
	});
});

$("#login dl span").click(function(){
	$(this).hide().prev().focus();
});
$("#login dl input").blur(function(){
	if($.trim($(this).val()) == ""){
		$(this).next().show();
	}
});
$(".login").click(function(){
	$(".popup-bg,#login").fadeIn("fast");
});

var imgList = $(".imglist"), timer, li;
$(".resource li").hover(function(){
	clearTimeout(timer);
	li = $(this);
	li.addClass("on").siblings().removeClass("on");
	imgList.css({
		top: li.offset().top + 23 + 160,
		left: li.offset().left	
	}).show();
}, function(){
	timer = setTimeout(function(){
		li.removeClass("on");
		imgList.hide();
	},300);
});

imgList.hover(function(){
	clearTimeout(timer);
}, function(){
	timer = setTimeout(function(){
		li.removeClass("on");
		imgList.hide();
	},300);
});

imgList.find("li").click(function(){
	$(this).addClass("selected").siblings().removeClass("selected");
});

var isChrome = window.navigator.userAgent.indexOf("Chrome") !== -1 ;
if(!isChrome && $(".bwWrapper").length > 0){
	$('.bwWrapper').BlackAndWhite({
		hoverEffect : false
	});
}
// $(".my .list li .kaiguan").click(function(){
// 	var li = $(this).parents("li");
// 	if(li.hasClass("on")){
// 		li.removeClass("on");
// 	}else{
// 		li.addClass("on");
// 	}
// });
