<?php
namespace app\bis\controller;
use think\Controller;
// use thin\Request;
class Register extends Controller{
    /**
     * @return mixed
     */
    public function index(){
        
        //获取省数据列表数据
        $citys=model('Regions')->getNormalCitysByParentId();
        //获取一级栏目分类数据列表数据
        $categorys=model('Category')->getNormalCagetorysByParentId();
        if($citys!=null){
            return $this->fetch('',[
            'citys'=>$citys,
            'categorys'=>$categorys
            ]);
        }        
        return $this->fetch();
        
    }

    public function add(){
        //校验是否为post请求
        if(!request()->isPost()){
            $this->error('请求错误');
        }
        //获取表单数据
        $info=input('post.');

        //上传缩略图到服务器并且获取图片地址
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0){
            $logo = request()->file('logo');
            // print_r($logo);
        }
        if(isset($logo)){
            $info['logo']=model('ImageUpdate')->photoUpdate('logo');
        }
        //上传营业执照到服务器并且获取图片地址
        if (isset($_FILES['licence_logo']) && $_FILES['licence_logo']['error'] == 0){
            $licence_logo = request()->file('licence_logo');
        }        
        if(isset($licence_logo)){
            $info['licence_logo']=model('ImageUpdate')->photoUpdate('licence_logo');
        }

        //基本信息数据校验
        $validate_base_info=validate('Bis');
        if(!$validate_base_info->scene('bis_base_info')->check($info)){
            $this->error($validate_base_info->getError());
        }
        //基本信息入库
        $baseData=[
            'name'=>$info['name'],
            'city_id'=>$info['city_id'],
            'city_path'=>empty($info['se_city_id'])?$info['city_id']:$info['city_id'].','.$info['se_city_id'],
            'logo'=>$info['logo'],
            'licence_logo'=>$info['licence_logo'],
            'description'=>empty($info['description'])?'':$info['description'],
            'bank_info'=>$info['bank_info'],
            'bank_name'=>$info['bank_name'],
            'bank_user'=>$info['bank_user'],
            'faren'=>$info['faren'],
            'faren_tel'=>$info['faren_tel'],
            'email'=>$info['email'],
        ];
        //数据导入数据库
        $baseInfoId=model('Bisuser')->bisBaseInfo($baseData);

        //总店信息数据校验
        $validate_zongdian_info=validate('Bis');
        if(!$validate_zongdian_info->scene('bis_zongdian_info')->check($info)){
            $this->error($validate_zongdian_info->getError());
        }
        //获取经纬度信息
        $lnglat=\Map::getLngLat($info['address']);
        if (empty($lnglat)){
            $this->error('数据匹配不精确！');
        }
        $xpoint=$lnglat->location->lng;
        $ypoint=$lnglat->location->lat;
        //判断是否有二级分类
        $info['cat']='';
        if (!empty($info['se_category_id'])){
            $info['cat']=implode('|',$info['se_category_id']);
        }
        //总店信息入库
        $locationDate=[
            'bis_id'=>$baseInfoId,
            'name'=>$info['name'],
            'tel'=>$info['tel'],
            'contact'=>$info['contact'],
            'category_id'=>$info['category_id'],
            'category_path'=>$info['category_id'].','.$info['cat'],
            'city_id'=>$info['city_id'],
            'city_path'=>empty($info['se_city_id'])?$info['city_id']:$info['city_id'].','.$info['se_city_id'],
            'address'=>$info['address'],
            'open_time'=>$info['open_time'],
            'content'=>empty($info['content'])?'':$info['content'],
            'is_main'=>1,//总店信息
            'xpoint'=>empty($xpoint)?'':$xpoint,
            'ypoint'=>empty($ypoint)?'':$ypoint,
            'status'=>0
        ];

        $locationId=model('Bislocation')->bisBaseInfoAdd($locationDate);
        //账号信息数据校验 并对密码进行加密！
        $bis_user_info=validate('Bis');
        if(!$bis_user_info->scene('bis_user_info')->check($info)){
            $this->error($bis_user_info->getError());
        }
        $info['code']=mt_rand(100,10000);
        $accountDate=[
            'bis_id'=>$baseInfoId,
            'username'=>$info['username'],
            'code'=>$info['code'],
            'password'=>md5($info['password'].$info['code']),
            'is_main'=>1//总店管理员
        ];

        $accountDateId=model('Bisaccount')->bisaccountInfoAdd($accountDate);
        if (!$accountDateId){
            $this->error('申请失败！');
        }

        //发送验证邮件
        $url=request()->domain().url('bis/register/waiting',['id'=>$baseInfoId]);
        $title='o2o入驻申请通知';
        $content="您提交的入驻申请需要等待平台审核，你可以通过点击链接<a href='".$url."' target='_blank'>查看链接</a>查看审核状态";
        \phpmailer\Email::send($info['email'],$title,$content);
        //邮件发送成功之后进行跳转！
        $this->success('申请成功！',url('register/waiting',['id'=>$baseInfoId]));
    }

    public function waiting($id){
        if (empty($id)){
            $this->error('error');
        }
        $detail=model('Bislocation')->get(['bis_id'=>$id]);

        return $this->fetch('',[
            'detail'=>$detail,
        ]);
    }



    
}