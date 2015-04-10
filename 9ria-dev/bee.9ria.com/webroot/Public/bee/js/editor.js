(function($){
    var app_id = gamecreator.app_id;
    var IS_LOGIN = $('#sso_user > div').hasClass('m');
    
    var static_url = gamecreator.static_url + app_id + '/';
    var xhr = {};
    var tmpl = {};
    window.tmpl = tmpl;
    window.MI = {};
    window.UI = {};
    
UI.getX = function (a) {
    return a.getBoundingClientRect 
        ? a.getBoundingClientRect().left+UI.scrollX() 
        : (a.offsetParent?a.offsetLeft+UI.getX(a.offsetParent):a.offsetLeft) + ("fixed"==UI.C(a,"position")?UI.scrollX():0);
};

UI.scrollX = function (a) {
    var b=document.documentElement;
    if (a) {
        var c = a.parentNode, f = a.scrollLeft||0;
        a == b && (f=UI.scrollX());
        return c ? f + UI.scrollX(c) : f;
    }
    return self.pageXOffset || b&&b.scrollLeft || document.body.scrollLeft;
};

UI.scrollY = function (a) {
    var b=document.documentElement;
    if (a) {
        var c = a.parentNode,
            f = a.scrollTop||0;
    
        a == b && (f=UI.scrollY());
        return c ? f + UI.scrollY(c) : f;
    }
    
    return self.pageYOffset||b&&b.scrollTop||document.body.scrollTop;
};

UI.getY = function (a) {
	var res;
	if (a.getBoundingClientRect) {
		res = a.getBoundingClientRect().top + UI.scrollY();
	} else {
		res = (a.offsetParent ? a.offsetTop+UI.getY(a.offsetParent):a.offsetTop) + ("fixed"==UI.C(a,"position")?UI.scrollY():0)
	}
	return res;
};

UI.scrollTo = function (a,b,c) {
	if (a == document.documentElement || a == document.body) {
		return window.scrollTo(b, c);
	}
};
    
MI.string = {
cut: function (a, b, c) {
	var c = UI.isUndefined(c) ? "..." : c, e = [], f = "";
	if (MI.string.length(a) > b) {
        a = a.split("");
        UI.each(a, function(a) {
            if (b > 0) {
                e.push(a);
                b = b - MI.string.length(a);
            } else {
                return 1;
            }
        });
        f = e.join("") + c;
    } else {
        f = a;
    }  
    return f;
}
,entityReplace: function (a) {
    return String(a).replace(/&#38;?/g,"&amp;").replace(/&amp;/g,"&").replace(/&#(\d+);?/g,function(a,b){return String.fromCharCode(b)}).replace(/&lt;/g,"<").replace(/&gt;/g,">").replace(/&quot;/g,'"').replace(/&nbsp;/g," ").replace(/&#13;/g,"\n").replace(/(&#10;)|(&#x\w*;)/g,"").replace(/&amp;/g,"&")}
,escape: function (a) {
    return MI.string.html(a).replace(/'/g,"\\'");
}
,escapeReg: function (a) {
    var a=String(a);
    for(var b=[],c=0;c<a.length;c++) {
        var e=a.charAt(c);
        switch(e){
            case ".":
            case "$":
            case "^":
            case "{":
            case "[":
            case "(":
            case "|":
            case ")":
            case "*":
            case "+":
            case "?":
            case "\\":
                b.push("\\x"+e.charCodeAt(0).toString(16).toUpperCase());
                break;
            default:
                b.push(e);
        }
    }
    return b.join("");
}
,html: function (a) {
    var a = String(a).replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;"),
        b=a.replace(/\/\*(\s|.)*?\*\//g,"");

    b.match(/expression/g) && (a = b.replace(/expression/g, "expressio n"));
    return a;
}
,length: function (a) {
    var b=String(a||"").match(/[^\x00-\x80]/g);
    return a.length+(b?b.length:0);
}
,sprintf: function () {
    var a = arguments,
        b = a[0]||"",
        c,
        e;

    c = 1;
    for (e=a.length;c<e;c++) b=b.replace(/%s/,a[c]);
    return b;
}
,trim: function (a) {
    return String(a).replace(/(^\s*)|(\s*$)/g,"");
}
,checkURL: function (a) {
    var r = new RegExp('((news|telnet|nttp|file|http|ftp|https)://){1}(([-A-Za-z0-9]+(\\.[-A-Za-z0-9]+)*(\\.[-A-Za-z]{2,5}))|([0-9]{1,3}(\\.[0-9]{1,3}){3}))(:[0-9]*)?(/[-A-Za-z0-9_\\$\\.\\+\\!\\*\\(\\),;:@&=\\?/~\\#\\%]*)*','i');
    return r.test(a);
}
};

    if (!window.location.origin) {
      window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
    }

    tmpl.render = function() {
        var id = arguments[0], data, out = String(tmpl[id]);
        for (var i=1,j=arguments.length; i<j; i++) {
            data = arguments[i] || {};
            out = out.replace(/\{\{(\w+)\}\}/g, function(m, i) {
                return (data[i] == undefined) ? m : String(data[i]);
            });
        }
        return out;
    };
    
    xhr.request = function(url, data, fn, err_fn) {
        var d = data || {}, callback_fn = fn;
        if (arguments.length == 2) {
            d = {};
            callback_fn = data;//(typeof data == 'function') ? data : fn;
        }
		
        return $.ajax({
          type: 'POST',
          url: url,
          data: d,
          success: function(res) {
            callback_fn && callback_fn(res);
          },
          error: function() {
            err_fn && err_fn();
          }
        });
    };
    
    xhr.abort_request = function(){
        
    };
    
    xhr.try_catch = function(d, fn){
        fn && fn(d);
    };
    
    window.authdata = window.authdata || {};
    xhr.check_login = function(fn, err_fn) {
        // use jsonp
        var check_login_url = '/index.php?s=Home/Bee/checklogin';
        return $.ajax({
          type: 'POST',
          url: check_login_url,
          success: function(d) {
            try{
              eval(d);
              if (authdata == null) {
                err_fn({error:'no login'});
              } else {
                fn && fn(authdata);
              }
            } catch(e) {
                authdata = null; 
                err_fn({error:'no login'});
            }
          }
        });
    };
    
    xhr.get_template = function(fn) {
        var get_template_url = '/index.php?s=Home/Bee/gamesetting/appid/' + app_id;
        return xhr.request(get_template_url, {}, function(d) {
            fn && fn(d);
        }, function(){
            alert('模板数据读取错误，该游戏可能已经被删除或下架！');
        });
    };
    
    xhr.check_app_name = function(app_name, fn, err_fn){
        var check_app_name_url = '/index.php?s=Home/Bee/checkName/id/' + app_id 
                + '/name/' + encodeURIComponent(MI.string.trim(app_name));
        
        return xhr.request(check_app_name_url, {}, function(d) {
            d = d || {};
            if (d.success){
                fn && fn(d);
            }else{
                err_fn && err_fn(typeof d=='object' ? d : {error:d});
            }
        });
    };
    
    xhr.get_file = function(filename, fn, err_fn) { 
        return $.ajax({
          url: filename,
          beforeSend: function( xhr ) {
            xhr.overrideMimeType("text/plain;");
          }
        }).done(function(d) {
            fn && fn(String(d));
        }).fail(function(d) {
            err_fn && err_fn({error:'No file'});
        });
    };
    
    xhr.write_file = function(filename, data, fn, err_fn) {
        var write_file_url = '/index.php?s=Home/Bee/write/appid/' + app_id + '/filename/' + escape(filename);
        return xhr.request(write_file_url, {'filedata':data}, function(d) {
            d = d || {};
            if (d.success) {
                fn && fn(d);
            } else {
                err_fn && err_fn(typeof d=='object' ? d : {error:d});
            }
        });
    };
    
    xhr.upload = function(filename, fn, err_fn){
        var fm = document.forms['app_file_upload'],
            ifr = $('iframe[name="app_file_proxy"]')[0];
    
        var upload_url = '/index.php?s=Home/Bee/upload/appid/' + app_id + '&filename=' + filename;
        fm.action = upload_url;
        
        ifr.onload = function() {
            try {
                var d = JSON.parse(String(ifr.contentDocument.body.textContent));
                if (d.success) {
                    fn && fn(d);
                } else {
                    err_fn && err_fn(typeof d=='object' ? d : {error:d});
                }
            } catch(e) { 
                err_fn && err_fn({error:String('上传失败.')});
            }
        };
        fm.submit();
    };
    
    xhr.replace_res = function(filename, filename_from, fn, err_fn) {
        var replace_res_url = '/index.php?s=Home/Bee/replace/appid/' + app_id + '.html';
        return xhr.request(replace_res_url, {'res':filename, 'web':filename_from}, function(d) {
            d = d || {};
            if (d.success) {
                fn && fn(d);
            } else {
                err_fn && err_fn(typeof d=='object' ? d : {error:d});
            }
        });
    };
    
    xhr.get_app_libs = function(fn) {
        if (xhr.get_app_libs.html) {
            fn && fn(xhr.get_app_libs.html);
            return;
        }
        
        var get_app_libs_url = '/index.php?s=Home/Bee/libs/appid/' + app_id + '.html';
        return xhr.request(get_app_libs_url, function(d) {
            xhr.get_app_libs.html = [];
            xhr.get_app_libs.data = d;
            for (var i=0,j=d.length;i<j;i++){
                xhr.get_app_libs.html.push(tmpl.render(
                    'libs-item', 
                    {texUrl:location.origin + d[i]}, 
                    {name:i, staticUrl:''})
                );
            }
            
            xhr.get_app_libs.html = xhr.get_app_libs.html.join('');
            fn && fn(xhr.get_app_libs.html);
        });
    };
    
    xhr.get_app_files = function(fn){
        var get_app_files_url = '/index.php?s=Home/Bee/codelist/appid/' + app_id;
        return xhr.request(get_app_files_url, function(d){
            fn && fn(d);
        });
    };
    
    xhr.is_done_load_ace_script = false;
    xhr.load_ace_script = function(fn) {
        if (xhr.is_done_load_ace_script) {
            fn&&fn();
            return;
        }
        
        $.ajax({url: "http://cdnjs.cloudflare.com/ajax/libs/ace/1.1.3/ace.js",cache: true, dataType: "script",success: function(){
            $.ajax({url: "http://cdnjs.cloudflare.com/ajax/libs/ace/1.1.3/mode-javascript.js",cache: true, dataType: "script",success: function(){
                $.ajax({url: "http://cdnjs.cloudflare.com/ajax/libs/ace/1.1.3/theme-twilight.js",cache: true, dataType: "script",success: function(){
                    xhr.is_done_load_ace_script = true;
                    fn&&fn();
                }});
            }});
        }});
    };
    
    function get_tmpl() {
    
        function get_outter(dom){
            var b = document.createElement('div');
            b.appendChild(dom);
            return b.innerHTML;// '<div class="'+String(dom.className)+'">' + $(dom).html() + '</div>';
        }
        
        tmpl['libs-item'] = get_outter($('.ghost-tabs-ctn .list .libs-item')[0]);
        $('.ghost-tabs-ctn .list .item').remove();
        
        tmpl['upload-layer'] = get_outter($('.upload-layer')[0]);
        tmpl['text-layer'] = get_outter($('.text-layer')[0]);
        $('.modify-layer').remove();
        
        $('.modify .cate .list .item').each(function(){
            var key = String(this.className).replace('item-sm','').replace('item','').replace(/ /g,'');
            tmpl[key] = get_outter(this);
        });
        $('.modify .cate .list').html('');
    }
    
    function getDirectDataType(a) {
		if (typeof a == 'object') return 'object'; 
        
        a = $.trim(a);
		if (Number(a) == String(a)) {
			return 'number';
		} else if (String(a).length==7 && String(a).substr(0, 1) == '#') {
			return 'color';
		} else { 
			return 'string';
		}
	}
    

    
    
    $(document).ready(function() {
        get_tmpl();
        xhr.get_app_files(function(files) {
        xhr.get_template(function(data) {
            var vars = data.templateVars;
            var categories = data.templateCategory;
            // 微信的分享文案
            var app_info = data.share.wechat;
            var app_setting = data.share.setting = data.share.setting || {};
            var html = {};
            html.elements = {};
            html.sounds = [];
            html.codes = [];
            
            var v, v_rest,v_h,v_w;
            var images;
            for (var cateIndex in categories) {
                images = categories[cateIndex];
                html.elements[cateIndex] = [];
                for (var imageIndex in images) {
                    var k = images[imageIndex];
                    v = vars[k] || {};
                    v.name = v.name || k;
                    v_rest = {itemkey: k, staticUrl: static_url};
                    v.desc = v.desc || v.name;
                    if (v.type == 'IMAGE') {
                    	  v_h = v.originH || 0;
                          v_w = v.originW || 0;
                    	  v.name = "(" + v_w + "*" + v_h + ")" + v.desc;
                          html.elements[cateIndex].push(tmpl.render('t-image', v, v_rest));
                    } else if (v.type == 'ANIMATION') {
                        // multi texture
                        if (v.texs){
                            for (var i=0,j=v.texs.length; i<j; i++){
                                v_rest.texUrl = v.texs[i];
                                v_rest.index = i;
                                html.elements[cateIndex].push(tmpl.render('t-animation', v, v_rest))
                            }
                        // single texture
                        }else{
                            html.elements[cateIndex].push(tmpl.render('t-image', v, v_rest))
                        }
                    }else if(v.type == 'LABEL'){
                        v_rest.string2 = MI.string.html(String(v.string));
                        html.elements[cateIndex].push(tmpl.render('t-text', v, v_rest));
                    }else if(v.type == 'STRING' || v.type == 'DIRECTDATA') {
                        v_rest.string2 = MI.string.html(String(v.value));
                        html.elements[cateIndex].push(tmpl.render('t-text', v, v_rest));
                    }else if (v.type == 'SOUND'){
                        html.sounds.push(tmpl.render('t-sound', v, v_rest));
                    }
                }
            }
            
            for (var f in files){
                v = files[f];
                var v_filename = v.replace(/\\/g,'/');
                v_rest = {name:v_filename, staticUrl:static_url, desc:v_filename};
                // 显示可编辑的代码
                html.codes.push(tmpl.render('t-code', v, v_rest));
            }
                     
            function write_data(fn, err_fn) {
                if (MI.string.length($('.e-info .app-name').val()) > 40) { 
					alert_tip('最多不能超过20个字', $('.e-info .app-name')[0]); 
					return false;
				}
				
                if (MI.string.length($('.e-info .app-desc').val()) > 80) { 
					alert_tip('最多不能超过40个字', $('.e-info .app-desc')[0]); 
					return false;
				}
                
                data.templateVars = vars;
                xhr.write_file('template.json', JSON.stringify(data), fn, err_fn);
                return true;
            }
            
            function save_code(fn, err_fn) {
                var err = check_code_error(), name = '';
                if (err) {
                    name = window.code_editor ? code_editor.filename : name;
                    alert_tip(err, $('.editor .list .item[name="' + name + '"]')[0]);
                    return false;
                }
                
                if (window.code_editor && window.code_editor.getValue) {
                    var content = code_editor.getValue();
                    xhr.write_file(code_editor.filename, content, function() {
                        fn && fn();
                    }, err_fn);
                } else {
                    fn && fn();
                }
                return true;
            }
            
            function reload_app(my_url) {
                //var app_url = my_url || static_url;
                var app_url = my_url || '/app/proxy/'+(new Date()).getTime()+'/'+app_id+'/?openid=otuWJjvQKhb9nn1xL8v-IRrgxct8';
                //static_url+'index.html?v=' + (new Date()).getTime();
                if (navigator.userAgent.toUpperCase().indexOf("MSIE") != -1) {
                  $('.preview .p .inner').html('<table style="background:#000;text-align:center;border:none;width:320px;height:480px;"><tr><td><h4>对不起，您的浏览器不支持预览！<br>建议使用更快的浏览器</h4><div>Chrome,Firefox,360极速浏览器 等来进行预览。<div></td></tr></table>');
                } else {
                    $('.preview .p .inner iframe').attr("src", app_url);
                  //$('.preview .p .inner').html('\
                  //  <iframe id="preview_proxy" sandbox="allow-scripts allow-same-origin" name="preview_proxy" src="' +app_url+ '" style="border:none;width:640px;height:960px"></iframe>');
                }
            }
            
            function check_code_error() {
                if (navigator.userAgent.toUpperCase().indexOf("MSIE") != -1) return '';
                if (window.code_editor){
                    var an = code_editor.getSession().getAnnotations(),
                        err_txt = [];
                    for (var i=0,j=an.length; i<j; i++){
                        if (an[i].type=='error'){
                            err_txt.push('[' + (an[i].row+1) +'] - \t'+' "'+an[i].text+'"\n')  
                        }
                    }
                    return err_txt.join('');
                }
                return '';
            }
            
            function alert_tip(t,dom,duration,is_html){
                t = is_html ? String(t) : MI.string.html(String(t)).replace(/\n/g,'<br>');
                var d = $('<pre class="alert-tip label label-danger">' +(t||'Error')+ '</pre>');
                $('.editor').append(d);
                if (dom){
                    var x = UI.getX(dom), y = UI.getY(dom);
                    d.css({top:y+$(dom).height()+10,left:x});
                    d.css({opacity:0})
                      .animate({opacity:1},200)
                      .animate({opacity:1},duration||1800)
                      .animate({opacity:0},500,function(){
                        d.remove();
                      });
                }
            }
           
            
            
            
            // publish
            var publish_url = '/index.php?s=Home/Bee/step4/appid/' + app_id;
            $('.btn-play').attr('link', publish_url);
            $(document).on('click', '.btn-play', function() {
                write_data(function() {
                    save_code(function() {
                        location.href= $('.btn-play').attr('link');
                    });
               });
            });
            
            var page_title = app_setting.title || MI.string.entityReplace(app_info.title);
            $('input[name="page_title"]').val(page_title);
            $('input[name="page_title"]')[0].origin = page_title;
            $('input[name="page_title"]').on('change', function() {
                var s = String(MI.string.trim($(this).val()));
                if (s == '') {
                    s = $(this)[0].origin;
                    $(this).val(s);
                    alert_tip('游戏名称不能为空哦', $(this)[0]);
                    return;
                }
                if (MI.string.length(s) > 40) {
                    alert_tip('最多不能超过20个字', $(this)[0]);
                    return;
                }
                data.share.setting.title = MI.string.html(s);
            });
            
            // show game info
            $('.e-info .icon > *[type="image"]')
                .css({'backgroundImage':'url(' + static_url + app_info.imgUrl + '?v=' + (new Date()).getTime() + ')'});
            
            $('.e-info .app-name').val(MI.string.entityReplace(app_info.title));
            $('.e-info .app-name')[0].origin = MI.string.entityReplace(app_info.title);
            $('.e-info .app-name').on('change', function() {
                var s = String(MI.string.trim($(this).val()));
                if (s == '') {
                    s = $(this)[0].origin;
                    $(this).val(s);
                    alert_tip('游戏名称不能为空哦', $(this)[0]);
                    return;
                }
                if (MI.string.length(s) > 40) {
                    alert_tip('最多不能超过20个字', $(this)[0]);
                    return;
                }
                data.share.wechat.title = MI.string.html(s);
            });
            
            $('.e-info .app-desc').val(MI.string.entityReplace(app_info.desc));
            $('.e-info .app-desc')[0].origin = MI.string.entityReplace(app_info.desc);
            $('.e-info .app-desc').on('change', function() {
                var s = String(MI.string.trim($(this).val()));
                if (s == '') {
                    s = $(this)[0].origin;
                    $(this).val(s);
                    alert_tip('游戏介绍不能为空哦', $(this)[0]);
                    return;
                }
                
                if (MI.string.length(s) > 80) {
                    alert_tip('最多不能超过40个字', $(this)[0]);
                    return;
                }
                data.share.wechat.desc = MI.string.html(s);
            });       
       
            // show iframe
            setTimeout(function() {
                reload_app();
            }, 100);
            
            // show template json
            var liElements = [];
            for (var cateIndex in html.elements) {
                var liEl = html.elements[cateIndex];
				liElements.push('<li>' + "<h4>" + cateIndex + "</h4>"
                    + liEl.join('') + '</li>');
            }
            $('.e-elements .list').html('<ol class="classify">' + liElements.join('') + '</ol>');
            //$('.e-sounds .list').html('<p>--/--</p>');//html.sounds.join(''))
            //$('.e-codes .list').html(html.codes.join(''));
            
            // 显示上传图片蒙层
            function show_uploader_layer(dom) {
                var x = UI.getX(dom), y = UI.getY(dom);
                var ly = $(tmpl.render('upload-layer')).show();
                
                $('.editor').append(ly);
                var name = $(dom).attr('name'),
                    index = $(dom).attr('index'),
                    v = vars[name] || {},
                    v_rest = {name:name, staticUrl:static_url};

                ly.attr('name', name);
                if (name == 'app-icon') {
                    v_rest.texUrl = app_info.imgUrl;
                }
                
                if (v.texs && index != null) {
                    ly.attr('index', index);
                    v_rest.texUrl = v.texs[index];
                }
                
                // create libs
                var libs = [];
                libs.push(tmpl.render('libs-item', v, v_rest));
                
                // show libs
                xhr.get_app_libs(function(libs_html){
                    libs.push(libs_html);
                    ly.find('.list').html(libs.join(''));
                    var curr_item = ly.find('.list .libs-item').eq(0).addClass('selected').attr('title', '当前正在使用的');
                    var curr_item_url = v_rest.staticUrl + curr_item.attr('image') + '?v='+(new Date()).getTime();
                    curr_item.find('.icon > *[type="image"]').css({'backgroundImage':'url(' + curr_item_url + ')'});
                });
                
                ly.css({top:y +  45, left:x});
                // show select active
                $('.editor .list .item').removeClass('active');
                $('.editor .list .item[name="'+name+'"]').addClass('active');
                
                
            }
            // 点击图片的事件处理
            $(document).on('click', '.t-image', function(evt) {
                $('.modify-layer').remove();
                show_uploader_layer(this);
                var titletmp=$(this).attr('name'); 
                var vs = vars[titletmp];
                if(titletmp=='app-icon'){
                	vs=app_info;
                	vs.originW=150;
                	vs.originH=150;
                }
                var vsw=vs.originW||0;
                var vsh=vs.originH||0;
                $(".upload-list .hint").after('<p>建议最佳图片尺寸：宽'+vsw+'PX*高'+vsh+'PX</p>');
                
                // 防止事件冒泡
                evt.stopPropagation();
            });
            
            $(document).on('click', '.t-animation', function(evt) {
                $('.modify-layer').remove();
                show_uploader_layer(this);
                evt.stopPropagation();
            });

            // liuna弹框位置
            $(document).on('click', '.item', function(evt) {
                var oTop = $(this).offset().top;
                var oFlage = 0;
                // var oBoxHeight = $('.modify-layer').height();
                // 元素距离底部距离
                var  oHeight = $(window).height()-oTop-$(this).height();               
                            if(oHeight < 310){
                                var oPos = oTop + 677 +"px";
                                $.scrollTo(oPos, 500);
                                }
            });

            $(window).on('scroll',function(){
                if($(document).scrollTop() > 90){
                    $('.right').css({'position':'fixed','top':'0','right':'0'});
                // console.log($(document).scrollTop() + "dddddd" +$('.right').offset().top);
                }else{
                    $('.right').css('position','absolute');   
                }    
            });
         
            
            $(document).on('click', '.t-text', function(evt) {
            	$('.modify-layer').remove();
            	
                var x = UI.getX(this), y = UI.getY(this);
                var ly = $(tmpl.render('text-layer')).show();
                $('.editor').append(ly);
                
                var name = $(this).attr('name'), v = vars[name] || {}, s = '';
                 
                
                // console.log(name);
                // console.log(vars);
                // console.log(v);
                if (v.string != null){
                    s = v.string;
                }
                if (v.value != null){
                    s = v.value;
                }
                 //增加温馨提示
                ly.find('.txt-hint').html(v.desc || v.name || '').after('<p>温馨提示:为了保证展现效果，请按照默认格式填写内容</p>');
                 var tp = getDirectDataType(s);
                if (tp == 'number') {
                    ly.find('.txt-string').parent().prepend('<input type="number" class="txt-string form-control" value="">');
                    ly.find('textarea.txt-string').remove(); // remove text
                    ly.find('.txt-string').val(Number(s));
                }else if(tp == 'color') {
                    ly.find('.txt-string').parent().prepend('<div class="curr-color"></div>');
                    ly.find('.txt-string').parent().prepend('<div class="evo-palcenter"><table class="e2"><tr><td style="background-color:#003366"></td><td style="background-color:#336699"></td><td style="background-color:#3366cc"></td><td style="background-color:#003399"></td><td style="background-color:#000099"></td><td style="background-color:#0000cc"></td><td style="background-color:#000066"></td></tr></table><table class="e2"><tr><td style="background-color:#006666"></td><td style="background-color:#006699"></td><td style="background-color:#0099cc"></td><td style="background-color:#0066cc"></td><td style="background-color:#0033cc"></td><td style="background-color:#0000ff"></td><td style="background-color:#3333ff"></td><td style="background-color:#333399"></td></tr></table><table class="e2"><tr><td style="background-color:#669999"></td><td style="background-color:#009999"></td><td style="background-color:#33cccc"></td><td style="background-color:#00ccff"></td><td style="background-color:#0099ff"></td><td style="background-color:#0066ff"></td><td style="background-color:#3366ff"></td><td style="background-color:#3333cc"></td><td style="background-color:#666699"></td></tr></table><table class="e2"><tr><td style="background-color:#339966"></td><td style="background-color:#00cc99"></td><td style="background-color:#00ffcc"></td><td style="background-color:#00ffff"></td><td style="background-color:#33ccff"></td><td style="background-color:#3399ff"></td><td style="background-color:#6699ff"></td><td style="background-color:#6666ff"></td><td style="background-color:#6600ff"></td><td style="background-color:#6600cc"></td></tr></table><table class="e2"><tr><td style="background-color:#339933"></td><td style="background-color:#00cc66"></td><td style="background-color:#00ff99"></td><td style="background-color:#66ffcc"></td><td style="background-color:#66ffff"></td><td style="background-color:#66ccff"></td><td style="background-color:#99ccff"></td><td style="background-color:#9999ff"></td><td style="background-color:#9966ff"></td><td style="background-color:#9933ff"></td><td style="background-color:#9900ff"></td></tr></table><table class="e2"><tr><td style="background-color:#006600"></td><td style="background-color:#00cc00"></td><td style="background-color:#00ff00"></td><td style="background-color:#66ff99"></td><td style="background-color:#99ffcc"></td><td style="background-color:#ccffff"></td><td style="background-color:#ccccff"></td><td style="background-color:#cc99ff"></td><td style="background-color:#cc66ff"></td><td style="background-color:#cc33ff"></td><td style="background-color:#cc00ff"></td><td style="background-color:#9900cc"></td></tr></table><table class="e2"><tr><td style="background-color:#003300"></td><td style="background-color:#009933"></td><td style="background-color:#33cc33"></td><td style="background-color:#66ff66"></td><td style="background-color:#99ff99"></td><td style="background-color:#ccffcc"></td><td style="background-color:#ffffff"></td><td style="background-color:#ffccff"></td><td style="background-color:#ff99ff"></td><td style="background-color:#ff66ff"></td><td style="background-color:#ff00ff"></td><td style="background-color:#cc00cc"></td><td style="background-color:#660066"></td></tr></table><table class="e2"><tr><td style="background-color:#333300"></td><td style="background-color:#009900"></td><td style="background-color:#66ff33"></td><td style="background-color:#99ff66"></td><td style="background-color:#ccff99"></td><td style="background-color:#ffffcc"></td><td style="background-color:#ffcccc"></td><td style="background-color:#ff99cc"></td><td style="background-color:#ff66cc"></td><td style="background-color:#ff33cc"></td><td style="background-color:#cc0099"></td><td style="background-color:#993399"></td></tr></table><table class="e2"><tr><td style="background-color:#336600"></td><td style="background-color:#669900"></td><td style="background-color:#99ff33"></td><td style="background-color:#ccff66"></td><td style="background-color:#ffff99"></td><td style="background-color:#ffcc99"></td><td style="background-color:#ff9999"></td><td style="background-color:#ff6699"></td><td style="background-color:#ff3399"></td><td style="background-color:#cc3399"></td><td style="background-color:#990099"></td></tr></table><table class="e2"><tr><td style="background-color:#666633"></td><td style="background-color:#99cc00"></td><td style="background-color:#ccff33"></td><td style="background-color:#ffff66"></td><td style="background-color:#ffcc66"></td><td style="background-color:#ff9966"></td><td style="background-color:#ff6666"></td><td style="background-color:#ff0066"></td><td style="background-color:#d60094"></td><td style="background-color:#993366"></td></tr></table><table class="e2"><tr><td style="background-color:#a58800"></td><td style="background-color:#cccc00"></td><td style="background-color:#ffff00"></td><td style="background-color:#ffcc00"></td><td style="background-color:#ff9933"></td><td style="background-color:#ff6600"></td><td style="background-color:#ff0033"></td><td style="background-color:#cc0066"></td><td style="background-color:#660033"></td></tr></table><table class="e2"><tr><td style="background-color:#996633"></td><td style="background-color:#cc9900"></td><td style="background-color:#ff9900"></td><td style="background-color:#cc6600"></td><td style="background-color:#ff3300"></td><td style="background-color:#ff0000"></td><td style="background-color:#cc0000"></td><td style="background-color:#990033"></td></tr></table><table class="e2"><tr><td style="background-color:#663300"></td><td style="background-color:#996600"></td><td style="background-color:#cc3300"></td><td style="background-color:#993300"></td><td style="background-color:#990000"></td><td style="background-color:#800000"></td><td style="background-color:#993333"></td></tr></table><table class="e2 g1"><tr><td style="background-color:#ffffff"></td><td style="background-color:#ebebeb"></td><td style="background-color:#d7d7d7"></td><td style="background-color:#c3c3c3"></td><td style="background-color:#afafaf"></td><td style="background-color:#9b9b9b"></td><td style="background-color:#878787"></td><td style="background-color:#737373"></td><td style="background-color:#5f5f5f"></td><td style="background-color:#4b4b4b"></td><td style="background-color:#373737"></td><td style="background-color:#232323"></td><td style="background-color:#0f0f0f"></td></tr></table><table class="e2"><tr><td style="background-color:#f5f5f5"></td><td style="background-color:#e1e1e1"></td><td style="background-color:#cdcdcd"></td><td style="background-color:#b9b9b9"></td><td style="background-color:#a5a5a5"></td><td style="background-color:#919191"></td><td style="background-color:#7d7d7d"></td><td style="background-color:#696969"></td><td style="background-color:#555555"></td><td style="background-color:#414141"></td><td style="background-color:#2d2d2d"></td><td style="background-color:#191919"></td><td style="background-color:#050505"></td></tr></table></div>');
                    
                    //ly.find('.txt-string').parent().prepend('<input type="color" class="txt-string form-control" value="">');
                    ly.find('.txt-string').attr('type','colorpicker');
                    ly.find('.txt-string').css({'height':45,'width':130});
                    ly.find('.curr-color').css({'background-color':s});
                    ly.find('.txt-string').val(s);
                    ly.find('.txt-string').val(s);
                }else{
                    ly.find('.txt-string').text(String(s));
                }
                
                ly.attr('name', name);
                ly.css({top:y + 25, left:x});
                
                // show select active
                $('.editor .list .item').removeClass('active');
                $('.editor .list .item[name="'+name+'"]').addClass('active');
                
                evt.stopPropagation();
                
                
                //绑定事件
                function blurok() {
          	        var self= $(".modify-layer .btn-ok");
                    var btn_ok = $(".modify-layer .btn-ok"),
                    el = self.parent(),
                    name = self.parent().attr('name'),
                    v = vars[name] || {},
                    v_rest = {name:name,staticUrl:static_url},
                    t_name, // template name will be render
                    STR_LOADING = '<i class="fa fa-spinner fa-spin"></i>';
                
                    // console.log(el);
                var ani_index,tab_index,texUrl,new_texUrl;
                
                function update_item() {
                    if (name == 'app-icon'){
                        $('.e-info .icon > *[type="image"]')
                            .css({'backgroundImage':'url('+static_url+app_info.imgUrl+'?v='+(new Date()).getTime()+')'});
                        return;
                    }
                
                    if (ani_index != null && v.texs){
                        v.texs[ani_index] = texUrl;
                        v_rest.index = ani_index;
                        v_rest.texUrl = texUrl;
                    }else{
                        v.texUrl = texUrl;
                    }
                    
                    // write data
                    vars[name] = v;
                    // update
                    var item = $(tmpl.render(t_name, v, v_rest));
                        // add a random number
                        item.find('.icon > *[type="image"]').css({'backgroundImage':'url('+v_rest.staticUrl+texUrl+'?v='+(new Date()).getTime()+')'})
                    var item_innerhtml = item.html();
                    $('.modify .cate .item[name="'+name+'"]').eq(el.attr('index')||0)
                        .html(item_innerhtml);
                
                    write_data();
                    //save_code();
                    setTimeout(function(){
                        reload_app();
                    }, 500);
                }
                
                if (name == 'app-icon'){
                    v.type = 'IMAGE';
                }
                
                if (v.type == 'IMAGE' || v.type == 'ANIMATION'){
                    // multi texture
                    if (v.texs){
                        t_name = 't-animation';
                    }else{
                        t_name = 't-image';
                    }
                    
                    ani_index = el.attr('index');
                    tab_index = $('.modify-layer .ghost-tabs .active').index(); //which one is selected
                    texUrl = (ani_index != null && v.texs && v.texs[ani_index]) ? v.texs[ani_index] : v.texUrl;
                    
                    if (name == 'app-icon'){
                        texUrl = app_info.imgUrl;
                    }
                    
                    // libs
                    if (tab_index == 1){
                        new_texUrl = $('.modify-layer .list .selected').attr('image');
                        if (new_texUrl == texUrl){ $('.modify-layer').remove(); return; }
                        
                        btn_ok.attr('disabled', 'false').html(STR_LOADING+' 替换中...');
                        xhr.replace_res(texUrl, new_texUrl, function() {
                            update_item();
                            $('.modify-layer').remove();
                        }, function(err) {
                            alert_tip(err.error, $('.modify .cate .item[name="'+name+'"]')[0]); $('.modify-layer').remove();
                        });
                        return;
                    // upload
                    }else if(tab_index == 0){
                        btn_ok.attr('disabled', 'false').html(STR_LOADING+' 上传中...');
                        xhr.upload(texUrl, function(){
                            update_item();
                            $('.modify-layer').remove();
                        }, function(err){
                            alert_tip(err.error, $('.modify .cate .item[name="'+name+'"]')[0]); $('.modify-layer').remove();
                        });
                        return;
                    // catch from web
                    }else if(tab_index == 2){
                        var new_texUrl = MI.string.trim(el.find('.txt-from-web').val());
                        if (new_texUrl == texUrl){ $('.modify-layer').remove(); return; }
							var srcPicErr = ['你输入的图片链接已提交，请等待', '图片地址不能为空，请在输入框粘贴或输入' ,'你输入的图片地址不是正确的URL格式，请重新输入','这不是一张图片哦'];
							
                            if(MI.string.checkURL(new_texUrl)){
                                var img = new Image();
                                img.onerror = function(){
                                    alert_tip(srcPicErr[3], el.find('.txt-from-web')[0]);
                                };
                                img.onload = function(){
                                    btn_ok.attr('disabled', 'false').html(STR_LOADING+' 抓取中...');
                                    xhr.replace_res(texUrl, new_texUrl, function(){
                                        update_item();
                                        $('.modify-layer').remove();
                                    }, function(err){
                                        alert_tip(err.error, $('.modify .cate .item[name="'+name+'"]')[0]); $('.modify-layer').remove();
                                    });
                                };
                                img.src=new_texUrl;
                                return;
                            } else {
                                alert_tip(new_texUrl==''?srcPicErr[1]:srcPicErr[2], el.find('.txt-from-web')[0]);
                                return;
                            }
                    }
                    
                }else if(v.type == 'LABEL'){
                    t_name = 't-text';
                    
                    var str_value = el.find('.txt-string').val();
                    if (MI.string.length(str_value) > 600) { alert_tip('最多不能超过300个字',$('.modify .cate .item[name="'+name+'"]')[0]); $('.modify-layer').remove(); return; }
                    
                    v.string = str_value;
                    v_rest.string2 = MI.string.html(String(v.string));
                    update_item();
                  }else if(v.type == 'STRING' || v.type == 'DIRECTDATA'){
                    t_name = 't-text';
                    
                    var str_value = el.find('.txt-string').val();
                    if (MI.string.length(str_value) > 600) { alert_tip('最多不能超过300个字',$('.modify .cate .item[name="'+name+'"]')[0]); $('.modify-layer').remove(); return; }
                    
                    var tp = getDirectDataType(str_value);
                    if (tp == 'number'){
                        v.value = Number(str_value);
                    }else{
                        v.value = String(str_value);
                    }
                     
                    
                    v_rest.string2 = MI.string.html(String(v.value));
                    update_item();
                }else if (v.type == 'SOUND'){
                    t_name = 't-sound';
                }
                
                $('.modify-layer').remove();
               }
                
                 $(document).on('blur', '.form-control',blurok); 
                
                    
            });
            
            $(document).on('click', '.t-sound', function(){
                //alert('sound');
            });
            
            $(document).on('click', '.t-code', function(){
                var name = $(this).attr('name');
                
                // write the previous file
                if (!save_code()) return;
                
                window.xhr_get_code && window.xhr_get_code.abort();
                window.xhr_get_code = xhr.get_file(static_url+name+'?v='+(new Date()).getTime(), function(d) {
                    $('.code-editor').remove();
                    $('.btn-close-code-editor').remove();
                    $('.loading-code').remove();
                    
                    // create editor
                    var editor_height = $(window).height() - $('.e-codes .list').height() - 56;
                    if (navigator.userAgent.toUpperCase().indexOf("MSIE") != -1){
                        /*var editor = document.createElement('textarea');
                        editor.style.cssText = 'display:block;font:normal 14px Ubuntu Mono,Monaco,Consolas,monospace; width:100%;min-height:'+editor_height+'px';
                        editor.className = 'code-editor';
                        editor.id = 'editor';
                        $('.modify .e-codes').append(editor);*/
                        $('.modify .e-codes').append('<pre id="editor" style="display:block;font:normal 14px Ubuntu Mono,Monaco,Consolas,monospace; width:100%;height:'+editor_height+'px" class="code-editor">' +MI.string.html(String(d))+ '</pre>');
                        window.code_editor = $('#editor');
                        code_editor.setValue = function(txt){
                            document.getElementById("editor").innerHTML = MI.string.html(String(txt));
                        };
                        code_editor.getValue = function(txt){
                            return MI.string.entityReplace(document.getElementById("editor").innerHTML);
                        };
                        //code_editor.setValue(String(d));
                        window.scrollTo(0,$(window).height());
                    } else {
                        $('.modify .e-codes').append('<p class="loading-code" style="padding:20px">loading</p>')
                        xhr.load_ace_script(function() {
                            $('.code-editor').remove();
                            $('.btn-close-code-editor').remove();
                            $('.loading-code').remove();
                            
                            $('.modify .e-codes').append('<a class="btn-close-code-editor" href="javascript:void(0)"><i class="fa fa-angle-double-up" title="收起/保存代码"></i></a><div id="editor" style="font:normal 14px Ubuntu Mono,Monaco,Consolas,monospace; width:100%;min-height:'+editor_height+'px" class="code-editor"></div>');
                            //ace.require("ace/ext/language_tools");
                            window.code_editor = ace.edit("editor");
                            code_editor.filename = name;
                            code_editor.setOptions({
                                enableBasicAutocompletion: true,
                                enableSnippets: true,
                                enableLiveAutocompletion: false
                            });
                            code_editor.setTheme("ace/theme/twilight");
                            code_editor.getSession().setMode("ace/mode/javascript");
                            code_editor.setValue(String(d),1);
                            
                            window.scrollTo(0,$(window).height());
                        });
                    }
                });

                // show select active
                $('.editor .list .item').removeClass('active');
                $('.editor .list .item[name="'+name+'"]').addClass('active');
            });
            
            $(document).on('click', '.btn-close-code-editor', function(){
                if (!save_code(function(){
                    $('.code-editor').remove();
                    $('.btn-close-code-editor').remove();
                    $('.loading-code').remove();   
                    // show select active
                    $('.editor .list .item').removeClass('active');
                })) return;
            });
            
            // modify-layer
            $(document).on('click', '.modify-layer .ghost-tabs a', function() {
                $('.modify-layer .ghost-tabs a').removeClass('active');
                $(this).addClass('active');
                var ctn = $(this).parent().parent().find('.ghost-tabs-ctn > *');
                ctn.hide();
                $(ctn[$(this).index()]).show();
            });
            
            $(document).on('click', '.modify-layer .ghost-tabs-ctn .list .libs-item', function(){
                $('.modify-layer .ghost-tabs-ctn .list .libs-item').removeClass('selected');
                $(this).addClass('selected');
            });
            
            function txt_from_web_change(target){
                $(target).parent().find('.icon > *[type="image"]').css({'backgroundImage':'url('+$(target).val()+')'});
            }
            
            $(document).on('keyup', '.modify-layer .txt-from-web', function(){ 
                txt_from_web_change(this);
            }).on('change', function(){ txt_from_web_change(this)});
            
            
          $(document).on('click', '.modify-layer .btn-ok', function(){
                var btn_ok = $(this),
                    el = $(this).parent(),
                    name = $(this).parent().attr('name'),
                    v = vars[name] || {},
                    v_rest = {name:name,staticUrl:static_url},
                    t_name, // template name will be render
                    STR_LOADING = '<i class="fa fa-spinner fa-spin"></i>';
                
                // console.log(el);
                var ani_index,tab_index,texUrl,new_texUrl;
                
                function update_item() {
                    if (name == 'app-icon'){
                        $('.e-info .icon > *[type="image"]')
                            .css({'backgroundImage':'url('+static_url+app_info.imgUrl+'?v='+(new Date()).getTime()+')'});
                        return;
                    }
                
                    if (ani_index != null && v.texs){
                        v.texs[ani_index] = texUrl;
                        v_rest.index = ani_index;
                        v_rest.texUrl = texUrl;
                    }else{
                        v.texUrl = texUrl;
                    }
                    
                    // write data
                    vars[name] = v;
                    // update
                    var item = $(tmpl.render(t_name, v, v_rest));
                        // add a random number
                        item.find('.icon > *[type="image"]').css({'backgroundImage':'url('+v_rest.staticUrl+texUrl+'?v='+(new Date()).getTime()+')'})
                    var item_innerhtml = item.html();
                    $('.modify .cate .item[name="'+name+'"]').eq(el.attr('index')||0)
                        .html(item_innerhtml);
                
                    write_data();
                    //save_code();
                    setTimeout(function(){
                        reload_app();
                    }, 500);
                }
                
                if (name == 'app-icon'){
                    v.type = 'IMAGE';
                }
                
                if (v.type == 'IMAGE' || v.type == 'ANIMATION'){
                    // multi texture
                    if (v.texs){
                        t_name = 't-animation';
                    }else{
                        t_name = 't-image';
                    }
                    
                    ani_index = el.attr('index');
                    tab_index = $('.modify-layer .ghost-tabs .active').index(); //which one is selected
                    texUrl = (ani_index != null && v.texs && v.texs[ani_index]) ? v.texs[ani_index] : v.texUrl;
                    
                    if (name == 'app-icon'){
                        texUrl = app_info.imgUrl;
                    }
                    
                    // libs
                    if (tab_index == 1){
                        new_texUrl = $('.modify-layer .list .selected').attr('image');
                        if (new_texUrl == texUrl){ $('.modify-layer').remove(); return; }
                        
                        btn_ok.attr('disabled', 'false').html(STR_LOADING+' 替换中...');
                        xhr.replace_res(texUrl, new_texUrl, function() {
                            update_item();
                            $('.modify-layer').remove();
                        }, function(err) {
                            alert_tip(err.error, $('.modify .cate .item[name="'+name+'"]')[0]); $('.modify-layer').remove();
                        });
                        return;
                    // upload
                    }else if(tab_index == 0){
                        btn_ok.attr('disabled', 'false').html(STR_LOADING+' 上传中...');
                        xhr.upload(texUrl, function(){
                            update_item();
                            $('.modify-layer').remove();
                        }, function(err){
                            alert_tip(err.error, $('.modify .cate .item[name="'+name+'"]')[0]); $('.modify-layer').remove();
                        });
                        return;
                    // catch from web
                    }else if(tab_index == 2){
                        var new_texUrl = MI.string.trim(el.find('.txt-from-web').val());
                        if (new_texUrl == texUrl){ $('.modify-layer').remove(); return; }
							var srcPicErr = ['你输入的图片链接已提交，请等待', '图片地址不能为空，请在输入框粘贴或输入' ,'你输入的图片地址不是正确的URL格式，请重新输入','这不是一张图片哦'];
							
                            if(MI.string.checkURL(new_texUrl)){
                                var img = new Image();
                                img.onerror = function(){
                                    alert_tip(srcPicErr[3], el.find('.txt-from-web')[0]);
                                };
                                img.onload = function(){
                                    btn_ok.attr('disabled', 'false').html(STR_LOADING+' 抓取中...');
                                    xhr.replace_res(texUrl, new_texUrl, function(){
                                        update_item();
                                        $('.modify-layer').remove();
                                    }, function(err){
                                        alert_tip(err.error, $('.modify .cate .item[name="'+name+'"]')[0]); $('.modify-layer').remove();
                                    });
                                };
                                img.src=new_texUrl;
                                return;
                            } else {
                                alert_tip(new_texUrl==''?srcPicErr[1]:srcPicErr[2], el.find('.txt-from-web')[0]);
                                return;
                            }
                    }
                    
                }else if(v.type == 'LABEL'){
                    t_name = 't-text';
                    
                    var str_value = el.find('.txt-string').val();
                    if (MI.string.length(str_value) > 600) { alert_tip('最多不能超过300个字',$('.modify .cate .item[name="'+name+'"]')[0]); $('.modify-layer').remove(); return; }
                    
                    v.string = str_value;
                    v_rest.string2 = MI.string.html(String(v.string));
                    update_item();
                    // console.log('blur1');
                }else if(v.type == 'STRING' || v.type == 'DIRECTDATA'){
                    t_name = 't-text';
                    
                    var str_value = el.find('.txt-string').val();
                    if (MI.string.length(str_value) > 600) { alert_tip('最多不能超过300个字',$('.modify .cate .item[name="'+name+'"]')[0]); $('.modify-layer').remove(); return; }
                    
                    var tp = getDirectDataType(str_value);
                    if (tp == 'number'){
                        v.value = Number(str_value);
                    }else{
                        v.value = String(str_value);
                    }
                    
                    v_rest.string2 = MI.string.html(String(v.value));
                    update_item();
                }else if (v.type == 'SOUND'){
                    t_name = 't-sound';
                }
                
                $('.modify-layer').remove();
            });
 
            // pick color
            $(document).on('click', '.evo-palcenter td', function(){
                var c = String($(this)[0].getAttribute('style')).toLowerCase().replace('background-color:',''), p = $(this).parent().parent().parent().parent().parent();
                p.find('.curr-color').css('background-color',c);
                p.find('.txt-string').val(c.toUpperCase());
            });
            // http://acko.net/blog/farbtastic-jquery-color-picker-plug-in/ 略叼
            $(document).on('change keyup', '.modify-layer .txt-string[type=colorpicker]', function(){
                $(this).parent().find('.curr-color').css('background-color',$(this).val());
            });
            
            $(document).on('click', '.modify', function(){ $('.modify-layer').remove(); });     
            $(document).on('click', '.btn-reload', function(){
                write_data();
                //save_code();
                setTimeout(function(){
                    reload_app();
                }, 500);
            });    
        }); // get_template
        }); // get_app_files
        
        $('.editor .modify').height($(window).height()-$('.navbar').height());
   
    });
    $(window).bind('beforeunload',function(){return '您输入的内容尚未保存，确定离开此页面吗？';});
})(window.jQuery);
