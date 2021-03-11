<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function status($status){
    if($status==1){
        $str="<span class='label label-success radius'>正常</span>";
    }elseif ($status==0){
        $str="<span class='label label-danger radius'>待审</span>";
    }elseif($status==-1){
        $str="<span class='label label-success radius'>删除</span>";
    }else{
        $str="<span class='label label-success radius'>不通过</span>";
    }
    return $str;
}

/**
 * @param $url
 * @param int $type 0为get请求，1为post请求
 * @param array $data
 */
function doCurl($url,$type=0,$data=[]){
    //初始化curl
    $ch=curl_init();
    //设置curl选项
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER,0);
    //校验请求类型
    if($type==1){
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    }

    //执行并获取内容
    $output=curl_exec($ch);
    //释放curl句柄
    curl_close($ch);
    return $output;
}


function bisRegister($status){
    if($status==0){
        $str='待会审核，平台审核完成会发送邮件通知，请关注！';
    }else if($status==1){
        $str='入驻申请成功！';
    }else if($status==2){
        $str='非常抱歉，你提交的资料不符合条件，请重新提交！';
    }else if($status==3){
        $str='你申请的账号已被占用，请重新申请！';
    }else{
        $str='该申请已被删除！';
    }
    return $str;
}

/**
 * 通用分页样式
 * @param $obj
 * @return string
 */
function pagination($obj){
    if(!$obj){
        return '';
    }
    return '<div class="cl pd-5 bg-1 bk-gray mt-20 tp5-o2o">'.$obj->render().'</div>';
}


function getSeCityName($path){
    if (empty($path)){
        return '';
    }
    if(preg_match('/,/',$path)){
        $cityPath=explode(',',$path);
        $cityId=$cityPath[1];
    }else{
        $cityId=$path;
    }
    $city=model('Regions')->get($cityId);
    return $city->region_name;
}

