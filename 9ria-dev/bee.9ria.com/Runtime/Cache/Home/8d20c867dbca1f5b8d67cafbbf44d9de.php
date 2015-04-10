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


/*券号管理05/03/02*/
.couponCon{float:left;width: 85%;margin-left: 40px/*border: #ccc solid 1px*/}
.couponCon input[type=text]{width: 60%;height: 30px;padding:0 40px;background-color:#eeeeee;border: #b4b4b4 solid 1px;font-size: 16px;color: #8d8d8d }
.couponCon input[type=button]{background-color: #099bee;color: #fff;border: none;width: 133px;height: 30px;font-size: 16px;margin-left: 15px}
.couponCon .dataTable{margin-top:30px; width:100%;}
.nav-tabs>li>a:hover{border: none!important;}
.fBlue{color: #099bee!important}
.fGreen{color: #54b811!important}
ul.bGray{border: none;}
ul.bGray li{background-color: #eeeeee!important;margin-top:1px!important;color: #8d8d8d!important}
ul.bGray li.active{background-color: #099bee!important;color: #fff!important}
ul.bGray li:hover{background-color: #099bee!important;color: #fff!important}

/*兑换管理05/03/02*/
.exchangeCon input[type=text]{width: 896px;height: 30px;padding:0 40px;background-color:#eeeeee;border: #b4b4b4 solid 1px;font-size: 16px;color: #8d8d8d }
.exchangeCon input[type=button]{background-color: #099bee;color: #fff;border: none;width: 133px;height: 30px;font-size: 16px;margin-left: 15px}
.dataTabs li.active a{height: 43px;}

/*报名信息*/
.fRed{color: #f35a5b!important}
.formInfo .selectBox{font-size: 16px;margin-top: 15px}
.formInfo .selectBox ul{display: inline-block;vertical-align: bottom;}
.formInfo .selectBox ul li,.selectBox ul li.active{float: left;background: url(/Public/bee1/images/sprite.png) no-repeat;padding-left: 28px;margin-right: 35px;}
.formInfo .selectBox ul li{background-position: 0 -1816px;}
.formInfo .selectBox ul li.active{background-position: 0 -1842px;}
.formInfo .txtInp{width: 70%;margin-top: 20px;padding:2px 10px;height: 40px;line-height: 40px;background-color: #eeeeee;border: #dadada;}
.formInfo .btnBlue{border: none;}
.formInfo .exportInfo{float:right;background: url(/Public/bee1/images/sprite.png) no-repeat;background-position: 0 -1877px;padding-left: 22px;color: #099bee;cursor: pointer;text-decoration: underline;}
.formInfo table{margin-top:30px;}
.formInfo table td,.formInfo table th{border: #dadada solid 1px;text-align: center;width: 210px;height:50px;padding: 12px 25px}
.formInfo table th{color: #5e5e5e;font-size: 16px;}
.formInfo table td{font-size: 14px;color: #b4b4b4}

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
        <div class="overView clearfix">
            <img src="<?php echo ($game["icon_url"]); ?>" alt="<?php echo ($game["title"]); ?>" />
            <div class="fl">
                <h2><?php echo ($game["title"]); ?><span><?php echo ($game["status_name"]); ?></span></h2>
                <ul class="introList clearfix">
                    <li style="text-align:left;width:155px;padding-left:0"><?php echo ($game["appcount"]["pv"]); ?><span><i class="icoView"></i>浏览量</span></li>
                    <li><?php echo ($game["appcount"]["uv"]); ?><span><i class="icoVistor"></i>访客数</span></li>
                    <li><?php echo ($game["appcount"]["sc"]); ?><span><i class="icoZ"></i>转发量</span></li>
                    <li class="borderN"><?php echo ($game["appcount"]["fr"]); ?><span><i class="icoSharecount"></i>转发率</span></li>
                </ul>
            </div>
        </div>
        
        <!-- 我的数据 -->
        <ul class="nav nav-tabs dataTabs" role="tablist" id="myTab">
            <li role="presentation" class="active"><a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">项目概览</a></li>
            <?php if($prizeType == 'raffle'): ?><li role="presentation"><a href="#lottery" aria-controls="lottery" role="tab" data-toggle="tab">中奖信息</a></li>
            <li role="presentation"><a href="#userdata" aria-controls="userdata" role="tab" data-toggle="tab">用户数据</a></li><?php endif; ?>
            <?php if($prizeType == 'coupon'): ?><li role="presentation"><a href="#coupon" aria-controls="coupon" role="tab" data-toggle="tab">券号管理</a></li>
            <li role="presentation"><a href="#exchange" aria-controls="exchange" role="tab" data-toggle="tab">礼物兑换</a></li><?php endif; ?>
            <?php if($prizeType == 'rankdata'): ?><li role="presentation"><a href="#rankdata" aria-controls="rankdata" role="tab" data-toggle="tab">排行榜详情</a></li><?php endif; ?>
            <?php if($prizeType == 'baoming'): ?><li role="presentation"><a href="#baoming" aria-controls="baoming" role="tab" data-toggle="tab">报名信息</a></li><?php endif; ?>
        </ul>
        
        <div class="myData mb60">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="overview">
                    <div class="chart">
	                    <div class="fl home_tab" id="overviewTab">
	                        <ul>
	                            <li class="active" aria-controls="today" role="tab" data-toggle="tab">今 日</li>
	                            <li aria-controls="yesterday" role="tab" data-toggle="tab">昨 日</li>
	                            <li aria-controls="week" role="tab" data-toggle="tab">一周</li>
	                            <li aria-controls="month" role="tab" data-toggle="tab">30天</li>
	                        </ul>
	                    </div>
	                    <div class="tab-content1 fr">
                            <div class="chart tab-pane1 active" id="chartZx"></div>
                            <div class="chart2 tab-pane1 active" id="chartLd"></div>
	                    </div>
	                    <div style="clear:both;"></div>
	                </div>
                </div>
                <div role="tabpanel" class="tab-pane formInfo" id="lottery"><div class="chart"></div></div>
                <div role="tabpanel" class="tab-pane formInfo" id="userdata"><div class="chart"></div></div>
                <div role="tabpanel" class="tab-pane" id="coupon">
                    <div class="chart">
                        <div class="fl home_tab" id="couponTab">
                            <ul class="bGray">
                                <li class="active" aria-controls="all" role="tab" data-toggle="tab">全部券号</li>
                                <li aria-controls="unexchange" role="tab" data-toggle="tab">剩余券号</li>
                                <li aria-controls="exchanged" role="tab" data-toggle="tab">已兑换</li>
                                <li aria-controls="receive" role="tab" data-toggle="tab">已发出</li>
                            </ul>
                        </div>
                        <div class="couponCon">
                            <input type="text" value="输入需要搜索的券号" class="txtInp searchInp">
                            <input type="button" value="搜索" class="searchBtn">
                            <div id="couponTable"></div>
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="exchange">
                    <div class="chart">
	                    <div class="exchangeCon">
	                       <input type="text" value="输入需要兑换的礼品券号" class="txtInp searchInp">
	                       <input type="button" value="兑换" class="searchBtn">
	                    </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane formInfo" id="baoming">
                    <div class="baomingCon">
                        <p style="margin-bottom：20px">报名人数：98977</p>
	                    <input type="text" value="输入需要搜索的报名信息(性别、生日、序号除外)" class="txtInp searchInp">
	                    <input type="button" value="搜索" class="btnBlue searchBtn">
	                </div>
                    <div class="selectBox">
                        <span>单页显示条数：</span>
                        <ul class="btn-group" role="group">
                            <li role="tab" data-toggle="tab" aria-controls="1">1</li>
                            <li role="tab" data-toggle="tab" aria-controls="2" class="active">2</li>
                            <li role="tab" data-toggle="tab" aria-controls="3">3</li>
                        </ul>
                        <span><a href="<?php echo U('Export/registerInfo',array('appid'=>$game[appid]));?>" class="exportInfo" id="exportRegisterInfo">导出所有报名信息</a></span>
                    </div>
                    <div id="baomingTable"></div>
                </div>
                <div role="tabpanel" class="tab-pane" id="rankdata"><div class="chart"></div></div>
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
    
<script type="text/javascript" src="/Public/static/echarts/js/echarts.js"></script>
<!-- <script type="text/javascript" src="/Public/static/echarts/theme.js"></script>  -->
<script>
    


    $(function() {
    	$('.chart').height(''); 
		var getLotterys = function (target) {
			$.get(target, function(data) {
                if(data.status == 1) {
                    var apphtml = '';
                    if(data.info.lotterys != '') {
                        apphtml = '<div class ="overF"><a href="<?php echo U('Export/lotterys',array('appid'=>$game[appid]));?>" class="exportInfo" id="exportLotterys">导出所有中奖信息</a></div>';
                    }
                    apphtml += '<table class="dataTable"><tbody>';
                    apphtml += '<tr><th>奖项</th><th>中奖用户昵称</th><th>联系方式</th><th>中奖时间</th></tr>';
                    if(data.info.lotterys != '') {
                        $.each(data.info.lotterys, function() {
                            var lot_name = this.lot_name != null ? this.lot_name : '未知礼物';
                            apphtml += '<tr><td>'+ lot_name +'</td><td>'+ this.nickname +'</td>';
                            apphtml += '<td>'+ (this.tel ? this.tel : '-') +'</td><td>'+ this.create_time +'</td></tr>';
                        });
                    } else {
                    	apphtml += '<tr><td colspan="4">没有查询结果</td></tr>';
                    }
                    
                    apphtml += '</tbody></table>';
                    
                    if(data.info.pages != '') {
                        apphtml += '<div class="pages">'+ data.info.pages +'</div>';
                    }
                    
                    $("#lottery div.chart").html(apphtml);
                    
                    $(".pages a").click(function(){
                        var targetUrl = $(this).attr("href");
                        getLotterys(targetUrl);
                        return false;
                    });
                }
            });
		}

		
		var getGamedatas = function (target) {
            $.get(target, function(data) {
                if(data.status == 1) {
                    var apphtml = '';
                    if(data.info.gamedatas != '') {
                        apphtml = '<div class ="overF"><a href="<?php echo U('Export/userinfo',array('appid'=>$game[appid]));?>" class="exportInfo" id="exportUser">导出所有用户数据</a></div>';
                    }
                    apphtml += '<table class="dataTable"><tbody>';
                    apphtml += '<tr><th>用户昵称</th><th>通讯地址</th><th>联系方式</th></tr>';
                    if(data.info.gamedatas != '') {
                        $.each(data.info.gamedatas, function() {
                            apphtml += '<tr><td>'+ this.nickname +'</td><td>'+ (this.addr ? this.addr : '-') +'</td>';
                            apphtml += '<td>'+ (this.tel ? this.tel : '-') +'</td></tr>';
                        });
                    } else {
                    	apphtml += '<tr><td colspan="3">没有查询结果</td></tr>';
                    }
                    
                    apphtml += '</tbody></table>';
                    
                    if(data.info.pages != '') {
                        apphtml += '<div class="pages">'+ data.info.pages +'</div>';
                    }
                    
                    $("#userdata div.chart").html(apphtml);
                    
                    $(".pages a").click(function(){
                        var targetUrl = $(this).attr("href");
                        getGamedatas(targetUrl);
                        return false;
                    });
                }
            });
        }
	    
		var getCoupons = function (target, params) {
			var params = arguments[1] ? arguments[1] : new Array();
			var type = params['type'] ? params['type'] : 'all';
			var code = params['code'] ? params['code'] : '';
			
			$.get(target, {type: type, code: code}, function(data) {
                if(data.status == 1) {
                	 var apphtml = '';
                         if(data.info.coupondatas != '') {
                             apphtml = '<div class ="overF formInfo"><a href="<?php echo U('Export/coupon',array('appid'=>$game[appid]));?>" class="exportInfo" id="exportCoupon">导出所有礼券信息</a></div>';
                         }
                             apphtml += '<table class="dataTable"><tbody>';
                	if('unexchange' != data.info.type) {
                		apphtml += '<tr><th>礼券名称</th><th>礼券券号</th><th>中奖用户名称</th><th>中奖时间</th><th>礼券状态</th></tr>';
                	} else apphtml += '<tr><th>礼券名称</th><th>礼券券号</th><th>礼券状态</th></tr>';
                    
                    if(data.info.coupondatas != '') {
                        $.each(data.info.coupondatas, function() {
                        	var gcStatuName = '未发出';
                        	var gcClass = '';
                        	if(this.status == 3) {
                        		gcStatuName = '已发出';
                        		gcClass = 'fBlue';
                        	} else if(this.status == 1) {
                        		gcStatuName = '已兑换';
                                gcClass = 'fGreen';
                        	}
                        	
                        	apphtml += '<tr><td>'+ this.lot_name +'</td>';
                        	apphtml += '<td>'+ this.gamecode +'</td>';
                        	
                        	if('unexchange' != data.info.type) {
                        		apphtml += '<td>'+ (this.nickname ? this.nickname : '-') +'</td>';
                        		apphtml += '<td>'+ (this.create_time ? this.create_time : '-') +'</td>';
                        	}
                            apphtml += '<td class="'+ gcClass +'">'+ gcStatuName +'</td></tr>';
                        });
                    } else {
                    	if(code != '') alert('您输入的券号有误，请确认后重新输入！');
                    	if('unexchange' != data.info.type) {
                    		apphtml += '<tr><td colspan="5">没有查询结果</td></tr>';
                    	} else {
                    		apphtml += '<tr><td colspan="3">没有查询结果</td></tr>';
                    	}
                    }
                    
                    apphtml += '</tbody></table>';
                    
                    if(data.info.pages != '') {
                        apphtml += '<div class="pages">'+ data.info.pages +'</div>';
                    }
                    
                    $("#couponTable").html(apphtml);
                    
                    $(".pages a").click(function(){
                        var targetUrl = $(this).attr("href");
                        getCoupons(targetUrl, params);
                        return false;
                    });
                }
			});
		}
		
		var curCouponTypeTab = 'all';
        var CouponTypeInit = function () {
            $('#couponTab li').click(function() {
                var tagCouponTypeTab = $(this).attr("aria-controls");
                var txtInpObj= $('.couponCon .searchInp').eq(0);
                var txtInpVal = txtInpObj.val();
                
                if(curCouponTypeTab != tagCouponTypeTab || ('输入需要搜索的券号' != txtInpVal && '' != txtInpVal)) {
                    $(this).tab('show');
                    txtInpObj.val('输入需要搜索的券号');
                    var target = "<?php echo U('statCoupon',array('appid'=>$game[appid], 'p'=>1));?>";
                    //target = target.replace('/p/1.html','/type/'+ tagCouponTypeTab + '/p/1.html');
                    var params = new Array();
                    params['type'] = tagCouponTypeTab;
                    getCoupons(target, params);
                    
                    curCouponTypeTab = tagCouponTypeTab;
                }
                
                return false;
            });
        }
        CouponTypeInit();
        
        var getRankdatas = function (target) {
            $.get(target, function(data) {
                if(data.status == 1) {
                    var apphtml = '';
                    if(data.info.rankdatas != '') {
                        apphtml = '<div class ="overF"><a href="<?php echo U('Export/rankdatas',array('appid'=>$game[appid]));?>" class="exportInfo" id="exportRankdatas">导出所有排行信息</a></div>';
                    }
                    apphtml += '<table class="dataTable"><tbody>';
                    apphtml += '<tr><th>奖项</th><th>排行</th><th>用户昵称</th></tr>';
                    if(data.info.rankdatas != '') {
                        $.each(data.info.rankdatas, function() {
                            apphtml += '<tr><td>'+ this.lot_desc +'</td><td>'+ this.rank_id +'</td>';
                            apphtml += '<td>'+ this.nickname +'</td></tr>';
                        });
                    } else {
                    	apphtml += '<tr><td colspan="3">没有查询结果</td></tr>';
                    }
                    
                    apphtml += '</tbody></table>';
                    
                    if(data.info.pages != '') {
                        apphtml += '<div class="pages">'+ data.info.pages +'</div>';
                    }
                    
                    $("#rankdata div.chart").html(apphtml);
                    
                    $(".pages a").click(function(){
                        var targetUrl = $(this).attr("href");
                        getRankdatas(targetUrl);
                        return false;
                    });
                }
            });
        }
        
        var getFormdatas = function (target, params) {
            var params = arguments[1] ? arguments[1] : new Array();
            var code = params['code'] ? params['code'] : '';
            var row = params['row'] ? params['row'] : curRow;
            
            $.get(target, {code: code, list_row: row},function(data) {
                if(data.status == 1) {
                	if(data.info.formTotal != '') {
                		$(".baomingCon p").html('报名人数：'+ data.info.formTotal);
                	}
                	
                	var apphtml = '<table><tbody>';
                	var colCount = 0;
                	var formItemArrs = new Array(); 
                	if(data.info.formItems != '') {
                		apphtml += '<tr><th>序号</th>';
                        $.each(data.info.formItems, function() {
                        	 apphtml += '<th>'+ this.label +'</th>';
                        	 formItemArrs[colCount] = this.name;
                        	 colCount++;
                        });
                        apphtml += '</tr>';
                        
                        if(data.info.formDatas != '') {
                        	var indexLen = 1;
                            $.each(data.info.formDatas, function() {
                                var formItem = this;
                                apphtml += '<tr><td>'+ indexLen +'</td>';
                                for(var i=0;i<colCount;i++) {
                                	var itemName = formItemArrs[i];
                                	var itemStr = '';
                                	if(itemName == 'sex') {
                                		itemStr = formItem['sex'] == 1 ? '<span class="fBlue">男</span>' : '<span class="fRed">女</span>';
                                	} /*else if(itemName == 'birthday') {
                                		itemStr = formItem['birthday'] == 1 ? '男' : '女';
                                	} */else {
                                		itemStr = formItem[itemName] ? formItem[itemName] : '' ;
                                	}
                                	apphtml += '<td>'+ itemStr +'</td>';
                                }
                                apphtml += '</tr>';
                                indexLen++;
                            });
                        } else {
                            apphtml += '<tr><td colspan="'+ colCount +'">没有查询结果</td></tr>';
                        }
                        
                    } else {
                        apphtml += '<th>--</th>';
                    }
                    
                    apphtml += '</tbody></table>';
                    
                    if(data.info.pages != '') {
                        apphtml += '<div class="pages">'+ data.info.pages +'</div>';
                    }
                    
                    $("#baomingTable").html(apphtml);
                    
                    $(".pages a").click(function(){
                        var targetUrl = $(this).attr("href");
                        getFormdatas(targetUrl, params);
                        return false;
                    });
                }
            });
        }
        
	    var refreshCharts = function (option) {
	    	if(typeof option != 'object') option = {};
	    	
	    	/*-echarts begin-*/
	        var myChartZx,myChartLd;
	        var domchartZx = document.getElementById('chartZx');
	        var domchartLd = document.getElementById('chartLd');
	        var echarts;
	        var curTheme = {};
	        
		    if (myChartZx && myChartZx.dispose) {
		    	myChartZx.dispose();
		    }
		    
		    if (myChartLd && myChartLd.dispose) {
                myChartLd.dispose();
            }
		    
		    require.config({paths: {echarts: './Public/static/echarts/js'}});
	        require([
	                'echarts',
	                'Public/static/echarts/theme',
	                'echarts/chart/line',
	                'echarts/chart/funnel'
	            ],
	            function (ec, curTheme) {
	                echarts = ec;
	                var curZxOptionExt = option.chartZx;
	                var curldOptionExt = option.chartLd;
	                
	                //chartZx
	                myChartZx = echarts.init(domchartZx, curTheme);
	                window.onresize = myChartZx.resize;
	                var curZxOption = {};
	                var baseZxOption = {
                        tooltip : {
                            trigger: 'axis',
                            formatter : function (params) {
                                var colorList = ['#44B7D3','#F4E24E','#8AED35'];
                                var inxCol = 0;
                                var inxName = '';
                                
                                var totalValue = curZxOptionExt.total;
                                //console.log(totalValue);
                                var rate = 0;
                                
                                var tabId = 0;
                                var re = /^[0-9]+.?[0-9]*$/;
                                if (!re.test(params[0].name)) inxName = params[0].name;
                                else {
                                	tabId = parseInt(params[0].name);
                                	inxName = tabId==0 ? ('22:59 - 23:59') : ((tabId-1) +':59-'+ tabId +':59');
                                }
                                var res = inxName + ' <div style="width:100px;border-top:1px solid #CCC;height:5px;"></div><div><table>';
                                for (var i = 0, l = params.length; i < l; i++) {
                                	inxCol = params[i].seriesIndex;
                                	rate = params[i].value * 100 / totalValue[i];
                                	rate = isNaN(rate)? 0 : (parseInt(rate)==rate) ? rate : rate.toFixed(2);
                                    res += '<tr style="color:' + colorList[inxCol] + ';font-size:14px;"><td>' + params[i].seriesName;
                                    res += ' : ' + params[i].value + '</td><td style="width:20px;"></td><td>';
                                    res += '占比：'+ rate +'% </td></tr>';
                                }
                                res += '</table></div>';
                                return res;
                            }
                        },
                        legend: {data:['浏览量','访客数','转发数']},
                        xAxis : [],
                        yAxis : [],
                        series : []
                    };
	                
	                curZxOption = baseZxOption;
	                
	                if(option.chartZx.xAxis) curZxOption.xAxis = curZxOptionExt.xAxis;
	                if(option.chartZx.yAxis) curZxOption.yAxis = curZxOptionExt.yAxis;
	                if(option.chartZx.series) curZxOption.series = curZxOptionExt.series;
	                
	                myChartZx.setOption(curZxOption, true);
	                
	                //chartLd
	                myChartLd = echarts.init(domchartLd, curTheme);
                    window.onresize = myChartLd.resize;
                    var curLdOption = {};
                    var baseLdOption = {
                    		title : {},
                    		color: ['#44B7D3','#8AED35'],
                    	    tooltip : {
                    	        trigger: 'item',
                    	        formatter: "{b} : {c}"
                    	    },
                    	    //legend: {data:['浏览量','转发数','转发率']},
                    	    legend: {data:['浏览量','转发数']},
                    	    series : []
                    };
                    
                    curLdOption = baseLdOption;
                    
                    if(option.chartLd.title) curLdOption.title = curldOptionExt.title;
                    if(option.chartLd.series) curLdOption.series = [curldOptionExt.series];
                    
                    myChartLd.setOption(curLdOption, true);
	                
	            }
	        );
		}
		
	    var todayOption = <?php echo ($curOption); ?>;
	    var curOption = {};
	    
        refreshCharts(todayOption);
        
		/*-echarts end-*/
		var changeChartOption = function(period) {
			var target = "<?php echo U('statDetail',array('appid'=>$game[appid]));?>";
			$.post(target, {period: period}, function(data) {
                if(data.status == 1) {
                	if(data.info != null) {
                		curOption = data.info;
                		refreshCharts(curOption);
                		return false;
                    }
                	return false;
                }
            });
			return false;
		}
		
		var curHomeTab = 'today';
		var homeTabInit = function () {
			$('#overviewTab li').click(function() {
	            var tagHomeTab = $(this).attr("aria-controls");
	            if(curHomeTab != tagHomeTab) {
	            	$(this).tab('show');
	            	if(tagHomeTab != 'today') {
	                    changeChartOption(tagHomeTab);
	                } else {
	                    refreshCharts(todayOption);
	                }
	            	
	            	curHomeTab = tagHomeTab;
	            }
	            
	            return false;
	        });
		}
		
		homeTabInit();
		
		// 我的数据选项卡
		var curTab = 'overview';
		//$('#myTab a').eq(0).tab('show');
		$('#myTab a').click(function (e) {
			e.preventDefault();
			var tagTab = $(this).attr('aria-controls');
			if(curTab != tagTab) {
			    $(this).tab('show');
			    if(tagTab == 'lottery') {
		            var target = "<?php echo U('statLottery',array('appid'=>$game[appid],'p'=>1));?>";
		            getLotterys(target);
			    } else if(tagTab == 'userdata') {
			    	var target = "<?php echo U('statUserdata',array('appid'=>$game[appid],'p'=>1));?>";
			    	getGamedatas(target);
			    } else if(tagTab == 'overview') {
			    	
			    } else if(tagTab == 'coupon') {
			    	var txtInpObj= $('.couponCon .searchInp').eq(0);
			    	var txtInpVal = txtInpObj.val();
		            if('输入需要搜索的券号' == txtInpVal) {
		            	//txtInpObj.val('输入需要搜索的券号');
		            	if('unexchange' != curCouponTypeTab) {
	                        var target = "<?php echo U('statCoupon',array('appid'=>$game[appid],'p'=>1));?>";
	                        var params = new Array();
	                        params['type'] = curCouponTypeTab;
	                        //target = target.replace('/p/1.html','/type/'+ curCouponTypeTab + '/p/1.html');
	                        getCoupons(target, params);
	                    }
		            }
			    	
			    } else if(tagTab == 'exchange') {
			    } else if(tagTab == 'rankdata') {
			    	var target = "<?php echo U('statRankdata',array('appid'=>$game[appid],'p'=>1));?>";
                    getRankdatas(target);
                } else if(tagTab == 'baoming') {
                    var target = "<?php echo U('statForm',array('appid'=>$game[appid],'p'=>1));?>";
                    var params = new Array();
                    getFormdatas(target, params);
                }
			    
			    curTab = tagTab;
			}
			return false;
		});
		
		//搜索
		$('.couponCon .searchInp').focus(function () {
			var txtInpObj= $(this);
			var txtInpVal = txtInpObj.val();
			if('输入需要搜索的券号' == txtInpVal) {
				txtInpObj.val('');
			}
		}).blur(function(){
			var txtInpObj= $(this);
            var txtInpVal = txtInpObj.val();
            if('' == txtInpVal) {
                txtInpObj.val('输入需要搜索的券号');
            }
		});
		
		$('.couponCon .searchBtn').click(function () {
            var txtInpObj= $('.couponCon .searchInp').eq(0);
            var txtInpVal = txtInpObj.val();
            if('输入需要搜索的券号' != txtInpVal && '' != txtInpVal) {
            	var target = "<?php echo U('statCoupon',array('appid'=>$game[appid],'p'=>1));?>";
            	//target = target.replace('/p/1.html','/code/'+ txtInpVal + '/p/1.html');
            	var params = new Array();
                params['code'] = txtInpVal;
                getCoupons(target, params);
            } else {
            	alert('请输入需要搜索的券号');
            }
        });
		
		$('.exchangeCon .searchInp').focus(function () {
            var txtInpObj= $(this);
            var txtInpVal = txtInpObj.val();
            if('输入需要兑换的礼品券号' == txtInpVal) {
                txtInpObj.val('');
            }
        }).blur(function(){
            var txtInpObj= $(this);
            var txtInpVal = txtInpObj.val();
            if('' == txtInpVal) {
                txtInpObj.val('输入需要兑换的礼品券号');
            }
        });
         
        $('.exchangeCon .searchBtn').click(function () {
            var txtInpObj= $('.exchangeCon .searchInp').eq(0);
            var txtInpVal = txtInpObj.val();
            if('输入需要兑换的礼品券号' != txtInpVal && '' != txtInpVal) {
                var target = "<?php echo U('changeCouponStatus',array('appid'=>$game[appid]));?>";
                target = target.replace('.html','/code/'+ txtInpVal + '.html');
                $.get(target, function(data) {
                    if(data.status == 1) {
                    	txtInpObj.val('输入需要兑换的礼品券号');
                    	alert('兑换成功！');
                    } else {
                    	alert('您输入的券号有误，请确认后重新输入！');
                    }
                });
            } else {
                alert('请输入需要兑换的礼品券号');
            }
        });
        
        $('.baomingCon .searchInp').focus(function () {
            var txtInpObj= $(this);
            var txtInpVal = txtInpObj.val();
            if('输入需要搜索的报名信息(性别、生日、序号除外)' == txtInpVal) {
                txtInpObj.val('');
            }
        }).blur(function(){
            var txtInpObj= $(this);
            var txtInpVal = txtInpObj.val();
            if('' == txtInpVal) {
                txtInpObj.val('输入需要搜索的报名信息(性别、生日、序号除外)');
            }
        });
        
        $('.baomingCon .searchBtn').click(function () {
        	var txtInpObj= $('.baomingCon .searchInp').eq(0);
            var txtInpVal = txtInpObj.val();
            if('输入需要搜索的报名信息(性别、生日、序号除外)' != txtInpVal && '' != txtInpVal) {
                var target = "<?php echo U('statForm',array('appid'=>$game[appid],'p'=>1));?>";
                var params = new Array();
                params['code'] = txtInpVal;
                getFormdatas(target, params);
            } else {
                alert('输入需要搜索的报名信息(性别、生日、序号除外)');
            }
        });
		
        var curRow = 2;
        $('.selectBox li').click(function (e) {
            e.preventDefault();
            var tarRow = $(this).attr('aria-controls');

            if(tarRow != curRow) {
            	var params = new Array();
                params['row'] = tarRow;
                
                var txtInpObj= $('.baomingCon .searchInp').eq(0);
                var txtInpVal = txtInpObj.val();
                if('输入需要搜索的报名信息(性别、生日、序号除外)' != txtInpVal && '' != txtInpVal) {
                    params['code'] = txtInpVal;
                }
                var target = "<?php echo U('statForm',array('appid'=>$game[appid],'p'=>1));?>";
                getFormdatas(target, params);
                curRow = tarRow;
            }
            
        }); 
    });
</script>
 <!-- 用于加载js代码 -->
</body>
</html>