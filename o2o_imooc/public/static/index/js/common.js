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


