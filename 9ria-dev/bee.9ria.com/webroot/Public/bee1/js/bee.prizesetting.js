    // 解决this问题
    function bind(obj, func) {
        return function() {
            return func.apply(obj, Array.prototype.slice.call(arguments));
        };
    }
    function bindAll(obj) {
        var funcs = Array.prototype.slice.call(arguments, 1);
        for (var i = 0; i < funcs.length; i++) {
            obj[funcs[i]] = bind(obj, obj[funcs[i]]);
        }
        return obj;
    }

var bee = bee || {};
    bee.form = bee.form || {};
    bee.btn = bee.btn || {};
    // 添加奖项按钮
    bee.btn.plusbtn = function(params){
        this._params = {
            "name" : "",
            "triggername" : ""
        };
        $.extend(this._params, params);
        this.initialize();
    };

    bee.btn.plusbtn.prototype = {
        initialize : function(){
            var self = this;
                this.render();
                this._el.click(function(){
                    // console.log(self._el[0]);
                    // console.log(self._params);
                    self._el.trigger(self._params.triggername,{});
                });
        },
        render : function(){
            this._el = $('<div class="add fl" id="addprize">'+ this._params.name +'</div>');
        }
    };

    //添加多选表单项按钮
    bee.btn.pluscheckbox = function(params){
    	this._params = {
            "name" : "",
            "triggername" : "",
            "tips" : ""
        };
        $.extend(this._params, params);
        this.initialize();
    }

    bee.btn.pluscheckbox.prototype = {
        initialize : function(params){
            var self = this;
            $.extend(this._params, params);
            bindAll(this, 'validate', 'triggerEvt');
            this.render();

            this._el.find("a[name=addcheckboxinput]").click(function(){
                if(self._el.find('.hiddenInp').css('display') == 'none') {
                	$(this).hide();
                	self._el.find('.hiddenInp').css('display','block')
	                    .animate({width:'380px', height:'32px'}, 500)
	                    .find('input[name=addcheckboxitem]')
	                    .css({position:'relative', bottom:'2px'});
                }
//                    self.triggerEvt();
            });

            this._el.find("input[name=addcheckboxitem]").click(function(e) {
            	var itemData = self.validate(e);
            	if(false != itemData) {
            		$.post('/index.php?s=Home/editor/addformdictitem.html', {label:itemData}, function(res) {
                        if(res.status == 1){
                        	self.cancelerr();
                        	if(self._el.find('.hiddenInp').css('display') == 'block') {
                        		self._el.find('.hiddenInp').hide();
                        		self._el.find("a[name=addcheckboxinput]").show();
                        	}
                        	if(res.info) {
                        		self._el.trigger(self._params.triggername, res.info.data);
                        	}
                        } else {
                        	self.seterr();
                        	_errDlg(res.info);
                        }
                    });
            	}
//                self.triggerEvt();
            });
            return this;
        },
        render : function(){
            this._el = $('<div class="checkboxBlockAdd">\
		     	<a href="javascript:;" class="aBlue" id="addInpA" name="addcheckboxinput">+添加其他信息</a>\
		        <div class="hiddenInp">\
            		<em class="simpletooltip" data-simpletooltip-theme="blue" data-simpletooltip-border-width="0" title="'+ this._params.tips +'" style="cursor: pointer;">\
		        	<input type="text" class="inpBox" id="addInp" value="" palceholder="用户输入字段需求信息" />\
            		</em>\
		        	<input type="button" name="addcheckboxitem" class="btnBlue1" value="确定" />\
		        </div>\
		     </div>');
        },
        validate : function(e){
            this._params.val = $(e.target).prev('em').find(".inpBox").val();
            if(this._params.val.toString().length < 2 || this._params.val.toString().length > 5){
                this.seterr();
                _errDlg("表单项名称不少于2个字且不超过5个字");
//                this._params.val = this._params.val.toString().substr(0,4);
//                this._el.find("input.inpBox").val(this._params.val);
                return false;
            } else {
            	this.cancelerr();
            	return this._params.val; 
            }
        },
        seterr : function(){
            this._el.find("input.inpBox").addClass('error');
        },
        cancelerr : function(){
            this._el.find("input.inpBox").removeClass('error');
        },
        setval : function(e, data){
            this._params = $.extend(this._params, data);
        },
        triggerEvt : function(){
            this._el.trigger(this._params.triggername, this._params.val);
        }
    };
    
    // 基础输入组件
    bee.form.baseinput = function(){};
    bee.form.baseinput.prototype = {
        initialize : function(params){
            bindAll(this, 'validate', 'seterr', 'cancelerr');
            var self = this;
                $("").extend(this._params, params);
                this._val = this._params.val;
                this.render();

                this._el.find("input").blur(function(e){
                    // console.log('blur');
                    self.validate(e);
                    var triggerdata = {};
                        triggerdata[self._params.tagname] = self._params.val;
                    if(self._params.triggername != ""){
//                        console.log('trigger:'+self._params.triggername);
                        self._el.trigger(self._params.triggername, triggerdata);
                    }
                });
                this._el.find('input').focus(function(){
                    // console.log('focus');
                    self.cancelerr();
                });
                return this;
        },
        render : function(){
            this._el = $('<li><span>'+this._params.name+'</span><em class="simpletooltip" data-simpletooltip-theme="blue" data-simpletooltip-border-width="0" title="'+this._params.tips+'" style="cursor: pointer;"><input type="'+this._params.type+'" name="'+ this._params.tagname+'" id="" value="'+this._params.val+'" class="txt '+ this._params.tagname+'" placeholder="'+this._params.placeholder+'"></em><div class="tips" style="margin-left:156px">'+this._params.desc+'</div></li>');
        },
        validate : function(e){
            // console.log("input change"+$(e.target).val());
            this._params.val = $(e.target).val();
            
            if(this._params.type == "text"){
                if(this._params.val == ""){
                    this.seterr();
                }
            }

            if(this._params.tagname == "lot_count"){
                this._params.val = this._params.val.substr(0,9);
                this._params.val = parseInt(this._params.val);
                if(isNaN(this._params.val) || this._params.val < 0) this._params.val = 0;
                this.cancelerr();
            }

            if(this._params.tagname == "prizeruledesc" || this._params.tagname == "nowinmsg"){
                if(this._params.val.toString().length > 40){
                    this.seterr();
                    _errDlg(this._params.name+"不得超过40个字");
                    this._params.val = this._params.val.toString().substr(0,40);
                }else{
                    this.cancelerr();
                }
            }

            if(this._params.tagname == "lot_name"){
                if(this._params.val.toString().length > 8){
                    this.seterr();
                    this._params.val = this._params.val.toString().substr(0,8);
                    _errDlg(this._params.name+"不得超过8个字");
                }else{
                    this.cancelerr();
                }
            }

            if(this._params.tagname == "lot_winning_tips"){
                if(this._params.val.toString().length > 40){
                    this.seterr();
                    this._params.val = this._params.val.toString().substr(0,40);
                    _errDlg(this._params.name+"不得超过40个字");
                }else{
                    this.cancelerr();
                }
            }

            this._el.find("input").val(this._params.val);
        },
        seterr : function(){
            this._el.find("input").addClass('error');
        },
        cancelerr : function(){
            this._el.find("input").removeClass('error');
        }
    };

    // 未中奖提示
    bee.form.nowininput = function(params){
        this._params = {
            "desc":"建议提示在20字以内",
            "val": "",
            "name":"未中奖提示",
            "placeholder":"请输入未中奖提示，例：很遗憾您未中奖，再接再厉！",
            "tagname":"nowinmsg",
            "type":"text",
            "role":"",
            "triggername" : ""
        };
        $.extend(this._params, params);
        this.initialize(params);
    }
    bee.form.nowininput.prototype = new bee.form.baseinput();
    bee.form.nowininput.prototype.render = function(){
        this._el = $('<li><span>'+ this._params.name+'</span><input type="text" name="prize_tips" id="" value="'+this._params.val+'" class="txt prize_tips '+this._params.tagname+'" placeholder="'+ this._params.placeholder +'" /><div class="tips" style="margin-left:129px">'+ this._params.desc +'</div></li>');
    }

    //重复中奖
    bee.form.winrepeatinput = function(){
        this._params = {
            "triggername" : "",
            "val": {},
            "name":"重复中奖",
            "placeholder" : "请输入中奖次数",
            "desc":"说明：默认每名玩家只能中奖一次，可在此修改中奖次数（0为不限制）"
        }
    }

    bee.form.winrepeatinput.prototype = {
        initialize : function(params){
            var self = this;
                $.extend(this._params, params);
                bindAll(this, 'validate', 'triggerEvt');
                this.render();

                this._el.find(".allowrepeat").click(function(){
                    if($(this).hasClass("checked")){
                        self._params.val.isallowrepeatwin = 0;
                        self._params.val.winrepeattimes = 1;
                        $(this).removeClass("checked").addClass("radio");
                        self._el.find("input[name=repeattimes]").attr({disabled:true}).val(1);
                    }else{
                        self._params.val.isallowrepeatwin = 1;
                        self._params.val.winrepeattimes = 2;
                        $(this).removeClass("radio").addClass("checked");
                        self._el.find("input[name=repeattimes]").attr({disabled:false}).val(2);
                    }
                    self.triggerEvt();
                });

                this._el.find("input[name=repeattimes]").change(function(){
                    self._params.val.winrepeattimes = self.validate($(this).val());
                    self.triggerEvt();
                });
                return this;
        },
        render : function(){
            console.log(this._params);
            this._el = $('<li>\
                            <span>'+this._params.name+'</span>\
                            <span class="'+(this._params.val.isallowrepeatwin ? 'checked' : 'radio')+' allowrepeat">允许重复中奖</span>\
                            <input type="text" name="repeattimes" id="" value="'+ this._params.val.winrepeattimes + '" class="txt prize_prob" placeholder="'+this._params.placeholder+'"'+(this._params.val.isallowrepeatwin ? '' : 'disabled="disabled"')+'" style="margin:15px 0 0 -10px;width:200px;" />\
                            <div class="tips" style="margin-left:129px">'+this._params.desc+'</div>\
                        </li>');
        },
        validate : function(val) {
    
            return val;
        },
        triggerEvt : function(){
            this._el.trigger(this._params.triggername, this._params.val);
        }
    };


    // 正常input输入框组件
    bee.form.normalinput = function(params){
        this._params = {
            "desc":"建议提示在20字以内",
            "val": "",
            "tips":"",
            "name":"未中奖提示",
            "placeholder":"请输入未中奖提示，例：很遗憾您未中奖，再接再厉！",
            "tagname":"",
            "type":"text",
        };
        $.extend(this._params, params);
        this.initialize(params);
    };
    bee.form.normalinput.prototype = $.extend(new bee.form.baseinput(), {
        disable : function(){
            this._el.find("input").attr({"disabled":true});
        },
        enable : function(){
            this._el.find("input").attr({"disabled":false});
        }
    });
    
    //概率输入框
    bee.form.probabilityinput = function(params){
        this._params = {
            "desc":"建议提示在20字以内",
            "val": "",
            "tips":"",
            "name":"未中奖提示",
            "placeholder":"请输入未中奖提示，例：很遗憾您未中奖，再接再厉！",
            "tagname":"",
            "type":"text",
        };
        $.extend(this._params, params);
        this.initialize(params);
    }
    bee.form.probabilityinput.prototype = $.extend(new bee.form.baseinput(),{
        render : function(){
            this._el = $('<li><span>'+this._params.name+'</span><em class="simpletooltip" data-simpletooltip-theme="blue" data-simpletooltip-border-width="0" title="'+this._params.tips+'" style="cursor: pointer;"><input type="'+this._params.type+'" name="'+ this._params.tagname+'" id="" value="'+this._params.val+'" class="txt '+ this._params.tagname+' short" placeholder="'+this._params.placeholder+'"></em><span style="padding:0 11px;">/</span>100<div class="tips" style="margin-left:156px">'+this._params.desc+'</div></li>');
        },
        validate : function(e){
            this._params.val = $(e.target).val();
            this._params.val = parseFloat(this._params.val);
            // console.log(this._params.val);
            if(isNaN(this._params.val)){
                $(e.target).val('0.00');
            }else{
                if(this._params.val < 0){
                    this._params.val = 0.00;
                }else{
                    this._params.val = this._params.val.toFixed(2);
                    if(this._params.val >= 100.00) this._params.val = 100.00;
                }
                $(e.target).val(this._params.val);
            }
        }
    });


    //生成游戏码
    bee.form.gamecodeinput = function(){
        this._triggername = "prizesetting.couponitem";
        this._params = {
            "desc":['券号前缀适用于由系统自行生成礼券编号，导入券号适用于用户自行生成的礼券编号导入系统','请将您的券号复制到txt文档，每行放置一个券号，注意不要添加多余的字段'],
            "val": {},
            "tips":"",
            "name":"生成券号",
            "placeholder":"请输入4字符位以内的券号前缀，如fmbq",
            "tagname":"gamecode",
            "type":"text",
            "lot_code_setting" : {}
        };
    }
    bee.form.gamecodeinput.prototype = {
        initialize : function(params){
            var self = this;
            $.extend(this._params, params);
            this.render();
            bindAll(this, 'triggerEvt');
            

            this._el.find(".uploadcoupon").fileupload({
                dataType: 'text',
                done: function (e, data) {

                    /*$.extend(self._params.val, {"num":10,"key":'abcdefg'});
                    self.triggerEvt();*/
                    if(data.result){
                        var result = JSON.parse(data.result);
                        if(result.code){
                            _errDlg(result.msg);
                            return;
                        }else{
                            $.extend(self._params.val, result.data);
                            self.triggerEvt();
                            bee.dialog.confirm("导入奖券成功！","您一共导入了"+result.data.num+"张奖券",{
                                "确定":{
                                    "primary":true,
                                    "func":function(){

                                    }
                                }
                            });
                        }
                    }
                }
            });

            this._el.on("click", ".gamecodebtn", function(){
                var actiondata = $(this).attr("action-data");
                    self._el.find(".quanUl>li").removeClass("active");
                    $(this).addClass("active");
                    self._el.find(".quanLi>li").hide();
                    self._el.find("."+actiondata).show();

                    self._params.val.type = $(this).attr("action-type");
                    console.log("change");
                    self.triggerEvt();
            });

            $(this._el).find('input[name=prefix]').blur(function(){
                var prefix = $(this).val();
                    if(!prefix.toString().match(/^[0-9a-zA-Z]{1,4}$/)){
                        _errDlg("请输入四个英文字符以内的劵号前缀...");
                        $(this).addClass("error");
                        return ;
                    }else{
                        $(this).removeClass("error");
                    }
                    self._params.val.prefix = prefix;
                    self.triggerEvt();
            });

            return this;
        },
        render : function(){
            if(this._params.val.type && (this._params.val.prefix || this._params.val.key)){
                this._el = $('<li><span>'+this._params.name+'</span><i id="" class="btnStyleW">奖券已经生成</i></li>');
            }else{
                this._el = $('<li style="margin:-23px 0 -8px">\
                      <span>'+this._params.name+'</span>\
                      <ul class="quanUl">\
                        <li class="gamecodebtn active" action-data="syscreate" action-type="1">没有券号，系统自动生成</li>\
                        <li class="gamecodebtn" action-data="uploadcreate" action-type="2">已有券号，导入系统</li>\
                      </ul>\
                      <ul class="quanLi">\
                        <li class="syscreate" style="display:block;margin-top:-10px">\
                            <input type="text" name="prefix" id="" value="" class="txt" placeholder="'+this._params.placeholder+'" style="margin:15px 0 0 155px" />\
                            <div class="tips" style="margin-left:156px">'+this._params.desc[0]+'</div>\
                        </li>\
                        <li class="uploadcreate">\
                          <em class="upload" style="margin-left:150px;top:-11px"><i class="icoDownload"></i>点击上传<input id="" type="file" name="files[]" data-url="/index.php?s=/Home/editor/uploadcoupon.html" class="set-upload uploadcoupon" multiple></em>\
                          <div class="tips" style="margin-left:156px">'+this._params.desc[1]+'</div>\
                        </li>\
                      </ul>\
                    </li>');
            }
        },
        triggerEvt : function(){
            this._el.trigger(this._triggername,{"lot_code_setting":this._params.val});
        }
    };


    // 排行榜名次组件
    bee.form.rankinput = function(){
        this._params = {
            "triggername" : "",
            "name" : "获奖名次",
            "val" : {
                firstnum : "",
                lastnum : ""
            },
            "desc":"说明：您可以在排行榜中不同名词区间设置不同档次的奖品，但必须保证各获奖名字区间没有间隔"
        }
    }
    bee.form.rankinput.prototype = {
        initialize : function(params){
            var self = this;
            bindAll(this, 'validate');
            $.extend(this._params, params);

            this.render();

            this._el.on("change", "input", function(e){
                self.validate();
                

                var triggerdata = {
                    "lot_code_setting" : self._params.val,
                }
                console.log(triggerdata);
                if(self._params.triggername != ""){
                    self._el.trigger(self._params.triggername, triggerdata);
                }
            });


            return this;
        },
        render : function(){
            this._el = $('<li>\
                            <span>'+this._params.name+'</span>\
                            <input type="text" name="firstnum" id="" value="'+(this._params.val.firstnum || "")+'" class="txt lot_code_setting" placeholder=""  style="width:100px">\
                             ~ \
                            <input type="text" name="lastnum" id=""   value="'+(this._params.val.lastnum || "")+'" class="txt lot_code_setting" placeholder="" style="width:100px">\
                            <div class="tips" style="margin-left:156px">'+this._params.desc+'</div>\
                        </li>')
        },
        validate : function(){
            this._params.val.firstnum = parseInt(this._el.find("input[name=firstnum]").val());
            this._params.val.lastnum = parseInt(this._el.find("input[name=lastnum]").val());

            if(isNaN(this._params.val.firstnum) ||this._params.val.firstnum <= 0  ){
                this._params.val.firstnum = 0;
            }
            if(isNaN(this._params.val.lastnum) || this._params.val.lastnum <= 0 ){
                this._params.val.lastnum = 0;
            }

            // console.log(this._params.val.firstnum + ':firstnum');
            // console.log(this._params.val.lastnum + ':lastnum');
            // console.log(this._params.val.firstnum - this._params.val.endtime);
            if(this._params.val.firstnum && this._params.val.lastnum && this._params.val.firstnum - this._params.val.lastnum > 0){
                this._params.val.lastnum = "";
                _errDlg("名次区间输入错误");
            }
            
            if(this._params.val.firstnum == 0)this._params.val.firstnum="";
            if(this._params.val.lastnum == 0)this._params.val.lastnum="";

            this._el.find("input[name=firstnum]").val(this._params.val.firstnum);
            this._el.find("input[name=lastnum]").val(this._params.val.lastnum);
        }
    }
    
    // 报名规则textarea
    bee.form.textarea = function(params){
        this._params = {
            "val": "",
            "name":"",
            "triggername" : "",
            "tagname":"",
        };
        $.extend(this._params, params);
        this.initialize(params);
    }
    
    bee.form.textarea.prototype = {
        initialize : function(params){
            var self = this;
            bindAll(this, 'validate');
            $.extend(this._params, params);

            this.render();
            
            this._el.find(".regestRule").keyup( function(e) {
                self.validate(e);
                var triggerdata = {};
                triggerdata[self._params.tagname] = self._params.val;
	            if(self._params.triggername != ""){
//	                console.log('trigger:'+self._params.triggername);
	                self._el.trigger(self._params.triggername, triggerdata);
	            }
            });


            return this;
        },
        render : function(){
        	this._el = $('<p class="infoTit"> '+ this._params.name +'： </p>'+
        		'<div class="regestRuleBox">'+
        	    '<textarea name="regestRule" cols="60" rows="10" class="regestRule">'+this._params.val+'</textarea>'+
        	    '<span><i id="textCount">0</i>/60</span>'+
        	    '</div>');
        },
        validate : function(e){
        	this._params.val = $(e.target).val();
        	var len = this._params.val.length;
        	var lessLen = (60 - len) >= 0 ? (60 - len) : 0;
        	$("#textCount").text(lessLen);
            if(len > 60) {
            	_errDlg("超过字数限制，多出的字将被截断！");
            }
        }
    }
    
    //选择时间组件
    bee.form.timeinput = function(){
        this._params = {
            "triggername":"",
            "name" : "",
            "starttime" : "",
            "endtime" : "",
            "desc":"说明：活动时间为开始记录日期的0:00到截止日期的23:59，排行榜成绩将于截止日期结束后进行统计"
        }
    };

    bee.form.timeinput.prototype = {
        initialize : function(params){
            var self = this;
                bindAll(this, 'validate', 'seterr', 'cancelerr');
            $.extend(this._params, params);
            this.render();

            this._el.find("#activeStart").datepicker({minDate: new Date()});
            this._el.find("#activeEnd").datepicker({minDate: new Date()});

            this._el.on("change", "input", function(e){
                var name = $(this).attr('name');
                self._params[name] = self.validate($(this).val());

                var starttime = Math.round(new Date(self._el.find("#activeStart").datepicker("getDate")).getTime()/1000);
                var endtime = Math.round(new Date(self._el.find("#activeEnd").datepicker("getDate")).getTime()/1000);

                if(starttime > endtime && starttime && endtime){
                    _errDlg("结束时间不能小于开始时间");
                    self._params.endtime = self._params.starttime;
                    self._el.find("#activeEnd").datepicker("setDate", self._params.endtime);
                }


                var triggerdata = {
                    "starttime" : self._params.starttime,
                    "endtime"   : self._params.endtime
                }
                if(self._params.triggername != ""){
                    self._el.trigger(self._params.triggername, triggerdata);
                }
            });


            return this;
        },
        render : function(){
            this._el = $('<li>\
                            <span>'+this._params.name+'</span>\
                            <input type="text" name="starttime" readonly="readonly" id="activeStart" value="'+this._params.starttime+'" class="txt activetime icoCalendar" placeholder="活动开始时间" style="width:209px;" />\
                             ~ \
                            <input type="text" name="endtime" readonly="readonly" id="activeEnd" value="'+this._params.endtime+'" class="txt activetime icoCalendar" placeholder="活动结束时间" style="width:209px;" />\
                            <div class="tips" style="margin-left:156px">'+this._params.desc+'</div>\
                        </li>');
        },
        validate : function(val){
            return val;
        },
        seterr : function(el){
            el.addClass('error');
        },
        cancelerr : function(el){
            el.removeClass('error');
        },

    };

    //上传图片组件
    bee.form.uploader = function(params){
        this._params = {
            "val" : "",
            "tagname" : "lot_url",
            "triggername": ""
        }
        this.initialize(params);
    }

    bee.form.uploader.prototype = {
        initialize : function(params){
            var self = this;
            this._params = $.extend(this._params, params);
            if(this._params.val != ""){
                this._previewurl = this._params.val;
                this._params.val = this._params.val.split(/\//).pop();
            }
            // console.log(this._params);
            this.render();
            prizeupload(this._el,function(res){
                if(res.success){
                    self._params.val = res.filename;
                    var triggerdata = {};
                        triggerdata[self._params.tagname] = '/Public/gamecreator/app/'+ token + '/' + self._params.val;
                        console.log(self._params);
                    if(self._params.triggername != ""){
                        self._el.trigger(self._params.triggername, triggerdata);
                    }
                }
            });
        },
        render : function(){
            this._el = $('<li style="">\
                  <span>奖品图片</span>\
                  <div class="fileInputContainer upload"><em class="f16"><i class="icoDownload"></i>点击上传</em>\
                    <input id="" type="file" name="files[]" data-url="/index.php?s=/Home/editor/settingUpload/appid/'+gamecreator.app_id+'/filename/.html" class="set-upload fileInput prize_uploader" multiple>\
                  </div>\
                  <span class="fgray f12">推荐尺寸：300px*300px 图片不得超过800KB</span>\
                  <div class="img-preview" action-name="'+this._params.val+'"></div>\
                </li>');

            if(this._params.val != ""){
                // console.log(this._el.find('.img-preview'));
                // console.log('<img src="'+this._previewurl+'?t='+new Date().getTime()+'/>');
                this._el.find('.img-preview').addClass("act").html('<img src="'+this._previewurl+'?t='+new Date().getTime()+'"/>');
            }

        },
    }

    // 抽奖设置
    bee.prizesetting = bee.prizesetting || {};

    // 抽奖设置 tabs
    bee.prizesetting.tabs = function(params){
        var self = this;
            this._cur = '';
            this._el = params.el;
            this._renddata = params.renddata;
            bindAll(this, 'change');
            this.initialize();
    };

    bee.prizesetting.tabs.prototype = {
        //初始化
        initialize : function(){
            var self = this;
                this.render();
                
                this._el.on("click", ".tabs>li", function(e){
                    var _actel = $(e.target);
                        if( !_actel.hasClass("disable") && !_actel.hasClass("active") ) {
                            self._el.find(".tabs>li").removeClass("active");
                            _actel.addClass("active");
                            self._el.trigger("tabs.change",{"actiondata":_actel.attr("action-data"),});
                        }
                });
                this._el.bind("tabs.change", this.change);

        },
        //显示tabs
        render : function(){
            var str = '<ul class="tabs clearfix">',_len = this._renddata.length, i = 0;
                for ( i = 0; i < _len; i++ ) {
                    var _class = '';
                        if(this._renddata[i].active) {
                            _class = 'active';
                            this._cur = this._renddata[i].sid;
                            $("#"+this._cur).removeClass("hide");
                        }
                        if(this._renddata[i].disable) _class += " hide";
                        str += '<li class="' + _class + '" action-data="'+this._renddata[i].sid+'">' + this._renddata[i].name + '</li>';
                };
                str += '</ul>';
                str += '<div class="rank-tips" style="">排行榜规则:取本模板玩家游戏的最高成绩进行排名；排名依据为游戏得分，得分越高的玩家在排行榜中的名次越靠前。</div>';
                this._el.append(str);
                this.ranktips();
        },
        //tabs切换导致表单区域的切换显示
        change : function(e, data){
            $("#"+this._cur).addClass("hide");
            $("#"+data.actiondata).removeClass("hide");
            _scroll(this._el);
            this._cur = data.actiondata;
            this.ranktips();
        },
        ranktips : function(){
            if(this._cur != "tabsrank"){
                 this._el.find(".rank-tips").hide();
             }else{
                 this._el.find(".rank-tips").show();
             }
        }
    };

    // 抽奖设置表单 collection
    bee.prizesetting.tabsraffle = function(params){
        this.raffletype = 0;
        this._params = params;
        this.settings = {
            prizes : [],
            nowinmsg : "",
            winrepeattimes : 1,
            isallowrepeatwin : 0
        };
        // this.initialize(params);
    };

    bee.prizesetting.tabsraffle.prototype = {
        initialize : function(){
            bindAll(this, 'add', 'addAll','delitem','triggerDelbtn');
            this._el = this._params.el;
            $.extend(this.settings, this._params.data);
            this._collection = [];
            this._plusbtn = new bee.btn.plusbtn({"name":"添加奖品","triggername":"raffle.add"});
            this._raffleitem_project = new bee.prizesetting.raffleitem_project().initialize({
                "val":{
                    "nowinmsg" : this.settings.nowinmsg,
                    "isallowrepeatwin" : this.settings.isallowrepeatwin,
                    "winrepeattimes" : this.settings.winrepeattimes
                }
            });
            this.render();

            this._plusbtn._el.bind("raffle.add", this.add);

            $(document).bind('prizesetting.raffleitem.delete', this.delitem);

            return this;
        },
        render : function(){
            // plusbtn
            this._el.append(this._plusbtn._el);
            this._el.append('<div class="prize-list fl"></div>');
            // prizeitem
            this.addAll();
            // nowinitem
            this._el.append(this._raffleitem_project._el);

        },
        addAll : function(){
            var length = this.settings.prizes.length;
            if(length > 0){
                for (var i = 0; i < length; i++) {
                    this.add({}, this.settings.prizes[i]);
                };
            }else{
                this.add({},{});
            }
        },
        delitem : function(){
            console.log('delitem');
            console.log(this._collection.length);
            for(item in this._collection){
                if(this._collection[item]._params == null){
                    this._collection.splice(item,1);
                }
            }
            console.log(this._collection.length);
            this.triggerDelbtn();
        },
        add : function(e, data){
            console.log('raffle add');
            var tmpobj = new bee.prizesetting.raffleitem().initialize(data);
            this._collection.push(tmpobj);
            this._el.find(".prize-list").append(tmpobj._el);
            tips();
            prizeupload();
            this.triggerDelbtn();
        },
        triggerDelbtn : function(){
            console.log('this._collection.length='+this._collection.length);
            if(this._collection.length > 1){
                $(document).trigger('prizesetting.tabsraffle.show');
            }else{
                $(document).trigger('prizesetting.tabsraffle.hide');
            }
        },
        getsetting : function(){
            this.settings.prizes = [];
            var allprob = 0;
            for (var i = 0; i < this._collection.length; i++) {
                if(this._collection[i]._params == null){

                }else{
                    console.log(this._collection[i]._params);
                    //验证
                    if(this._collection[i]._params.lot_desc == ""){
                        _errDlg('奖项名称不能为空');
                        return;
                    }
                    if(this._collection[i]._params.lot_name == ""){
                        _errDlg('奖品名称不能为空');
                        return;
                    }
                    if(this._collection[i]._params.probability == ""){
                        _errDlg('中奖概率数值区间需为0~100');
                        return;
                    }
                    if(this._collection[i]._params.lot_count == ""){
                        _errDlg('奖品数量必须存在且为数字');
                        return;
                    }
                    if(this._collection[i]._params.lot_winning_tips == ""){
                        _errDlg('中奖提示不能为空');
                        return;
                    }
                    if(this._collection[i]._params.lot_url == ""){
                        _errDlg('奖品图片必须存在');
                        return;
                    }
                    this.settings.prizes.push(this._collection[i]._params);

                    allprob += parseFloat(this._collection[i]._params.probability);
                }
            };
            // this.settings.nowinmsg = this._raffleitem_project._params.val;
            $.extend(this.settings, this._raffleitem_project._params.val);

            if(this.settings.nowinmsg == ""){
                _errDlg('未中奖提示语不能为空');
                return;
            }

            if(allprob > 100){
                _errDlg('总概率之和不能超过100%');
                return;
            }

            return this.settings;
        }
    };

    bee.prizesetting.raffleitem = function(){
        this._triggername = "prizesetting.raffleitem";
        this._params = {
            "id" : "",
            "lot_name" : "",
            "lot_count" : "",
            "lot_desc" : "",
            "probability" : "",
            "lot_winning_tips" : "",
            "lot_url" : "",
            "lot_type" : 0,

        }
    };

    bee.prizesetting.raffleitem.prototype = {
        initialize : function(params){
            bindAll(this, 'destroy','setval');
            // this._params = $.extend(this._params, params);
            this._params = this.unique(this._params, params);
            console.log(this._params);
            this.lot_desc = new bee.form.normalinput({
                "desc":"",
                "val": this._params.lot_desc,
                "name":"奖项名称",
                "placeholder":"请输入奖项类型的名称，例：一等奖、创新奖...",
                "tagname":"lot_desc",
                "type":"text",
                "tips":"为保证游戏体验，此处建议输入7个汉字以内",
                "triggername":this._triggername
            });
            this.lot_name = new bee.form.normalinput({
                "desc":"",
                "val": this._params.lot_name,
                "name":"奖品名称",
                "placeholder":"请输入奖品名称    例：iPhone6",
                "tagname":"lot_name",
                "type":"text",
                "tips":"为保证游戏体验，此处建议输入8个汉字以内",
                "triggername":this._triggername
            });
            this.lot_winning_tips = new bee.form.normalinput({
                "desc":"",
                "val": this._params.lot_winning_tips,
                "name":"中奖提示",
                "placeholder":"请输入中奖描述    例：恭喜你！",
                "tagname":"lot_winning_tips",
                "type":"text",
                "tips":"为保证游戏体验，此处建议输入20个汉字以内",
                "triggername":this._triggername
            });

            this.lot_count = new bee.form.normalinput({
                "desc":"",
                "val": this._params.lot_count,
                "name":"奖品数量",
                "placeholder":"请输入奖品发放数量    例：100",
                "tagname":"lot_count",
                "type":"text",
                "tips":"请输入奖品发放数量，必须为数字",
                "triggername":this._triggername
            });

            this.probability = new bee.form.probabilityinput({
                "desc":"说明：中奖概率填写范围为0-100，未中奖概率=100%-各中奖概率之和。各中奖概率之和小于等于100",
                "val": this._params.probability,
                "name":"中奖概率",
                "placeholder":"0",
                "tagname":"probability",
                "type":"text",
                "tips":"请输入本产品的中奖概率权重：数值区间为0~100",
                "triggername":this._triggername
            });

            this.uploader = new bee.form.uploader({"triggername":this._triggername,"val":this._params.lot_url});

            this.delbtn = new bee.prizesetting.delbtn({parent_tag:'prizesetting.tabsraffle'});

            this.delbtn._el.bind("prizesetting.del",this.destroy);

            this.render();

            // 监听变化
            this.lot_desc._el.bind(this._triggername,this.setval);
            this.lot_name._el.bind(this._triggername,this.setval);
            this.lot_count._el.bind(this._triggername,this.setval);
            this.lot_winning_tips._el.bind(this._triggername,this.setval);
            this.probability._el.bind(this._triggername,this.setval);
            this.uploader._el.bind(this._triggername,this.setval);
            return this;
        },
        render : function(){
            this._el = $('<div class="prize-item" style=""><ul></ul></div>');
            this._el.find("ul").append(this.lot_desc._el);
            this._el.find("ul").append(this.lot_name._el);
            this._el.find("ul").append(this.probability._el);
            this._el.find("ul").append(this.lot_count._el);
            this._el.find("ul").append(this.lot_winning_tips._el);
            this._el.find("ul").append(this.uploader._el);
            this._el.append(this.delbtn._el);
        },
        destroy : function(params){
            var self = this;
            bee.dialog.confirm("是否确认删除此奖项？","删除后不可恢复",{
                "确定删除":{
                    "primary":true,
                    "func":function(){
                        if(self._params.id){
                            $.post('/index.php?s=Home/editor/delsetting/id/' + self._params.id + '.html',{},function(res){
                                // console.log(res);
                            });
                        }
                        self._el.remove();
                        self._params = null;
                        console.log('delete trigger name :' + self._triggername+'.delete');
                        $(document).trigger(self._triggername+".delete");
                    }
                },
                "取消":{
                    "primary":false,
                    "func":function(){
                        // console.log('false')
                    }
                }
            });
            // console.log(this._params);

        },
        setval : function(e, data){
            console.log('setval func');
            console.log(data);
            console.log(this._params);
            this._params = $.extend(this._params, data);
            console.log(this._params);
        },
        unique : function(params,data){
            for(var key in params){
                if(typeof(data[key]) != "undefined"){
                    params[key] = data[key];
                }
            }
            return params;
        }
    };

    //抽奖属性设置
    bee.prizesetting.raffleitem_project = function(){
        this._params = {
            "triggername" : "prizesetting.raffleitem_project",
            "val":{},
        }
    };

    bee.prizesetting.raffleitem_project.prototype = {
        initialize : function(params){
            var self = this;
                bindAll(this, 'setval');
                $.extend(this._params, params);
                this._nowininput = new bee.form.nowininput({
                    "triggername" : this._params.triggername,
                    "val" : this._params.val.nowinmsg
                });
                this._winrepeatinput = new bee.form.winrepeatinput().initialize({
                    "triggername" : this._params.triggername,
                    "val":{
                            "isallowrepeatwin" : this._params.val.isallowrepeatwin,
                            "winrepeattimes" : this._params.val.winrepeattimes
                        }
                });
                this.render();

                this._nowininput._el.bind(this._params.triggername, this.setval);
                this._winrepeatinput._el.bind(this._params.triggername, this.setval);

                return this;
        },
        render : function(){
            this._el = $('<div class="baseBox fl mb60"><ul></ul></div>');
            this._el.find("ul").append(this._nowininput._el);
            this._el.find("ul").append(this._winrepeatinput._el);
        },
        setval : function(e, data){
            $.extend(this._params.val, data);
            console.log(this._params.val);
        }
    }

    // 奖券表单
    bee.prizesetting.tabscoupon = function(params){
        this.raffletype = 1;
        this._params = params;
        this.settings = {
            prizes : [],
            nowinmsg : ""
        };
        // this.initialize(params);
    };

    bee.prizesetting.tabscoupon.prototype = $.extend(new bee.prizesetting.tabsraffle({}),{
        initialize : function(){
            bindAll(this, 'add', 'addAll','triggerDelbtn','delitem');
            this._el = this._params.el;
            $.extend(this.settings, this._params.data);
            this._collection = [];
            this._plusbtn = new bee.btn.plusbtn({"name":"添加奖券","triggername":"coupon.add"});
            this._raffleitem_project = new bee.prizesetting.raffleitem_project().initialize({
                "val":{
                    "nowinmsg" : this.settings.nowinmsg,
                    "isallowrepeatwin" : this.settings.isallowrepeatwin,
                    "winrepeattimes" : this.settings.winrepeattimes
                }
            });
            this.render();
            this._plusbtn._el.bind("coupon.add", this.add);
            $(document).bind('prizesetting.couponitem.delete', this.delitem);
            return this;
        },
        triggerDelbtn : function(){
            if(this._collection.length > 1){
                $(document).trigger('prizesetting.tabscoupon.show');
            }else{
                $(document).trigger('prizesetting.tabscoupon.hide');
            }
        },
        add : function(e, data){
            var tmpobj = new bee.prizesetting.couponitem().initialize(data);
            this._collection.push(tmpobj);
            this._el.find(".prize-list").append(tmpobj._el);
            tips();
            this.triggerDelbtn();
        },
        getsetting : function(){
            this.settings.prizes = [];
            var allprob = 0;
            for (var i = 0; i < this._collection.length; i++) {
                if(this._collection[i]._params == null){
                    //
                }else{
                    // console.log(this._collection[i]._params);
                    //验证
                    if(this._collection[i]._params.lot_name == ""){
                        _errDlg('礼券名称不能为空');
                        return;
                    }
                    if(this._collection[i]._params.probability == ""){
                        _errDlg('中奖概率数值区间需为0~100');
                        return;
                    }
                    if(this._collection[i]._params.lot_winning_tips == ""){
                        _errDlg('中奖提示不能为空');
                        return;
                    }

                    if(this._collection[i]._params.lot_code_setting.type == undefined){
                        _errDlg('请选择生成奖券');
                        return;
                    }
                    if(this._collection[i]._params.lot_code_setting.type == 1 && !this._collection[i]._params.lot_code_setting.prefix){
                        _errDlg('券号前缀必须存在');
                        return;   
                    }

                    if(this._collection[i]._params.lot_code_setting.type == 2 && !this._collection[i]._params.lot_code_setting.key){
                        _errDlg('请导入符合要求的券号');
                        return;   
                    }



                    if(this._collection[i]._params.lot_count == ""){
                        _errDlg('奖品数量必须存在且为数字');
                        return;
                    }
                    this.settings.prizes.push(this._collection[i]._params);
                    allprob += parseFloat(this._collection[i]._params.probability);
                }
            };
            // this.settings.nowinmsg = this._nowininput._params.val;
            $.extend(this.settings, this._raffleitem_project._params.val);
            if(this.settings.nowinmsg == ""){
                _errDlg('未中奖提示语不能为空');
                return;
            }

            if(allprob > 100){
                _errDlg('总概率之和不能超过100%');
                return;
            }

            return this.settings;
        }
    });

    bee.prizesetting.couponitem = function(){
        this._triggername = "prizesetting.couponitem";
        this._params = {
            "id" : "",
            "lot_name" : "",
            "lot_count" : "",
            // "lot_desc" : "",
            "probability" : "",
            "lot_winning_tips" : "",
            // "lot_url" : "",
            "lot_type" : 1,
            "lot_code_setting" : {
                "type":1,
                "num":"",
                "prefix":"",
                "key":""
            },
        }
    }

    bee.prizesetting.couponitem.prototype = $.extend(new bee.prizesetting.raffleitem(),{
        initialize : function(params){
            bindAll(this, 'destroy','setval','update_lot_code_setting');
            // this._params = $.extend(this._params, params);
            this._params = this.unique(this._params, params);
            this.lot_name = new bee.form.normalinput({
                "desc":"",
                "val": this._params.lot_name,
                "name":"礼券名称",
                "placeholder":"请输入礼券名称    例：iPhone6",
                "tagname":"lot_name",
                "type":"text",
                "tips":"为保证游戏体验，此处建议输入8个汉字以内",
                "triggername":this._triggername
            });
            this.lot_winning_tips = new bee.form.normalinput({
                "desc":"",
                "val": this._params.lot_winning_tips,
                "name":"中奖提示",
                "placeholder":"请输入中奖描述    例：恭喜你！",
                "tagname":"lot_winning_tips",
                "type":"text",
                "tips":"为保证游戏体验，此处建议输入20个汉字以内",
                "triggername":this._triggername
            });

            this.lot_count = new bee.form.normalinput({
                "desc":"",
                "val": this._params.lot_count,
                "name":"礼券数量",
                "placeholder":"请输入礼券发放数量    例：100",
                "tagname":"lot_count",
                "type":"text",
                "tips":"",
                "triggername":this._triggername
            });

            if(this._params.id){
                this.lot_count.disable();
            }

            this.probability = new bee.form.probabilityinput({
                "desc":"说明：中奖概率填写范围为0-100，未中奖概率=100%-各中奖概率之和。各中奖概率之和小于等于100",
                "val": this._params.probability,
                "name":"中奖概率",
                "placeholder":"0",
                "tagname":"probability",
                "type":"text",
                "tips":"请输入本产品的中奖概率权重：数值区间为0~100",
                "triggername":this._triggername
            });
            this.gamecode = new bee.form.gamecodeinput().initialize({'val' : this._params.lot_code_setting});
            this.delbtn = new bee.prizesetting.delbtn({parent_tag:'prizesetting.tabscoupon'});

            this.delbtn._el.bind("prizesetting.del",this.destroy);

            this.render();

            // 监听变化
            this.lot_name._el.bind(this._triggername,this.setval);
            this.lot_count._el.bind(this._triggername,this.setval);
            this.lot_winning_tips._el.bind(this._triggername,this.setval);
            this.probability._el.bind(this._triggername,this.setval);
            this.gamecode._el.bind(this._triggername,this.update_lot_code_setting);
            return this;
        },
        render : function(){
            this._el = $('<div class="prize-item" style=""><ul></ul></div>');
            this._el.find(">ul").append(this.lot_name._el);
            this._el.find(">ul").append(this.probability._el);
            this._el.find(">ul").append(this.lot_winning_tips._el);
            this._el.find(">ul").append(this.gamecode._el);
            this._el.find(">ul").append(this.lot_count._el);
            this._el.append(this.delbtn._el);
        },
        update_lot_code_setting : function(e, data){
            $.extend(this._params, data);
            //联动
            if(data.lot_code_setting.type == 1){
                //自动生成
                this.lot_count.enable();
            }else if(data.lot_code_setting.type == 2){
                this.lot_count.disable();
                if(data.lot_code_setting.num){
                    this.lot_count._el.find("input").val(data.lot_code_setting.num);
                    this._params.lot_count = data.lot_code_setting.num;
                }
            }
        }
    });

    // 排行榜活动信息
    bee.prizesetting.rankitem_project = function(){
        this._triggername = "prizesetting.rankitem_pro";
        this._params = {
            "starttime":"",
            "endtime":"",
            "prizeruledesc":""
        }
    }
    bee.prizesetting.rankitem_project.prototype = $.extend(new bee.prizesetting.raffleitem(), {
        initialize : function(params){
            bindAll(this, 'destroy','setval');
            $.extend(this._params, params);
            this._timeinput = new bee.form.timeinput().initialize({"name":"活动时间","starttime":this._params.starttime,"endtime":this._params.endtime,"triggername":this._triggername});
            this._prizeruledescinput = new bee.form.normalinput({
                "name" : "领奖描述",
                "placeholder":"关注某某公众号，我们将在活动时间结束的三个工作日内与你取得联系！",
                "val":this._params.prizeruledesc,
                "desc":"请将兑奖方式在此填写清楚，在排行榜结算后可以在此项目的数据中查看对应名次的玩家昵称，推荐在此让玩家关注公众账号，并使用公众账号与中奖者进行联系，不得超过40个汉字",
                "triggername":this._triggername,
                "tagname":"prizeruledesc"
            });

            this.render();

            this._prizeruledescinput._el.bind(this._triggername, this.setval);
            this._timeinput._el.bind(this._triggername, this.setval);

            return this;
        },
        render : function(){
            this._el = $('<div class="prize-item pro" style=""><ul></ul></div>');
            this._el.find("ul").append(this._timeinput._el);
            this._el.find("ul").append(this._prizeruledescinput._el);
        }
    });
    
    // 排行榜表单
    bee.prizesetting.tabsrank = function(params){
            this.raffletype = 2;
    	   this._params = params;
           this.settings = {
               prizes : [],
               // nowinmsg : "",
               starttime: "",
               endtime : "",
               prizeruledesc: ""
           };
         
    };

    bee.prizesetting.tabsrank.prototype = $.extend(new bee.prizesetting.tabsraffle(),{
            initialize : function(){
                bindAll(this, 'add', 'addAll','triggerDelbtn','delitem');
                this._el = this._params.el;

                $.extend(this.settings, this._params.data);
                this._collection = [];
                
                this._projectitem = new bee.prizesetting.rankitem_project().initialize({
                    "starttime":this.settings.starttime,
                    "endtime":this.settings.endtime,
                    "prizeruledesc":this.settings.prizeruledesc
                });

                this._plusbtn = new bee.btn.plusbtn({"name":"添加奖品","triggername":"rank.add"});
                this.render(this._params.data);
              
                this._plusbtn._el.bind("rank.add", this.add);
                $(document).bind('prizesetting.rankitem.delete', this.delitem);
                return this;
            },
           
            render : function(data){
            	
                // plusbtn
                this._el.append(this._projectitem._el);
                this._el.append(this._plusbtn._el);
                this._el.append('<div class="prize-list fl"></div>');
                // prizeitem
                this.addAll();
                // nowinitem
            },
            triggerDelbtn : function(){
                if(this._collection.length > 1){
                    $(document).trigger('prizesetting.tabsrank.show');
                }else{
                    $(document).trigger('prizesetting.tabsrank.hide');
                }
            },
            add : function(e, data){
                var tmpobj = new bee.prizesetting.rankitem().initialize(data);
                this._collection.push(tmpobj);
                this._el.find(".prize-list").append(tmpobj._el);
                tips();
                prizeupload();
                this.triggerDelbtn();
            },
            getsetting : function(){

                this.settings.starttime = this._projectitem._params.starttime;
                this.settings.endtime = this._projectitem._params.endtime;
                this.settings.prizeruledesc = this._projectitem._params.prizeruledesc;

                if(this.settings.starttime == ""){
                    _errDlg('活动开始时间不能为空');
                    return;
                }
                
                if(this.settings.endtime == ""){
                    _errDlg('活动结束时间不能为空');
                    return;
                }

                if(this.settings.prizeruledesc == ""){
                    _errDlg('领奖描述不能为空');
                    return;
                }


                this.settings.prizes = [];
                for (var i = 0; i < this._collection.length; i++) {
                    if(this._collection[i]._params == null){
                        
                    }else{
                        console.log(this._collection[i]._params);
                        //验证
                        if(this._collection[i]._params.lot_code_setting == null || !this._collection[i]._params.lot_code_setting.firstnum || !this._collection[i]._params.lot_code_setting.lastnum){
                            _errDlg('获奖名次不能为空');
                            return;
                        }

                        this._collection[i]._params.lot_count = this._collection[i]._params.lot_code_setting.lastnum - this._collection[i]._params.lot_code_setting.firstnum + 1;


                        if(this._collection[i]._params.lot_desc == ""){
                            _errDlg('奖项名称不能为空');
                            return;
                        }
                        if(this._collection[i]._params.lot_name == ""){
                            _errDlg('奖品名称不能为空');
                            return;
                        }
                        if(this._collection[i]._params.lot_url == ""){
                            _errDlg('奖品图片必须存在');
                            return;
                        }
                        this.settings.prizes.push(this._collection[i]._params);
                    }
                };

                return this.settings;
            }
        });

    
     bee.prizesetting.rankitem = function(){
        this._triggername = "prizesetting.rankitem";
        this._params = {
            "id":'',
            "lot_code_setting" : {},
            "lot_name" : "",
            "lot_desc" : "",
            "lot_url" : "",
            "lot_type" : 2,

        };
    };
    
     bee.prizesetting.rankitem.prototype = $.extend(new bee.prizesetting.raffleitem(), {
        initialize : function(params){
            bindAll(this, 'destroy','setval');
            this._params = this.unique(this._params, params); 
            console.log('rankitem');
            console.log(this._params);
            this.lot_code_setting = new bee.form.rankinput().initialize({
                "desc":"说明：您可以在排行榜中不同名次区间设置不同档次的奖品，但必须保证各获奖名次区间没有间隔。",
                "val": this._params.lot_code_setting || {"firstnum":"","lastnum":""},
                "name":"获奖名次",
                "placeholder":"1",
                "tagname":"lot_code_setting",
                "type":"text",
                "tips":"",
                "triggername":this._triggername
            });
            
            this.lot_desc = new bee.form.normalinput({
                "desc":"",
                "val": this._params.lot_desc,
                "name":"奖项名称",
                "placeholder":"请输入奖项类型的名称，例：一等奖、创新奖...",
                "tagname":"lot_desc",
                "type":"text",
                "tips":"为保证游戏体验，此处建议输入7个汉字以内",
                "triggername":this._triggername
            });
            this.lot_name = new bee.form.normalinput({
                "desc":"",
                "val": this._params.lot_name,
                "name":"奖品名称",
                "placeholder":"请输入奖品名称    例：iPhone6",
                "tagname":"lot_name",
                "type":"text",
                "tips":"为保证游戏体验，此处建议输入8个汉字以内",
                "triggername":this._triggername
            });
        
            this.uploader = new bee.form.uploader({"triggername":this._triggername,"val":this._params.lot_url});
            this.delbtn = new bee.prizesetting.delbtn({parent_tag:'prizesetting.tabsrank'});
            this.delbtn._el.bind("prizesetting.del",this.destroy);
            this.render();

            // 监听变化
            this.lot_desc._el.bind(this._triggername,this.setval);
            this.lot_name._el.bind(this._triggername,this.setval);
            this.lot_code_setting._el.bind(this._triggername,this.setval);
            this.uploader._el.bind(this._triggername,this.setval);
            return this;
        },
        render : function(){
            this._el = $('<div class="prize-item" style=""><ul></ul></div>');
            this._el.find("ul").append(this.lot_code_setting._el);
            this._el.find("ul").append(this.lot_desc._el);
            this._el.find("ul").append(this.lot_name._el);
            this._el.find("ul").append(this.uploader._el);
            this._el.append(this.delbtn._el);
        }
    });
     
     
  // 排行榜活动信息
     bee.prizesetting.entryitem_project = function(){
         this._triggername = "prizesetting.entryitem_pro";
         this._params = {
             "formruledesc" : ""
         }
     }
     bee.prizesetting.entryitem_project.prototype = $.extend(new bee.prizesetting.raffleitem(), {
         initialize : function(params){
             bindAll(this, 'setval');
             $.extend(this._params, params);
             this._formruledesc = new bee.form.textarea({
                 "name" : "请输入报名规则",
                 "val":this._params.formruledesc,
                 "triggername":this._triggername,
                 "tagname":"formruledesc"
             });

             this.render();

             this._formruledesc._el.bind(this._triggername, this.setval);

             return this;
         },
         render : function(){
             this._el = this._formruledesc._el;
         }
     });
     
     // 报名表单
     bee.prizesetting.tabsentry = function(params){
            this.raffletype = 4;
            this._params = params;
            this.settings = {
            	default_formitems : [],
            	custom_formitems : [],
            	formitems : [],
            	formruledesc : "",
            };
          
     };

     bee.prizesetting.tabsentry.prototype = $.extend(new bee.prizesetting.tabsraffle(),{
             initialize : function(){
            	 var self = this;
                 bindAll(this, 'addDefaultTabItem', 'addCustomTabItem', 'addCustomTabItemxx', 'addListItem', 'addAll','triggerDelbtn','delitem');
                 this._el = this._params.el;

                 $.extend(this.settings, this._params.data);
                 this._collection = [];

                 this._projectitem = new bee.prizesetting.entryitem_project().initialize({
                     "formruledesc" : this.settings.formruledesc
                 });
                 
                 //this._entryform = new bee.form.textarea({});
                 
                 this._pluscheckbox = new bee.btn.pluscheckbox({"name":"添加奖品","triggername":"entrytab.add","tips":"为保证游戏体验，此处建议输入2-5个汉字以内"});
                 this._pluscheckbox._el.bind("entrytab.add", this.addCustomTabItemxx);
                 
                 this.render(this._params.data);
                 
                 // 自定义表单，拖动
                 $( ".registPrizeItem ul" ).sortable({
                	 placeholder: "ui-state-highlight" , //拖动时，用css
             	     cursor: "move",
             	     items :"li",                        //只是li可以拖动
             	     opacity: 0.6                   	//拖动时，透明度为0.6
                 });
                 $( ".registPrizeItem ul" ).disableSelection();
                 return this;
             },
            
             render : function(data){
                 this._el.append('<div class="prize-list fl">\
            		 <div class="prize-item registerBox f16">\
	            		 <h4>点击添加您需要收集的报名信息：</h4>\
	            	     <div id="registerDefaultTabBox" class="registerTabBox line clearfix"><ul></ul></div>\
	            	     <div id="registerCustomTabBox" class="registerTabBox clearfix"><ul></ul></div>\
            		 </div>\
                 </div>');
                 this._el.append('<p class="infoTit fl mt20">拖动右侧箭头可直接变换各信息的顺序，为保证体验，报名信息建议不超过5个为宜 </p>');
                 this._el.append('<div class="prize-list fl"><div class="prize-item registPrizeItem"><ul>'+
                		 '</ul></div></div>');
                 this._el.append('<div class="prize-list fl"><div class="prize-item regestRuleBoxText"></div></div>');
                 this._el.find(".registerBox").append(this._pluscheckbox._el);
                 this._el.find(".regestRuleBoxText").append(this._projectitem._el);
                 // prizeitem
                 this.addAll();
                 // nowinitem
             },
             addAll : function() {
            	 var allFormItems = new Array();
            	 for(i in this.settings.default_formitems) {
            		 this.addDefaultTabItem({}, this.settings.default_formitems[i]);
            		 allFormItems[i] = this.settings.default_formitems[i];
            	 }
            	 
            	 for(i in this.settings.custom_formitems) {
            		 this.addCustomTabItem({}, this.settings.custom_formitems[i]);
            		 allFormItems[i] = this.settings.custom_formitems[i];
            	 }
            	 
            	 for(i in this.settings.formitems) {
            		 var itemKey = this.settings.formitems[i];
            		 if(typeof(allFormItems[itemKey]) != 'undefined') {
            			 var curFormItem = allFormItems[itemKey];
            			 $('.registerTabBox input[type=checkbox][id='+curFormItem.name+']').attr('checked', true);
            			 this.addListItem({}, curFormItem);
            		 }
            	 }
            	 
            	 for(i in allFormItems) {
            		 var tarFormItem = allFormItems[i];
            		 this.triggerInitTab($('.registerTabBox input[type=checkbox][id='+tarFormItem.name+']'));
            	 }
             },
             triggerDelbtn : function(){
                if(this._collection.length > 1){
                     $(document).trigger('prizesetting.tabsentry.show');
                 }else{
                     $(document).trigger('prizesetting.tabsentry.hide');
                 }
             },
             triggerInitTab : function(el){
            	 var self = this;
            	 el.button()
	            	 .change(function () {
	            		 if(this.checked == false) {
	                		 var itemText = $(this).next().text();
	                		 var elem = "label:contains(" + itemText + ")";
	                		 $('.registPrizeItem ul').find(elem).parent().remove();
	                	 } else {
	                		 var itemProps = $(this).attr('action-data').split("|");
	                		 self.addListItem({}, {"id":itemProps[0],"name":itemProps[1],"label":itemProps[2],"type":itemProps[3],"rule":itemProps[4]});
	                	 }
	            	 });
             },
             triggerDelTab : function(el){
            	 el.parent().hover(function(){
            		 el.css('display','inline-block'); 
            	 }, function(){
            		 el.css('display','none'); 
            	 });
            	 
            	 el.click(function(){
            		 var actionData = el.parent().find("input[type=checkbox]").attr("action-data").split("|");
            		 var itemId 	= parseInt(actionData[0]);
            		 var itemLabel 	= actionData[2];
                	 if(false != itemId) {
                 		$.post('/index.php?s=Home/editor/delformdictitem.html', {id:itemId}, function(res) {
                             if(res.status == 1) {
    	                		 var elem = "label:contains(" + itemLabel + ")";
    	                		 $('.registPrizeItem ul').find(elem).parent().remove();
                            	 el.parent().remove();
                             } else {
                             	_errDlg(res.info);
                             }
                         });
                	 }
            	 });
            	 
             },
             addDefaultTabItem : function(e, data){
                 var tmpTabObj = new bee.prizesetting.entrytabitem().initialize(data);
                 this._el.find("#registerDefaultTabBox ul").append(tmpTabObj._el);
//                 this.triggerDelbtn();
             },
             addCustomTabItem : function(e, data){
                 var tmpTabObj = new bee.prizesetting.entrytabitem().initialize(data);
                 this._el.find("#registerCustomTabBox ul").append(tmpTabObj._el);
                 this.triggerDelTab(tmpTabObj._el.find(".delBtnHid"));
                 
//                 this.triggerDelbtn();
             },
             addCustomTabItemxx : function(e, data){
                 var tmpTabObj = new bee.prizesetting.entrytabitem().initialize(data);
                 this._el.find("#registerCustomTabBox ul").append(tmpTabObj._el);
                 this.triggerInitTab(tmpTabObj._el.find("input[type=checkbox]"));
                 this.triggerDelTab(tmpTabObj._el.find(".delBtnHid"));
                 tips();
//                 tips();
//                 this.triggerDelbtn();
             },
             addListItem : function(e, data){
                 var tmpObj = new bee.prizesetting.entryitem().initialize(data);
                 this._el.find(".registPrizeItem ul").append(tmpObj._el);
                 this._collection.push(tmpObj);
                 this.triggerDelbtn();
             },
             getsetting : function(){
            	 this.settings.resultformitems = [];
            	 var collection = $( ".registPrizeItem ul" ).sortable('toArray');
            	 for (var i = 0; i < collection.length; i++) {
            		 var colArr = collection[i].split("_");
            		 this.settings.resultformitems.push(colArr[1]);
            	 }

            	 this.settings.formruledesc = this._projectitem._params.formruledesc;
                 if(this.settings.formruledesc == ""){
                     _errDlg('请输入报名规则不能为空');
                     return;
                 }
                 
                 for (i in this.settings) {
					 if(-1 != $.inArray( i, ['formitems', 'default_formitems', 'custom_formitems'] )) {
						 delete this.settings[i];
					 }
                 }
                 
                 return this.settings;
             }
         });

     
      bee.prizesetting.entrytabitem = function(){
         this._triggername = "prizesetting.entrytabitem";
         this._params = {
             "id":'',
             "name" : '',
             "label" : '',
             "type" : ''
         };
     };
     
     bee.prizesetting.entrytabitem.prototype = $.extend(new bee.prizesetting.raffleitem(), {
         initialize : function(params){
             bindAll(this, 'destroy','setval');
             this._params = this.unique(this._params, params);
             this.render();
             return this;
         },
         render : function(){
        	var actionData = this._params.id+'|'+this._params.name+'|'+this._params.label+'|'+this._params.type;
        	this._el = $('<li class="fl"><input type="checkbox" id="'+ this._params.name +'" name="formitem['+ this._params.name +']" value="'+ this._params.id +'"\
        			action-data="'+ actionData +'" /><label for="'+ this._params.name +'">'+ this._params.label +'</label>\
        			<i class=\"delBtnHid\"></i></li>');
         }
     });
     
     bee.prizesetting.entryitem = function(){
         this._triggername = "prizesetting.entryitem";
         this._params = {
             "id":'',
             "name" : '',
             "label" : '',
             "type" : ''
         };
     };
     
     bee.prizesetting.entryitem.prototype = $.extend(new bee.prizesetting.raffleitem(), {
         initialize : function(params){
             bindAll(this, 'destroy','setval');
             this._params = this.unique(this._params, params); 
             
             this.delbtn = new bee.prizesetting.delbtn({parent_tag:'prizesetting.tabsentry', custom_class:'delBtn', custom_node:'i'});
             this.delbtn._el.bind("prizesetting.del",this.destroy);
             this.movebtn = new bee.prizesetting.movebtn({parent_tag:'prizesetting.tabsentry', custom_class:'moveBtn', custom_node:'i'});
             this.movebtn._el.bind("prizesetting.move",this.destroy);
             this.render();

             // 监听变化
             //this.lot_name._el.bind(this._triggername,this.setval);
             return this;
         },
         render : function(){
        	 this._el = $('<li id="formlistitem_'+ this._params.id +'">'+ 
        	         '<label for="">'+ this._params.label +'</label>'+ 
        	         '<input type="text" disabled="true" name="'+ this._params.name +'" value="用户填写'+ this._params.label +'" />'+ 
        	         '<i class="moveBtn"></i>'+ 
        	 		 '</li>');
        	 this._el.append(this.delbtn._el);
        	 this._el.append(this.movebtn._el);
        	 //this._el = $('<li>'+this._params.label+'</li>');
             //this._el = $('<div class="prize-item" style=""><ul></ul></div>');
        	/* if(this._params.name == 'birthday') {
        		 this._el = $('<div>'+ 
            	         '<label for="">'+ this._params.label +'</label>'+ 
            	         '<input type="text" disabled="true" name="'+ this._params.name +'" value="用户填写'+ this._params.label +'" />'+ 
            	         '<i class="moveBtn"></i>'+ 
            	         '<i class="delBtn"></i>'+ 
            	 		 '</div>');
        	 } else if(this._params.name == 'sex') {
        		 this._el = $('<div>'+ 
            	         '<label for="">'+ this._params.label +'</label>'+ 
            	         '<input type="text" disabled="true" name="'+ this._params.name +'" value="用户填写'+ this._params.label +'" />'+ 
            	         '<i class="moveBtn"></i>'+ 
            	         '<i class="delBtn"></i>'+ 
            	 		 '</div>');
        	 } else {
        		 this._el = $('<div>'+ 
            	         '<label for="">'+ this._params.label +'</label>'+ 
            	         '<input type="text" disabled="true" name="'+ this._params.name +'" value="用户填写'+ this._params.label +'" />'+ 
            	         '<i class="moveBtn"></i>'+ 
            	         '<i class="delBtn"></i>'+ 
            	 		 '</div>');
        	 }*/
        	 
             //this._el.find("ul").append(this.lot_name._el);
//             this._el.append(this.delbtn._el);
         },
         destroy : function(params){
             var self = this;
             self._el.remove();
             self._params = null;
             $(document).trigger(self._triggername+".delete");
             $('#name').attr('checked', false);
             $( ".registerTabBox input[type=checkbox]" ).button("refresh");
         }
     });
    
     //移动按钮
     bee.prizesetting.movebtn = function(params){
         this._params = {
             parent_tag 	: 'prizesetting.tabsraffle',
             custom_node 	: 'div',
             custom_class 	: 'move'
         }
         $.extend(this._params, params);
//         console.log('parent_tag : '+this._params.parent_tag)
         this.initialize();
     };
     bee.prizesetting.movebtn.prototype = {
         initialize : function(){
             var self = this;
             bindAll(this,'show','hide');
             this.render();
             /*this._el.click(function(e){
                 self._el.trigger("prizesetting.del",{});
             });*/
             $(document).bind(this._params.parent_tag+".show", this.show);

             $(document).bind(this._params.parent_tag+'.hide', this.hide);
         },
         render : function(){
         	var custom_node 	= this._params.custom_node;
         	var custom_class 	= this._params.custom_class;
             this._el = $('<'+ custom_node +' class="'+ custom_class +' hide"></'+ custom_node +'>');
         },
         show : function(){
             this._el.removeClass('hide');
         },
         hide : function(){
             this._el.addClass('hide');
         }
     };
     
    //删除按钮
    bee.prizesetting.delbtn = function(params){
        this._params = {
            parent_tag 		: 'prizesetting.tabsraffle',
            custom_node 	: 'div',
            custom_class 	: 'delete'
        }
        $.extend(this._params, params);
//        console.log('parent_tag : '+this._params.parent_tag)
        this.initialize();
    };
    bee.prizesetting.delbtn.prototype = {
        initialize : function(){
            var self = this;
            bindAll(this,'show','hide');
            this.render();
            this._el.click(function(e){
                self._el.trigger("prizesetting.del",{});
            });
            $(document).bind(this._params.parent_tag+".show", this.show);

            $(document).bind(this._params.parent_tag+'.hide', this.hide);
        },
        render : function(){
        	var custom_node 	= this._params.custom_node;
        	var custom_class 	= this._params.custom_class;
            this._el = $('<'+ custom_node +' class="'+ custom_class +' hide"></'+ custom_node +'>');
        },
        show : function(){
            this._el.removeClass('hide');
        },
        hide : function(){
            this._el.addClass('hide');
        }
    };

// 设置抽奖信息执行入口
    $(function() {
        var initinfo = {
            'none'   : {"active" : false, "disable": true, "data":{}},
            'raffle' : {"active" : false, "disable": true, "data":{'prizes':[], 'nowinmsg':"", 'isallowrepeatwin':0, 'winrepeattimes':1}},
            'coupon' : {"active" : false, "disable": true, "data":{'prizes':[], 'nowinmsg':"", 'isallowrepeatwin':0, 'winrepeattimes':1}},
            'rank'   : {"active" : false, "disable": true, "data":{'prizes':[], "starttime":"","endtime":"","prizeruledesc":""}},
            'entry'  : {"active" : false, "disable": true, "data":{'formitems':[], "formruledesc":""}}
        };

        var raffletype = parseInt(setting.raffletype);
            switch(raffletype){
                case 0 : initinfo.raffle.active = true;
                    break;
                case 1 : initinfo.coupon.active = true;
                    break;
                case 2 : initinfo.rank.active = true;
                    break;
                case 4 : initinfo.entry.active = true;
                	break;
                case 3 :
                default : initinfo.none.active = true;
            }

            for(key in gamecreator.raffletypes){
                switch(parseInt(gamecreator.raffletypes[key])){
                    case 0 : initinfo.raffle.disable = false;
                        break;
                    case 1 : initinfo.coupon.disable = false;
                        break;
                    case 2 : initinfo.rank.disable = false;
                        break;
                    case 4 : initinfo.entry.disable = false;
                    	break;
                    case 3 : 
                    default : initinfo.none.disable = false;
                }
            }
            var setting_value;
            for(key in setting) {
                switch(key) {
                    case "nowinmsg" : 
                        initinfo.raffle.data.nowinmsg = setting[key];
                        initinfo.coupon.data.nowinmsg = setting[key];
                        break;
                    case "isallowrepeatwin":
                        setting_value = ($.isNumeric(setting[key])) ? parseInt(setting[key]) : 0;
                        initinfo.raffle.data.isallowrepeatwin = setting_value;
                        initinfo.coupon.data.isallowrepeatwin = setting_value;
                        break;
                    case "winrepeattimes":
                        setting_value = ($.isNumeric(setting[key])) ? parseInt(setting[key]) : 1;
                        initinfo.raffle.data.winrepeattimes = setting_value;
                        initinfo.coupon.data.winrepeattimes = setting_value;
                        break;
                    case "starttime": 
                        initinfo.rank.data.starttime = setting[key];
                        break;
                    case "endtime": 
                        initinfo.rank.data.endtime = setting[key];
                        break;
                    case "prizeruledesc":
                        initinfo.rank.data.prizeruledesc = setting[key];
                        break;
                    case "default_formitems":
                        initinfo.entry.data.default_formitems = setting[key];
                        break;
                    case "custom_formitems":
                        initinfo.entry.data.custom_formitems = setting[key];
                        break;
                    case "formitems":
                        initinfo.entry.data.formitems = setting[key];
                        break;
                    case "formruledesc":
                        initinfo.entry.data.formruledesc = setting[key];
                        break;
                    default :
                    	 break;
                }
            }

            for(num in prizes){
                if(prizes[num]){
                    if(prizes[num].lot_type == 0 ){
                        initinfo.raffle.data.prizes.push(prizes[num]);
                    }else if(prizes[num].lot_type == 1){
                        initinfo.coupon.data.prizes.push(prizes[num]);
                    }else if(prizes[num].lot_type == 2){
                        initinfo.rank.data.prizes.push(prizes[num]);
                    }else{}
                }
            }
        console.log("initinfo");
        console.log(initinfo);
        var publish_url = '/index.php?s=Home/editor/setting/appid/' + appid + '.html';
        var settingtabs = new bee.prizesetting.tabs({
                el : $("#settingtabs"),
                renddata : [
                    {"name":"不设置","active":initinfo.none.active,"disable":initinfo.none.disable,"sid":"tabsnone"},
                    {"name":"抽奖","active":initinfo.raffle.active,"disable":initinfo.raffle.disable,"sid":"tabsraffle"},
                    {"name":"派发礼券或小样","active":initinfo.coupon.active,"disable":initinfo.coupon.disable,"sid":"tabscoupon"},
                    {"name":"排行榜发奖","active":initinfo.rank.active ,"disable":initinfo.rank.disable, "sid":"tabsrank"},
                    {"name":"报名表单","active":initinfo.entry.active ,"disable":initinfo.entry.disable, "sid":"tabsentry"}
                ]
            });

        var tabsnone = { _el : "",raffletype:3, getsetting: function(){ return {};}};

        var tabsraffle = new bee.prizesetting.tabsraffle({
                el : $("#tabsraffle"),
                data : initinfo.raffle.data
            }).initialize();

        var tabscoupon = new bee.prizesetting.tabscoupon({
                el : $("#tabscoupon"),
                raffletype:1,
                data : initinfo.coupon.data
            }).initialize();
        //排行榜
        var tabsrank = new bee.prizesetting.tabsrank({
                el : $("#tabsrank"),
                raffletype:2,
                data : initinfo.rank.data
            }).initialize();
        //报名表单
        var tabsentry = new bee.prizesetting.tabsentry({
                el : $("#tabsentry"),
                raffletype:4,
                data : initinfo.entry.data
            }).initialize();
        
        $('.publish').click(function(){
            var postdata = eval(settingtabs._cur).getsetting();
            $.extend(postdata, {raffletype:eval(settingtabs._cur).raffletype});
            if(typeof(postdata) == 'object'){

                if(postdata.raffletype != 3 && postdata.raffletype != 4 && postdata.prizes.length == 0){
                    _errDlg("至少应存在一个奖项...");
                    return;
                }
                $.post(publish_url, postdata, function(res){
                    if(res){
                        location.href= "/index.php?s=/Home/editor/editScene/appid/"+gamecreator.app_id+'.html';
                        // console.log(res);
                    }
                });
            }
        });

    });