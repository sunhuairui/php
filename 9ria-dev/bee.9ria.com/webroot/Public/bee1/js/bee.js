var _errDlg = function(msg, title){
  if(typeof(errordlg) == 'object')errordlg.remove();
  errordlg = $('<div class="modal fade" id="registdlg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\
    <div class="modal-dialog">\
      <div class="modal-content">\
        <div class="modal-header">\
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
          <h4 class="modal-title" id="myModalLabel">'+(title || '提示')+'</h4>\
        </div>\
        <div class="modal-body">\
          <p>'+(msg || '')+'&hellip;</p>\
        </div>\
      </div>\
    </div>\
  </div>');
  $("body").append(errordlg);
  errordlg.modal('show');
}


// 浏览器定位滚动
var _scroll = function(el){
    $("html,body").animate({scrollTop:el.offset().top-100},"slow");
};


function AutoResizeImage(maxWidth,maxHeight,srcwidth,srcheight){ 
    var hRatio; 
    var wRatio; 
    var Ratio = 1; 
    var w = srcwidth; 
    var h = srcheight; 
    wRatio = maxWidth/w; 
    hRatio = maxHeight/h; 
    if (maxWidth == 0 && maxHeight == 0) { 
        Ratio = 1; 
    } else if (maxWidth == 0) {
        if (hRatio < 1) {Ratio = hRatio;} 
    } else if (maxHeight == 0) { 
        if (wRatio < 1){Ratio = wRatio;} 
    } else if (wRatio < 1 || hRatio < 1) { 
        Ratio = (wRatio<=hRatio?wRatio:hRatio); 
    } 
    if (Ratio<1) { 
        w = w * Ratio; 
        h = h * Ratio; 
    } 

    var left=(160-w)/2;
    var top=(160-h)/2;
    return 'width:'+w+'px; height:'+h+'px;left:'+left+'px;top:'+top+'px;';
}

var bee = bee || {};

    bee.dialog = bee.dialog || {};
    
    //bee.dialog.confirm("title","description",{"确定":{"primary":true,func:function(){console.log('success')}},"取消":{"primary":false,"func":function(){console.log('false')}}})
    bee.dialog.confirm = function(title, msg, btns){
    if(typeof(confirmdlg) == 'object')confirmdlg.remove();
    confirmdlg = $('<div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\
            <div class="modal-dialog">\
                <div class="modal-content">\
                    <div class="modal-body">\
                       <h3>'+title+'</h3>\
                       '+msg+'\
                    </div>\
                    <div class="btns modal-footer">\
                    </div>\
                </div>\
            </div>\
        </div>');
    var btn_el = "";
    for(key in btns){
        if(btns[key].primary){
            btn_el +='<button type="button" class="btn btn-primary">'+key+'</button>';
        }else{
            console.log(confirmdlg.find(".btns")[0]);
            btn_el += '<button type="button" class="btn btn-default">'+key+'</button>';
        }
    }
    console.log(btn_el);
    confirmdlg.find(".btns").append(btn_el);
    $("body").append(confirmdlg);
    confirmdlg.modal('show');

    confirmdlg.on("click", "button", function(e){
        btns[$(e.target).html()].func();
        confirmdlg.modal("hide");
    });


}

bee.createdlg = function(container, selector, callback){
	var dlg_elment = $('<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\
		<div class="modal-dialog">\
			<div class="modal-content">\
				<div class="modal-body">\
					<form action="" class="comForm">\
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">关闭</span></button>\
						<div>\
							<input class="inp" type="text" placeholder="登录邮箱" />\
						</div>\
						<div>\
							<input class="inp" type="tel" placeholder="请输入你的密码" />\
						</div>\
						<div>\
							<div class="rpw fl"><input type="checkbox" id="checkbox" name="remember" /> 记住密码</div>\
							<a href=" " class="fpw fr">忘记密码</a>\
						</div>\
						<a class="btnCom btnLogin" value="">登录</a>\
						<a class="btnCom btnLogin" value="">注册</a>\
					</form>\
				</div>\
			</div>\
		</div>\
	</div>');
	$("body").append(dlg_elment);
}

bee.login = function(el, success, error){
    if(typeof(el) == 'object'){
        var dlg_elment = el;
    }else{
    	var dlg_elment = $('<div class="modal fade" id="logindlg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\
    		<div class="modal-dialog">\
    			<div class="modal-content">\
    				<div class="modal-body">\
    					<form action="" class="comForm">\
    						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">关闭</span></button>\
    						<div>\
    							<input class="inp login_email" type="text" placeholder="登录邮箱" />\
    						</div>\
    						<div>\
    							<input class="inp login_passwd" type="password" placeholder="请输入你的密码" />\
    						</div>\
    						<div>\
    							<a href="#" class="rpw fl"><input type="checkbox" id="checkbox" name="remember" /> 记住密码</a>\
    						</div>\
    						<a class="btnCom btnLogin loginbtn" value="">登录</a>\
    					</form>\
    					<div class="ajaxmsg"><span></span></div>\
    				</div>\
    			</div>\
    		</div>\
    	</div>');
        // <a href="#" class="fpw fr">忘记密码</a>\
		//<a class="btnCom registerbtn" value="">注册</a>\
    	if($("body").find("#logindlg").length == 0){
    		$("body").append(dlg_elment);
    	}
    	$(dlg_elment).modal('show');
    }
    $('#logindlg').keydown(function(e){
        if(e.keyCode == 13){
            bee.ajaxlogin(dlg_elment,success,error);
        }
    })
	$(dlg_elment).find(".loginbtn").click(function(){
		bee.ajaxlogin(dlg_elment,success,error);
	});
	$(dlg_elment).find(".registerbtn").click(function(){
		dlg_elment.modal('hide');
		bee.regist();
	});
};

bee.ajaxlogin = function(dlg_elment,success,error){
    var username = $(dlg_elment).find('.login_email').val();
    var password = $(dlg_elment).find('.login_passwd').val();
    var remember = $(dlg_elment).find('input[name="remember"]').val();
    if(username != '' && password != ''){
        $.post('/index.php?s=/Home/User/ajaxlogin.html',{username:username,password:password, remember:remember},function(res){
            if(res.status){
                //登录成功
                if(success){
                    success(res);
                }else{
                    setTimeout(function(){
                        location.reload();
                    },100);
                }
            }else{
                //失败
                if(error){
                    error(res);
                }
            }
            $(dlg_elment).find(".ajaxmsg span").html(res.info);
        });
    }else{
        if(username == ''){
            $(dlg_elment).find(".ajaxmsg span").html('注册邮箱不能为空');
        }else{
            $(dlg_elment).find(".ajaxmsg span").html('请输入密码');
        }
    }
}

bee.regist = function(){
    var cates = ["广告/营销/公关","互联网","汽车","电子产品","建筑/地产","教育/金融/保险","传媒/娱乐","旅游/交通","其他"];
	var dlg_elment = $('<div class="modal fade" id="registdlg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\
		<div class="modal-dialog">\
			<div class="modal-content">\
				<div class="modal-body">\
					<form action="" class="comForm">\
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">关闭</span></button>\
						<div>\
							<input class="inp regist_email" type="text" placeholder="注册邮箱" />\
						</div>\
						<div>\
							<input class="inp regist_passwd" type="password" placeholder="请输入你的密码" />\
						</div>\
						<div>\
							<input class="inp regist_name" type="text" placeholder="企业名称" />\
						</div>\
						<div>\
							<input class="inp regist_title" type="text" placeholder="品牌名称" />\
						</div>\
						<div>\
							<input class="inp regist_phone" type="text" placeholder="手机号码" />\
						</div>\
						<div>\
							<select class="inp regist_cate">\
                            </select>\
						</div>\
						<a class="btnCom btnLogin registcombtn" value="">提交</a>\
					</form>\
					<div class="ajaxmsg"><span></span></div>\
				</div>\
			</div>\
		</div>\
	</div>');
    
    for (var i = 0; i < cates.length; i++) {
        options += '<option value="'+(i+1)+'">'+cates[i]+'</option>';
    };
    dlg_elment.find('.regist_cate').html(options);

    if($("body").find("#registdlg").length == 0){
        var options = '';
		$("body").append(dlg_elment);
	}
	$(dlg_elment).modal('show');
    var errmsg = dlg_elment.find('.ajaxmsg');
	$(dlg_elment).find('.registcombtn').click(function(){
        var email = dlg_elment.find('.regist_email').val();
        var password = dlg_elment.find('.regist_passwd').val();
        var name = dlg_elment.find('.regist_name').val();
        var title = dlg_elment.find('.regist_title').val();
        var phone = dlg_elment.find('.regist_phone').val();
        var cate = dlg_elment.find('.regist_cate').val();   
        if(!bee.checkEmail(email)){
            errmsg.html('请输入正确的邮箱!');
            return;
        }

        password = password.toString();
        if(password.length <6 || password.length>16){
            errmsg.html('密码必须存在，长度为6~16位，区分大小写');
            return;
        }else{
            errmsg.html('');
        }

        name = name.toString();
        if(name.length < 4 ) {
            errmsg.html('企业名称必须存在，且长度不小于6位');
            return;   
        }else{
            errmsg.html('');
        }

        title = title.toString();
        if(title.length < 1 ) {
            errmsg.html('品牌名称不能为空');
            return;
        } else {
            errmsg.html('');
        }

        if(!bee.checkPhone(phone)){
            errmsg.html('手机号码输入错误');
            return;
        }
    

        $.post('/index.php?s=/Home/User/ajaxregister.html',{username:name,password:password,email:email,brand_name:title,mobile:phone,category:cate},function(res){
            if(res.status){
                //登录成功
                setTimeout(function(){
                    location.reload();
                },1000);
            }
            errmsg.html(res.info);
        });
	});
}

bee.logout = function(){
    if(is_login){
        $.post("/index.php?s=/Home/User/ajaxlogout.html", {}, function(res){
            location.reload();
        });
    }
}

bee.checkEmail = function(str){
    var Expression=/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; 
    var objExp=new RegExp(Expression);
    if(objExp.test(str)==true){
        return true;
    } else {
        return false;
    }
}

bee.checkPhone = function(number){
    if(number.match(/^1[358]\d{9}$/)){
        return true;
    }
    return false;
}

bee.replacepanel = function(el){
    var position = $(el).offset();
    var widowW = $(window).width();
    var disPop = widowW - position.left;
    // console.log(disPop);
    bee.replacetabs({top:position.top+100,left:position.left+100});
    var type = $(el).attr('action-type');
    if(type == 'IMAGE'){
        var size = el.find('.fblue').html();
        var filename = el.attr('action-data');
        var templateVarName = el.attr("name");
        bee.replacetabs.dlg.append('<div class="popover-title">\
                <ul class="nav nav-tabs">\
                  <li role="presentation" class="tabs active" action-data="uploader" style="height:42px;border:none;overflow:hidden"><a href="javascript:;style="display:inline-block;height:42px;font-weight:bold;">上传</a></li>\
                </ul>\
            </div>\
            <div class="popover-content">\
                <form name="app_file_upload" method="post" target="app_file_proxy" enctype="multipart/form-data">\
                    <div class="popcont fileInputContainer upload" style="margin:auto;display:block;"><em class="f16"><i class="icoDownload"></i>点击上传</em><input id="fileupload" type="file" name="files[]" data-url="'+gamecreator.uploadurl + '&filename=' + filename+'" class="fileInput" multiple></div>\
                </form>\
                <div style="text-align:center;margin-top:30px;" class="f12">推荐使用.png格式图片，推荐尺寸'+size+'</div>\
            </div>');
        $('#fileupload').fileupload({
            dataType: 'text',
            add : function(e, data){
                var jqXHR = data.submit().error(function (jqXHR, textStatus, errorThrown){
                    _errDlg("上传文件超时...");
                    $(document).trigger('bee.removepopover');
                    return;

                }).success(function(result, textStatus, jqXHR){
                    if(uploadtimelistener) clearTimeout(uploadtimelistener);
                    if(result) {
                        var result = JSON.parse(result);
                        if (!result.code) {
                            el.find('.imgbox').css('background-image', 'url(\'/Public/gamecreator/app/'+gamecreator.app_id+'/'+ result.data.filename +'?t='+ new Date().getTime() +'\')');
                            el.attr({"action-data": result.data.filename});
                            if(filename == result.data.filename){
                                //替换
                                $(document).trigger("bee.reloadgame");
                                $(document).trigger('bee.removepopover');
                            }else{
                                // 新建图片
                                gamecreator.tmpsdata.templateVars[templateVarName] && gamecreator.tmpsdata.templateVars[templateVarName].texUrl ?  gamecreator.tmpsdata.templateVars[templateVarName].texUrl = result.data.filename : null;
                                bee.write_file('template.json', gamecreator.tmpsdata, function(res){
                                    $(document).trigger("bee.reloadgame");
                                    $(document).trigger('bee.removepopover');
                                });
                            }
                        }else{
                            $(document).trigger('bee.removepopover');
                            _errDlg(result.msg);
                            return;
                        }
                    }
                });
                var uploadtimelistener = setTimeout(function(){
                        jqXHR.abort();
                },10000);
            },
            progressall: function (e, data) {
                bee.replacetabs.dlg.find(".popover-content").html('<div style="width:50px;height:50px;margin:auto;"><img style="width:50px;height:50px;" src="/Public/bee1/images/loading.gif"></div>');
            }
        });
    }else if(type == 'STRING'){
        var title = el.attr('title');
        var name = el.attr('action-name'); 
        var key = el.attr('action-data');
        bee.replacetabs.dlg.append('<div class="popover-title">\
                <ul class="nav nav-tabs">\
                  <li role="presentation" class="tabs active" action-data="uploader" style="border:none;height:42px;"><a href="javascript:;" style="display:inline-block;height:42px">'+ name +'</a></li>\
                </ul>\
            </div>\
            <div class="popover-content">\
                <p class="word-tips">温馨提示:为了保证展现效果，请按照默认格式填写内容</p>\
                <textarea class="content"  style="width:80%;padding:0 5px;min-height:60px;line-height:30px;resize:none"  type="text" title="'+ title +'">'+title+'</textarea>\
                <input type="submit" value="提交" style="background:#099bee;color:#fff;border:none;height:30px;line-height:23px;float:right;margin-right:15px;"></submit>\
                <div class="errormsg" style="color:red;"></div>\
            </div>');
        bee.replacetabs.dlg.find("input[type=submit]").click(function(){
            var val = $.trim(bee.replacetabs.dlg.find("textarea.content").val());

            if(val == ""){
                bee.replacetabs.dlg.find(".errormsg").html("输入内容不能为空");
                return;
            }

            if(gamecreator.tmpsdata.templateVars[key] && val != "" && gamecreator.tmpsdata.templateVars[key].value!=val){
                gamecreator.tmpsdata.templateVars[key].value=val;
                bee.write_file('template.json', gamecreator.tmpsdata, function(res){
                    $(document).trigger("bee.reloadgame");
                    $(document).trigger('bee.removepopover');
                    el.find('.strbox').text(val);
                    el.attr({title:val});
                }, function(res){
                });
            }
        });
    }else if(type == 'AUDIO'){
        /**背景音乐**/ 
       var size = "1M";/**el.attr('name');**/
       var filename = el.attr('action-data');
       bee.replacetabs.dlg.append('<div class="popover-title">\
                <ul class="nav nav-tabs">\
                  <li role="presentation" class="tabs active" action-data="uploader" style="height:42px;border:none;overflow:hidden"><a href="javascript:;style="display:inline-block;height:42px;font-weight:bold;">上传</a></li>\
                </ul>\
            </div>\
            <div class="popover-content">\
                <form name="app_file_upload" method="post" target="app_file_proxy" enctype="multipart/form-data">\
                    <div class="popcont fileInputContainer upload" style="margin:auto;display:block;"><em class="f16"><i class="icoDownload"></i>点击上传</em><input id="musicupload" type="file" name="music" data-url="'+'/index.php?s=Home/editor/uploadMusic/appid/' + gamecreator.app_id + '&filename=' + filename+'" class="fileInput" multiple></div>\
                </form>\
                <div style="text-align:center;margin-top:30px;" class="f12">推荐使用.mp3格式音频，推荐大小' +size+ '</div>\
            </div>');
        $('#musicupload').fileupload({
            dataType: 'text',
            add : function(e, data){
                var jqXHR = data.submit().error(function (jqXHR, textStatus, errorThrown){
                    _errDlg("上传文件超时...");
                    $(document).trigger('bee.removepopover');
                    return;
                }).success(function(result, textStatus, jqXHR){
                    if(uploadtimelistener) clearTimeout(uploadtimelistener);
                    console.log('upload success');
                   /** alert('成功啦');**/
                    if(result){
                        var result = JSON.parse(result);
                        if(result.success){
                            $(document).trigger("bee.reloadgame");
                            $(document).trigger('bee.removepopover'); 
                            _errDlg("上传成功");
                        }else{
                            $(document).trigger('bee.removepopover');
                            _errDlg(result.msg);
                            return;
                        }
                    }


                });
                var uploadtimelistener = setTimeout(function(){
                        jqXHR.abort();
                },10000);
            } 
        });
    }else{

    }

}

bee.replacetabs = function(position){
    if(bee.replacetabs.dlg){bee.replacetabs.dlg.remove();}
    bee.replacetabs.dlg = $('<div class="popover fade bottom in" role="tooltip" style="max-width:none;width:400px;"><div class="arrow" style="left: 10%;"></div>\
        </div>');
    $("body").append(bee.replacetabs.dlg);
    bee.replacetabs.dlg.css(position);
    bee.replacetabs.dlg.click(function(e){
        //console.log('bee.replacetabs.dlg click');
        e.stopPropagation();
    });
}

bee.get_template = function(app_id, fn) {
    var get_template_url = '/index.php?s=Home/editor/gamesetting/appid/' + app_id;
    $.get(get_template_url, {}, function(d) {
        fn && fn(d);
    });
};

bee.write_file = function(filename, data, fn, err_fn) {
    var write_file_url = '/index.php?s=Home/editor/write/appid/' + gamecreator.app_id + '/filename/' + escape(filename);
    $.post(write_file_url, {'filedata':JSON.stringify(data)}, function(d) {
        d = d || {};
        if (d.success) {
            fn && fn(d);
        } else {
            err_fn && err_fn(typeof d=='object' ? d : {error:d});
        }
    });
};

/***************************************************/
bee._errDlg = function(msg, title){
  if(typeof(errordlg) == 'object')errordlg.remove();
  errordlg = $('<div class="modal fade" id="registdlg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\
    <div class="modal-dialog">\
      <div class="modal-content">\
        <div class="modal-header">\
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
          <h4 class="modal-title" id="myModalLabel">'+(title || '提示')+'</h4>\
        </div>\
        <div class="modal-body">\
          <p>'+(msg || '')+'&hellip;</p>\
        </div>\
      </div>\
    </div>\
  </div>');
  $("body").append(errordlg);
  errordlg.modal('show');
  return;
}

function checkBroswer()
{
    var agent = navigator.userAgent.toLowerCase() ;

    var regStr_ie = /msie [\d.]+;/gi ;
    var regStr_ff = /firefox\/[\d.]+/gi
    var regStr_chrome = /chrome\/[\d.]+/gi ;
    var regStr_saf = /safari\/[\d.]+/gi ;
    //IE
    if(agent.indexOf("msie") > 0)
    {
        var str = agent.match(regStr_ie) ;
        if(str){
            if(str.toString().match(/\d/)[0] <= 8){
                return false;
            }else{
                return true;
            }
        }
    }
    return true;

}


bee.previewgame = function(el, appid){
    $(document).bind("bee.reloadgame", function(event){
        if(checkbroswer){
            $(el).html('<iframe id="preview_proxy"  style="margin-left:-23px;border:none" class="frame" sandbox="allow-scripts allow-same-origin" name="preview_proxy" style="border:none;" src="'+'/app/proxy/' + new Date().getTime() + "/" + appid + '/?openid=otuWJjvQKhb9nn1xL8v-IRrgxct8"></iframe>')
            // $("#preview_proxy").attr({src:"/app/proxy/" + new Date().getTime() + "/" + gamecreator.app_id + "/?openid=otuWJjvQKhb9nn1xL8v-IRrgxct8"});
        }
    });
    $(document).trigger('bee.reloadgame');
}


var alertFallback = false;
if (typeof console === "undefined" || typeof console.log === "undefined") {
 console = {};
 if (alertFallback) {
     console.log = function(msg) {
          alert(msg);
     };
 } else {
     console.log = function() {};
 }
}
/**
 * @desc 系统消息前台显示
 * @auth changzhengfei
 * @time 2015/04/15
 * **/
bee.message = function(title,message){
  messagedlg = $('<div class="modal fade" id="registdlg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\
   <div class="modal-dialog">\
     <div class="modal-content">\
        <div class="modal-header">\
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>\
            <h3 id="myModalLabel">'+(title || '消息提示')+'</h3>\
        </div>\
        <div class="modal-body content">'+(message || '&hellip;')+'</div>\
        <div class="modal-footer" style="text-align:center">\
            <button class="btn" data-dismiss="modal" aria-hidden="true">朕知道了</button>\
        </div>\
     </div>\
   </div>\
</div>');
  $("body").append(messagedlg);
  messagedlg.modal('show');
  return;
}