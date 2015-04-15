<?php if (!defined('THINK_PATH')) exit();?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>编辑项目表</title>
    <link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css" media="all">
   <link rel="stylesheet" type="text/css" href="/Public/Admin/css/default_color.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/jquery.mousewheel.js"></script>
    <!--<![endif]-->
    
</head>
<body>
    <!-- 头部 -->
    <div class="header">
        <!-- Logo -->
        <span class="logo"> 赢销+</span>
        <!-- /Logo -->
        <!-- 主导航 -->
        <ul class="main-nav">
            <li class=""><a href="/admin.php?s=/Index/index.html">首页</a></li><li class=""><a href="/admin.php?s=/Config/group.html">系统</a></li><li class=""><a href="/admin.php?s=/Article/mydocument.html">内容</a></li><li class=""><a href="/admin.php?s=/User/index.html">用户</a></li><li class=""><a href="/admin.php?s=/Project/index.html">项目</a></li><li class=""><a href="/admin.php?s=/Template/index.html">模板</a></li><li class=""><a href="/admin.php?s=/Statistics/index.html">数据统计</a></li>        </ul>
        <!-- /主导航 -->
        <!-- 用户栏 -->
        <div class="user-bar">
            <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li class="manager">你好，<em title="spcent">spcent</em></li>
                <li><a href="/admin.php?s=/User/updatePassword.html">修改密码</a></li>
                <li><a href="/admin.php?s=/User/updateNickname.html">修改昵称</a></li>
                <li><a href="/admin.php?s=/Public/logout.html">退出</a></li>
            </ul>
        </div>
    </div>
    <!-- /头部 -->
    <!-- 边栏 -->
    <div class="sidebar">
        <!-- 子导航 -->
        
            <div id="subnav" class="subnav">
                                            </div>
        
        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->
    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
                        <!-- nav -->
            
            
<script type="text/javascript" src="/Public/static/uploadify/jquery.uploadify.min.js"></script>
    <div class="main-title cf">
        <h2>编辑 [项目表]</h2>
    </div>
    <!-- 标签页导航 -->
<div class="tab-wrap">
    <ul class="tab-nav nav">
         <li data-tab="tab1" class="current"><a href="javascript:void(0);">基础</a></li>    </ul>
    <div class="tab-content">
    <!-- 表单 -->
    <form id="form" action="/admin.php?s=/Project/edit/model/103.html" method="post" class="form-horizontal">
        <!-- 基础文档模型 -->
      <div id="tab1" class="tab-pane in tab1">
            <div class="form-item cf">
                    <label class="item-label">名称<span class="check-tips">（项目英文名称）</span></label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="name" value="mali">                    </div>
                </div><div class="form-item cf">
                    <label class="item-label">中文名称<span class="check-tips">（中文名称）</span></label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="title" value=" ">                    </div>
                </div><div class="form-item cf">
                    <label class="item-label">项目简介<span class="check-tips"></span></label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="desc" value="向经典致敬，一款手速类型的游戏，通过替换金币图片来进行产品展示。">                    </div>
                </div><div class="form-item cf">
                    <label class="item-label">修改时间<span class="check-tips">（修改时间）</span></label>
                    <div class="controls">
                        <input type="text" name="modify_time" class="text input-mid time" value="1970-01-01 08:00" placeholder="请选择时间" />                    </div>
                </div><div class="form-item cf">
                    <label class="item-label">状态<span class="check-tips">（状态）</span></label>
                    <div class="controls">
                        <select name="status">
                                    <option value="0" selected>下线</option><option value="1" >未发布</option><option value="2" >发布</option>                                </select>                    </div>
                </div><div class="form-item cf">
                    <label class="item-label">项目icon<span class="check-tips">（项目icon）</span></label>
                    <div class="controls">
                        <div class="controls">
                           <input type="file" id="upload_picture_icon_url">
                           <input type="hidden" name="icon_url" id="cover_id_icon_url" value="869"/>
                           <div class="upload-img-box">
                           <div class="upload-pre-item"><img src="/Uploads/Picture/2015-03-26/5513afdf04d5f.png"/></div>                           </div>
                        </div>
                        <script type="text/javascript">
                        //上传图片
                         /* 初始化上传插件 */
                        $("#upload_picture_icon_url").uploadify({
                             "height"          : 30,
                             "swf"             : "/Public/static/uploadify/uploadify.swf",
                             "fileObjName"     : "download",
                             "buttonText"      : "上传图片",
                             "uploader"        : "/admin.php?s=/File/uploadPicture/session_id/88rkot7dbnco3i77q6j4jbub01.html",
                             "width"           : 120,
                             'removeTimeout'   : 1,
                             'fileTypeExts'    : '*.jpg; *.png; *.gif;',
                             "onUploadSuccess" : uploadPictureicon_url,
                                    'onFallback' : function() {
                                        alert('未检测到兼容版本的Flash.');
                                    }
                         });
                        function uploadPictureicon_url(file, data){
                           var data = $.parseJSON(data);
                           var src = '';
                             if(data.status){
                              $("#cover_id_icon_url").val(data.id);
                              src = data.url || '' + data.path;
                              $("#cover_id_icon_url").parent().find('.upload-img-box').html(
                                 '<div class="upload-pre-item"><img src="' + src + '"/></div>'
                              );
                             } else {
                              updateAlert(data.info);
                              setTimeout(function(){
                                     $('#top-alert').find('button').click();
                                     $(that).removeClass('disabled').prop('disabled',false);
                                 },1500);
                             }
                         }
                        </script>                    </div>
                </div><div class="form-item cf">
                    <label class="item-label">是否是自定义项目<span class="check-tips">（是否是自定义项目）</span></label>
                    <div class="controls">
                        <select name="is_diy">
                                    <option value="0" selected>不是</option><option value="1" >是</option>                                </select>                    </div>
                </div><div class="form-item cf">
                    <label class="item-label">环境<span class="check-tips">（0测试，1线上，2开发）</span></label>
                    <div class="controls">
                        <select name="env">
                                    <option value="0" >测试</option><option value="1" selected>线上</option><option value="2" >开发</option>                                </select>                    </div>
                </div><div class="form-item cf">
                    <label class="item-label">行业分类<span class="check-tips"></span></label>
                    <div class="controls">
                        <select name="category">
                                    <option value="0" >无</option><option value="1" >快消品</option><option value="2" >互联网</option><option value="3" >建筑、加工、制造</option><option value="4" >文化、体育、娱乐</option><option value="5" >餐饮</option>                                </select>                    </div>
                </div><div class="form-item cf">
                    <label class="item-label">是否推荐到用户案例<span class="check-tips">（0表示推荐，1表示推荐）</span></label>
                    <div class="controls">
                        <select name="is_recommend">
                                    <option value="0" selected> 否</option><option value="1" > 是</option>                                </select>                    </div>
                </div>        </div>

        <div class="form-item cf">
            <input type="hidden" name="id" value="132504">
            <button class="btn submit-btn ajax-post hidden" id="submit" type="submit" target-form="form-horizontal">确 定</button>
            <a class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</a>
        </div>
    </form>
    </div>
</div>

        </div>
        <div class="cont-ft">
            <div class="copyright">
                <div><a href="http://www.9ria.com" target="_blank">9RIA蜂群工作室</a>出品</div>
            </div>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "", //当前网站地址
            "APP"    : "/admin.php?s=", //当前项目地址
            "PUBLIC" : "/Public", //项目公共目录地址
            "DEEP"   : "/", //PATHINFO分割符
            "MODEL"  : ["3", "", "html"],
            "VAR"    : ["m", "c", "a"]
        }
    })();
    </script>
    <script type="text/javascript" src="/Public/static/think.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
            $subnav.find("a[href='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

           /* 表单获取焦点变色 */
           $("form").on("focus", "input", function(){
              $(this).addClass('focus');
           }).on("blur","input",function(){
                    $(this).removeClass('focus');
                 });
          $("form").on("focus", "textarea", function(){
             $(this).closest('label').addClass('focus');
          }).on("blur","textarea",function(){
             $(this).closest('label').removeClass('focus');
          });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
    </script>
    
<link href="/Public/static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
<link href="/Public/static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript">
$('#submit').click(function(){
    $('#form').submit();
});

$(function(){
   $('.time').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language:"zh-CN",
        minView:2,
        autoclose:true
    });
    $('.date').datetimepicker({
        format: 'yyyy-mm-dd',
        language:"zh-CN",
        minView:2,
        autoclose:true
    });
    showTab();
});
</script>

</body>
</html>