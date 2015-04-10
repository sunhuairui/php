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
.codeBoxTop {width:100%; padding:10px 11px 20px;}
.codeBoxTop .codeshow{width:100%; display:block; background:#FFF;padding:10px;margin-bottom:35px;cursor:pointer;}
.codeBoxTop img{width: 201px!important;height: 201px!important;border:none;margin:0;/*margin: 5px auto 15px auto;border: 10px solid #fff;*/}
.codeBoxTop h5 {color:#FFF;}
.codeBoxTop a {margin:0;width:107px;cursor:pointer;display:block;float:left;}
.codeBoxTop a.codeBoxTryBtn {margin: 0 5px 0 0;}
.creatS{padding-top:36px;background:none; }
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
 <div class="modal fade" id="create_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-body">
                    <form action="" class="comForm creatS">
                        <div>
                          <p style="border-top:#099bee solid 1px;width:100%;height:1px;position:relative;top: 14px;"></p>
                          <h2 style="display:inline-block;width: 131px;background-color:#fff;position:relative;bottom: 14px;color:#099bee">创建场景</h2>  
                        </div>
                        <div>
                            <input  type="text" placeholder="输入场景名称" class="inp login_email" id="addtitle"/>
                        </div>
                        <div>
                            <select class="inp category" id="addcategory">
                                <option value="">给场景分类</option>
                                <?php if(is_array($categorys)): $i = 0; $__LIST__ = $categorys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val['id']); ?>"><?php echo ($val['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                           </select>
                        </div>
                           <input type="hidden" value="" id="addname">
                           <input type="hidden" value="" id="addurl">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">确定</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        </div>
                    </form>
                </div> 
            </div> 
        </div> 
    </div>
  <div class="crumb" id="activehtml">
    <a href="#" id="activehtml">模板库</a>  / 全部模板
  </div>
  <ul class="tag">
    <li class="active"><a onclick="setList(1,'','','','', this);">全部模板</a></li>
    <li><a onclick="setList(1,'','',1,'', this);">最新模板</a></li>
    <li><a onclick="setList(1,'','','',1, this);">最热模板</a></li>
    <li><a>应用情景</a>
     <ul class="subTag">
        <?php if(is_array($categorys)): $i = 0; $__LIST__ = $categorys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$varlcat): $mod = ($i % 2 );++$i;?><li><a onclick="setList(1,<?php echo ($varlcat['id']); ?>,'','','',this);"><?php echo ($varlcat['name']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </li>
    <li><a>热门标签</a>
      <ul class="subTag">
      <?php if(is_array($tags)): $i = 0; $__LIST__ = $tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tags): $mod = ($i % 2 );++$i;?><li><a onclick="setList(1,'',<?php echo ($tags['id']); ?>,'','',this);"><?php echo ($tags['name']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </li>
  </ul>
  <ul class="main">
   <?php if(is_array($templates)): $i = 0; $__LIST__ = $templates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$template): $mod = ($i % 2 );++$i;?><li>
      <div class="topB">
        <img  src="<?php echo (get_production_cover_url($template["icon_url"])); ?>" alt="200x200">
        <span></span>
        <em>采用次数：<?php echo ($template["used_times"]); ?></em>
      </div>
      <h3><?php echo ($template["title"]); ?></h3>
      <p><?php echo ($template["desc"]); ?></p>
      <div class="codeBox"></div>
      <div class="codeBoxTop">
        <div class="codeshow" value="<?php echo ($template[codeurl]); ?>"></div>
        <div style="clear:both;">
	        <a href="<?php echo U('demo', 'name='.$template[name]);?>" class="codeBoxTryBtn">试玩一下</a>
	        <a value="<?php echo U('project/create', 'name='.$template[name]);?>"  name ="<?php echo ($template[name]); ?>" data-toggle="modal" data-target="#create_add"  class="create" >开始制作</a>
        </div>
      </div>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>
  </ul>
  <?php if(!empty($is_more)): ?><a class="more" style="cursor:pointer" onclick="sList()">查看更多...</a><?php endif; ?>
</div>
 <input type="hidden" id="s_page" value="2">
 <input type="hidden" id="s_cate" value="">
 <input type="hidden" id="s_tag" value="">
 <input type="hidden" id="s_new" value="">
 <input type="hidden" id="s_hot" value="">

 
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
    
<script>
  function setList(page,s_cate,s_tag,s_new,s_hot,el){
      console.log(el);
      console.log($(el).parent().closest("li")[0]);
      $("#s_page").val(page);
      $("#s_cate").val(s_cate);
      $("#s_tag").val(s_tag);
      $("#s_new").val(s_new);
      $("#s_hot").val(s_hot);
      sList();
  }

  function  sList(){
       var page=$("#s_page").val();
       var s_cate=$("#s_cate").val();
       var s_tag=$("#s_tag").val();
       var s_new= $("#s_new").val();
       var s_hot=$("#s_hot").val();
	   var pagei=parseInt(page)+parseInt(1);
          $("#s_page").val(pagei);
        $.ajax({
               url: '<?php echo U("template_ajax");?>',
               type: "POST",
               dataType:"json",
               data:{page:page,s_cate:s_cate,s_tag:s_tag,s_new:s_new,s_hot:s_hot},
               success: function(d) {
                var apphtml ='';
                if(page<=1){
                  $(".main").html('');
                }
                var num=0;
                if(d.data!=null){
                    $.each(d.data, function(){
                         apphtml+= '<li><div class="topB"><img  src="'+this.imgurl+'" alt="200x200"><span></span><em>采用次数：'+this.used_times+'</em></div>';
                         apphtml+= '<h3>'+this.title+'</h3><p>'+this.desc+'</p>';
                         apphtml+='<div class="codeBox"></div><div class="codeBoxTop">'; 
                         //apphtml+='<h5>点击或扫描二维码进行试玩</h5>';
                         apphtml+='<span class="codeshow" value="'+this.codeurl+'"></span>';
                         apphtml+='<div style="clear:both;"><a href="'+this.sw+'" class="codeBoxTryBtn">试玩一下</a><a value="'+this.create+'" name ="'+this.name+'" data-toggle="modal" data-target="#create_add"  class="create">开始制作</a></div></div></li>';    
                         num++;
                     });
                 }

                $(".main").append(apphtml);
                if (d.ispage > 0) {
                    $(".more").remove();
                 } else {
                    $(".more").html('查看更多...'); 
                }
                bootstart();
              }
           });   
  }

  function bootstart(){
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