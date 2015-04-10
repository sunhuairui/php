// JavaScript
//新手引导
$(function(){
	var allHeight = $(document).height();
	var allWidth = $(document).width();
	$('#mask').height(allHeight);
	$('#mask').width(allWidth);
	// 14寸笔记本
	if(window.screen.width == 1366){
		$('.editor_bg02').css('right','-131px');
		$('#searchTips_editor li.stepB span').css('left','604px');
	}
	console.log(window.screen.width);
	
	// $(window).resize(function(){
	// 	var allHeight = $(document).height();
	// 	var allWidth = $(document).width();
	// 	$('#mask').height(allHeight);
	// 	$('#mask').width(allWidth);			
	// });

	 $(window).scroll(function(){ 
	 	var allHeight = $(document).height();
		var allWidth = $(document).width();
		$('#mask').height(allHeight);
		$('#mask').width(allWidth);		
	 });

	// $('.editor .preview .p .inner','.desktop').height(allHeight*0.1);

	var oMask = $('#mask');
	var oSearch = $('#searchTips');
	var aStep = oSearch.children().children();
	$('#mask,#maskR,#searchTips,#searchTips ul li:eq(0),#searchTipsrR,#searchTipsR ul li:eq(0),#searchTips_editor,#searchTips_editor ul li:eq(0)').show();
	/*  alert($('#searchTipsR ul li:eq(0)').html());  */
	//$('.des').addClass('firstLayer');
	$('#searchTips a').click(function(){
		var i=[0,0,0];
		var current = $(this).parent();
		var num = current.prevAll().length;
		current.hide();
		var n = current.next();
		n.show();
		$('body,html').scrollTop(i[num]);
		});
		
	$('#searchTipsR a').click(function(){
		var i=[0,0,0];
		var current = $(this).parent();
		var num = current.prevAll().length;
		current.hide();
		var n = current.next();
		n.show();
		$('body,html').scrollTop(i[num]);
		});
	
	$('#searchTips_editor a').click(function(){
		var i=[0,0,0];
		var current = $(this).parent();
		var num = current.prevAll().length;
		current.hide();
		var n = current.next();
		n.show();
		$('body,html').scrollTop(i[num]);
		});
	
		
	$('#searchTips span,#searchTips a:last,#searchTipsR span,#searchTipsR a:last,#searchTips_editor span').click(function(){
		$('#mask,#maskR,#searchTips,#searchTipsR,#searchTips_editor').hide();
		$('body,html').animate({scrollTop:0},400); 
	  })
	
	
	
	//if(oMaskR.length){
		var oMaskR  = $('#maskR');
		var oSearchR = $('#searchTipsR');
		var aStep = oSearchR.children().children();
		$('#maskR1,#searchTipsrR,.btnExp').show();
		$('.des,.help,.downLoad').addClass('firstLayer')	
		$('.btnExp').click(function(){
			$('#maskR,#searchTipsR').hide();
			$('body,html').animate({scrollTop:0},400); 
			$('.des,.help,.downLoad').removeClass('firstLayer');
			
		  });
		
	//}
	})