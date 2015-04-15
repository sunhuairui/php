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
    <link rel="stylesheet" href="/Public/bee1/css/bootstrap.min.css" />
    <script href="/Public/bee1/js/ie-css3.htc"></script>
    
<link rel="stylesheet" href="/Public/bee1/css/main.css" />
<!--
<style>
.codeBoxTop {width:100%; padding:10px 11px 20px;}
.codeBoxTop .codeshow{width:100%; display:block; background:#FFF;padding:10px;margin-bottom:35px;cursor:pointer;}
.codeBoxTop img{width: 201px!important;height: 201px!important;border:none;margin:0;/*margin: 5px auto 15px auto;border: 10px solid #fff;*/}
.codeBoxTop h5 {color:#FFF;}
.codeBoxTop a {margin:0;width:107px;cursor:pointer;display:block;float:left;}
.codeBoxTop a.codeBoxTryBtn {margin: 0 5px 0 0;}
.creatS{padding-top:36px;background:none; }
</style>-->

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
<div class="headerTop">
  <nav class="navNew">
    <a href="<?php echo U('index/index');?>" class="logo"></a>
    <?php if(is_login()): ?><a class="<?php if($Think.CONTROLLER_NAME == 'Project') echo 'active';?>" href="<?php echo U('home/project/index');?>">我的项目</a>
    <a class="<?php if( $Think.CONTROLLER_NAME == 'Statistics') echo 'active';?>" href="<?php echo U('home/statistics/index');?>">我的数据</a><?php endif; ?>
    <a href="<?php echo U('home/case/index');?>" class="<?php if($Think.CONTROLLER_NAME == 'Case') echo 'active';?>">用户案例</a>
    <a href="<?php echo U('home/template/index');?>" class="<?php if($Think.CONTROLLER_NAME == 'Template') echo 'active';?>">模板库</a>
    <a href="<?php echo U('home/index/qa');?>" class="<?php if($Think.CONTROLLER_NAME == 'Index' && $Think.ACTION_NAME == 'qa') echo 'active';?>">帮助中心</a>
    <div class="loginInfo">
       <?php if(is_login()): ?><a href="<?php echo U('home/user/logout');?>" class="logout">退出</a>
        <a href="<?php echo U('User/accountinfo');?>" class="userName"><?php echo get_username();?></a> 
       <?php else: ?>
       <a href="#" data-toggle="modal" class="login">登录</a><?php endif; ?>
    </div>
  </nav>
</div>
 
<div class="wrapperNew"> 
  <div class="crumb" id="activehtml">
    <a href="#" id="activehtml">模板库</a>  / 全部模板
  </div>  
  <ul class="caseList">
   <?php if(is_array($cases)): $i = 0; $__LIST__ = $cases;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$case): $mod = ($i % 2 );++$i;?><li>
        <a href="<?php echo U('case_info','id='.$case['token']);?>">
            <img src="<?php echo (get_production_cover_url($case["icon_url"])); ?>" alt="">
        </a>
        <div class="imgBlock">
          <div class="opacityBg"></div>
          <div class="erCode"></div> 
          <div class="codeurl" value="<?php echo ($case[codeurl]); ?>"></div>       
        </div>
      
      <h3><?php echo ($case["title"]); ?><a href=""></a></h3>
      <p class="intro">作者：<?php echo ($case["username"]); ?></p>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>
  </ul>
  <?php if(!empty($is_more)): ?><a class="more" style="cursor:pointer" onclick="sList()">查看更多...</a><?php endif; ?>
</div>
 <input type="hidden" id="s_page" value="2">

 
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
    if(screenW > 1400) {
        $('.mainContainer').css('width','1345px');
        // $('ul.main li').css('margin-right','48px');
        $('a.more').css('width','1294px');
        $('.editorBox').css('width','840px');
    }

    // 手机预览位置固定
    $(window).on('scroll',function() {
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
        if(topH > h) {
            $('#goTop').fadeIn(200);
        } else {
            $('#goTop').fadeOut(200);
        }
    }

    b();
    $(window).scroll(function(e){
        b();    
    });

    $('#goTop').click(function(){
        $("html,body").animate({scrollTop:"0px"}, 200); 
    });

    // 反馈意见距离左边的距离
    if ($('ul.main').length > 0) {
        var goTopLeft = $('ul.main').offset().left + $('ul.main').width();
        $('#sugest').css('left',goTopLeft);
        $('#goTop').css('left',goTopLeft);
    }
    if ($('.mainContainer').length > 0) {
        var goTopLeft = $('.mainContainer').offset().left + $('.mainContainer').width();
        $('#sugest').css('left',goTopLeft);
        $('#goTop').css('left',goTopLeft);
    }

});
</script>

<script>
getCode();
// 案例展示二维码 
function getCode(){
   $('.caseList li h3 a').hover(function(){
	  var codeurl= $(this).parent().prev().find(".codeurl").attr("value");
	  var codeshow = $(this).parent().prev().find(".erCode");
	  if(codeshow.html() == ''){
		  var qrcode = new QRCode(codeshow[0], {
			   width : 180,
			   height : 180
		  }); 
		  qrcode.makeCode(codeurl);
	  }     
      $(this).parent().prev().fadeIn();             
	  }
      ,function(){
       $(this).parent().prev().fadeOut();

      }
    );
}
  function setList(page,el){
      console.log(el);
      console.log($(el).parent().closest("li")[0]);
      $("#s_page").val(page)
      sList();
  }

  function  sList(){
       var page=$("#s_page").val();
	   var pagei=parseInt(page)+parseInt(1);
          $("#s_page").val(pagei);
        $.ajax({
               url: '<?php echo U("case_ajax");?>',
               type: "POST",
               dataType:"json",
               data:{page:page},
               success: function(d) {
                var apphtml ='';
                if(page<=1){
                  $(".caseList").html('');
                }
                var num=0;
                if(d.data!=null){
                    $.each(d.data, function(){
                         apphtml+= '<li> <a href="'+this.sw+'"><img src="'+this.imgurl+'" width="200px" height="200px" alt=""></a>';
						 apphtml+= '<div class="imgBlock"><div class="opacityBg"></div><div class="erCode"></div>';
						 apphtml+= '<div class="codeurl" value="'+this.codeurl+'"></div></div>';
                         apphtml+= '<h3>'+this.title+'<a href=""></a></h3><p class="intro">作者：'+this.username+'</p></li>';
                         num++;
                     });
                 }

                $(".caseList").append(apphtml);
                if (d.ispage > 0) {
                    $(".more").remove();
                 } else {
                    $(".more").html('查看更多...'); 
                }
                getCode();
              }
           });   
  }

 /* function bootstart(){
      $(".main li").hover(function(){
    	  var target = $(this);
          var codeBox = target.find('.codeBox');
          var codeBoxTop = target.find('.codeBoxTop');
          var codeShow = codeBoxTop.find('.codeshow');
          var codeUrl = codeShow.attr('value');
          
          codeBox.show();
          codeBoxTop.show();
          
          var codeHtml = codeShow.html();
          if(codeHtml == '') {
              //异步加载
              var qrcode = new QRCode(codeShow[0], {
                  width : 201,
                  height : 201
              });
              
              qrcode.makeCode(codeUrl);
          }
      }, function() {
    	  var target = $(this);
          var codeBox = target.find('.codeBox');
          var codeBoxTop = target.find('.codeBoxTop');
          
          codeBox.hide();
          codeBoxTop.hide(); 
      });
      
      $(".create").click(function(){
          if (is_login == 0) {
              bee.login();
              $('#create_add').modal('hide');
              return false;
           }
          var name = $(this).attr('name');
          //var category = $(this).attr('category');
          $('#create_add').find("option").attr("selected",false);
          //$('#create_add').find("option[value="+category+"]").attr("selected",true);
          $("#addname").val(name);
         });
      }
*/
  $(function(){
    $("#addtitle").change(function() {
        var title = $("#addtitle").val();
        var target = '<?php echo U("project/checkName");?>';
        $.post(target, {name: title}, function(data) {
            if(data.success) {
                return true;
            } else {
                alert(data.error ? data.error : '校验场景名称失败');
                $("#addtitle").focus();
                return false;
            }
        });
    });
    $('ul.tag li a').mouseover(function(){
    $(this).siblings("ul").stop().slideDown();
  });
  
 
  $('ul.tag > li >a').click(function(){
      $('ul',this).stop().slideUp();
      $('ul.tag > li >a').removeClass('active');
      $(this).addClass('active');
      var text = $(this).text();
      $("#activehtml").html('<a href="#" >模板库</a> / '+text);
  });
  $('ul.subTag > li >a').click(function(){
	  $('ul.tag > li >a').removeClass('active');
	  $(this).parent().parent().siblings('a').addClass('active');
	  var text = $(this).text();
      $("#activehtml").html('<a href="#" >模板库</a> / '+text);
  });
  
  
  
  $('ul.tag li').mouseleave(function(){
    $('ul',this).stop().slideUp();
    // $(this).siblings("ul").hide();
   });

  bootstart();
  //登录弹框
  bee.createdlg($(".main"), $(".create"),function(){
      console.log('调用成功');
  });
  <?php  if(!empty($_GET['name'])){ ?>
   if(is_login==0){
       bee.login();
     return false;
   }else{
       $("#addname").val("<?php echo ($_GET['name']); ?>");
       $('#create_add').modal('show');
       
   }  
        
<?php }?>
 });
</script>
 <!-- 用于加载js代码 -->
</body>
</html>