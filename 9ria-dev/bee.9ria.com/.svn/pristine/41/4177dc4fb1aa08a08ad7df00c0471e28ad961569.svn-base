// <== 表单js start ==>
    // 删除
    $('body').on('click', '.delBtn', function() {
       // 最后一条不能删除
       while($('.ui-sortable .ui-state-default').size() == 1){
        confirm('只剩最后一条了，别删了');
        $('i.delBtn:hover').css('background-position','0 -1557px');
        return false;
       }
      var elem = "div:contains(" + $(this).parent().find('label').text() + ")";
      $('.checkboxBlock').find(elem).removeClass('active');
      $(this).parent().remove();
    });
    $('body').on('click', '.delBtnHid', function() {
      $(this).parent().remove();
    });
    $('body').on('hover','.checkboxBlockAdd div',function(){
      $(this).find('i.delBtnHid').css('display','inline-block');   
    });
    $('body').on('mouseleave','.checkboxBlockAdd div',function(){
      $(this).find('i.delBtnHid').css('display','none');      
    });

    // 报名表单多选框,同时增加表单条目
    $('body').on('click','i.selectBlue',function(){
        var itemId = $(this).attr('data');
        if($(this).parent().hasClass('active')){
          $(this).parent().removeClass('active');
          var elem = "label:contains(" + $(this).prev().val() + ")";
          $('#sortable').find(elem).parent().remove();
        }else{
            // 表单项目多于5个时，不能再增加 
            // if($('.ui-sortable .ui-state-default').size() == 5){
              // var action_data = $(e.target).attr('action-data');
            //   confirm('表单条目最多5个，请删除无用条目后，再添加新条目');
            //   return false;
            // }else{
              $(this).parent().addClass('active'); 
              if($(this).prev().val() == '性别'){
                   $('#sortable').children().last().after("<div class=\"ui-state-default\"><label>性别</label><input name=\"sex\" type=\"radio\" value=\"男\" checked=\"checked\" disabled=\"true\">男<i class=\"marginR\"></i><input name=\"sex\" type=\"radio\" value=\"女\" disabled=\"true\">女<i class=\"moveBtn\"></i><i class=\"delBtn\"></i></div>");
                   return false;

              }if($(this).prev().val() == '生日'){
                 $('#sortable').children().last().after("<div class=\"ui-state-default\" style=\"position: relative;\"><label>生日</label><select name=\"YYYY\" disabled=\"true\"><option>1987 年</option> </select><select name=\"MM\" disabled=\"true\"> <option>06 月</option> </select><select name=\"DD\" disabled=\"true\"><option>06 日</option></select><i class=\"moveBtn\"></i><i class=\"delBtn\"></i></div>");
                 return false;
                  
              }
              else{
                $('#sortable').children().last().after("<div class=\"ui-state-default \"><label>" + $(this).prev().val() + "</label><input type=\"text\" disabled=\"true\" /><i class=\"moveBtn\"></i><i class=\"delBtn\"></i></div>");

              }
              
            // }
        }  

    });
    // 表单添加其它信息
    $('.aBlue').click(function(){
      $('.aBlue').hide();
      $('.hiddenInp').css('display','block');
      $('.hiddenInp input').css({position:'relative',bottom:'2px'});
      $('.hiddenInp').animate({width:'380px',height:'30px'},500);
    });

    $('.btnBlue1').click(function(){
      if($('#addInp').val() == ''){
        alert('请输入内容');
        $('#addInp').focus();
      }else{
        $('.hiddenInp').before("<div><input type=\"checkbox\" value=" + $('#addInp').val() + "><i class=\"selectBlue\"></i>" + $('#addInp').val() + "<i class=\"delBtnHid\"></i></div>");
      }      
    });
// <== 表单js end ==>
 
 // 礼券选项卡
        $('ul.tabs li').click(function(){
          $('.tabPanels').hide().eq($('ul.tabs li').index(this)).show();
          $('ul.tabs li').removeClass('active');
          $(this).addClass('active');
        });

    // 生成券号选项卡
        $('ul.quanUl li').click(function(){
          $('ul.quanLi li').hide().eq($('ul.quanUl li').index(this)).show();
          $('ul.quanUl li').removeClass('active');
          $(this).addClass('active');
        });
    

    // 宽度liuna
        var screenW = document.body.clientWidth;
        //console.log(screenW);
        if(screenW > 1400){
            $('.container').css('width','1345px');
            // $('ul.main li').css('margin-right','48px');
            $('a.more').css('width','1294px');

        }

    // 手机预览位置固定
        $(window).on('scroll',function(){
            if($(document).scrollTop() > 90){
                $('.viewFix').css({'position':'fixed','top':'35px'});
                $('.editorBox').css('margin-left','333px');
            }else{
                $('.viewFix').css('position','static');
                $('.editorBox').css('margin-left','0');   
            }    
        });

    // 返回顶部
        function b(){
            h = $(window).height();
            t = $(document).scrollTop();
            if(t > h){
                $('#goTop').show();

            }else{
                $('#goTop').hide();
            }
        }
        
        b();
        $('#goTop').click(function(){
            $(document).scrollTop(0);   
        })