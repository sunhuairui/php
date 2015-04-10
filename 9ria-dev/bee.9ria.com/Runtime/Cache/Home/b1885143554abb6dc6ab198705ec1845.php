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
        body{overflow-y:scroll !important; overflow-y:auto;/*解决滚动条抖动问题*/}
        .inner{position:relative;width: 100%;margin-top:50px;/*border: #ccc solid 1px*/}
        .accountInfo{margin-left:175px;width: 80%;min-height:415px;padding:9px 65px 60px;margin-bottom:60px;background-color:#fff;}
        ul.leftMenu{position:absolute;top:0;left:0;width: 175px;z-index:2;/*padding-top:13px;*/}
        ul.leftMenu li{position: relative;height: 50px;line-height: 50px;padding:0 10px;background-color:#e5e5e5;text-align: center;color: #b4b4b4;font-size: 18px;cursor: pointer;}
        ul.leftMenu li.active{left:30px;padding-left:24px;text-align: left;background-color:#099bee;color: #fff;}
        .triangle{font-size: 0.8em;color: #fff;-webkit-transform:rotate(90deg);-moz-transform:rotate(90deg);transform: rotate(90deg);}
        .triangleShadow{position:absolute;top:-14px;right:0;background:url(/Public/bee1/images/sprite.png) no-repeat;background-position:0 -1205px;width: 30px;height: 14px}
        h2{font-size: 24px}
        .WhiteGray{color: #525252;font-size: 20px}
        ul.accountForm{margin-top: 40px}
        ul.accountForm li{margin-bottom: 25px}
        ul.accountForm li span,ul.accountForm li label{display:inline-block;width:137px;color: #b4b4b4;font-size: 18px;font-weight: normal;}
        ul.accountForm li input,ul.accountForm li select,ul.accountForm li textarea{width: 470px;height: 30px;line-height:20px;padding:5px 20px;border: #dadada solid 1px} 
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
 
<div class="container common">    
    <div class="line mt20">
        <h2 class="h2tit"> 账户管理</h2>
    </div> 
    <div class="inner">
        <ul class="leftMenu">
            <li><a href="<?php echo U('accountinfo');?>">账户资料</a></li>
            <li class="active">修改密码<span class="triangle fr">▲</span><span class="triangleShadow"></span></li>
        </ul>
        <div class="accountInfo">
            <div class="line">
                <h3 class="WhiteGray">修改你的赢销+密码</h3> 
            </div>
            <ul class="accountForm">
                <li> 
                    <span>原密码</span>
                    <input type="password" name="old" id="" value="" class="">
                </li>
                <li> 
                    <span>新密码</span>
                    <input type="password" name="password" id="" value="" class="" placeholder="6~16个字符，区分大小写">
                </li>
                <li> 
                  <span>确认密码</span>
                  <input type="password" name="repassword" id="" value="" class="" placeholder="6~16个字符，区分大小写">
                </li>
            </ul>
            <p class="btnBlue" style="width:170px;margin:0 auto;position:relative;right:96px;font-size:18px">保存修改</p>
            <p class="ajaxmsg" style="coler:red;"></p>
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
    
<script type="text/javascript">
        var resetpwdurl = "<?php echo U('profile');?>";
        (function($){
            $(".btnBlue").click(function(){
                $.post(resetpwdurl,{
                    "old" : $("input[name=old]").val(),
                    "password" : $("input[name=password]").val(),
                    "repassword": $("input[name=repassword]").val()
                }, function(res){
                    if(res.status){
                        $(".ajaxmsg").html("修改成功，请重新登录...");
                        setTimeout(function(){
                            location.href = "<?php echo U('relogin');?>";
                        },1000)
                    }else{
                         $(".ajaxmsg").html(res.info);
                    }
                })
            })
        }(jQuery));

</script>
 <!-- 用于加载js代码 -->
</body>
</html>