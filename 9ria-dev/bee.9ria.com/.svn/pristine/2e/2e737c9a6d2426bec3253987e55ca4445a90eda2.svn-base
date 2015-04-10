
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