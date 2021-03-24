 $(function() {

     //缩略图片展示
    $("#file_upload").change(function(){
            console.log($(this));
            $("#upload_org_code_img").attr("src",URL.createObjectURL($(this)[0].files[0]));
            $("#upload_org_code_img").css("display",'block');
    });

    //营业执照图片展示
    $("#file_upload_other").change(function(){
            console.log($(this));
            $("#upload_org_code_img_other").attr("src",URL.createObjectURL($(this)[0].files[0]));
            $("#upload_org_code_img_other").css("display",'block');
    });

    //地图显示
    $('.maptag').click(function(){
        var address=$('#address').val();
        var map_url=SCOPE.map_url;
        var data={'address':address};
        $.post(map_url,data,function(result){
            if(result.status==1){
               $("#map_img").attr("src",result.data);
               $("#map_img").css("display",'inline');
        }else {
            alert(result.msg);
        }
        },'json')
    });
});