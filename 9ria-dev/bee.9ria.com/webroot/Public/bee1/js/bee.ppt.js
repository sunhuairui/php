
bee = bee || {};
bee.ppt = bee.ppt || {};

// 页面切换
bee.ppt.pagechange = function(ui){
    ui.newHeader.addClass("select-label");
    ui.oldHeader.removeClass("select-label");
    pageNo  = ui.newPanel.attr("action-number");
    this.preview();
}

bee.ppt.pagechange.prototype = {
    preview : function(){
        //切换左侧预览页面
        $(document).trigger("pagetemplate.play",pageNo);
    }
}


bee.ppt.combineTemplateHtml = function(){

}


bee.ppt.renderpage = function(){
    $(".cate").html("");
    bee.get_template(gamecreator.app_id, function (data){
        gamecreator.tmpsdata = data;
        var vars = data.templateVars,var1 = data.share,categories = data.templateCategory,i=1,catelength=Object.keys(categories).length, templateTypes = data.templateType || [], pages = data.pages;
        var html = '<ol class="classify box-container" id="accordion">';
        for (var cateIndex in categories) {
            if(i == 1 || i== catelength){
                html += '<li>'+
                '<h4 class="">' + i + '.' + cateIndex + '</h4>';
            }else{
                html += '<li>'+
                    '<h4>' + i + '.<input type="text" value="' + cateIndex + '" action-data="'+cateIndex+'">'+
                    '<div class="opbtn">'+
                        '<div class="addBtn"></div>'+
                        '<div class="moveBtn"></div>'+
                        '<div class="delBtn"></div>'+
                    '</div>'+
                    '<select name="" form="" class="selectList">';
                    // 板式选择
                    for(var sortid in templateTypes){
                        html += '<option '+ (pages[cateIndex]['pageid'] == sortid ? "selected" : "") +' value="' + sortid + '">' + templateTypes[sortid].temp_name + '</option>';
                    }
                html += '</select></h4>';
            }

            html +='<div class="panelBox" action-number="' + i + '"><div class="line"></div>';
            for (var resourcename in categories[cateIndex]) {
                var key = categories[cateIndex][resourcename];
                if (vars[key]) {
                    if (vars[key]['type'] == 'IMAGE') {
                        html +='<div class="item t-image box" action-data="'+ vars[key]['texUrl'] +'" action-type="IMAGE" name="' + key + '" title="' + vars[key]['desc'] + '">\
                            <div class="icon">\
                              <div type="image" class="imgbox" style="background-image: url(\'/Public/gamecreator/app/'+gamecreator.app_id+'/'+vars[key]['texUrl']+'?t='+gamecreator.time+'\');'+AutoResizeImage(100,100,vars[key]['originW'],vars[key]['originH'])+'"></div>\
                            </div>\
                            <p><a href="#">'+vars[key]['desc']+'</a> <span>推荐尺寸：<i class="fblue">' + vars[key]['originW'] + 'px*' + vars[key]['originH'] + 'px</i></span></p>\
                          </div>';
                        }else if(vars[key]['type'] == 'STRING'){
                          html+='<div class="item t-text box" name="desc3" title="'+vars[key]['value']+'" action-data="'+ key +'" action-type="STRING" action-name="'+vars[key]['desc']+'">\
                            <div class="icon">\
                              <div type="text" class="strbox" style="word-break:break-word;">'+vars[key]['value']+'</div>\
                            </div>\
                            <p>'+vars[key]['desc']+'</p>\
                          </div>';
                        }else if(vars[key]['type'] == 'AUDIO'){
                          html+='<div class="item t-text box" name="'+vars[key]['recommendSize']+'" title="'+vars[key]['desc']+'" action-data="'+ vars[key]['texUrl'] +'" action-type="AUDIO" action-name="'+var1['setting']['switch']+'">\
                            <div class="icon">\
                            <div id="audio" name="'+ vars[key]['name']+'" action-name="'+var1['setting']['switch']+'"></div>\
                              <div type="image" class="imgbox" style="word-break:break-word;background-image: url(\'/Public/bee1/images/musicicon.png\');"></div>\
                            </div>\
                            <p><a href="#">'+vars[key]['desc']+'</a><span>推荐时长：<i class="fblue">'+ vars[key]['recommendTime'] +'</i></span></p>\
                          </div>';
                        }else{}
                }else{
                    console.log('vars不存在');
                }
            }

            html+='</div></li>';
            
            i++;
        }
        html+='</ol>';
        $(".cate").append(html);
        // 场景
        bee.ppt.accordion = $( "#accordion" ).accordion({
            heightStyle : "content",
            active: pageNo -1,
            activate : function(event, ui){
                new bee.ppt.pagechange(ui);
            }
        });

        //设置第一页展开样式
        $($("ol>li>h4")[pageNo - 1]).addClass('select-label');

        // 弹出框
        $(".box-container").on("click", ".box", function (e){
            bee.replacepanel($(e.target).closest(".box"));
            e.stopPropagation();
        });

    });
}


//初始化
$(function(){
    //获取配置文件数据
    bee.ppt.renderpage();
    // 修改后触发 重新获取数据
    $(document).bind("bee.reloadgame", function(event){
        console.log('bee.reloadgame');
        $(document).trigger("pagetemplate.getdata",function(){
            console.log('trigger play');
            $(document).trigger("pagetemplate.play",pageNo);
        });
    });
    
    //默认展示第一页
    $(document).trigger("bee.reloadgame");
    
    $(document).bind("bee.removepopover", function(event){
      if(bee.replacetabs.dlg){bee.replacetabs.dlg.remove();}
    });

    $(document).on("click",function(e){
      $(document).trigger('bee.removepopover');
    });
    

    // 中间页标题名称修改
    $(".body-right").on('change', "h4>input", function(e){
        var el = $(e.target), originVal = el.attr("action-data"), newVal = el.val();
        if(newVal && originVal != newVal){
            if(gamecreator.tmpsdata.pages[newVal]){
                _errDlg("页面名称不能相同");
                $(e.target).val(originVal);
                return;
            }
            if(gamecreator.tmpsdata.templateCategory[originVal]){
                // 替换名称 templateCategory pages
                var templateCategory = {};
                var pages = {};
                for(var catename in gamecreator.tmpsdata.templateCategory){
                    if(catename == originVal){
                        templateCategory[newVal] = gamecreator.tmpsdata.templateCategory[catename];
                        pages[newVal] = gamecreator.tmpsdata.pages[catename];
                    }else{
                        templateCategory[catename] = gamecreator.tmpsdata.templateCategory[catename];
                        pages[catename] = gamecreator.tmpsdata.pages[catename];
                    }
                }
                gamecreator.tmpsdata.templateCategory = templateCategory;
                gamecreator.tmpsdata.pages = pages;
                console.log(gamecreator.tmpsdata);
                bee.write_file('template.json', gamecreator.tmpsdata, function(res){
                    el.attr({"action-data" : newVal});
                });
            }
        }
    });

    // 板式切换
     $(".body-right").on('change', "h4>select", function(e){
        var el = $(e.target), pageid = el.find('option:selected').val(), catename = el.parent().find("input").attr('action-data');
        bee.ppt.changePage(catename, pageid);
        // gamecreator.tmpsdata.templateVars[catename] = pageinfo.edit;
        // gamecreator.tmpsdata
     });


    $(".body-right").on('click', "h4 .addBtn", function(e){
        var el = $(e.target),catename = el.parent().parent().find("input").attr('action-data');
        bee.ppt.copy(catename);
    });

    $(".body-right").on('click', "h4 .delBtn", function(e){
        var el = $(e.target),catename = el.parent().parent().find("input").attr('action-data');
        bee.ppt.remove(catename);
    });

    $(".body-right").on('click', "h4 .moveBtn", function(e){
        var el = $(e.target),catename = el.parent().parent().find("input").attr('action-data');
        bee.ppt.move(catename); 
    });





    // 跳转到editScene页面
    $(".publish").click(function(){
        location.href = gamecreator.nextStepUrl;
    });


});


bee.ppt.changePage = function(catename, pageid){
    // 删除templateVars 
    var pages   = gamecreator.tmpsdata.pages, templateVars = gamecreator.tmpsdata.templateVars, templateCategory = gamecreator.tmpsdata.templateCategory;
    var oldPage = pages[catename],oldCate = templateCategory[catename], elements = oldPage['elements'];

    for(var key in elements){
        var elementId = elements[key];
        if(isCopyElementName(elementId)){
            templateVars[elementId] && delete templateVars[elementId];
        }
    }
    gamecreator.tmpsdata.pages[catename] = {};
    gamecreator.tmpsdata.templateCategory[catename] = [];

    gamecreator.tmpsdata.pages[catename] = {
        'pageid':pageid,
        'elements':[]
    };

    var oldCateElements = gamecreator.tmpsdata.templateType[pageid]['edit'];
    var oldPageElements = gamecreator.tmpsdata.templateType[pageid]['elements'];

    for(var key in oldPageElements){
        var oldElementId = oldPageElements[key];
        var newElementId = getNewElementName(oldElementId);
        
        if(oldCateElements.indexOf(oldElementId) >= 0){
            gamecreator.tmpsdata.templateCategory[catename].push(newElementId);
        }
        gamecreator.tmpsdata.templateVars[newElementId] = gamecreator.tmpsdata.templateVars[oldElementId];
        gamecreator.tmpsdata.pages[catename]['elements'].push(newElementId);
    }
    bee.write_file('template.json', gamecreator.tmpsdata, function(res){
        bee.ppt.renderpage();
        $(document).trigger("bee.reloadgame");
    });
}

// 拷贝操作
bee.ppt.copy = function(catename){
    var pages = gamecreator.tmpsdata.pages, templateVars = gamecreator.tmpsdata.templateVars, templateCategory = gamecreator.tmpsdata.templateCategory,newPage = {},newCate = [];
    var newName = getNewCateName(catename);
    var pageinfo = pages[catename];

        newPage = {
            'pageid': pageinfo.pageid,
            'elements' : []
        };

    // 新旧
    // var corresponding = {}
    for(var key in pageinfo['elements']){
        var oldElementId = pageinfo['elements'][key];
        var newElementId = getNewElementName(oldElementId);
        
        // corresponding[oldElementId] = newElementId;
        

        if(templateCategory[catename].indexOf(oldElementId) >= 0){
            newCate.push(newElementId);
        }

        templateVars[newElementId] = templateVars[oldElementId];

        newPage['elements'].push(newElementId);
    }

    // console.log(newPage, newCate, templateVars);
    // return;


    var pageNames = Object.keys(templateCategory);
    var pos = pageNames.indexOf(catename);

        pageNames.splice(pos+1, 0, newName);
    

    // 添加新的 gamecreator.tmpsdata.pages gamecreator.tmpsdata.templateCategory
    var newPages = {}, newCates = {};
    for(var key in pageNames){
        var pageName = pageNames[key];
        if(pageName == newName){
            newPages[newName] = newPage;
            newCates[newName] = newCate;
        }else{
            newPages[pageName] = pages[pageName];
            newCates[pageName] = templateCategory[pageName];
        }
    }

    gamecreator.tmpsdata.templateCategory = newCates;
    gamecreator.tmpsdata.pages = newPages;
    console.log(gamecreator.tmpsdata.pages,gamecreator.tmpsdata.templateCategory);
    
    bee.write_file('template.json', gamecreator.tmpsdata, function(res){
        bee.ppt.renderpage();
        $(document).trigger("bee.reloadgame");
    });
}

bee.ppt.remove = function(catename){
    console.log(catename);
    var pages   = gamecreator.tmpsdata.pages, templateVars = gamecreator.tmpsdata.templateVars, templateCategory = gamecreator.tmpsdata.templateCategory;
    var oldPage = pages[catename],oldCate = templateCategory[catename], elements = oldPage['elements'];

    for(var key in elements){
        var elementId = elements[key];
        if(isCopyElementName(elementId)){
            templateVars[elementId] && delete templateVars[elementId];
        }
    }
    gamecreator.tmpsdata.pages[catename] && delete gamecreator.tmpsdata.pages[catename];
    gamecreator.tmpsdata.templateCategory[catename] && delete gamecreator.tmpsdata.templateCategory[catename];

    // console.log(gamecreator.tmpsdata);
    bee.write_file('template.json', gamecreator.tmpsdata, function(res){
        bee.ppt.renderpage();
        $(document).trigger("bee.reloadgame");
    });

}

bee.ppt.move = function(catename){


}

// 生成新的templateCategory key
function getNewCateName(catename){
    var number = 0,originName = catename, newName = '', pages = gamecreator.tmpsdata.pages, suffixName = '';
    if(catename.match(/（[0-9]+）/)){
        suffixName = catename.match(/（[0-9]+）/)[0];
        originName = catename.replace(suffixName, '');
        number = suffixName.match(/[0-9]+/);
    }

    do{
        number ++ ;
        newName = originName + '（' + number + '）';

    }while(pages[newName]);

    return newName;
}

// 获取新的动画元素名称
function getNewElementName(elementId){
    var time = new Date().getTime(),originId=elementId,newId='', suffixName='';
    if(elementId.match(/_[0-9]{13}/)){
        suffixName = elementId.match(/_[0-9]{13}/)[0];
        originId = elementId.replace(suffixName, '');
    }
    return originId + '_' + time;
}

// 判断元素名称是否为复制的
function isCopyElementName(elementId){
    if( elementId.match(/_[0-9]{13}/) ){
        return true;
    }
    return false;
}


