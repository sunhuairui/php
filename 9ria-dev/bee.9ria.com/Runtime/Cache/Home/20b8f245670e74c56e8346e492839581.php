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
 
  <div class="container">
  <div class="modal fade" id="create_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog"> 
          <div class="modal-content"> 
               <div class="modal-body">
                    <form action="" class="comForm">
                        <div>
                            <input  type="text" placeholder="输入场景名称" class="inp login_email" id="addtitle"/>
                        </div>
                        <div>
                            <select class="inp login_email" id="addcategory">
                                <option value="">给场景分类</option>
                                <?php if(is_array($categorys)): $i = 0; $__LIST__ = $categorys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val['id']); ?>"><?php echo ($val['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                           </select>
                        </div>
                        <input type="hidden" value="<?php echo ($template_name); ?>" id="addname">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">确定</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        </div>
                    </form>
                </div> 
            </div> 
       </div> 
  </div>    
  <div class="wrapper">
  <div class="mobile" style="margin: 3% 0 0 8%;padding: 7% 2%;">
        <a href="javascript:window.history.go(-1)" class="goPre"></a>
        <iframe src="<?php echo ($pc_url); ?>"  style="height: 600px;width: 376px;border: none;position:relative;right:2px;top:37px"></iframe>
  </div>
  <div class="shareBoxB"></div>
  <div class="shareBox">
    <h4>&nbsp;&nbsp;&nbsp;用微信扫码，分享到朋友圈！</h4>
     <div style="width: 215px;height: 214px;margin: 5px auto 0;" id="codeshow">
</div>
    <a href="<?php echo ($qr_svg); ?>"><p style="width:215px;margin-left:17px"><i class="icoDownload"></i>点击下载二维码</p></a>
    <i class="line2 mt10"></i>
    <h4 class="mt20">模板链接</h4>
    <input type="text" value="<?php echo ($url); ?>" readonly="readonly">
     <p id="clip_container" style="position: relative;width:100%;text-align: center;" class="mb60"><b id="a_cptxt"  style="width: 100%;height:40px;line-height:40px;position: absolute;left: 0px;">点击复制</b></p>
    <span>&nbsp;&nbsp;&nbsp;这个模板太赞了，<a style="cursor:pointer" value="<?php echo U('project/create', 'name='.$template_name);?>"  name ="<?php echo ($template_name); ?>" data-toggle="modal" data-target="#create_add">我也要做!</a></span>
  </div>
</div>
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
    
<script src="/Public/bee/js/zeroclip/ZeroClipboard.js"></script>
 <script>
    $(function(){
      $("body").addClass('bg');
      // 上下线按钮，在父元素上绑定事件，提高效率
      $(".main").on("click","a.offline",function(){
          $(this).removeClass('offline');
          $(this).addClass('online');
      });

      $(".main").on("click","a.online",function(){
          $(this).removeClass('online');
          $(this).addClass('offline');
      });
      
      var codeshow =$("#codeshow");
      var codeurl='<?php echo $url;?>';
       var qrcode = new QRCode(codeshow[0], {
          width : 215,
          height : 215
      });	   
      qrcode.makeCode(codeurl);
    });
    
    // 复制分享
    function init_cpswf() {
    	ZeroClipboard.moviePath = '/Public/bee/js/zeroclip/ZeroClipboard.swf'
    	var clip = new ZeroClipboard.Client();
    	clip.setHandCursor( true );
    	clip.setCSSEffects( true );
    	 clip.addEventListener('load', function (client) {
    		debugstr("Flash movie loaded and ready.");
    	});

    	clip.addEventListener('mouseOver', function (client) {
    		clip.setText('<?php echo $url;?>');
    	});

    	clip.addEventListener('complete', function (client, text) {
    		document.getElementById('a_cptxt').className = '';
    		alert('游戏地址（'+text+'）已复制，您可以在QQ、MSN、邮箱或论坛上直接粘贴，向朋友推荐本游戏！');
    	});
    	clip.glue( 'a_cptxt', 'clip_container' );
    }

    init_cpswf();
  </script>
 <!-- 用于加载js代码 -->
</body>
</html>