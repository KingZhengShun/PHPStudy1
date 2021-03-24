<?php
namespace app\api\controller;
use think\Controller;
use think\Request;
use think\File;

class Map extends Controller{
	public function getMapPhoto(){
		if(request()->isPost()){
			$address=input('post.address');
			//获取地址经纬度
			$lnglat=\Map::getLngLat($address);
			if (empty($lnglat)){
			    $this->error('数据匹配不精确！');
			}
			$xpoint=$lnglat->location->lng;
			$ypoint=$lnglat->location->lat;
			$center=$xpoint.','.$ypoint;
			//获取经纬度的静态地图
			$mapUrl=\Map::staticImage($center);
			if(!$mapUrl){
			    return show(0,'地图获取失败！');
			}
			return show(1,'success',$mapUrl);

		}
		
	}
}