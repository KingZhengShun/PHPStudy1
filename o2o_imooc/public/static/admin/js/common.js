/*页面 全屏-添加*/
function o2o_edit(title,url){
    var index = layer.open({
        type: 2,
        title: title,
        content: url
    });
    layer.full(index);
}

/*添加或者编辑缩小的屏幕*/
function o2o_s_edit(title,url,w,h){
    layer_show(title,url,w,h);
}
/*-删除*/
function o2o_del(url){

    layer.confirm('确认要删除吗？',function(index){
        window.location.href=url;
    });
}

$('.listorder input').blur(function () {
    //获取主键id
    var id=$(this).attr('attr-id');
    //获取排序的值
    var listorder=$(this).val();
    //编写请求地址

    var url=SCOPE.listorder_url;
    //编写请求数据的参数
    var postData={
        'id':id,
        'listorder':listorder
    };
    //发送请求
    $.post(url,postData,function (result) {
        //逻辑
        if(result.code==1){
            location.href=result.data;
        }else {
            alert(result.msg);
        }
    },'json');

});

/**城市相关二级内容**/
$(".cityId").change(function(){
    city_id = $(this).val();
    // 抛送请求
    city_url = SCOPE.city_url;
    postData = {'id':city_id};
    $.post(city_url,postData,function (result) {
        if(result.status == 1) {
            // 将信息填充到html中
            data = result.data;
            city_html = "<option value=\"0\">--请选择--</option>";
            $(data).each(function(i){
                city_html += "<option value='"+this.region_id+"'>"+this.region_name+"</option>";
            });
            $('.se_city_id').html(city_html);
        }else if(result.status == 0) {
            $('.se_city_id').html("<option value=\"0\">--请选择--</option>");
        }
    },'json');
});


/**分类相关二级内容**/
$(".categoryId").change(function(){
    category_id = $(this).val();
    // 抛送请求
    url = SCOPE.category_url;
    postData = {'id':category_id};
    $.post(url,postData,function(result){
        //相关的业务处理
        if(result.status == 1) {
            data = result.data;
            category_html = "";
            $(data).each(function(i){
                category_html += '<input name="se_category_id[]" type="checkbox" id="checkbox-moban" value="'+this.id+'"/>'+this.name;
                category_html += '<label for="checkbox-moban">&nbsp;</label>';
            });
            $('.se_category_id').html(category_html);
        }else if(result.status == 0) {
            $('.se_category_id').html('');
        }
    }, 'json');
});

function selecttime(flag){
    if(flag==1){
        var endTime = $("#countTimeend").val();
        if(endTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',maxDate:endTime});
        }else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'});
        }
    }else{
        var startTime = $("#countTimestart").val();
        if(startTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:startTime});
        }else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'});
        }
    }
}

