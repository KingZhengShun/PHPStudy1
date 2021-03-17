<?php
namespace app\api\controller;

use think\Controller;

class City extends Controller{
    private $obj;
    public function _initialize()
    {
        $this->obj=model('Regions');
    }
    //获取二级城市信息
    public function getCitysByParentId(){
        $id=input('post.id');
        if(!$id){
            $this->error('id不合法！');
        }
        $citys=$this->obj->getNormalCitysByParentId($id);
        if(!$citys){
            return show(0,'false');
        }
        return show(1,'success',$citys);
        
    }
}