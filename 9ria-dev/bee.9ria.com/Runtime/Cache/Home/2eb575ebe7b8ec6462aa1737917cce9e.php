<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo ($meta_title ? $meta_title : C('WEB_SITE_TITLE')); ?></title>
    <meta name="description" content="<?php echo ($meta_desc ? $meta_desc : C('WEB_SITE_DESCRIPTION')); ?>" />
    <meta name="keywords" content="<?php echo ($meta_keyword ? $meta_keyword : C('WEB_SITE_KEYWORD')); ?>" />
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="/Public/bee/css/bootstrap.min.css" />
    <script href="/Public/bee1/js/ie-css3.htc"></script>
    
<link rel="stylesheet" href="/Public/bee1/css/main.css" />    
<style>
.pages {text-align: center;margin-top: 50px;padding:30px 0px;}
.pages a,.pages span.current {width: 38px;height: 38px; border-radius: 19px; background: #fff;color:#888;font-size: 18px;display: inline-block;text-align: center;line-height: 38px;margin-right: 15px;}
.pages a:hover,.pages a.current,.pages span.current {background: #2686d0;color:#fff;}
</style>

    <!-- Custom styles for this template --> 
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! --> 
    <!--[if lt IE 9]><script src="/Public/static/ie8-responsive-file-warning.js"></script><![endif]--> 
    <script src="/Public/static/ie-emulation-modes-warning.js"></script> 
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries --> 
    <!--[if lt IE 9]>
    <script src="/Public/static/html5shiv.min.js"></script>
    <script src="/Public/static/respond.min.js"></script>
    <![endif]-->
</head> 
<body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <!--  <a href="" style="float:left"><img src="images/logo.png" alt=""></a> --> 
        <a href="<?php echo U('index/index');?>" class="logo"></a>
        <div class="loginInfo">
          <?php if(is_login()): ?><a href="<?php echo U('User/accountinfo');?>"><?php echo get_username();?></a> <a href="<?php echo U('home/user/logout');?>" style="margin-left:20px;" class="logout">退出</a>
          <?php else: ?>
              <a href="#" data-toggle="modal" class="login">登录</a><?php endif; ?>
        </div>
        <div class="container" style="width:60%;position: absolute;top: 0;left: 264px;">
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                <?php if(is_login()): ?><li class="<?php if($Think.CONTROLLER_NAME == 'Project') echo 'active';?>"><a href="<?php echo U('home/project/index');?>">我的项目</a></li>
                <li class="<?php if( $Think.CONTROLLER_NAME == 'Statistics') echo 'active';?>">
                    <a href="<?php echo U('home/statistics/index');?>">我的数据</a>
                </li><?php endif; ?>
                <li class="<?php if($Think.CONTROLLER_NAME == 'Template') echo 'active';?>"><a href="<?php echo U('home/template/index');?>">模板库</a></li>
                <li class="<?php if($Think.CONTROLLER_NAME == 'Index' && $Think.ACTION_NAME == 'qa') echo 'active';?>"><a href="<?php echo U('home/index/qa');?>">帮助中心</a></li>
                </ul>
            </div>
        </div>
    </nav>
 
<div class="mainContainer">    
	<div class="line mt20">
	   <h2 class="h2tit">我的数据</h2>
	</div> 
	<div class="overView clearfix" style="margin-left:125px"> 
		<ul class="introList clearfix"> 
			<li><?php echo ($total["pageview"]); ?><span><i class="icoView"></i>浏览量</span></li> 
			<li><?php echo ($total["userview"]); ?><span><i class="icoVistor"></i>访客数</span></li> 
			<li><?php echo ($total["sharecount"]); ?><span><i class="icoZ"></i>转发量</span></li> 
			<li class="borderN"><?php echo ($total["sharerate"]); ?>%<span><i class="icoSharecount"></i>转发率</span></li> 
		</ul>
	</div> 
	<ul class="tag normalP">
        <?php if($curType == 'pageview'): ?><li><a href="javascript:void(0)" class="active">按浏览量排序</a></li>
        <?php else: ?>
            <li><a href="<?php echo U('statistics/index',array('type'=>'pageview'));?>">按浏览量排序</a></li><?php endif; ?>
        <?php if($curType == 'userview'): ?><li><a href="javascript:void(0)" class="active">访客数排序</a></li>
        <?php else: ?>
            <li><a href="<?php echo U('statistics/index',array('type'=>'userview'));?>">访客数排序</a></li><?php endif; ?>
        <?php if($curType == 'sharecount'): ?><li><a href="javascript:void(0)" class="active">转发数排序</a></li>
        <?php else: ?>
            <li><a href="<?php echo U('statistics/index',array('type'=>'sharecount'));?>">转发数排序</a><?php endif; ?>
	</ul>
	<div class="boxWhite">
		<table class="dataTable">
			<tbody>
				<tr><th>项目名称</th><th>浏览量</th><th>访客数</th><th>转发数</th><th>项目详情</th></tr>
				<?php if(is_array($items)): $i = 0; $__LIST__ = $items;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
					<td><?php echo ($item["title"]); ?></td>
					<td><?php echo ($item["pageview"]); ?></td> 
					<td><?php echo ($item["userview"]); ?></td> 
					<td><?php echo ($item["sharecount"]); ?></td>
					<td><a href="<?php echo U('statDetail', 'appid='.$item['appid']);?>" class="dataA">查看详情</a></td>  
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
		<div class="pages">
		<?php echo ((isset($page) && ($page !== ""))?($page):''); ?>
		</div>
	</div>
</div>

 
 <div class="footer">
    <img src="/Public/bee1/images/footerLogo.png" alt="">
</div>    
 
 <!--返回顶部+建议-->
    <a id="sugest" href="mailto:sunxiao@cyou-inc.com"></a>
    <a id="goTop" href="javascript:void(0)"></a>
    <script src="/Public/static/jquery.min.js"></script>
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="/Public/static/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/Public/static/ie10-viewport-bug-workaround.js"></script>
    <script src="/Public/static/qrcode.min.js"></script>  <!-- 二维码文件 -->
    <script type="text/javascript" src="/Public/bee1/js/bee.js"></script>
    <script type="text/javascript">
        var is_login = '<?php echo is_login();?>';
        var checkbroswer = checkBroswer();
$(function(){
    $(".login").click(function(){
        bee.login();
    });

    $(".logout").click(function(){
        bee.logout();
    });

    //创建场景
    $('#create_add .btn-primary').bind("click", function() {
        var that = this;
        var name = $("#addname").val();
        var title = $("#addtitle").val();
        var category = $("#addcategory").val();
        if (name == '') {
            alert('请选择模板！');
            return false;
        } else if (title == '') {
            alert('请输入场景名称！');
            return  false;
        } else if (category == '') {
            alert('请选择应用场景！');
            return false;
        } else if (title.length > 30) {
            alert('场景名称不能大于30个字符！');
            return false;
        }
    
        $(that).attr('disabled', true);
        var posturl = '<?php echo U("project/create");?>';
        $.post(posturl, {name:name, title:title, category:category }, function(data) {
            $(that).attr('disabled', false);
            if (typeof data.status == 'undefined') {
                alert("数据格式非法");
                return false;
            }
            
            if (data.status) {
                data.url && (location.href = data.url);
            } else {
                data.info && alert(data.info);
                return false;
            }
        });
    });

        // 宽度liuna
        var screenW = document.body.clientWidth;
        if(screenW > 1400){
            $('.mainContainer').css('width','1345px');
            // $('ul.main li').css('margin-right','48px');
            $('a.more').css('width','1294px');
            $('.editorBox').css('width','840px');

        }

        // 手机预览位置固定
        $(window).on('scroll',function(){
            if($(document).scrollTop() > 90){
                $('.viewFix').css({'position':'fixed','top':'95px'});
                $('.titFix').css({'position':'fixed','top':'70px'});
                $('.editorBox').css('margin-left','333px');
            }else{
                $('.viewFix').css('position','static');
                $('.titFix').css('position','static');
                $('.editorBox').css('margin-left','0');   
            }    
        });

        // 返回顶部
        function b(){
            h = $(window).height();
            topH = document.documentElement.scrollTop + document.body.scrollTop;
            if(topH > h){
                $('#goTop').fadeIn(200);
            }else{
                $('#goTop').fadeOut(200);
            }
        }
        
        b();
        $(window).scroll(function(e){
            b();    
            // console.log(h + '<br>滚动距离:' + t);    
        })

        $('#goTop').click(function(){
            // $(document).scrollTop(0);  
            $("html,body").animate({scrollTop:"0px"},200); 
        });

        // 反馈意见距离左边的距离
        if($('ul.main')[0]){
            var goTopLeft = $('ul.main').offset().left + $('ul.main').width();
            $('#sugest').css('left',goTopLeft);
            $('#goTop').css('left',goTopLeft);
        }
         if($('.mainContainer')[0]){
            var goTopLeft = $('.mainContainer').offset().left + $('.mainContainer').width();
            $('#sugest').css('left',goTopLeft);
            $('#goTop').css('left',goTopLeft);
        }
        
    });
    </script>
     <!-- 用于加载js代码 -->
</body>
</html>