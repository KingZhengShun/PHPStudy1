<?php
namespace app\admin\controller;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
       return $this->fetch();
    }

    public function welcome(){
        return '欢迎来到o2o首页！';
    }

    public function map(){
        //$result=json_decode(\Map::getLngLat('天台客运中心'),1);
        //$demos=$result['result'][0]['location'];
        //$center=$demos['lng'].','.$demos['lat'];
        $url=\Map::staticImage('天台客运中心');
        return $url;
    }

}
