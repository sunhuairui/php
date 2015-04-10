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
     <ul class="leftMenu" style="top:13px">
       <li class="active">账户资料<span class="triangle fr" style="display:block">▲</span><span class="triangleShadow" style="display:block"></span></li>
       <li><a href="<?php echo U('resetpwd');?>">修改密码</a></li>
     </ul>
     <div class="accountInfo" style="display:block">
       <div class="line">
        <h3 class="WhiteGray">将账户资料补充完整</h3> 
       </div>
       <ul class="accountForm">
         <li> 
          <label for="comName">企业名称</label>
          <input type="text" name="username" id="comName" value="<?php echo ($info["username"]); ?>" class="">
         </li>
          <li> 
          <span>主要品牌</span>
          <input type="text" name="brand_name" id="" value="<?php echo ($info["brand_name"]); ?>" class="">
         </li>
         <li>
          <span>联系电话</span>
          <input type="number" name="mobile" id="" value="<?php echo ($info["mobile"]); ?>" class="">
         </li>
         <li>
          <span>联系人</span>
          <input type="text" name="contact" id="" value="<?php echo ($info["contact"]); ?>" class="">
         </li>
         <li>
          <span>公司所在地</span>
          <select name="city" id="">
            <option value="0">请选择</option>
            <option value="1">北京市</option>
            <option value="2">天津市</option>
            <option value="3">上海市</option>
            <option value="4">重庆市</option>
            <option value="5">河北省</option>
            <option value="6">山西省</option>
            <option value="7">辽宁省</option>
            <option value="8">吉林省</option>
            <option value="9">黑龙江省</option>
            <option value="10">江苏省</option>
            <option value="11">浙江省</option>
            <option value="12">安徽省</option>
            <option value="13">福建省</option>
            <option value="14">江西省</option>
            <option value="15">山东省</option>
            <option value="16">河南省</option>
            <option value="17">湖北省</option>
            <option value="18">湖南省</option>
            <option value="19">广东省</option>
            <option value="20">海南省</option>
            <option value="21">四川省</option>
            <option value="22">贵州省</option>
            <option value="23">云南省</option>
            <option value="24">陕西省</option>
            <option value="25">甘肃省</option>
            <option value="26">青海省</option>
            <option value="27">西藏自治区</option>
            <option value="28">广西壮族自治区</option>
            <option value="29">内蒙古自治区</option>
            <option value="30">宁夏回族自治区</option>
            <option value="31">新疆维吾尔自治区</option>
            <option value="32">香港特别行政区</option>
            <option value="33">澳门地区</option>
            <option value="33">台湾省</option>
          </select>
         </li>
         <li>
          <span>公司年营业额</span>
          <select name="turnover" id="">
            <option value="0">请选择</option>
            <option value="1">10亿元以上</option>
            <option value="2">1亿元~10亿元</option>
            <option value="3">1000万元~1亿元</option>
            <option value="4">1000万元以下</option>
          </select>
         </li>
         <li>
          <span>所属行业</span>
          <select name="category" id="">
            <option value="0">请选择</option>
            <option value="1">广告/营销/公关</option>
            <option value="2">互联网</option>
            <option value="3">汽车</option>
            <option value="4">电子产品</option>
            <option value="5">建筑/地产</option>
            <option value="6">教育/金融/保险</option>
            <option value="7">传媒/娱乐</option>
            <option value="8">旅游/交通</option>
            <option value="9">其他</option>
          </select>
         </li>
         <li>
          <span>主要产品</span>
          <input type="text" name="production" id="" value="<?php echo ($info["production"]); ?>" class="">
         </li>
         <li>
          <span>QQ</span>
          <input type="text" name="qq" id="" value="<?php echo ($info["qq"]); ?>" class="">
         </li>
         <li>
          <span>微信</span>
          <input type="text" name="wechat" id="" value="<?php echo ($info["wechat"]); ?>" class="">
         </li>
         <li>
          <span>目标客户</span>
          <input type="text" name="customer" id="" value="<?php echo ($info["customer"]); ?>" class="">
         </li>
         <li>
          <span style="position:relative;bottom:30px">备注</span>
          <textarea style="height:50px" class="remark"><?php echo ($info["remarks"]); ?></textarea>
         </li>
       </ul>
       <p class="btnBlue savebtn" style="width:170px;margin:0 auto;position:relative;right:96px;font-size:18px">保存修改</p>
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
        var posturl = "<?php echo U('User/updateaccountinfo');?>"
        var info = {};
            info.category = "<?php echo ($info["category"]); ?>" || 0;
            info.city = "<?php echo ($info["city"]); ?>" || 0;
            info.turnover = "<?php echo ($info["turnover"]); ?>" || 0;
    $(function(){
        $("select[name=category]").val(info.category);
        $("select[name=city]").val(info.city);
        $("select[name=turnover]").val(info.turnover);

        $(".savebtn").click(function(e){
            //validate
            var data = {};
                data.username = $("input[name=username]").val();
                if(!data.username){
                    _errDlg("企业名称不能为空");
                    return;
                }

                data.brand_name = $("input[name=brand_name]").val();
                if(!data.brand_name){
                    _errDlg("主要品牌不能为空");
                    return;
                }

                data.mobile = $("input[name=mobile]").val();
                if(!data.mobile){
                    _errDlg("联系电话不能为空");
                    return;
                }

                data.contact = $("input[name=contact]").val();
                if(!data.contact){
                    _errDlg("联系人不能为空");
                    return;
                }

                data.city = $("select[name=city]").val();
                data.turnover = $("select[name=turnover]").val();
                data.category = $("select[name=category]").val();

                data.production = $("input[name=production]").val();
                if(!data.production){
                    _errDlg("主要产品不能为空");
                    return;
                }

                data.qq = $("input[name=qq]").val();
                data.wechat = $("input[name=wechat]").val();
                data.customer = $("input[name=customer]").val();
                data.remarks = $("textarea").val();

                $.post(posturl, data, function(res){
                    $(".ajaxmsg").html(res.message);
                });

        });
    });
    </script>
 <!-- 用于加载js代码 -->
</body>
</html>